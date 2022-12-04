<?php
namespace models\Photo;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class UploadModel extends BaseModel {
    public $title;
    public $author;
    public $private;
    public $image;
    public $extension;
    public function __construct($title, $author, $image, $private = false, $message = "", $userLoggedIn = false, $username = null, $userEmail = null){
        parent::__construct($message, $userLoggedIn, $username, $userEmail);
        $this->title = $title;
        $this->author = $author;
        $this->private = $private;
        $this->image = $image;
    }
}