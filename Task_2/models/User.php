<?php

namespace models;

use core\Model;
class User extends Model
{

    const TABLENAME = 'user';

    public function getRecords(): array {
        try {
            return $this->database->getRecordsFromDB();
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
            $this->database->addRecordToDB($name,$email,$gender,$status);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function deleteUser($id): bool {
        if ($this->database->deleteRecordFromDB($id) === false)
            return false;
        return true;
    }

    public function changeUserInfo($name,$email,$gender,$status,$id) {

        if (!$this->validation->checkUser($email, $name, $gender, $status))
            return;
        try {
            $this->database->editRecordInDB($name, $email, $gender, $status, $id);
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
            $users = $this->database->getRecordsFromDB();
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