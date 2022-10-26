<?php

namespace models;

use core\Model;
class User extends Model
{

    const TABLENAME = 'user';

    public function getRecords(): array {
        try {
            return $this->database->getUsersFromDB();
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }

    public function addUser($name,$email,$gender,$status) {
        $users = $this->getRecords();
        if (!$this->validation->checkUser($email, $name, $gender, $status) || !$this->validation->isUniqEmail($email,$this->database))
            return;
        try {
            $this->database->addUserToDB($name,$email,$gender,$status);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function deleteUser($id): bool {
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

    public function checkUniqEmail($email): bool {
        if (!$this->validation->isUniqEmail($email,$this->database))
           return false;
        return true;
    }

    public function findRecord($id) {
        try {
            $users = $this->database->getUsersFromDB();
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
        foreach ($users as $user) {
            if ($user['id_user'] === $id)
                return $user;
        }
        return [];
    }
}