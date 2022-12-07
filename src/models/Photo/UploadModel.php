<?php
namespace models\Photo;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class UploadModel extends BaseModel {
    public $title;
    public $author;
    public $watermark;
    public $private;
    public $image;
    public $extension;
    public function __construct($title, $author, $watermark, $image, $private = false, $status = 0){
        parent::__construct($status);
        $this->title = $title;
        $this->author = $author;
        $this->watermark = $watermark;
        $this->private = $private;
        $this->image = $image;
    }
}