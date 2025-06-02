<?php
require_once __DIR__ . '/../models/DonHangModel.php';

class OrderController {
    private $donHangModel;

    public function __construct() {
        $this->donHangModel = new DonHangModel();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
        $user = $_SESSION['user'];
        $userId = $user['ID'] ?? $user['id'] ?? null;
        if (!$userId) {
            die('Không xác định được ID người dùng');
        }
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'all';

        $orders = $this->donHangModel->getByUserId($userId);

        if ($selectedStatus !== 'all') {
            $orders = array_filter($orders, function($order) use ($selectedStatus) {
                return $order['TrangThaiDonHang'] === $selectedStatus;
            });
        }
        if ($search !== '') {
            $orders = array_filter($orders, function($order) use ($search) {
                return stripos($order['ID'], $search) !== false || stripos($order['SoDienThoai'], $search) !== false;
            });
        }

        // Phân trang
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = 2;
        $totalOrders = count($orders);
        $totalPages = ceil($totalOrders / $perPage);
        $orders = array_slice($orders, ($page - 1) * $perPage, $perPage);

        require_once APP_PATH . '/views/user/orders.php';
    }

    // Lấy chi tiết đơn hàng (API)
    public function getDetails() {
        header('Content-Type: application/json');
        try {
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
                exit;
            }

            $orderId = $_GET['id'] ?? null;
            if (!$orderId) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
                exit;
            }

            // Lấy thông tin đơn hàng
            $order = $this->donHangModel->getOne($orderId);
            if (!$order) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
                exit;
            }

            // Kiểm tra quyền xem đơn hàng
            $user = $_SESSION['user'];
            $userId = $user['ID'] ?? $user['id'] ?? null;
            if ($order['IDNguoiDung'] != $userId) {
                echo json_encode(['success' => false, 'message' => 'Bạn không có quyền xem đơn hàng này']);
                exit;
            }

            // Lấy chi tiết đơn hàng
            $details = $this->donHangModel->getDetail($orderId);

            echo json_encode([
                'success' => true,
                'order' => $order,
                'details' => $details
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
        exit;
    }
} 