<?php
require_once __DIR__ . '/../config/database.php';

class SalesModel {
    private $db;
    private $table = 'SanPham_KhuyenMai';

    public function __construct() {
        $this->db = db_connect();
    }

    public function getAllSales() {
        $sql = "SELECT s.ID, t.ID as IDThietBi, t.Ten as TenThietBi, k.TenKhuyenMai, t.Gia, 
                (t.Gia * (1 - k.MucGiamGia/100)) as GiaKhuyenMai, s.NgayTao,
                k.NgayBatDau, k.NgayKetThuc, k.MucGiamGia,
                (SELECT DuongDanHinhAnh FROM hinhanhthietbi 
                 WHERE IDThietBi = t.ID AND LaAnhChinh = 1 AND NgayXoa IS NULL 
                 LIMIT 1) as HinhAnh
                FROM SanPham_KhuyenMai s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE k.NgayXoa IS NULL
                ORDER BY s.NgayTao DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaleById($id) {
        $sql = "SELECT s.*, t.Ten as TenThietBi, k.TenKhuyenMai, k.MucGiamGia, t.Gia, 
                (t.Gia * (1 - k.MucGiamGia/100)) as GiaKhuyenMai
                FROM {$this->table} s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE s.IDThietBi = :id 
                AND k.NgayXoa IS NULL 
                AND (k.NgayBatDau IS NULL OR k.NgayBatDau <= CURRENT_TIMESTAMP)
                AND (k.NgayKetThuc IS NULL OR k.NgayKetThuc >= CURRENT_TIMESTAMP)
                AND k.MucGiamGia > 0
                ORDER BY k.MucGiamGia DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Debug information
        error_log("SQL Query: " . $sql);
        error_log("Product ID: " . $id);
        error_log("Query Result: " . print_r($result, true));
        
        return $result;
    }

    public function createSale($data) {
        $sql = "INSERT INTO SanPham_KhuyenMai (IDThietBi, IDKhuyenMai) VALUES (:IDThietBi, :IDKhuyenMai)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    public function updateSale($data) {
        $sql = "UPDATE SanPham_KhuyenMai SET IDThietBi = :IDThietBi, IDKhuyenMai = :IDKhuyenMai WHERE ID = :ID";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ID' => $data['ID'],
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    public function deleteSale($id) {
        $sql = "DELETE FROM SanPham_KhuyenMai WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getDevicesByType($typeId, $limit = 5) {
        $sql = "SELECT t.*, 
                (SELECT DuongDanHinhAnh FROM hinhanhthietbi 
                 WHERE IDThietBi = t.ID AND LaAnhChinh = 1 AND NgayXoa IS NULL 
                 LIMIT 1) as HinhAnh
                FROM thietbi t
                WHERE t.IDLoaiThietBi = :typeId 
                AND t.NgayXoa IS NULL
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':typeId', $typeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPromotionalProductsByPromotion($promotionId, $limit = 5) {
        $sql = "SELECT t.ID as IDThietBi, t.Ten as TenThietBi, k.MucGiamGia,
                (t.Gia * (1 - k.MucGiamGia/100)) as GiaKhuyenMai,
                (SELECT DuongDanHinhAnh FROM hinhanhthietbi 
                 WHERE IDThietBi = t.ID AND LaAnhChinh = 1 AND NgayXoa IS NULL 
                 LIMIT 1) as HinhAnh
                FROM {$this->table} s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE s.IDKhuyenMai = :promotionId
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':promotionId', $promotionId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
