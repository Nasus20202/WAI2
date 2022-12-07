<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class SavedModel extends BaseModel {
    public $saved;
    public $basePath;
    public function __construct($saved = array(),  $status = 0, $basePath = PhotoController::IMAGE_URL){
        parent::__construct($status);
        $this->saved = $saved;
        $this->basePath = $basePath;
    }
}