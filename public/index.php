<?php
// public/index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

define('APP_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

$protocol = "https://";
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $protocol . $host . ($scriptDir === '/' || $scriptDir === '\\' ? '' : rtrim($scriptDir, '/'));
define('BASE_URL', $baseUrl);

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $paths = [ APP_PATH . '/' . $className . '.php', ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
    $subDirs = ['controllers', 'models', 'router', 'config', 'core'];
    foreach ($subDirs as $subDir) {
        $path = APP_PATH . '/' . $subDir . '/' . basename($className) . '.php';
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once APP_PATH . '/router/Router.php';
require_once APP_PATH . '/config/database.php';

// Initialize database connection
$db = db_connect();

$router = new Router($db);

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if ($page === 'product' && $action === 'detail' && $id) {
    require_once APP_PATH . '/controllers/ProductController.php';
    $controller = new ProductController();
    $controller->detail($id);
    exit;
}

if ($page === 'cart' && $action === 'index') {
    require_once APP_PATH . '/controllers/GioHangController.php';
    $controller = new GioHangController();
    $controller->index();
    exit;
}

if (($page ?? null) === 'cart' && ($action ?? null) === 'add') {
    require_once APP_PATH . '/controllers/GioHangController.php';
    $controller = new GioHangController();
    $controller->add();
    exit;
}

if (($page ?? null) === 'cart' && ($action ?? null) === 'delete') {
    $controller = new GioHangController();
    $controller->delete();
    exit;
}

if (($page ?? null) === 'cart' && ($action ?? null) === 'updateQuantity') {
    $controller = new GioHangController();
    $controller->updateQuantity();
    exit;
}

if ($page === 'thanhtoan') {
    require_once APP_PATH . '/controllers/ThanhToanController.php';
    $controller = new ThanhToanController();
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $controller->$action();
    } else {
        $controller->index();
    }
    exit;
}

if ($page === 'orders') {
    require_once APP_PATH . '/controllers/OrderController.php';
    $controller = new OrderController();
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $controller->$action();
    } else {
        $controller->index();
    }
    exit;
}

if ($page === 'admin_phanhoi') {
    require_once APP_PATH . '/controllers/phanhoi_controler.php';
    exit;
}

$router->dispatch();
?>