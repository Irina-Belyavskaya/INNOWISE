<?php
namespace core;
class Router
{
    protected array $routes= [];
    protected array $params= [];

    function __construct() {
        // Get our routes
        $arr = require_once "config/routes.php";

        // Save routes
        foreach ($arr as $key => $value) {
            $this->add($key,$value);
        }
    }

    public function add($route, $params) {
        // Make each route as regular expression
        $route = '#^'.$route.'$#';

        // Save routes (route -> url, $params -> controller and action)
        $this->routes[$route] = $params;
    }

    public function match(): bool {
        // Get url
        $url = trim($_SERVER['REQUEST_URI'],'/');
        $strings = explode('?',$url);
        $url = $strings[0];

        // Read parameters in url
        if (count($strings) !== 1) {
            $strings = explode('&',$strings[1]);
            foreach ($strings as $string) {
                $temp = explode('=',$string);
                $_GET[$temp[0]] = $temp[1];
            }
        }

        // Find desired route
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url)) {
                // Save found route
                $this->params= $params;
                return true;
            }
        }
        return false;
    }

    public function run() {
        // If found desired path
        if($this->match()) {

            // Make name of controller class
            $pathToController = 'controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            // Check existence of controller class
            if (class_exists($pathToController)) {

                // Make name of action
                $action = $this->params['action'] . 'Action';

                // Check existence of action method
                if (method_exists($pathToController, $action)) {

                    // Create object of controller
                    $controller = new $pathToController($this->params);

                    // Call action
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}