<?php
require_once __DIR__ . '/../config/database.php';

class PosterModel {
    private $db;
    private $table = 'poster_settings';

    public $ID;
    public $Title;
    public $Description;
    public $Image;
    public $IDKhuyenMai;
    public $MaxDisplayProducts;
    public $IsActive;
    public $NgayTao;
    public $NgayCapNhat;

    public function __construct() {
        $this->db = db_connect();
    }

    public function getAll() {
        $query = "SELECT ps.*, km.TenKhuyenMai 
                 FROM {$this->table} ps 
                 JOIN khuyenmai km ON ps.IDKhuyenMai = km.ID 
                 WHERE ps.IsActive = 1 
                 ORDER BY ps.ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getOne($id) {
        $query = "SELECT ps.*, km.TenKhuyenMai 
                 FROM {$this->table} ps 
                 JOIN khuyenmai km ON ps.IDKhuyenMai = km.ID 
                 WHERE ps.ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (Title, Description, Image, IDKhuyenMai, MaxDisplayProducts, IsActive) 
                 VALUES (:title, :description, :image, :idkhuyenmai, :maxDisplay, :isActive)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':title', $this->Title);
        $stmt->bindParam(':description', $this->Description);
        $stmt->bindParam(':image', $this->Image);
        $stmt->bindParam(':idkhuyenmai', $this->IDKhuyenMai);
        $stmt->bindParam(':maxDisplay', $this->MaxDisplayProducts);
        $stmt->bindParam(':isActive', $this->IsActive);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm cài đặt poster!'];
    }

    public function update() {
        $query = "UPDATE {$this->table} 
                 SET Title = :title, 
                     Description = :description, 
                     Image = :image, 
                     IDKhuyenMai = :idkhuyenmai, 
                     MaxDisplayProducts = :maxDisplay,
                     IsActive = :isActive,
                     NgayCapNhat = CURRENT_TIMESTAMP
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $this->ID);
        $stmt->bindParam(':title', $this->Title);
        $stmt->bindParam(':description', $this->Description);
        $stmt->bindParam(':image', $this->Image);
        $stmt->bindParam(':idkhuyenmai', $this->IDKhuyenMai);
        $stmt->bindParam(':maxDisplay', $this->MaxDisplayProducts);
        $stmt->bindParam(':isActive', $this->IsActive);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật cài đặt poster!'];
    }

    public function delete($id) {
        $query = "UPDATE {$this->table} SET IsActive = 0 WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getActivePoster() {
        $query = "SELECT ps.*, km.TenKhuyenMai 
                 FROM {$this->table} ps 
                 JOIN khuyenmai km ON ps.IDKhuyenMai = km.ID 
                 WHERE ps.IsActive = 1 
                 ORDER BY ps.ID DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPromotions() {
        $query = "SELECT ID, TenKhuyenMai FROM khuyenmai WHERE NgayXoa IS NULL ORDER BY ID DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 