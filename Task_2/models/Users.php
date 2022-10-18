<?php

namespace models;

use core\Model;
class Users extends Model
{
    public function getRecords(): array {
        try {
            return $this->database->getRecordsFromDB();
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
    }

    public function addUser($name,$email,$gender,$status) {
        if (!$this->validation->checkUser($email, $name, $gender, $status))
            return;
        try {
            $this->database->addRecordToDB($name,$email,$gender,$status);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function deleteUser($id): bool {
        if (!$this->validation->checkId($id))
            return false;
        if ($this->database->deleteRecordFromDB($id) === false)
            return false;
        return true;
    }

    public function changeUserInfo($name,$email,$gender,$status,$id) {
        if (!$this->validation->checkUser($email, $name, $gender, $status,(int)$id))
            return;
        try {
            $this->database->editRecordInDB($name, $email, $gender, $status, $id);
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
        }
    }

    public function findRecord($id) {
        try {
            $users = $this->database->getRecordsFromDB();
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return [];
        }
        foreach ($users as $user) {
            if ($user[0] === $id)
                return $user;
        }
        return [];
    }
}