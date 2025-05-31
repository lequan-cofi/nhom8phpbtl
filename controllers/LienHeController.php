<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/LienHeModel.php';
require_once __DIR__ . '/../models/PhanHoiModel.php';

class LienHeController {
    private $lienHeModel;
    private $phanHoiModel;

    public function __construct() {
        $this->lienHeModel = new LienHeModel();
        $this->phanHoiModel = new PhanHoiModel();
    }

    // Handle contact form submission
    public function submitContact() {
        // Kiểm tra phương thức request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        // Lấy dữ liệu từ form
        $data = [
            'HoTen' => $_POST['HoTen'] ?? '',
            'Email' => $_POST['Email'] ?? '',
            'ChuDe' => $_POST['ChuDe'] ?? '',
            'NoiDung' => $_POST['NoiDung'] ?? '',
            'TrangThai' => 'Chưa xử lý'
        ];

        // Validate dữ liệu
        if (empty($data['HoTen']) || empty($data['Email']) || empty($data['ChuDe']) || empty($data['NoiDung'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
            return;
        }

        if (!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
            return;
        }

        // Lưu vào database
        $result = $this->lienHeModel->create($data);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => 'Gửi liên hệ thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi gửi liên hệ']);
        }
    }

    // Handle admin actions
    public function handleAdminAction() {
        $action = $_GET['action'] ?? '';
        $response = ['success' => false, 'message' => ''];

        switch ($action) {
            case 'getAll':
                $stmt = $this->lienHeModel->getAll();
                $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response = ['success' => true, 'data' => $contacts];
                break;

            case 'getOne':
                $id = $_GET['id'] ?? 0;
                $stmt = $this->lienHeModel->getOne($id);
                $contact = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = ['success' => true, 'data' => $contact];
                break;

            case 'updateStatus':
                $id = $_POST['id'] ?? 0;
                $status = $_POST['status'] ?? '';
                if ($this->lienHeModel->updateStatus($id, $status)) {
                    $response = ['success' => true, 'message' => 'Cập nhật trạng thái thành công!'];
                } else {
                    $response = ['success' => false, 'message' => 'Lỗi khi cập nhật trạng thái!'];
                }
                break;

            case 'submitResponse':
                $data = [
                    'IDLienHe' => $_POST['IDLienHe'] ?? 0,
                    'NoiDung' => $_POST['NoiDung'] ?? ''
                ];
                $response = $this->phanHoiModel->create($data);
                break;

            case 'getUnprocessedCount':
                $count = $this->lienHeModel->getUnprocessedCount();
                $response = ['success' => true, 'count' => $count];
                break;

            default:
                $response = ['success' => false, 'message' => 'Action không hợp lệ!'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Handle AJAX requests
if (isset($_GET['action']) || isset($_POST['action'])) {
    $controller = new LienHeController();
    $controller->handleAdminAction();
} 