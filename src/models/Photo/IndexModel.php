<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class IndexModel extends BaseModel {
    public $photos;
    public $basePath;
    public function __construct($photos, $status = 0, $basePath = PhotoController::IMAGE_URL){
        parent::__construct($status);
        $this->photos = $photos;
        $this->basePath = $basePath;
    }
}