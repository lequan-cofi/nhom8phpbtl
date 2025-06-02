<?php
require_once __DIR__ . '/../models/DonHangModel.php';
require_once __DIR__ . '/../models/GioHangModel.php';
require_once __DIR__ . '/../config/database.php';

set_exception_handler(function($e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
    exit;
});
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => "PHP Error: $errstr in $errfile:$errline"]);
    exit;
});

class ThanhToanController {
    private $db;
    private $donHangModel;
    private $gioHangModel;

    public function __construct() {
        $this->db = db_connect();
        $this->donHangModel = new DonHangModel();
        $this->gioHangModel = new GioHangModel();
    }

    // Hiển thị trang thanh toán
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
        $user = $_SESSION['user'];
        $userId = $user['ID'] ?? $user['id'] ?? null;
        if (!$userId) {
            // Chuyển hướng hoặc hiển thị lỗi HTML
            die('Không xác định được ID người dùng');
        }
        $cartItems = $this->gioHangModel->getByUser($userId);
        if (empty($cartItems)) {
            // Chuyển hướng hoặc hiển thị lỗi HTML
            die('Giỏ hàng trống');
        }
        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['Gia'] * $item['SoLuong'];
        }
        require_once APP_PATH . '/views/layouts/thanhtoan_layout.php';
    }

    // Xử lý đặt hàng
    public function datHang() {
        header('Content-Type: application/json');
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
                exit;
            }
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để đặt hàng']);
                exit;
            }
            $user = $_SESSION['user'];
            $userId = $user['ID'] ?? $user['id'] ?? null;
            if (!$userId) {
                echo json_encode(['success' => false, 'message' => 'Không xác định được ID người dùng']);
                exit;
            }
            if (empty($_POST['TenKhachHang']) || empty($_POST['SoDienThoai']) || 
                empty($_POST['DiaChiGiaoHang']) || empty($_POST['PhuongThucThanhToan'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
                exit;
            }

            // Lấy thông tin giỏ hàng trước khi tạo đơn hàng
            $cartItems = $this->gioHangModel->getByUser($userId);
            if (empty($cartItems)) {
                echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống']);
                exit;
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['Gia'] * $item['SoLuong'];
            }

            $maChuyenKhoan = $_POST['MaChuyenKhoan'] ?? null;
            $phuongThuc = $_POST['PhuongThucThanhToan'];
            $data = [
                'IDNguoiDung' => $userId,
                'TenKhachHang' => $_POST['TenKhachHang'],
                'GioiTinh' => $_POST['GioiTinh'] ?? null,
                'SoDienThoai' => $_POST['SoDienThoai'],
                'DiaChiGiaoHang' => $_POST['DiaChiGiaoHang'],
                'PhuongThucThanhToan' => $phuongThuc,
                'MaChuyenKhoan' => $maChuyenKhoan,
                'GhiChu' => $_POST['note'] ?? null,
                'TongTien' => $total,
                'TrangThaiDonHang' => 'Chờ xử lý'
            ];

            $this->db->beginTransaction();
            try {
                // Tạo đơn hàng
                $orderId = $this->donHangModel->create($data);
                
                // Thêm chi tiết đơn hàng
                $orderDetails = [];
                foreach ($cartItems as $item) {
                    $orderDetails[] = [
                        'IDThietBi' => $item['IDThietBi'],
                        'SoLuong' => $item['SoLuong'],
                        'Gia' => $item['Gia']
                    ];
                }
                
                if (!$this->donHangModel->addDetail($orderId, $orderDetails)) {
                    throw new Exception('Không thể thêm chi tiết đơn hàng');
                }

                // Xóa giỏ hàng
                $this->gioHangModel->clearByUser($userId);
                
                $this->db->commit();
                
                echo json_encode([
                    'success' => true,
                    'order_id' => $orderId,
                    'total' => $total
                ]);
            } catch (Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage()]);
        }
        exit;
    }
}
