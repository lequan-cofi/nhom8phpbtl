<?php
require_once __DIR__ . '/../models/ThietBiModel.php';
require_once __DIR__ . '/../models/ThongSoKyThuat.php';
require_once __DIR__ . '/../models/HinhanhthietbiModel.php';

class ProductController {
    public $thietBiModel;
    public $thongSoModel;

    public function __construct() {
        $this->thietBiModel = new ThietBiModel();
        $this->thongSoModel = new ThongSoKyThuatModel();
    }

    public function detail($id) {
        $thietBi = $this->thietBiModel->getOne($id);
        $thietBiData = $thietBi->fetch(PDO::FETCH_ASSOC);

        if (!$thietBiData) {
            echo "<h2>Không tìm thấy sản phẩm!</h2>";
            return;
        }

        $thongSo = $this->thongSoModel->getThongSoByThietBi($id);
        $thongSoData = $thongSo->fetchAll(PDO::FETCH_ASSOC);

        $thongSoNhom = [];
        foreach ($thongSoData as $ts) {
            $nhom = $this->getNhomThongSo($ts['Ten']);
            if (!isset($thongSoNhom[$nhom])) {
                $thongSoNhom[$nhom] = [];
            }
            $thongSoNhom[$nhom][] = $ts;
        }

        $hinhanhModel = new HinhanhthietbiModel();
        $hinhAnhList = $hinhanhModel->getByThietBi($id);

        require APP_PATH . '/views/layouts/product-detail.php';
        // View sẽ dùng $thietBiData, $thongSoNhom, $hinhAnhList
    }

    public function getNhomThongSo($tenThongSo) {
        // Phân loại thông số kỹ thuật theo nhóm
        $nhom = 'Khác';
        
        if (stripos($tenThongSo, 'chip') !== false || stripos($tenThongSo, 'cpu') !== false) {
            $nhom = 'Chip';
        } elseif (stripos($tenThongSo, 'ram') !== false) {
            $nhom = 'RAM';
        } elseif (stripos($tenThongSo, 'pin') !== false || stripos($tenThongSo, 'battery') !== false) {
            $nhom = 'Pin';
        } elseif (stripos($tenThongSo, 'màn hình') !== false || stripos($tenThongSo, 'display') !== false) {
            $nhom = 'Màn hình';
        } elseif (stripos($tenThongSo, 'lưu trữ') !== false || stripos($tenThongSo, 'storage') !== false) {
            $nhom = 'Lưu trữ';
        }

        return $nhom;
    }

    public function getIconForNhom($nhom) {
        $icons = [
            'Chip' => '💻',
            'RAM' => '🧠',
            'Pin' => '🔋',
            'Màn hình' => '📱',
            'Lưu trữ' => '💾',
            'Khác' => '⚡'
        ];

        return $icons[$nhom] ?? '⚡';
    }
} 