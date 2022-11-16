<?php
namespace models\API;
class User
{
    public function __construct() {}

    public function getUsers() {
        $users = str_replace('id','id_user',file_get_contents("https://gorest.co.in/public/v2/users"));
        return json_decode($users, true);
    }
}