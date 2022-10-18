<?php

namespace lib;

class Validation
{
    public function checkUser( $email, $name, $gender, $status, $id = 1): bool {
        if (!$this->checkId($id)) {
            return false;
        }

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

    public function checkId($id): bool {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return false;
        }
        return true;
    }
}