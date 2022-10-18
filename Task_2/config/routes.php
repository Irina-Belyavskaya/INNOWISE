<?php
namespace config;
require_once 'configInfo.php';

$baseUrl = $GLOBALS['baseUrl'];
return [
    $baseUrl => [
        'controller' => 'users',
        'action' => 'showMain'
    ],
    $baseUrl . '/add' => [
        'controller' => 'users',
        'action' => 'add'
    ],
    $baseUrl . '/showForm' => [
        'controller' => 'users',
        'action' => 'showForm'
    ],
    $baseUrl . '/change' => [
        'controller' => 'users',
        'action' => 'change'
    ],
    $baseUrl . '/update' => [
        'controller' => 'users',
        'action' => 'update'
    ],
    $baseUrl . '/delete' => [
        'controller' => 'users',
        'action' => 'delete'
    ],
];