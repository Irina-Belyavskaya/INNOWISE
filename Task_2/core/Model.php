<?php

namespace core;

use repositories\UserRepository;
use lib\Validation;
abstract class Model
{
    public $database;
    public $validation;

    public function __construct() {
        $this->database = new UserRepository();
        $this->validation = new Validation();
    }
}