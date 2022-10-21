<?php

namespace lib;

class Validation
{
    public function checkUser( $email, $name, $gender, $status): bool {
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

    public function isUniqEmail($users, $email, $id): bool {
        foreach ($users as $user) {
            if ($user['Email'] === $email && $user['id_user'] != $id)
                return false;
        }
        return true;
    }
}