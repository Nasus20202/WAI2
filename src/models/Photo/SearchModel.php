<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class SearchModel extends BaseModel {
    public $query;
    public $result;
    public function __construct($query = null,  $result = array(), $status = 0){
        parent::__construct($status);
        $this->query = $query;
        $this->result = $result;
    }
}