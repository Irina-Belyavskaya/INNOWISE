<?php

namespace core;

use repositories\UserRepository;
use lib\Validation;
abstract class Model
{
    public $database;
    public $mainDB;
    public $validation;
    public $connectionToDB;

    public function __construct() {
        $this->database = new UserRepository();
        $this->validation = new Validation();
        $this->mainDB = Database::getInstance();
        $this->connectionToDB = $this->database->getConnection();
    }
}