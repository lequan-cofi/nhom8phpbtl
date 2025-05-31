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
    header('Content-Type: application/json');
    $controller = new SalesController();
    $action = $_GET['action'] ?? $_POST['action'];
    $response = ['success' => false, 'message' => 'Invalid action'];

    switch ($action) {
        case 'getAllSales':
            $response = ['success' => true, 'data' => $controller->getAllSales()];
            break;
        case 'getSaleById':
            if (isset($_GET['id'])) {
                $response = ['success' => true, 'data' => $controller->getSaleById($_GET['id'])];
            }
            break;
        case 'createSale':
            if (isset($_POST['IDThietBi']) && isset($_POST['IDKhuyenMai'])) {
                $response = ['success' => $controller->createSale($_POST)];
            }
            break;
        case 'updateSale':
            if (isset($_POST['ID']) && isset($_POST['IDThietBi']) && isset($_POST['IDKhuyenMai'])) {
                $response = ['success' => $controller->updateSale($_POST)];
            }
            break;
        case 'deleteSale':
            if (isset($_POST['id'])) {
                $response = ['success' => $controller->deleteSale($_POST['id'])];
            }
            break;
        case 'getDevicesByType':
            if (isset($_GET['typeId'])) {
                $limit = $_GET['limit'] ?? 5;
                $response = ['success' => true, 'data' => $controller->getDevicesByType($_GET['typeId'], $limit)];
            }
            break;
        case 'getPromotionalProductsByPromotion':
            if (isset($_GET['promotionId'])) {
                $limit = $_GET['limit'] ?? 5;
                $response = ['success' => true, 'data' => $controller->getPromotionalProductsByPromotion($_GET['promotionId'], $limit)];
            }
            break;
    }

    echo json_encode($response);
    exit;
}
