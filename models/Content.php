<?php
require_once __DIR__ . '/../config/database.php';

class Content {
    private $db;
    private $table = 'content';

    // Properties
    public $ID;
    public $TieuDe;
    public $MoTa;
    public $NoiDung;
    public $DuongDanHinhAnh;
    public $DuongDanLienKet;
    public $IsActive;
    public $SortOrder;
    public $NgayTao;
    public $NgayCapNhat;
    public $NgayXoa;

    public function __construct() {
        $this->db = db_connect();
    }

    // Get all contents
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE NgayXoa IS NULL ORDER BY SortOrder ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single content
    public function getOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE ID = ? AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $this->ID);
        $stmt->execute();
        return $stmt;
    }

    // Create content
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                (TieuDe, MoTa, NoiDung, DuongDanHinhAnh, DuongDanLienKet, IsActive, SortOrder)
                VALUES
                (:tieuDe, :moTa, :noiDung, :duongDanHinhAnh, :duongDanLienKet, :isActive, :sortOrder)";

        $stmt = $this->db->prepare($query);

        // Clean data
        $this->TieuDe = htmlspecialchars(strip_tags($this->TieuDe));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));
        $this->NoiDung = htmlspecialchars(strip_tags($this->NoiDung));
        $this->DuongDanHinhAnh = htmlspecialchars(strip_tags($this->DuongDanHinhAnh));
        $this->DuongDanLienKet = htmlspecialchars(strip_tags($this->DuongDanLienKet));

        // Bind data
        $stmt->bindParam(':tieuDe', $this->TieuDe);
        $stmt->bindParam(':moTa', $this->MoTa);
        $stmt->bindParam(':noiDung', $this->NoiDung);
        $stmt->bindParam(':duongDanHinhAnh', $this->DuongDanHinhAnh);
        $stmt->bindParam(':duongDanLienKet', $this->DuongDanLienKet);
        $stmt->bindParam(':isActive', $this->IsActive);
        $stmt->bindParam(':sortOrder', $this->SortOrder);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update content
    public function update() {
        $query = "UPDATE " . $this->table . "
                SET
                    TieuDe = :tieuDe,
                    MoTa = :moTa,
                    NoiDung = :noiDung,
                    DuongDanHinhAnh = :duongDanHinhAnh,
                    DuongDanLienKet = :duongDanLienKet,
                    IsActive = :isActive,
                    SortOrder = :sortOrder,
                    NgayCapNhat = CURRENT_TIMESTAMP
                WHERE
                    ID = :id";

        $stmt = $this->db->prepare($query);

        // Clean data
        $this->TieuDe = htmlspecialchars(strip_tags($this->TieuDe));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));
        $this->NoiDung = htmlspecialchars(strip_tags($this->NoiDung));
        $this->DuongDanHinhAnh = htmlspecialchars(strip_tags($this->DuongDanHinhAnh));
        $this->DuongDanLienKet = htmlspecialchars(strip_tags($this->DuongDanLienKet));

        // Bind data
        $stmt->bindParam(':tieuDe', $this->TieuDe);
        $stmt->bindParam(':moTa', $this->MoTa);
        $stmt->bindParam(':noiDung', $this->NoiDung);
        $stmt->bindParam(':duongDanHinhAnh', $this->DuongDanHinhAnh);
        $stmt->bindParam(':duongDanLienKet', $this->DuongDanLienKet);
        $stmt->bindParam(':isActive', $this->IsActive);
        $stmt->bindParam(':sortOrder', $this->SortOrder);
        $stmt->bindParam(':id', $this->ID);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Soft delete content
    public function delete() {
        $query = "UPDATE " . $this->table . "
                SET NgayXoa = CURRENT_TIMESTAMP
                WHERE ID = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->ID);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get active contents
    public function getActive() {
        $query = "SELECT * FROM " . $this->table . " 
                WHERE IsActive = 1 AND NgayXoa IS NULL 
                ORDER BY SortOrder ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Search contents
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . "
                WHERE (TieuDe LIKE :keyword OR MoTa LIKE :keyword OR NoiDung LIKE :keyword)
                AND NgayXoa IS NULL
                ORDER BY SortOrder ASC";

        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?>
