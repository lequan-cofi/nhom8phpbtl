<?php
require_once __DIR__ . '/../config/database.php';

class SalesModel {
    private $db;
    private $table = 'SanPham_KhuyenMai';

    public function __construct() {
        $this->db = db_connect();
    }

    public function getAllSales() {
        $sql = "SELECT s.ID, t.Ten as TenThietBi, k.TenKhuyenMai, t.Gia, 
                (t.Gia * (1 - k.MucGiamGia/100)) as GiaKhuyenMai, s.NgayTao
                FROM SanPham_KhuyenMai s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                ORDER BY s.NgayTao DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaleById($id) {
        $sql = "SELECT s.*, t.Ten as TenThietBi, k.TenKhuyenMai, t.Gia, 
                (t.Gia * (1 - k.MucGiamGia/100)) as GiaKhuyenMai
                FROM {$this->table} s
                JOIN thietbi t ON s.IDThietBi = t.ID
                JOIN khuyenmai k ON s.IDKhuyenMai = k.ID
                WHERE s.ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSale($data) {
        $sql = "INSERT INTO {$this->table} (IDThietBi, IDKhuyenMai) 
                VALUES (:IDThietBi, :IDKhuyenMai)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    public function updateSale($data) {
        $sql = "UPDATE {$this->table} 
                SET IDThietBi = :IDThietBi, 
                    IDKhuyenMai = :IDKhuyenMai,
                    NgayCapNhat = CURRENT_TIMESTAMP
                WHERE ID = :ID";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ID' => $data['ID'],
            'IDThietBi' => $data['IDThietBi'],
            'IDKhuyenMai' => $data['IDKhuyenMai']
        ]);
    }

    public function deleteSale($id) {
        $sql = "DELETE FROM {$this->table} WHERE ID = :id";
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
