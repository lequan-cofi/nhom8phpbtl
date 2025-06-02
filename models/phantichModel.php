<?php
require_once __DIR__ . '/../config/database.php';
class PhanTichModel {
    protected $db;
    public function __construct() {
        $this->db = db_connect();
    }
    // Doanh thu theo ngày
    public function getDoanhThuTheoNgay($from, $to) {
        $sql = "SELECT DATE(NgayTao) as ngay, SUM(TongTien) as doanh_thu
                FROM donhang
                WHERE NgayXoa IS NULL AND TrangThaiDonHang = 'Hoàn thành'
                  AND DATE(NgayTao) BETWEEN :from AND :to
                GROUP BY DATE(NgayTao)
                ORDER BY ngay ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Số đơn hàng theo ngày
    public function getDonHangTheoNgay($from, $to) {
        $sql = "SELECT DATE(NgayTao) as ngay, COUNT(*) as so_don
                FROM donhang
                WHERE NgayXoa IS NULL
                  AND DATE(NgayTao) BETWEEN :from AND :to
                GROUP BY DATE(NgayTao)
                ORDER BY ngay ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Số tài khoản mới theo ngày
    public function getTaiKhoanMoiTheoNgay($from, $to) {
        $sql = "SELECT DATE(NgayTao) as ngay, COUNT(*) as so_tai_khoan
                FROM nguoidung
                WHERE NgayXoa IS NULL
                  AND DATE(NgayTao) BETWEEN :from AND :to
                GROUP BY DATE(NgayTao)
                ORDER BY ngay ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Tổng hợp nhanh cho dashboard
    public function getTongDoanhThu($from, $to) {
        $sql = "SELECT SUM(TongTien) as doanh_thu
                FROM donhang
                WHERE NgayXoa IS NULL AND TrangThaiDonHang = 'Hoàn thành'
                  AND DATE(NgayTao) BETWEEN :from AND :to";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchColumn();
    }
    public function getTongDonHang($from, $to) {
        $sql = "SELECT COUNT(*) as so_don
                FROM donhang
                WHERE NgayXoa IS NULL
                  AND DATE(NgayTao) BETWEEN :from AND :to";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchColumn();
    }
    public function getTongTaiKhoanMoi($from, $to) {
        $sql = "SELECT COUNT(*) as so_tai_khoan
                FROM nguoidung
                WHERE NgayXoa IS NULL
                  AND DATE(NgayTao) BETWEEN :from AND :to";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchColumn();
    }
}
