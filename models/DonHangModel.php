<?php
require_once __DIR__ . '/../config/database.php';
class DonHangModel {
    private $db;
    public function __construct() {
        $this->db = db_connect();
    }
    // Lấy danh sách đơn hàng theo ID người dùng
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE IDNguoiDung = ? AND NgayXoa IS NULL ORDER BY NgayTao DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy chi tiết đơn hàng
    public function getDetail($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM chitietdonhang WHERE IDDonHang = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 