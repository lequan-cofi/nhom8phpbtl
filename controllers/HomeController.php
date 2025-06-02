<?php
// controllers/HomeController.php

// Hiện tại chưa cần model cho chỉ riêng phần header (nếu header là tĩnh)
// require_once APP_PATH . '/models/LoaiThietBiModel.php';

class HomeController {

    public function __construct() {
        // Khởi tạo model nếu cần cho header sau này
    }

    public function index() {
        $data = [];
        $data['pageTitle'] = "Trang Chủ - iStore"; // Tiêu đề cho trang

        // Các dữ liệu khác cho header có thể được thêm ở đây nếu cần
        // Ví dụ: số điện thoại, thông tin người dùng nếu đã đăng nhập

        // Lấy sản phẩm mới nhất
        require_once APP_PATH . '/models/ThietbiModel.php';
        $thietbiModel = new ThietBiModel();
        $recentProducts = $thietbiModel->getRecentProducts();

        // Gọi view layout chính, layout sẽ nạp các phần khác
        $contentView = APP_PATH . '/views/home/index.php'; // Trang con sẽ được nạp vào layout
        
        // Kiểm tra file layout tồn tại
        $layoutPath = APP_PATH . '/views/layouts/main_layout.php';
        if (!file_exists($layoutPath)) {
            die("Lỗi: Không tìm thấy file layout chính tại: " . htmlspecialchars($layoutPath));
        }
        require_once $layoutPath;
    }
}
?>