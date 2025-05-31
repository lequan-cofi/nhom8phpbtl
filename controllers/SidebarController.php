<?php
require_once __DIR__ . '/../models/LoaiThietBiModel.php';

class SidebarController {
    private $loaiThietBiModel;

    public function __construct() {
        $this->loaiThietBiModel = new LoaiThietBiModel();
    }

    public function getDeviceTypes() {
        $stmt = $this->loaiThietBiModel->getAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 