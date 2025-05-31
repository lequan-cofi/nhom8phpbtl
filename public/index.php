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
$router->dispatch();
?>