<?php
namespace repositories;

use core\View;
use Exception;
class UserRepository
{
    protected $database;
    protected $tableName = 'user';

    public function __construct() {
        $config = $GLOBALS['configInfo'];
        $this->database = mysqli_connect($config['hostname'],$config['username'],$config['password'],$config['database']);
        if (mysqli_connect_errno()) {
            throw new Exception('Error sql connection');
        }
        $this->tableName = $config['tableName'];
    }

    public function addUserToDB($name, $email, $gender, $status) {
        $sqlRequest = "INSERT INTO `$this->tableName` (`id_user`, `FIO`, `Email`, `Gender`, `Status`) VALUES (NULL, '$name','$email', '$gender', '$status');";
        if (!mysqli_query($this->database,$sqlRequest)) {
            throw new Exception('Error on sql query execution');
        }
    }

    public function deleteUserFromDB($id) {
        $sqlRequest = "DELETE FROM `$this->tableName` WHERE `$this->tableName`.`id_user` = '$id';";
        return mysqli_query($this->database,$sqlRequest);
    }

    public function getUsersFromDB(): array {
        $sqlRequest = "SELECT * FROM `$this->tableName`;";
        $result = mysqli_query($this->database,$sqlRequest);
        if (!$result) {
            throw new Exception('Error on sql query execution');
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function editUserInDB($name,$email,$gender,$status,$id) {
        $sqlRequest = "UPDATE `$this->tableName` SET `FIO` = '$name', `Email` = '$email', `Gender` = '$gender', `Status` = '$status' WHERE `$this->tableName`.`id_user` = '$id';";
        if (!mysqli_query($this->database,$sqlRequest)) {
            throw new Exception('Error on sql query execution');
        }
    }

    public function sendRequest($sqlRequest): array {
        $result = mysqli_query($this->database,$sqlRequest);
        if (!$result) {
            throw new Exception('Error on sql query execution');
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}