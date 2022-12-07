<?php
namespace controllers;
use models\BaseModel;
use routing\Router;
use database\Database;
use models\Photo;
require_once('Controller.php');

class PhotoController extends Controller implements IController {
    const IMAGE_PATH = __BASEDIR__.'/web/images/';
    const IMAGE_URL = '/images/';
    public function index(){
        $title = "Galeria zdjęć";
        $this->loadModel();
        $db = new Database();
        $photos = $db->getPhotos();
        $model = new \models\Photo\IndexModel($photos, $title);
        $this->render($model);
    }
    public function upload(){
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
    public function dispatch(){
        switch($this->getAction()){
            case 'upload':
                $this->upload();
                break;
            default:
                $this->setAction(\routing\FrontController::DEFAULT_ACTION);
                $this->index();
                break;
        }
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
        if ($fileSize > 1*1024*1024) {
            return 3;
        }
        return 0;
    }

    public function generateThumbnail($model, $id, $filename){
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

    public function generateWatermark($model, $id, $filename){
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