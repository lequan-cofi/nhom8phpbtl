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

                $id = $_GET['id'] ?? null;
                $reflection = new ReflectionMethod($controllerInstance, $method);
                if ($reflection->getNumberOfParameters() > 0) {
                    if ($id !== null) {
                        $controllerInstance->$method($id);
                    } else {
                        die("Thiếu tham số id cho action '$method' trong controller '$controller'.");
                    }
                } else {
                    $controllerInstance->$method();
                }
            } else {
                throw new Exception("Controller not found: $controller");
            }
        } else {
            // Handle 404
            header("HTTP/1.0 404 Not Found");
            require_once 'views/errors/404.php';
        }

        if ($_GET['page'] === 'blog' && $_GET['action'] === 'get') {
            require_once 'controllers/BlogController.php';
            $controller = new BlogController($db);
            $controller->get($_GET['id']);
            exit;
        }

        if ($_GET['page'] === 'cart' && $_GET['action'] === 'add') {
            $controller = new GioHangController();
            $controller->add();
            exit;
        }

        if ($_GET['page'] === 'cart' && $_GET['action'] === 'delete') {
            $controller = new GioHangController();
            $controller->delete();
            exit;
        }

        // Trong Router.php, thêm case cho thanh toán
        if ($_GET['page'] === 'thanhtoan') {
            require_once APP_PATH . '/controllers/ThanhToanController.php';
            $controller = new ThanhToanController();
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                $controller->$action();
            } else {
                $controller->index();
            }
        }
    }
} 