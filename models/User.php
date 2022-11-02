<?php

namespace models;

use core\Model;
class User extends Model
{

    const TABLENAME = 'user';

    public function getUsers() {
        try {
            return $this->database->getUsersFromDB();
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }

    public function addUser($name,$email,$gender,$status) {
        $users = $this->getUsers();
        if (!$this->validation->checkUser($email, $name, $gender, $status) || !$this->validation->isUniqEmail($email,$this->mainDB,$this->connectionToDB))
            return;
        try {
            $this->database->addUserToDB($name,$email,$gender,$status);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function deleteUser($id) {
        if ($this->database->deleteUserFromDB($id) === false)
            return false;
        return true;
    }

    public function changeUserInfo($name,$email,$gender,$status,$id) {

        if (!$this->validation->checkUser($email, $name, $gender, $status))
            return;
        try {
            $this->database->editUserInDB($name, $email, $gender, $status, $id);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
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
            $sqlRequest = "SELECT * FROM `$tableName` WHERE id_user=" . $id . ";";
            $result = mysqli_fetch_all($this->mainDB->sendRequest($this->connectionToDB,$sqlRequest), MYSQLI_ASSOC);
            return $result[0];
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }

    public function getLimitUsers($from, $limit) {
        try {
            $tableName = self::TABLENAME;
            $sqlRequest = "SELECT * FROM `$tableName` WHERE id_user>0 ORDER BY id_user DESC LIMIT ".$from.",".$limit.";";
            return $this->mainDB->sendRequest($this->connectionToDB,$sqlRequest);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }

    public function getUsersCount() {
        try {
            $tableName = self::TABLENAME;
            $sqlRequest = "SELECT COUNT(*) as count FROM `$tableName`;";
            $result = mysqli_fetch_all($this->mainDB->sendRequest($this->connectionToDB,$sqlRequest), MYSQLI_ASSOC);
            return $result[0]['count'];
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }
}