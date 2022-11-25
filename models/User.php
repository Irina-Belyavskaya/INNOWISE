<?php

namespace models;

use core\Model;
use repositories\UserRepository;

class User extends Model
{
    const TABLENAME = 'user';
    public function __construct() {
        parent::__construct();
        $this->database = new UserRepository();
        $this->connectionToDB = $this->database->getConnection();
    }

    public function getUsers() {
        try {
            return $this->database->getUsersFromDB();
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function addUser($newUser) {
        if (!$this->validation->checkUser($newUser) || !$this->validation->isUniqEmail($newUser['email'],$this->mainDB,$this->connectionToDB))
            return ['errorCode' => '422', 'errorText' => 'Unprocessable Entity. Invalid user info.'];
        try {
            $this->database->addUserToDB($newUser);
            return [];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function deleteUser($id) {
        if ($this->database->deleteUserFromDB($id) === false)
            return false;
        return true;
    }

    public function changeUserInfo($changedUser) {
        if (!$this->validation->checkUser($changedUser))
            return ['errorCode' => '422', 'errorText' => 'Unprocessable Entity. Invalid user info.'];
        try {
            $this->database->editUserInDB($changedUser);
            return [];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function checkUniqEmail($email) {
        if (!$this->validation->isUniqEmail($email,$this->mainDB,$this->connectionToDB))
           return false;
        return true;
    }

    public function findUser($id) {
        try {
            $tableName = self::TABLENAME;
            $sqlRequest = "SELECT * FROM `$tableName` WHERE id=" . $id . ";";
            $result = mysqli_fetch_all($this->mainDB->sendRequest($this->connectionToDB,$sqlRequest), MYSQLI_ASSOC);
            return $result[0];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function getLimitUsers($from, $limit) {
        try {
            $tableName = self::TABLENAME;
            $sqlRequest = "SELECT * FROM `$tableName` WHERE id>0 ORDER BY id DESC LIMIT ".$from.",".$limit.";";
            return mysqli_fetch_all($this->mainDB->sendRequest($this->connectionToDB,$sqlRequest), MYSQLI_ASSOC);
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function getUsersCount() {
        try {
            $tableName = self::TABLENAME;
            $sqlRequest = "SELECT COUNT(*) as count FROM `$tableName`;";
            $result = mysqli_fetch_all($this->mainDB->sendRequest($this->connectionToDB,$sqlRequest), MYSQLI_ASSOC);
            return $result[0]['count'];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }
}