<?php
require_once __DIR__ . '/../config/database.php';

class KhuyenMaiModel {
    protected $db;
    protected $table = 'khuyenmai';

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả khuyến mãi (chưa bị xóa)
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} WHERE NgayXoa IS NULL ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khuyến mãi theo ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :id AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm khuyến mãi mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (TenKhuyenMai, MucGiamGia, NgayBatDau, NgayKetThuc)
                VALUES (:TenKhuyenMai, :MucGiamGia, :NgayBatDau, :NgayKetThuc)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'TenKhuyenMai' => $data['TenKhuyenMai'],
            'MucGiamGia' => $data['MucGiamGia'],
            'NgayBatDau' => $data['NgayBatDau'],
            'NgayKetThuc' => $data['NgayKetThuc']
        ]);
        return $this->db->lastInsertId();
    }

    // Cập nhật khuyến mãi
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                    TenKhuyenMai = :TenKhuyenMai,
                    MucGiamGia = :MucGiamGia,
                    NgayBatDau = :NgayBatDau,
                    NgayKetThuc = :NgayKetThuc,
                    NgayCapNhat = CURRENT_TIMESTAMP
                WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'TenKhuyenMai' => $data['TenKhuyenMai'],
            'MucGiamGia' => $data['MucGiamGia'],
            'NgayBatDau' => $data['NgayBatDau'],
            'NgayKetThuc' => $data['NgayKetThuc'],
            'id' => $id
        ]);
    }

    // Xóa mềm khuyến mãi
    public function delete($id) {
        $sql = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
