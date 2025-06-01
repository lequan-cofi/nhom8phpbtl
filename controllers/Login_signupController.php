<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Signup_LoginModel.php';

class Login_signupController {
    private $db;
    private $authModel;

    public function __construct() {
        $this->db = db_connect();
        $this->authModel = new Signup_Login($this->db);
    }

    public function index() {
        // Load the login/signup view
        require_once __DIR__ . '/../views/layouts/login_signup.php';
    }

    public function signin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate input
            if (empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ thông tin";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Use model to handle login
            $result = $this->authModel->login($email, $password);
            
            if ($result['success']) {
                // Set session variables (lưu toàn bộ user)
                $_SESSION['user'] = $result['user'];
                // Phân quyền điều hướng
                header('Location: ' . BASE_URL . '/index.php');
                exit();
            } else {
                $error = $result['message'];
                require_once __DIR__ . '/../views/layouts/login_signup.php';
            }
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $gender = $_POST['gender'] ?? '';

            // Validate input
            if (empty($name) || empty($email) || empty($password) || empty($password_confirm) || 
                empty($phone) || empty($address) || empty($gender)) {
                $error = "Vui lòng điền đầy đủ thông tin";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Validate phone format (Vietnamese phone number)
            if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $error = "Số điện thoại không hợp lệ";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Validate password match
            if ($password !== $password_confirm) {
                $error = "Mật khẩu xác nhận không khớp";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Validate password strength
            if (strlen($password) < 8) {
                $error = "Mật khẩu phải có ít nhất 8 ký tự";
                require_once __DIR__ . '/../views/layouts/login_signup.php';
                return;
            }

            // Use model to handle signup
            $result = $this->authModel->signup($name, $email, $password, $phone, $address, $gender);
            
            if ($result['success']) {
                $success = $result['message'];
                require_once __DIR__ . '/../views/layouts/login_signup.php';
            } else {
                $error = $result['message'];
                require_once __DIR__ . '/../views/layouts/login_signup.php';
            }
        }
    }

    public function logout() {
        // Destroy session
        session_destroy();
        
        // Redirect to home page
        header('Location: ' . BASE_URL . '/index.php');
        exit();
    }
} 