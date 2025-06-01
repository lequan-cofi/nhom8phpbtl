<?php
require_once 'models/MicrosoftModel.php';
require_once 'models/KhuyenMaiModel.php';

class MicrosoftController {
    private $model;
    private $khuyenMaiModel;
    private $db;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'Quản trị viên') {
            header('Location: /index.php?page=login_signup');
            exit;
        }
        $this->db = $db;
        $this->model = new MicrosoftModel($db);
        $this->khuyenMaiModel = new KhuyenMaiModel($db);
    }

    public function index() {
        try {
            $khuyenMaiList = $this->khuyenMaiModel->getAllKhuyenMai();
            $selectedKhuyenMai = isset($_GET['khuyenmai']) ? $_GET['khuyenmai'] : null;
            
            if ($selectedKhuyenMai) {
                $products = $this->model->getProductsByKhuyenMai($selectedKhuyenMai);
            } else {
                $products = $this->model->getAllMicrosoftProducts();
            }

            require_once 'views/partials/microshop.php';
        } catch (Exception $e) {
            error_log("Error in index: " . $e->getMessage());
            $products = [];
            $khuyenMaiList = [];
            require_once 'views/partials/microshop.php';
        }
    }

    public function adminIndex() {
        try {
            $khuyenMaiList = $this->khuyenMaiModel->getAllKhuyenMai();
            $selectedKhuyenMai = isset($_GET['khuyenmai']) ? $_GET['khuyenmai'] : null;
            
            if ($selectedKhuyenMai) {
                $products = $this->model->getProductsByKhuyenMai($selectedKhuyenMai);
            } else {
                $products = $this->model->getAllMicrosoftProducts();
            }

            require_once 'views/admin/admin_microsoft.php';
        } catch (Exception $e) {
            error_log("Error in adminIndex: " . $e->getMessage());
            $products = [];
            $khuyenMaiList = [];
            require_once 'views/admin/admin_microsoft.php';
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validate required fields
                if (empty($_POST['title']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['product_link'])) {
                    throw new Exception("Vui lòng điền đầy đủ thông tin sản phẩm");
                }

                // Sanitize and prepare data
                $data = [
                    'title' => trim($_POST['title']),
                    'price' => (int)$_POST['price'],
                    'quantity' => (int)$_POST['quantity'],
                    'product_link' => trim($_POST['product_link']),
                    'khuyenmai_id' => !empty($_POST['khuyenmai_id']) ? (int)$_POST['khuyenmai_id'] : null
                ];

                // Log the data being sent to the model
                error_log("Creating product with data: " . print_r($data, true));

                if ($this->model->createMicrosoftProduct($data)) {
                    $_SESSION['success'] = "Thêm sản phẩm thành công";
                } else {
                    throw new Exception("Không thể thêm sản phẩm");
                }
            } catch (Exception $e) {
                error_log("Error in create: " . $e->getMessage());
                $_SESSION['error'] = $e->getMessage();
            }
        }
        header('Location: index.php?controller=microsoft&action=adminIndex');
        exit;
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            try {
                $id = $_POST['id'];
                $product = $this->model->getMicrosoftProductById($id);
                if (!$product) {
                    throw new Exception("Không tìm thấy sản phẩm");
                }

                // Validate required fields
                if (empty($_POST['title']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['product_link'])) {
                    throw new Exception("Vui lòng điền đầy đủ thông tin sản phẩm");
                }

                $data = [
                    'title' => trim($_POST['title']),
                    'price' => (int)$_POST['price'],
                    'quantity' => (int)$_POST['quantity'],
                    'product_link' => trim($_POST['product_link']),
                    'khuyenmai_id' => !empty($_POST['khuyenmai_id']) ? (int)$_POST['khuyenmai_id'] : null
                ];

                if ($this->model->updateMicrosoftProduct($id, $data)) {
                    $_SESSION['success'] = "Cập nhật sản phẩm thành công";
                } else {
                    throw new Exception("Không thể cập nhật sản phẩm");
                }
            } catch (Exception $e) {
                error_log("Error in edit: " . $e->getMessage());
                $_SESSION['error'] = $e->getMessage();
            }
        }
        header('Location: index.php?controller=microsoft&action=adminIndex');
        exit;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            try {
                $id = $_POST['id'];
                if ($this->model->deleteMicrosoftProduct($id)) {
                    $_SESSION['success'] = "Xóa sản phẩm thành công";
                } else {
                    throw new Exception("Không thể xóa sản phẩm");
                }
            } catch (Exception $e) {
                error_log("Error in delete: " . $e->getMessage());
                $_SESSION['error'] = $e->getMessage();
            }
        }
        header('Location: index.php?controller=microsoft&action=adminIndex');
        exit;
    }
}
?>
