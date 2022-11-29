<?php

namespace lib;

class Validation
{
    public function checkUser($userInfo) {
        if (!filter_var($userInfo['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $regexp = '/^([а-яА-яa-zA-z]+\s)+([а-яА-яa-zA-z])+$/i';
        if (!preg_match($regexp, $userInfo['name'])) {
            return false;
        }

        if ($userInfo['gender'] !== 'male' && $userInfo['gender'] !== 'female') {
            return false;
        }

        if ($userInfo['status'] !== 'active' && $userInfo['status'] !== 'inactive') {
            return false;
        }

        return true;
    }

    public function isUniqEmail($email, $database,$connectionToDB) {
        $tableName = \models\User::TABLENAME;
        $sqlRequest = "SELECT * FROM `$tableName` WHERE `Email` = '$email';";
        try {
            $result = mysqli_fetch_all($database->sendRequest($connectionToDB, $sqlRequest));
            if ($result) {
                return false;
            }
            return true;
        } catch (\Exception $exception) {
            echo 'Caught exception: ',  $exception->getMessage(), "\n";
            return false;
        }
    }
}