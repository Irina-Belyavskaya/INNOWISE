<?php

namespace lib;

class Validation
{
    public function checkUser($email, $name, $gender, $status): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $regexp = '/^([а-яА-яa-zA-z]+\s)+([а-яА-яa-zA-z])+$/i';
        if (!preg_match($regexp, $name)) {
            return false;
        }

        if ($gender !== 'male' && $gender !== 'female') {
            return false;
        }

        if ($status !== 'active' && $status !== 'inactive') {
            return false;
        }

        return true;
    }

    public function isUniqEmail($email, $database): bool {
        //$config = $GLOBALS['configInfo'];
        $tableName = \models\User::TABLENAME;
        $sqlRequest = "SELECT * FROM `$tableName` WHERE `Email` = '$email';";
        $result = $database->sendRequest($sqlRequest);
        if ($result) {
            return false;
        }
        return true;
    }
}