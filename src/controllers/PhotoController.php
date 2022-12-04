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
        $this->loadModel();
        $db = new Database();
        $photos = $db->getPhotos();
        $model = new \models\Photo\IndexModel($photos, "Galeria zdjęć");
        $this->render($model);
    }
    public function upload(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Photo\UploadModel($_POST['title'], $_POST['author'], $_FILES['image'], "Prześlij zdjęcia");
            $isFileGood = $this->validatePhoto($model);
            if($isFileGood){
                $photo = new \database\Photo($model->title, $model->author, $model->extension);
                $db = new Database();
                $db->createPhoto($photo);
                $this->generatePhotosAndSave($model, $photo->id);
                Router::redirect('photo');
            }
            else{
                $this->render($model);
            }
        }
        else {
            $this->render(new BaseModel());
        }
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'test':
                Router::redirect('account');
                break;
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
        $extension = pathinfo($model->image['name'], PATHINFO_EXTENSION);
        $this->saveFile($model, $id . '.' . $extension);
    }

    protected function saveFile($model, $filename){
        $file = $model->image;
        $targetFilePath = PhotoController::IMAGE_PATH . $filename;
        $tmp_path = $file['tmp_name'];
        move_uploaded_file($tmp_path, $targetFilePath);
    }
    protected function validatePhoto(&$model){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileName = $model->image['tmp_name'];
        $fileType = finfo_file($finfo, $fileName);
        if ($fileType != "image/jpeg" && $fileType != "image/png") {
            $model->message = "Nieobsługiwany format pliku";
            return false;
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
            $model->message = "Plik jest zbyt duży";
            return false;
        }
        return true;
    }
}