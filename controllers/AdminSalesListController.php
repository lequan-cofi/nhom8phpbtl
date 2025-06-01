<?php
require_once __DIR__ . '/../models/AdminSalesListModel.php';

class AdminSalesListController {
    private $adminSalesListModel;

    public function __construct() {
        if ((isset($_GET['admin']) && $_GET['admin'] == 1) || (php_sapi_name() === 'cli-server')) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            if (empty($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'Quản trị viên') {
                header('Location: /index.php?page=login_signup');
                exit;
            }
        }
        $this->adminSalesListModel = new AdminSalesListModel();
    }

    public function getAllSettings() {
        $stmt = $this->adminSalesListModel->getAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSettingById($id) {
        $stmt = $this->adminSalesListModel->getOne($id);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSetting($data) {
        $this->adminSalesListModel->IDLoaiThietBi = $data['IDLoaiThietBi'];
        $this->adminSalesListModel->SoLuongHienThi = $data['SoLuongHienThi'];
        $this->adminSalesListModel->IsActive = $data['IsActive'] ?? 1;
        return $this->adminSalesListModel->create();
    }

    public function updateSetting($data) {
        $this->adminSalesListModel->ID = $data['ID'];
        $this->adminSalesListModel->IDLoaiThietBi = $data['IDLoaiThietBi'];
        $this->adminSalesListModel->SoLuongHienThi = $data['SoLuongHienThi'];
        $this->adminSalesListModel->IsActive = $data['IsActive'] ?? 1;
        return $this->adminSalesListModel->update();
    }

    public function deleteSetting($id) {
        return $this->adminSalesListModel->delete($id);
    }

    public function getDeviceTypes() {
        return $this->adminSalesListModel->getDeviceTypes();
    }

    public function getActiveSettings() {
        return $this->adminSalesListModel->getActiveSettings();
    }
}

// API endpoints
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    $controller = new AdminSalesListController();
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if ($action === 'getAllSettings') {
            $data = $controller->getAllSettings();
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'getSettingById') {
            $id = $_GET['id'] ?? $_POST['id'];
            $data = $controller->getSettingById($id);
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => $data ? true : false, 'data' => $data]);
        } elseif ($action === 'createSetting') {
            $result = $controller->createSetting($_POST);
            if (ob_get_length()) ob_clean();
            echo json_encode($result);
        } elseif ($action === 'updateSetting') {
            $result = $controller->updateSetting($_POST);
            if (ob_get_length()) ob_clean();
            echo json_encode($result);
        } elseif ($action === 'deleteSetting') {
            $id = $_GET['id'] ?? $_POST['id'];
            $result = $controller->deleteSetting($id);
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => $result, 'message' => $result ? 'Xóa thành công' : 'Không thể xóa']);
        } elseif ($action === 'getDeviceTypes') {
            $data = $controller->getDeviceTypes();
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => true, 'data' => $data]);
        } elseif ($action === 'getActiveSettings') {
            $data = $controller->getActiveSettings();
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            if (ob_get_length()) ob_clean();
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        if (ob_get_length()) ob_clean();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
} 