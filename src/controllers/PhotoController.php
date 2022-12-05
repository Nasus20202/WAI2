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
        $title = "Wyślij zdjęcie"; $pageId = 1;
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Photo\UploadModel($_POST['title'], $_POST['author'], $_FILES['image'], false, $title, "", $pageId);
            $isFileGood = $this->validatePhoto($model);
            if($isFileGood == 0){
                $photo = new \database\Photo($model->title, $model->author, $model->extension);
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
        $this->saveFile($model, $id . '.' . $model->extension);
    }

    protected function saveFile($model, $filename){
        $file = $model->image;
        $targetFilePath = PhotoController::IMAGE_PATH . $filename;
        $tmp_path = $file['tmp_name'];
        if(!is_dir(PhotoController::IMAGE_PATH)){
            mkdir(PhotoController::IMAGE_PATH);
        }
        move_uploaded_file($tmp_path, $targetFilePath);
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
}