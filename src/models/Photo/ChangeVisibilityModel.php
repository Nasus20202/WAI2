<?php
namespace models\Photo;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class changeVisibilityModel extends BaseModel {
    public $id;
    public $visibility;
    public function __construct($id, $visibility = 'public', $status = 0){
        parent::__construct($status);
        $this->id = $id;
        $this->visibility = $visibility;
    }
}