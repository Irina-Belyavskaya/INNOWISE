<?php
namespace repositories;

use core\Database;
use core\View;
use Exception;
class UserRepository
{
    protected $database;
    protected $tableName = 'user';

    public function __construct() {
        $config = $GLOBALS['configInfo'];
        $mainDB = Database::getInstance();
        try {
            $this->database = $mainDB->connectToDB($config['hostname'], $config['username'], $config['password'], $config['database']);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function addUserToDB($name, $email, $gender, $status) {
        $sqlRequest = "INSERT INTO `$this->tableName` (`id`, `name`, `email`, `gender`, `status`) VALUES (NULL, '$name','$email', '$gender', '$status');";
        if (!mysqli_query($this->database,$sqlRequest)) {
            throw new Exception('Error on sql query execution');
        }
    }

    public function deleteUserFromDB($id) {
        $sqlRequest = "DELETE FROM `$this->tableName` WHERE `$this->tableName`.`id` = '$id';";
        return mysqli_query($this->database,$sqlRequest);
    }

    public function getUsersFromDB() {
        $sqlRequest = "SELECT * FROM `$this->tableName`;";
        $result = mysqli_query($this->database,$sqlRequest);
        if (!$result) {
            throw new Exception('Error on sql query execution');
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function editUserInDB($name,$email,$gender,$status,$id) {
        $sqlRequest = "UPDATE `$this->tableName` SET `name` = '$name', `email` = '$email', `gender` = '$gender', `status` = '$status' WHERE `id` = '$id';";
        if (!mysqli_query($this->database,$sqlRequest)) {
            throw new Exception('Error on sql query execution');
        }
    }

    public function getConnection() {
        return $this->database;
    }
}