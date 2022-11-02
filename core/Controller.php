<?php
namespace core;

abstract class Controller
{
    public array $route;
    public $model;
    public View $view;

    public function __construct($route) {
        // Save controller and action
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name) {
        $path = 'models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path();
        }
    }
}