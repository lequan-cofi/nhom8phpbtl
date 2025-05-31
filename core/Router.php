<?php
class Router {
    private $routes = [];

    public function addRoute($path, $controller) {
        $this->routes[$path] = $controller;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (array_key_exists($uri, $this->routes)) {
            list($controller, $method) = explode('@', $this->routes[$uri]);
            $controllerFile = 'controllers/' . $controller . '.php';
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerInstance = new $controller();
                $controllerInstance->$method();
            } else {
                throw new Exception("Controller not found: $controller");
            }
        } else {
            // Handle 404
            header("HTTP/1.0 404 Not Found");
            require_once 'views/errors/404.php';
        }
    }
} 