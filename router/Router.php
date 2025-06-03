<?php
// router/Router.php

class Router {
    protected $routes = [];
    protected $controllerNamespace = 'App\\Controllers\\'; // Nếu bạn dùng namespace
    protected $db;

    public function __construct($db) {
        $this->db = $db;
        // Có thể định nghĩa các route tĩnh ở đây nếu muốn
        // $this->addRoute('GET', '/products/{id}', 'ProductController@show');
    }

    // Hàm này có thể được mở rộng để xử lý các phương thức HTTP khác nhau (POST, GET,...)
    // và các mẫu URL phức tạp hơn.
    // Hiện tại, chúng ta làm đơn giản dựa trên $_GET['page'] và $_GET['action']
    public function dispatch() {
        // Lấy 'page' và 'action' từ URL, hoặc đặt giá trị mặc định
        // Ví dụ: index.php?page=home&action=index
        // Hoặc nếu dùng .htaccess: yourdomain.com/home/index -> page=home, action=index
        $page = $_GET['page'] ?? 'home';
        $action = $_GET['action'] ?? 'index';

        // Debug logging
        error_log("Router: Processing page='{$page}', action='{$action}'");

        // Chuyển hướng page=sanpham sang CuahangController
        if (strtolower($page) === 'sanpham') {
            $controllerName = 'CuahangController';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        }
        // Chuyển hướng page=login sang Login_signupController
        else if (strtolower($page) === 'login') {
            $controllerName = 'Login_signupController';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        }
        // Chuyển hướng page=lienhe sang Lienhe_layoutController
        else if (strtolower($page) === 'lienhe') {
            $controllerName = 'Lienhe_layoutController';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        }
        // Chuyển đổi tên page thành tên Controller
        else {
            $controllerName = ucfirst(strtolower($page)) . 'Controller';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        }

        error_log("Router: Looking for controller file at: " . $controllerFile);

        if (file_exists($controllerFile)) {
            error_log("Router: Controller file found");
            require_once $controllerFile;

            // Kiểm tra xem class controller có tồn tại không
            // Nếu bạn dùng namespace, ví dụ: $fullControllerName = "App\\Controllers\\" . $controllerName;
            if (class_exists($controllerName)) {
                error_log("Router: Controller class exists");
                $controllerInstance = new $controllerName($this->db);

                // Kiểm tra xem action (phương thức) có tồn tại trong controller không
                if (method_exists($controllerInstance, $action)) {
                    error_log("Router: Calling action {$action} on {$controllerName}");
                    // Gọi action
                    // Nếu action cần tham số (ví dụ: ID sản phẩm), bạn cần xử lý truyền tham số ở đây
                    // Ví dụ: $id = $_GET['id'] ?? null;
                    // $controllerInstance->$action($id);
                    $controllerInstance->$action();
                } else {
                    error_log("Router: Action {$action} not found in {$controllerName}");
                    $this->notFound("Action '{$action}' không được định nghĩa trong controller '{$controllerName}'.");
                }
            } else {
                error_log("Router: Controller class {$controllerName} not found");
                $this->notFound("Controller class '{$controllerName}' không tồn tại trong file.");
            }
        } else {
            error_log("Router: Controller file not found at {$controllerFile}");
            $this->notFound("Controller file '{$controllerName}.php' không tìm thấy.");
        }

        if (($_GET['page'] ?? '') === 'cart' && ($_GET['action'] ?? '') === 'updateQuantity') {
            $controller = new GioHangController();
            $controller->updateQuantity();
            exit;
        }
    }

    protected function notFound($message = "Trang bạn yêu cầu không tồn tại.") {
        http_response_code(404);
        // Thay vì echo, bạn nên include một view 404 đẹp hơn
        // require_once APP_PATH . '/views/errors/404.php';
        echo "<h1>Lỗi 404</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        // Log lỗi
        error_log("404 Not Found: " . $message . " - Requested URL: " . ($_SERVER['REQUEST_URI'] ?? 'N/A'));
        exit;
    }
    

}
?>