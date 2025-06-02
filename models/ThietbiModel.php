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
        $sql = "SELECT t.*, 
            (SELECT DuongDanHinhAnh FROM hinhanhthietbi WHERE IDThietBi = t.ID AND LaAnhChinh = 1 AND NgayXoa IS NULL LIMIT 1) as HinhAnh
            FROM thietbi t
            LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID
            WHERE (t.Ten LIKE :keyword OR l.Ten LIKE :keyword) AND t.NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm mới trong 1 tháng gần đây
    public function getRecentProducts() {
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi,
        (SELECT DuongDanHinhAnh FROM hinhanhthietbi WHERE IDThietBi = t.ID AND LaAnhChinh = 1 AND NgayXoa IS NULL LIMIT 1) as HinhAnh
        FROM thietbi t
        LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID
        WHERE t.NgayXoa IS NULL
        AND t.NgayTao >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)
        ORDER BY t.NgayTao DESC
        LIMIT 5";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);   
    }

    // Lấy tất cả thông số kỹ thuật (chưa bị xóa)
    public function getAllThongSo() {
        $sql = "SELECT * FROM thongsokythuat WHERE NgayXoa IS NULL ORDER BY ID ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả thông số kỹ thuật và giá trị của một thiết bị
    public function getThongSoByThietBi($idThietBi) {
        $sql = "SELECT ts.ID, ts.Ten, ts.KieuDuLieu, ct.GiaTri
                FROM thongsokythuat ts
                LEFT JOIN chitietthongsothietbi ct ON ts.ID = ct.IDThongSo AND ct.IDThietBi = :idThietBi AND ct.NgayXoa IS NULL
                WHERE ts.NgayXoa IS NULL
                ORDER BY ts.ID ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idThietBi' => $idThietBi]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật hoặc thêm giá trị thông số cho thiết bị
    public function setThongSoThietBi($idThietBi, $idThongSo, $giaTri) {
        // Kiểm tra đã tồn tại chưa
        $sql = "SELECT ID FROM chitietthongsothietbi WHERE IDThietBi = :idThietBi AND IDThongSo = :idThongSo AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idThietBi' => $idThietBi, 'idThongSo' => $idThongSo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Update
            $sql = "UPDATE chitietthongsothietbi SET GiaTri = :giaTri, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['giaTri' => $giaTri, 'id' => $row['ID']]);
        } else {
            // Insert
            $sql = "INSERT INTO chitietthongsothietbi (IDThietBi, IDThongSo, GiaTri) VALUES (:idThietBi, :idThongSo, :giaTri)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['idThietBi' => $idThietBi, 'idThongSo' => $idThongSo, 'giaTri' => $giaTri]);
        }
    }

    // Xóa mềm thông số kỹ thuật của thiết bị
    public function deleteThongSoThietBi($idThietBi, $idThongSo) {
        $sql = "UPDATE chitietthongsothietbi SET NgayXoa = CURRENT_TIMESTAMP WHERE IDThietBi = :idThietBi AND IDThongSo = :idThongSo AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['idThietBi' => $idThietBi, 'idThongSo' => $idThongSo]);
    }

    // Lưu tất cả thông số kỹ thuật cho một thiết bị
    public function saveSpecs($idThietBi, $specs) {
        foreach ($specs as $idThongSo => $giaTri) {
            $this->setThongSoThietBi($idThietBi, $idThongSo, $giaTri);
        }
        return ['success' => true];
    }
}
