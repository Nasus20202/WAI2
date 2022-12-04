<?php
namespace database;

class Photo {
    public $id;
    public $title;
    public $author;
    public $ownerId;
    public $private;

    public function __construct($title, $author, $ownerId = null, $private = false, $id = null){
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->ownerId = $ownerId;
        $this->private = $private;
    }
}