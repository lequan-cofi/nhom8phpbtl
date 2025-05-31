<?php
require_once __DIR__ . '/../config/database.php';

class ThietBiModel {
    private $db;
    private $table = 'thietbi';

    public $ID;
    public $Ten;
    public $Gia;
    public $SoLuongTonKho;
    public $IDLoaiThietBi;
    public $NgayTao;
    public $NgayCapNhat;
    public $NgayXoa;
    public $DuongDanLienKet;

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả thiết bị (chưa bị xóa)
    public function getAll() {
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi 
                 FROM {$this->table} t 
                 LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID 
                 WHERE t.NgayXoa IS NULL 
                 ORDER BY t.ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy một thiết bị theo ID
    public function getOne($id) {
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi 
                 FROM {$this->table} t 
                 LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID 
                 WHERE t.ID = ? AND t.NgayXoa IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Thêm mới thiết bị
    public function create() {
        $query = "INSERT INTO {$this->table} (Ten, Gia, SoLuongTonKho, IDLoaiThietBi, DuongDanLienKet) 
                 VALUES (:ten, :gia, :soluong, :idloai, :duongdan)";
        
        $stmt = $this->db->prepare($query);
        
        // Bind các tham số
        $stmt->bindParam(':ten', $this->Ten);
        $stmt->bindParam(':gia', $this->Gia);
        $stmt->bindParam(':soluong', $this->SoLuongTonKho);
        $stmt->bindParam(':idloai', $this->IDLoaiThietBi);
        $stmt->bindParam(':duongdan', $this->DuongDanLienKet);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm thiết bị!'];
    }

    // Cập nhật thiết bị
    public function update() {
        $query = "UPDATE {$this->table} 
                 SET Ten = :ten, 
                     Gia = :gia, 
                     SoLuongTonKho = :soluong, 
                     IDLoaiThietBi = :idloai, 
                     DuongDanLienKet = :duongdan 
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        
        // Bind các tham số
        $stmt->bindParam(':id', $this->ID);
        $stmt->bindParam(':ten', $this->Ten);
        $stmt->bindParam(':gia', $this->Gia);
        $stmt->bindParam(':soluong', $this->SoLuongTonKho);
        $stmt->bindParam(':idloai', $this->IDLoaiThietBi);
        $stmt->bindParam(':duongdan', $this->DuongDanLienKet);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật thiết bị!'];
    }

    // Xóa mềm thiết bị (cập nhật NgayXoa)
    public function delete($id) {
        $query = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    // Lấy thiết bị theo loại
    public function getByCategory($categoryId) {
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi 
                 FROM {$this->table} t 
                 LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID 
                 WHERE t.IDLoaiThietBi = ? AND t.NgayXoa IS NULL 
                 ORDER BY t.ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Tìm kiếm thiết bị
    public function search($keyword) {
        $keyword = "%{$keyword}%";
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi 
                 FROM {$this->table} t 
                 LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID 
                 WHERE (t.Ten LIKE ? OR l.Ten LIKE ?) AND t.NgayXoa IS NULL 
                 ORDER BY t.ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);
        $stmt->execute();
        return $stmt;
    }
}
