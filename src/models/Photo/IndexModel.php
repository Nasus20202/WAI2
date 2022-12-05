<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class IndexModel extends BaseModel {
    public $photos;
    public $basePath;
    public function __construct($photos, $status = 0, $basePath = PhotoController::IMAGE_URL, $userLoggedIn = false, $username = null, $userEmail = null){
        parent::__construct($status, $userLoggedIn, $username, $userEmail);
        $this->photos = $photos;
        $this->basePath = $basePath;
    }
}