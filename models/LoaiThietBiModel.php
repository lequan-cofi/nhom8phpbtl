<?php
require_once __DIR__ . '/../config/database.php';

class LoaiThietBiModel {
    private $db;
    private $table = 'loaithietbi';

    public $ID;
    public $Ten;
    public $NgayTao;
    public $NgayCapNhat;
    public $NgayXoa;
    public $DuongDanHinhAnh;
    public $DuongDanLienKet;

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả loại thiết bị chưa bị xóa
    public function getAll() {
        $query = "SELECT * FROM $this->table WHERE NgayXoa IS NULL ORDER BY ID ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy 1 loại thiết bị theo ID
    public function getOne() {
        $query = "SELECT * FROM $this->table WHERE ID = ? AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $this->ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Thêm mới loại thiết bị
    public function create() {
        $query = "INSERT INTO $this->table (Ten, DuongDanHinhAnh, DuongDanLienKet, NgayTao) VALUES (:ten, :duongdanhinhanh, :duongdanlienket, NOW())";
        $stmt = $this->db->prepare($query);
        $this->Ten = htmlspecialchars(strip_tags($this->Ten));
        $this->DuongDanHinhAnh = htmlspecialchars(strip_tags($this->DuongDanHinhAnh));
        $this->DuongDanLienKet = htmlspecialchars(strip_tags($this->DuongDanLienKet));
        $stmt->bindParam(':ten', $this->Ten);
        $stmt->bindParam(':duongdanhinhanh', $this->DuongDanHinhAnh);
        $stmt->bindParam(':duongdanlienket', $this->DuongDanLienKet);
        return $stmt->execute();
    }

    // Cập nhật loại thiết bị
    public function update() {
        $query = "UPDATE $this->table SET Ten = :ten, DuongDanHinhAnh = :duongdanhinhanh, DuongDanLienKet = :duongdanlienket, NgayCapNhat = NOW() WHERE ID = :id AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($query);
        $this->Ten = htmlspecialchars(strip_tags($this->Ten));
        $this->DuongDanHinhAnh = htmlspecialchars(strip_tags($this->DuongDanHinhAnh));
        $this->DuongDanLienKet = htmlspecialchars(strip_tags($this->DuongDanLienKet));
        $stmt->bindParam(':ten', $this->Ten);
        $stmt->bindParam(':duongdanhinhanh', $this->DuongDanHinhAnh);
        $stmt->bindParam(':duongdanlienket', $this->DuongDanLienKet);
        $stmt->bindParam(':id', $this->ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa cứng loại thiết bị
    public function delete() {
        $query = "DELETE FROM $this->table WHERE ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->ID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lấy tất cả loại thiết bị kèm số lượng sản phẩm
    public function getAllWithProductCount() {
        $query = "SELECT ltb.*, COUNT(tb.ID) as SoLuongSanPham
                  FROM $this->table ltb
                  LEFT JOIN thietbi tb ON tb.IDLoaiThietBi = ltb.ID AND tb.NgayXoa IS NULL
                  WHERE ltb.NgayXoa IS NULL
                  GROUP BY ltb.ID
                  ORDER BY ltb.ID ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
