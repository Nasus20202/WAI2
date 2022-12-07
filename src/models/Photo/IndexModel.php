<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class IndexModel extends BaseModel {
    public $photos;
    public $basePath;
    public $page;
    public $amount;
    public $total;
    public $saved;
    public function __construct($photos, $page = 0, $amount = PhotoController::IMAGES_PER_PAGE, $total = 0, $status = 0, $basePath = PhotoController::IMAGE_URL){
        parent::__construct($status);
        $this->photos = $photos;
        $this->basePath = $basePath;
        $this->page = $page;
        $this->amount = $amount;
        $this->total = $total;
        $this->saved = isset($_SESSION[PhotoController::SAVED_SESSION]) ? $_SESSION[PhotoController::SAVED_SESSION] : array();
    }
}