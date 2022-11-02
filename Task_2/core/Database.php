<?php

namespace core;

use Exception;
class Database
{
    private static array $instances = [];

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    static public function getInstance() {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }
        return self::$instances[$cls];
    }

    public function connectToDB($hostname, $username, $password, $databaseName) {
        $database = mysqli_connect($hostname,$username,$password,$databaseName);
        if (mysqli_connect_errno()) {
            throw new Exception('Error sql connection');
        }
        return $database;
    }

    public function sendRequest($database, $sqlRequest) {
        $result = mysqli_query($database,$sqlRequest);
        if (!$result) {
            throw new Exception('Error on sql query execution');
        } else {
            return  $result;
        }
    }
}