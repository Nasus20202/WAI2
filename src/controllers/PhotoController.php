<?php
namespace controllers;
use models\BaseModel;
use routing\Router;
use database\Database;
use models\Photo;
use auth\Auth;
use routing\Route;

require_once('Controller.php');

class PhotoController extends Controller implements IController {
    const IMAGE_PATH = __BASEDIR__.'/web/images/';
    const IMAGE_URL = '/images/';
    const IMAGE_MAX_SIZE = 10000000;
    const IMAGES_PER_PAGE = 10;
    const SAVED_SESSION = 'saved';
    protected function index(){
        $this->loadModel();
        $db = new Database();
        $photoPage = $this->get('page') != null ? $this->get('page') : 0;
        $photosPerPage = $this->get('amount') != null ? $this->get('amount') : self::IMAGES_PER_PAGE;
        if($photoPage < 0 || $photosPerPage < 0){
            $photoPage = 0; $photosPerPage = self::IMAGES_PER_PAGE;
        }
        $photos = $db->getPhotos(Auth::getUserId(), (int)$photosPerPage, (int)$photoPage*$photosPerPage);
        $photoInfo = array();
        foreach($photos as $photo){
            $photoInfo[] = [
                "photo" => $photo,
                "url" => self::IMAGE_URL . $photo->id . '.' . $photo->extension,
                "thumbnail" => self::IMAGE_URL . $photo->id . '-min.' . $photo->extension,
                "watermark" => self::IMAGE_URL . $photo->id . '-wm.' . $photo->extension
            ];
        }
        $model = new \models\Photo\IndexModel($photoInfo, $photoPage, $photosPerPage, $db->getPhotoCount(Auth::getUserId()));
        $this->render($model);
    }
    protected function upload(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Photo\UploadModel($this->post('title'), $this->post('author'), $this->post('watermark'), $this->files('image'), $this->post('private') != null ? true : false);
            $isFileGood = $this->validatePhoto($model);
            if($isFileGood == 0){
                if($model->userLoggedIn){
                    $photo = new \database\Photo($model->title, $model->author, $model->extension, $model->userId, $model->private);}
                else{
                    $photo = new \database\Photo($model->title, $model->author, $model->extension);}
                $db = new Database();
                $db->createPhoto($photo);
                $this->generatePhotosAndSave($model, $photo->id);
                Router::redirect('photo');
            }
            else{
                Router::redirectToUrl('upload?error='.$isFileGood);
            }
        }
        else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel($error);
            $this->render($model);
        }
    }
    protected function changeVisibility(){
        if($this->method != "POST")
            Router::redirect();
        $this->loadModel();
        $model = new \models\Photo\ChangeVisibilityModel($this->post('id'), $this->post('visibility'));
        $db = new Database();
        $image = $db->getPhoto($model->id);
        if($image->ownerId == Auth::getUserId()){
            if($model->visibility == 'public')
                $image->private = false;
            else if ($model->visibility == 'private')
                $image->private = true;
            else 
                $image->private = !$image->private;
            $db->updatePhoto($image);
        }
    }

    protected function saved($remove = false){
        $this->loadModel();
        if($this->method == "POST"){
            $ids = $this->post('saved');
            if($ids == null)
                Router::redirect('saved');
            $db = new Database();
            foreach($ids as $id){
                $photo = $db->getPhoto($id);
                if($remove)
                    $this->removeSaved($photo);
                else if($photo->ownerId == Auth::getUserId() || $photo->private == false)
                    $this->addSaved($photo);
            }
            Router::redirect('saved');
        } else {
            $model = new \models\Photo\SavedModel();
            $photos = $this->getSavedPhotos($model);
            $photoInfo = array();
            foreach($photos as $photo){
                $photoInfo[] = [
                    "photo" => $photo,
                    "url" => self::IMAGE_URL . $photo->id . '.' . $photo->extension,
                    "thumbnail" => self::IMAGE_URL . $photo->id . '-min.' . $photo->extension,
                    "watermark" => self::IMAGE_URL . $photo->id . '-wm.' . $photo->extension
                ];
            }
            $model->saved = $photoInfo;
            $this->render($model);
        }
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'upload':
                $this->upload();
                break;
            case 'changeVisibility':
                $this->changeVisibility();
                break;
            case 'saved':
                $this->saved();
                break;
            case 'saved/remove':
                $this->setAction('saved');
                $this->saved(true);
                break;
            default:
                $this->setAction(\routing\FrontController::DEFAULT_ACTION);
                $this->index();
                break;
        }
    }

    protected function getSavedPhotos($model){
        $keys = $this->getSavedKeys();
        $db = new Database();
        $photos = array();
        foreach($keys as $key){
            $photo = $db->getPhoto($key);
            if($photo != null && ($photo->ownerId == $model->userId || $photo->private == false)){
                $photos[] = $photo;
            } else {
                $this->removeSaved($photo);
            }
        }
        return $photos;
    }

    protected function getSavedKeys(){
        return $this->session(self::SAVED_SESSION) != null ? $this->session(self::SAVED_SESSION) : array();
    }

    protected function addSaved($photo){
        $saved = $this->getSavedKeys();
        if(in_array($photo->id, $saved))
            return;
        $saved[] = $photo->id;
        $this->setSession(self::SAVED_SESSION, $saved);
    }

    protected function removeSaved($photo){
        $saved = $this->getSavedKeys();
        $saved = array_diff($saved, array($photo->id));
        $this->setSession(self::SAVED_SESSION, $saved);
    }

    protected function generatePhotosAndSave(&$model, $id){
        $baseFilePath = $this->saveUploadedFile($model->image, $id . '.' . $model->extension);
        $this->generateThumbnail($model, $id, $baseFilePath);
        $this->generateWatermark($model, $id, $baseFilePath);
    }

    protected function saveUploadedFile($file, $filename){
        $targetFilePath = PhotoController::IMAGE_PATH . $filename;
        $tmp_path = $file['tmp_name'];
        if(!is_dir(PhotoController::IMAGE_PATH)){
            mkdir(PhotoController::IMAGE_PATH);
        }
        move_uploaded_file($tmp_path, $targetFilePath);
        return $targetFilePath;
    }
    protected function validatePhoto(&$model){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileName = $model->image['tmp_name'];
        if ($fileName == null){ // upload failed, probably file too big or no file selected
            return 1;
        }
        $fileType = finfo_file($finfo, $fileName);
        if ($fileType != "image/jpeg" && $fileType != "image/png") {
            return 2;
        }
        switch($fileType){
            case "image/jpeg":
                $model->extension = "jpg";
                break;
            case "image/png":
                $model->extension = "png";
                break;
        }
        $fileSize = filesize($model->image['tmp_name']);
        if ($fileSize > PhotoController::IMAGE_MAX_SIZE) {
            return 3;
        }
        return 0;
    }

    protected function generateThumbnail($model, $id, $filename){
        $image = null;
        switch($model->extension){
            case "jpg":
                $image = imagecreatefromjpeg($filename);
                break;
            case "png":
                $image = imagecreatefrompng($filename);
                break;
        }
        $width = imagesx($image);
        $height = imagesy($image);
        $newWidth = 200;
        $newHeight = 125;
        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $thumbnailPath = PhotoController::IMAGE_PATH . $id . '-min.' . $model->extension;
        switch($model->extension){
            case "jpg":
                imagejpeg($thumbnail, $thumbnailPath);
                break;
            case "png":
                imagepng($thumbnail, $thumbnailPath);
                break;
        }
    }

    protected function generateWatermark($model, $id, $filename){
        $image = null;
        switch($model->extension){
            case "jpg":
                $image = imagecreatefromjpeg($filename);
                break;
            case "png":
                $image = imagecreatefrompng($filename);
                break;
        }
        $height = imagesy($image);
        $witdh = imagesx($image);
        imagettftext($image, 100, 45, $height/2, $witdh/2, imagecolorallocate($image, 255, 255, 255), __BASEDIR__ . 'web/static/fonts/Lato.ttf', $model->watermark);
        $watermarkPath = PhotoController::IMAGE_PATH . $id . '-wm.' . $model->extension;
        switch($model->extension){
            case "jpg":
                imagejpeg($image, $watermarkPath);
                break;
            case "png":
                imagepng($image, $watermarkPath);
                break;
        }
    }
}