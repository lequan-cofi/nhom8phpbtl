<?php
require_once __DIR__ . '/../models/admin_saleModel.php';

class AdminSaleController {
    private $model;
    public function __construct() {
        $this->model = new AdminSaleModel();
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getOne($id) {
        return $this->model->getOne($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($data) {
        return $this->model->update($data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function getAllThietBi() {
        return $this->model->getAllThietBi();
    }

    public function getAllKhuyenMai() {
        return $this->model->getAllKhuyenMai();
    }
}

// API endpoint
if (isset($_GET['action']) || isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    $controller = new AdminSaleController();
    $action = $_GET['action'] ?? $_POST['action'];
    try {
        if ($action === 'getAll') {
            echo json_encode(['success' => true, 'data' => $controller->getAll()]);
        } elseif ($action === 'getOne') {
            $id = $_GET['id'] ?? $_POST['id'];
            echo json_encode(['success' => true, 'data' => $controller->getOne($id)]);
        } elseif ($action === 'create') {
            $result = $controller->create($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'update') {
            $result = $controller->update($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'delete') {
            $id = $_POST['id'] ?? $_GET['id'];
            $result = $controller->delete($id);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'getAllThietBi') {
            echo json_encode(['success' => true, 'data' => $controller->getAllThietBi()]);
        } elseif ($action === 'getAllKhuyenMai') {
            echo json_encode(['success' => true, 'data' => $controller->getAllKhuyenMai()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
} 