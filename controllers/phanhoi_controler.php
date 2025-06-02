<?php
require_once __DIR__ . '/../models/Phanhoi_lienheModel.php';
require_once __DIR__ . '/../models/LienHeModel.php';

class Phanhoi_Controller {
    private $phanhoiModel;
    private $lienheModel;

    public function __construct() {
        $this->phanhoiModel = new Phanhoi_lienheModel();
        $this->lienheModel = new LienHeModel();
    }

    // Hiển thị danh sách liên hệ để phản hồi
    public function index() {
        $contacts = $this->lienheModel->getAll()->fetchAll(PDO::FETCH_ASSOC);
        require APP_PATH . '/views/admin/admin_phanhoi.php';
    }

    // Lưu phản hồi
    public function create() {
        $idLienHe = $_POST['IDLienHe'] ?? null;
        $noiDung = $_POST['NoiDung'] ?? '';
        if ($idLienHe && $noiDung) {
            $this->phanhoiModel->create([
                'IDLienHe' => $idLienHe,
                'NoiDung' => $noiDung
            ]);
            // Cập nhật trạng thái liên hệ
            $this->lienheModel->updateStatus($idLienHe, 'Đã xử lý');
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
        exit;
    }

    // Hiển thị toàn bộ danh sách phản hồi
    public function list() {
        $phanhois = $this->phanhoiModel->getAll();
        require APP_PATH . '/views/admin/admin_phanhoi_list.php';
    }
}

// Router đơn giản
$action = $_GET['action'] ?? 'index';
$controller = new Phanhoi_Controller();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
