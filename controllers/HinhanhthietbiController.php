<?php
require_once __DIR__ . '/../models/HinhanhthietbiModel.php';

class HinhanhthietbiController {
    private $model;
    public function __construct() {
        $this->model = new HinhanhthietbiModel();
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getByThietBi($idThietBi) {
        return $this->model->getByThietBi($idThietBi);
    }

    public function getOne($id) {
        return $this->model->getOne($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }
}

// API cho AJAX
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    $controller = new HinhanhthietbiController();
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
            echo json_encode(['success' => $result]);
        } elseif ($action === 'update') {
            $id = $_POST['ID'];
            $result = $controller->update($id, $_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'delete') {
            $id = $_GET['id'] ?? $_POST['id'];
            $result = $controller->delete($id);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'getByThietBi') {
            $idThietBi = $_GET['IDThietBi'] ?? $_POST['IDThietBi'];
            $data = $controller->getByThietBi($idThietBi);
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}