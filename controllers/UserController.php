<?php
require_once __DIR__ . '/../models/Signup_LoginModel.php';
require_once __DIR__ . '/../models/DonHangModel.php';
class UserController {
    private $userModel;
    private $orderModel;
    private $currentUser;
    public function __construct($db) {
        $this->userModel = new Signup_Login($db);
        $this->orderModel = new DonHangModel();
        // Phân quyền và kiểm tra đăng nhập
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /index.php?page=login_signup');
            exit;
        }
        $user = $_SESSION['user'];
        // Bỏ qua kiểm tra nếu action là logout
        $action = $_GET['action'] ?? '';
        if (isset($user['VaiTro']) && $action !== 'logout') {
            if ($user['VaiTro'] === 'Quản trị viên') {
                header('Location: /iStore_PHP_Backend/views/admin/dashboard.php');
                exit;
            }
        }
        $this->currentUser = $user;
    }
    // Xem hồ sơ
    public function taikhoankh() {
        $userId = $this->currentUser['ID'] ?? $this->currentUser['id'] ?? null;
        $user = $this->userModel->getUserById($userId);
        require __DIR__ . '/../views/layouts/taikhoankh.php';
    }
    public function profile() {
        $userId = $this->currentUser['ID'] ?? $this->currentUser['id'] ?? null;
        $user = $this->userModel->getUserById($userId);
        require __DIR__ . '/../views/layouts/taikhoankh.php';
    }
    // Đổi mật khẩu
    public function changePassword() {
        $userId = $this->currentUser['ID'] ?? $this->currentUser['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $msg = '';
            if ($new && $new === $confirm) {
                $ok = $this->userModel->changePassword($userId, $new);
                $msg = $ok ? 'Đổi mật khẩu thành công!' : 'Có lỗi xảy ra.';
            } else {
                $msg = 'Mật khẩu xác nhận không khớp!';
            }
        }
        require __DIR__ . '/../views/layouts/taikhoankh.php';
    }
    // Địa chỉ nhận hàng (giả sử 1 địa chỉ, lấy/sửa trong bảng nguoidung)
    public function address() {
        $userId = $this->currentUser['ID'] ?? $this->currentUser['id'] ?? null;
        $user = $this->userModel->getUserById($userId);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = $_POST['address'] ?? '';
            if ($address) {
                // Lấy kết nối DB từ model
                $reflection = new \ReflectionClass($this->userModel);
                $connProp = $reflection->getProperty('conn');
                $connProp->setAccessible(true);
                $db = $connProp->getValue($this->userModel);
                $stmt = $db->prepare("UPDATE nguoidung SET DiaChi = ? WHERE ID = ?");
                $stmt->execute([$address, $userId]);
                $user['DiaChi'] = $address;
            }
        }
        require __DIR__ . '/../views/layouts/taikhoankh.php';
    }
    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: /iStore_PHP_Backend/public/index.php');
        exit;
    }
    // Đơn hàng của tôi
    public function orders() {
        $userId = $this->currentUser['ID'] ?? $this->currentUser['id'] ?? null;
        $orders = $this->orderModel->getByUserId($userId);
        require __DIR__ . '/../views/layouts/taikhoankh.php';
    }
} 