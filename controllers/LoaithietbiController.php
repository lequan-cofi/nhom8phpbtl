<?php
require_once __DIR__ . '/../models/LoaiThietBiModel.php';

class LoaithietbiController {
    private $loaiThietBiModel;

    public function __construct() {
        $this->loaiThietBiModel = new LoaiThietBiModel();
    }

    public function getAll() {
        $stmt = $this->loaiThietBiModel->getAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id) {
        $this->loaiThietBiModel->ID = $id;
        $stmt = $this->loaiThietBiModel->getOne();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function handleImageUpload($fileInput, $urlInput) {
        if (!empty($urlInput)) {
            return $urlInput;
        }
        if (isset($fileInput) && $fileInput['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/loaithietbi/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid('ltb_') . '_' . basename($fileInput['name']);
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($fileInput['tmp_name'], $targetFile)) {
                // Trả về đường dẫn tương đối để lưu vào DB
                return '/iStore_PHP_Backend/uploads/loaithietbi/' . $fileName;
            }
        }
        return null;
    }

    public function create($data) {
        $url = $data['DuongDanHinhAnh'] ?? '';
        $file = $_FILES['DuongDanHinhAnhFile'] ?? null;
        $this->loaiThietBiModel->Ten = $data['Ten'];
        $this->loaiThietBiModel->DuongDanHinhAnh = $this->handleImageUpload($file, $url);
        $this->loaiThietBiModel->DuongDanLienKet = $data['DuongDanLienKet'] ?? null;
        return $this->loaiThietBiModel->create();
    }

    public function update($data) {
        $url = $data['DuongDanHinhAnh'] ?? '';
        $file = $_FILES['DuongDanHinhAnhFile'] ?? null;
        $this->loaiThietBiModel->ID = $data['ID'];
        $this->loaiThietBiModel->Ten = $data['Ten'];
        $this->loaiThietBiModel->DuongDanHinhAnh = $this->handleImageUpload($file, $url);
        $this->loaiThietBiModel->DuongDanLienKet = $data['DuongDanLienKet'] ?? null;
        return $this->loaiThietBiModel->update();
    }

    public function delete($id) {
        $this->loaiThietBiModel->ID = $id;
        return $this->loaiThietBiModel->delete();
    }

    public function getAllWithProductCount() {
        $stmt = $this->loaiThietBiModel->getAllWithProductCount();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    $controller = new LoaithietbiController();

    header('Content-Type: application/json; charset=utf-8');

    try {
        if ($action === 'create') {
            $result = $controller->create($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'update') {
            $result = $controller->update($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'delete') {
            $id = $_GET['id'] ?? $_POST['id'];
            $result = $controller->delete($id);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'getOne') {
            $id = $_GET['id'] ?? $_POST['id'];
            $data = $controller->getOne($id);
            echo json_encode(['success' => $data ? true : false, 'data' => $data]);
        } elseif ($action === 'getAllWithProductCount') {
            $data = $controller->getAllWithProductCount();
            echo json_encode(['success' => $data ? true : false, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
