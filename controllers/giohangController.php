<?php
require_once __DIR__ . '/../models/giohangModel.php';

class GioHangController {
    private $gioHangModel;

    public function __construct() {
        $this->gioHangModel = new GioHangModel();
    }

    // Hiển thị trang giỏ hàng
    public function index() {
        
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            die('Bạn cần đăng nhập để xem giỏ hàng!');
        }
        $userId = $user['id'] ?? $user['ID'] ?? null;
        if (!$userId) {
            die('Không xác định được ID người dùng!');
        }
        $cartItems = $this->gioHangModel->getByUser($userId);
        require_once APP_PATH . '/views/layouts/giohang_layout.php';
    }

    // Các hàm thêm/xóa/cập nhật giỏ hàng có thể bổ sung sau

    public function add() {
        // Kiểm tra đăng nhập
        $user = $_SESSION['user'] ?? null;
        $userId = $user['id'] ?? $user['ID'] ?? null;
        if (!$userId) {
            // Chuyển hướng sang trang đăng nhập
            header('Location: ' . BASE_URL . '/index.php?page=login_signup');
            exit();
        }
        // Lấy dữ liệu sản phẩm từ POST
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        if ($productId) {
            $this->gioHangModel->add($userId, $productId, $quantity);
            // Chuyển hướng sang trang giỏ hàng hoặc thông báo thành công
            header('Location: ' . BASE_URL . '/index.php?page=cart');
            exit();
        } else {
            die('Thiếu thông tin sản phẩm!');
        }
    }

    public function delete() {
        $user = $_SESSION['user'] ?? null;
        $userId = $user['id'] ?? $user['ID'] ?? null;
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            exit;
        }
        $itemId = $_POST['item_id'] ?? null;
        if ($itemId) {
            $this->gioHangModel->delete($itemId);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu ID mục giỏ hàng']);
        }
        exit;
    }

    public function updateQuantity() {
        $user = $_SESSION['user'] ?? null;
        $userId = $user['id'] ?? $user['ID'] ?? null;
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            exit;
        }
        $itemId = $_POST['item_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        if ($itemId && $quantity) {
            $this->gioHangModel->updateQuantity($itemId, $quantity);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
        exit;
    }
}
