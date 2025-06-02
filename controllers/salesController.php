<?php
require_once __DIR__ . '/../models/SalesModel.php';

class SalesController {
    private $salesModel;
    private $adminSettings;

    public function __construct() {
        $this->salesModel = new SalesModel();
        require_once __DIR__ . '/../models/AdminSalesListModel.php';
        $this->adminSettings = new AdminSalesListModel();
    }

    public function getAllSales() {
        return $this->salesModel->getAllSales();
    }

    public function getSaleById($id) {
        return $this->salesModel->getSaleById($id);
    }

    public function createSale($data) {
        return $this->salesModel->createSale($data);
    }

    public function updateSale($data) {
        return $this->salesModel->updateSale($data);
    }

    public function deleteSale($id) {
        return $this->salesModel->deleteSale($id);
    }

    public function getDevicesByType($typeId, $limit = 5) {
        return $this->salesModel->getDevicesByType($typeId, $limit);
    }

    public function getPromotionalProductsByPromotion($promotionId, $limit = 5) {
        return $this->salesModel->getPromotionalProductsByPromotion($promotionId, $limit);
    }
}

// API endpoint handling
if (isset($_GET['action']) || isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    $controller = new SalesController();
    $action = $_GET['action'] ?? $_POST['action'];
    error_log('Action nhận được: ' . $action);
    try {
        if ($action === 'getAllSales') {
            echo json_encode(['success' => true, 'data' => $controller->getAllSales()]);
        } elseif ($action === 'getSaleById') {
            $id = $_GET['id'] ?? $_POST['id'];
            echo json_encode(['success' => true, 'data' => $controller->getSaleById($id)]);
        } elseif ($action === 'createSale') {
            $result = $controller->createSale($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'updateSale') {
            $result = $controller->updateSale($_POST);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'deleteSale') {
            $id = $_POST['id'] ?? $_GET['id'];
            $result = $controller->deleteSale($id);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'getDevicesByType') {
            if (isset($_GET['typeId'])) {
                $limit = $_GET['limit'] ?? 5;
                echo json_encode(['success' => true, 'data' => $controller->getDevicesByType($_GET['typeId'], $limit)]);
            }
        } elseif ($action === 'getPromotionalProductsByPromotion') {
            if (isset($_GET['promotionId'])) {
                $limit = $_GET['limit'] ?? 5;
                echo json_encode(['success' => true, 'data' => $controller->getPromotionalProductsByPromotion($_GET['promotionId'], $limit)]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
