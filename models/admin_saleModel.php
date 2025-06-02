<?php
require_once __DIR__ . '/../config/database.php';

class AdminSaleModel {
    private $db;
    private $table = 'sanpham_khuyenmai';

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả bản ghi, join với thiết bị và khuyến mãi
    public function getAll() {
        $sql = "SELECT s.ID, s.IDThietBi, t.Ten as TenThietBi, t.Gia, s.IDKhuyenMai, k.TenKhuyenMai, k.MucGiamGia, k.NgayBatDau, k.NgayKetThuc, s.NgayTao, s.NgayCapNhat
                FROM {$this->table} s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE t.NgayXoa IS NULL AND (k.NgayXoa IS NULL OR k.NgayXoa IS NULL)
                ORDER BY s.NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một bản ghi
    public function getOne($id) {
        $sql = "SELECT s.ID, s.IDThietBi, t.Ten as TenThietBi, t.Gia, s.IDKhuyenMai, k.TenKhuyenMai, k.MucGiamGia, k.NgayBatDau, k.NgayKetThuc, s.NgayTao, s.NgayCapNhat
                FROM {$this->table} s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE s.ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (IDThietBi, IDKhuyenMai) VALUES (:IDThietBi, :IDKhuyenMai)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    // Cập nhật
    public function update($data) {
        $sql = "UPDATE {$this->table} SET IDThietBi = :IDThietBi, IDKhuyenMai = :IDKhuyenMai, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :ID";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ID' => $data['ID'],
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    // Xóa
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Lấy tất cả thiết bị
    public function getAllThietBi() {
        $sql = "SELECT ID, Ten FROM thietbi WHERE NgayXoa IS NULL ORDER BY Ten ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả khuyến mãi
    public function getAllKhuyenMai() {
        $sql = "SELECT ID, TenKhuyenMai FROM khuyenmai WHERE NgayXoa IS NULL ORDER BY TenKhuyenMai ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
