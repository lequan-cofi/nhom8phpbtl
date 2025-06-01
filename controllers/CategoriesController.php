<?php
require_once __DIR__ . '/../models/LoaiThietBiModel.php';
require_once __DIR__ . '/../models/Thietbi.php';

class CategoriesController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function index() {
        $loaiModel = new LoaiThietBiModel();
        $deviceTypes = $loaiModel->getAllWithProductCount()->fetchAll(PDO::FETCH_ASSOC);
        $devices = [];
        $selectedType = null;
        if (isset($_GET['category_id'])) {
            $selectedType = (int)$_GET['category_id'];
            $thietbiModel = new ThietBiModel();
            $devices = $thietbiModel->getByCategory($selectedType)->fetchAll(PDO::FETCH_ASSOC);
        }
        require __DIR__ . '/../views/layouts/danhmuc_layout.php';
    }
}
