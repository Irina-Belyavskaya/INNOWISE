<?php
namespace documentation;

use controllers\UserController;

/*var_dump(class_exists( "C:/WebData/INNOWISE/controllers/UserController"));
var_dump(class_exists( "..\controllers\UserController"));
var_dump(class_exists( 'INNOWISE\\controllers\\UserController'));
var_dump(class_exists( UserController::class));*/
//echo class_exists($_SERVER['DOCUMENT_ROOT'] . "\INNOWISE\controllers\UserController", true)?'Exist!!!!':'Not exist!';

require($_SERVER['DOCUMENT_ROOT']."/INNOWISE/vendor/autoload.php");
$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT']. "/INNOWISE/controllers"]);
header('Content-Type: application/x-json');
echo $openapi->toJson();





