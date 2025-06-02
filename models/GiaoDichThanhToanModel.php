<?php
require_once __DIR__ . '/../config/database.php';
class GiaoDichThanhToanModel {
    protected $db;
    protected $table = 'giaodichthanhtoan';

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả giao dịch theo mã đơn hàng
    public function getByOrderId($orderId) {
        $sql = "SELECT * FROM {$this->table} WHERE MaDonHangThamChieu = :orderId ORDER BY NgayGiaoDich DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 giao dịch theo ID
    public function getOne($id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm giao dịch mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (CongThanhToan, NgayGiaoDich, SoTaiKhoan, TaiKhoanPhu, MaGiaoDichCongTT, NoiDung, LoaiGiaoDich, MoTa, SoTienChuyen, MaDonHangThamChieu, TrangThaiGiaoDich, IDNguoiDung)
                VALUES (:CongThanhToan, :NgayGiaoDich, :SoTaiKhoan, :TaiKhoanPhu, :MaGiaoDichCongTT, :NoiDung, :LoaiGiaoDich, :MoTa, :SoTienChuyen, :MaDonHangThamChieu, :TrangThaiGiaoDich, :IDNguoiDung)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật giao dịch
    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = "UPDATE {$this->table} SET ".implode(',', $fields)." WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Xoá giao dịch
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
} 