<?php
namespace config;
require_once 'config.php';

$baseUrl = $GLOBALS['baseUrl'];
return [
    $baseUrl => [
        'controller' => 'user',
        'action' => 'index'
    ],
    $baseUrl . '/create' => [
        'controller' => 'user',
        'action' => 'create'
    ],
    $baseUrl . '/add' => [
        'controller' => 'user',
        'action' => 'add'
    ],
    $baseUrl . '/change' => [
        'controller' => 'user',
        'action' => 'change'
    ],
    $baseUrl . '/update' => [
        'controller' => 'user',
        'action' => 'update'
    ],
    $baseUrl . '/delete' => [
        'controller' => 'user',
        'action' => 'delete'
    ],
    $baseUrl . '/doc' => [
        'controller' => 'user',
        'action' => 'api'
    ],
];