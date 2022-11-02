<?php

namespace core;

class View
{
    public string $path;
    public array $route;
    public string $layout = 'defaultPage';

    public function __construct($route) {
        $this->route = $route;
        $this->path = $this->route['controller'].'/'. $this->route['action'];
    }

    public function render($title, $vars = []) {
        // Imports variables from an array into the current symbol table
        extract($vars);
        $path = 'views/' . $this->path . '.php';
        if (file_exists($path)) {

            // This function enables output buffering.
            // While output buffering is active, the script does not send output (except headers),
            // instead, the output is stored in an internal buffer.
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once 'views/layouts/' . $this->layout . '.php';
        }
    }

    public function redirect($url) {
        header('location: ' . $url);
        exit;
    }

    public static function errorCode($code) {
        http_response_code($code);
        $path = 'views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
        exit;
    }


}