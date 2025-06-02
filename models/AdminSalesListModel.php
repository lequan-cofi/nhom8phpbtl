<?php

require_once __DIR__ . '/../config/database.php';

class AdminSalesListModel {
    private $db;
    private $table = 'admin_sales_list_settings';

    public $ID;
    public $IDLoaiThietBi;
    public $SoLuongHienThi;
    public $IsActive;
    public $NgayTao;
    public $NgayCapNhat;

    public function __construct() {
        $this->db = db_connect();
    }

    public function getAll() {
        $query = "
SELECT ass.*, ltb.Ten as TenLoaiThietBi, t.Ten as TenThietBi, t.Gia, t.SoLuongTonKho, t.DuongDanLienKet
FROM {$this->table} ass
JOIN loaithietbi ltb ON ass.IDLoaiThietBi = ltb.ID
JOIN (
    SELECT *
    FROM thietbi
    WHERE NgayXoa IS NULL
    ORDER BY NgayTao DESC
) t ON t.IDLoaiThietBi = ltb.ID
WHERE ass.IsActive = 1
GROUP BY t.IDLoaiThietBi
ORDER BY t.NgayTao DESC
";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getOne($id) {
        $query = "SELECT ass.*, ltb.Ten as TenLoaiThietBi 
                 FROM {$this->table} ass 
                 JOIN loaithietbi ltb ON ass.IDLoaiThietBi = ltb.ID 
                 WHERE ass.ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (IDLoaiThietBi, SoLuongHienThi, IsActive) 
                 VALUES (:idloaithietbi, :soluonghienthi, :isactive)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':idloaithietbi', $this->IDLoaiThietBi);
        $stmt->bindParam(':soluonghienthi', $this->SoLuongHienThi);
        $stmt->bindParam(':isactive', $this->IsActive);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Thêm cài đặt thành công', 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm cài đặt danh sách ưu đãi!'];
    }

    public function update() {
        $query = "UPDATE {$this->table} 
                 SET IDLoaiThietBi = :idloaithietbi, 
                     SoLuongHienThi = :soluonghienthi,
                     IsActive = :isactive,
                     NgayCapNhat = CURRENT_TIMESTAMP
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $this->ID);
        $stmt->bindParam(':idloaithietbi', $this->IDLoaiThietBi);
        $stmt->bindParam(':soluonghienthi', $this->SoLuongHienThi);
        $stmt->bindParam(':isactive', $this->IsActive);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Cập nhật cài đặt thành công'];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật cài đặt danh sách ưu đãi!'];
    }

    public function delete($id) {
        try {
            $query = "UPDATE {$this->table} SET IsActive = 0 WHERE ID = ?";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error in delete: " . $e->getMessage());
            return false;
        }
    }

    public function getDeviceTypes() {
        $query = "SELECT ID, Ten FROM loaithietbi WHERE NgayXoa IS NULL ORDER BY Ten ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveSettings() {
        $query = "SELECT ass.*, ltb.Ten as TenLoaiThietBi 
                 FROM {$this->table} ass 
                 JOIN loaithietbi ltb ON ass.IDLoaiThietBi = ltb.ID 
                 WHERE ass.IsActive = 1 
                 ORDER BY ass.ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 