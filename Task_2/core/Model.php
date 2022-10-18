<?php

namespace core;

use repositories\WorkWithUsers;
use lib\Validation;
abstract class Model
{
    public $database;
    public $validation;

    public function __construct() {
        $this->database = new WorkWithUsers();
        $this->validation = new Validation();
    }
}