<?php
require_once __DIR__ . '/../models/PosterModel.php';

class PosterController {
    private $model;

    public function __construct() {
        $this->model = new PosterModel();
    }

    public function getAll() {
        $stmt = $this->model->getAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id) {
        $stmt = $this->model->getOne($id);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $this->model->Title = $data['Title'];
        $this->model->Description = $data['Description'];
        $this->model->Image = $data['Image'];
        $this->model->IDKhuyenMai = $data['IDKhuyenMai'];
        $this->model->MaxDisplayProducts = $data['MaxDisplayProducts'];
        $this->model->IsActive = $data['IsActive'] ?? 1;
        return $this->model->create();
    }

    public function update($data) {
        $this->model->ID = $data['ID'];
        $this->model->Title = $data['Title'];
        $this->model->Description = $data['Description'];
        $this->model->Image = $data['Image'];
        $this->model->IDKhuyenMai = $data['IDKhuyenMai'];
        $this->model->MaxDisplayProducts = $data['MaxDisplayProducts'];
        $this->model->IsActive = $data['IsActive'] ?? 1;
        return $this->model->update();
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function getActivePoster() {
        return $this->model->getActivePoster();
    }

    public function getPromotions() {
        return $this->model->getPromotions();
    }
}

// API endpoints
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    $controller = new PosterController();
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if ($action === 'getAll') {
            $data = $controller->getAll();
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
        } elseif ($action === 'getActivePoster') {
            $data = $controller->getActivePoster();
            echo json_encode(['success' => $data ? true : false, 'data' => $data]);
        } elseif ($action === 'getPromotions') {
            $data = $controller->getPromotions();
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
} 