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
            return ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function addUserToDB($data) {
        $name = $data['name'];
        $email = $data['email'];
        $gender = $data['gender'];
        $status = $data['status'];
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

    public function editUserInDB($data) {
        $name = $data['name'];
        $email = $data['email'];
        $gender = $data['gender'];
        $status = $data['status'];
        $id = $data['id'];
        $sqlRequest = "UPDATE `$this->tableName` SET `name` = '$name', `email` = '$email', `gender` = '$gender', `status` = '$status' WHERE `id` = '$id';";
        if (!mysqli_query($this->database,$sqlRequest)) {
            throw new Exception('Error on sql query execution');
        }
    }

    public function getConnection() {
        return $this->database;
    }
}