<?php
namespace App\Core\abstract;
use App\Core\Database;

use App\core\App;
class AbstractRepository{
protected Database $database;

public function __construct(){

$this->database=App::getDependencies('database');
}


}