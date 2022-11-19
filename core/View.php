<?php

namespace core;

require_once 'vendor/autoload.php';
class View
{
    public string $path;
    public array $route;
    private $twig;

    public function __construct($route) {
        $this->route = $route;
        $this->path = $this->route['controller'].'/'. $this->route['action'];

        // Load twig
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $this->twig = new \Twig\Environment($loader);
    }

    public function render($vars = []) {
        try {
            $path = $this->path.'.html';
            echo $this->twig->render($path, $vars);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function redirect($url) {
        header('location: ' . $url);
        exit;
    }

    public static function error($vars) {
        $path = 'errors/error.html';
        try {
            // Load twig
            $loader = new \Twig\Loader\FilesystemLoader('views');
            $twig = new \Twig\Environment($loader);
            echo $twig->render($path, $vars);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
        exit;
    }


}