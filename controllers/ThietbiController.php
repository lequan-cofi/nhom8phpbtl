<?php
require_once __DIR__ . '/../models/ThietbiModel.php';
if ((isset($_GET['admin']) && $_GET['admin'] == 1) || (php_sapi_name() === 'cli-server')) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'Quản trị viên') {
        header('Location: /index.php?page=login_signup');
        exit;
    }
}

class ThietBiController {
    private $model;

    public function __construct() {
        $this->model = new ThietBiModel();
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getOne($id) {
        $stmt = $this->model->getOne($id);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $this->model->Ten = $data['Ten'];
        $this->model->Gia = $data['Gia'];
        $this->model->SoLuongTonKho = $data['SoLuongTonKho'];
        $this->model->IDLoaiThietBi = $data['IDLoaiThietBi'];
        $this->model->DuongDanLienKet = $data['DuongDanLienKet'] ?? null;
        return $this->model->create();
    }

    public function update($data) {
        $this->model->ID = $data['ID'];
        $this->model->Ten = $data['Ten'];
        $this->model->Gia = $data['Gia'];
        $this->model->SoLuongTonKho = $data['SoLuongTonKho'];
        $this->model->IDLoaiThietBi = $data['IDLoaiThietBi'];
        $this->model->DuongDanLienKet = $data['DuongDanLienKet'] ?? null;
        return $this->model->update();
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function getByCategory($categoryId) {
        $stmt = $this->model->getByCategory($categoryId);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $stmt = $this->model->search($keyword);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentProducts() {
        return $this->model->getRecentProducts();
    }

    public function getSpecs($id) {
        $data = $this->model->getThongSoByThietBi($id);
        return ['success' => true, 'data' => $data];
    }
}

// API endpoints
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    $controller = new ThietBiController();
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if ($action === 'getAll') {
            $data = $controller->getAll();
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'getRecentProducts') {
            $data = $controller->getRecentProducts();
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'getOne') {
            $id = $_GET['id'] ?? $_POST['id'];
            $data = $controller->getOne($id);
            echo json_encode(['success' => $data ? true : false, 'data' => $data]);
        } elseif ($action === 'create') {
            $result = $controller->create($_POST);
            echo json_encode($result);
        } elseif ($action === 'update') {
            $result = $controller->update($_POST);
            echo json_encode($result);
        } elseif ($action === 'delete') {
            $id = $_GET['id'] ?? $_POST['id'];
            $result = $controller->delete($id);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'getByCategory') {
            $categoryId = $_GET['categoryId'] ?? $_POST['categoryId'];
            $data = $controller->getByCategory($categoryId);
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'search') {
            $keyword = $_GET['keyword'] ?? $_POST['keyword'];
            $data = $controller->search($keyword);
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'getSpecs') {
            $id = $_GET['id'];
            $data = $controller->getSpecs($id);
            echo json_encode($data);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
} 