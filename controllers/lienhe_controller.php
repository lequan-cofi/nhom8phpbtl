<?php
require_once __DIR__ . '/../models/LienHeModel.php';

class LienHe_Controller {
    private $lienHeModel;

    public function __construct() {
        $this->lienHeModel = new LienHeModel();
    }

    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
        require_once APP_PATH . '/views/layouts/lienhe_layout.php';
    }

    public function submitContact() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
        $user = $_SESSION['user'];
        $hoTen = $_POST['HoTen'] ?: ($user['Ten'] ?? '');
        $email = $_POST['Email'] ?: ($user['Email'] ?? '');
        $chuDe = trim($_POST['ChuDe'] ?? '');
        $noiDung = trim($_POST['NoiDung'] ?? '');

        if (!$chuDe || !$noiDung) {
            echo "<script>alert('Vui lòng nhập tiêu đề và nội dung!');window.history.back();</script>";
            exit;
        }

        $data = [
            'HoTen' => $hoTen,
            'Email' => $email,
            'ChuDe' => $chuDe,
            'NoiDung' => $noiDung,
            'TrangThai' => 'Chưa xử lý'
        ];
        $result = $this->lienHeModel->create($data);
        if ($result['success']) {
            echo "<script>alert('Gửi liên hệ thành công!');window.location.href='".BASE_URL."/index.php?page=lienhe';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi gửi liên hệ!');window.history.back();</script>";
        }
        exit;
    }
}

// Router cho controller này
$action = $_GET['action'] ?? 'index';
$controller = new LienHe_Controller();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
} 