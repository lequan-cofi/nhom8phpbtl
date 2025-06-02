<?php
require_once __DIR__ . '/../config/database.php';

class LienHeModel {
    private $db;
    private $table = 'lienhe';

    public function __construct() {
        $this->db = db_connect();
    }

    // Get all contacts
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single contact by ID
    public function getOne($id) {
        $query = "SELECT l.*, p.NoiDung as NoiDungPhanHoi, p.NgayTao as NgayPhanHoi 
                 FROM {$this->table} l 
                 LEFT JOIN phanhoi p ON l.ID = p.IDLienHe 
                 WHERE l.ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Create new contact
    public function create($data) {
        $query = "INSERT INTO {$this->table} (HoTen, Email, ChuDe, NoiDung, TrangThai) 
                 VALUES (:hoten, :email, :chude, :noidung, :trangthai)";
        
        $stmt = $this->db->prepare($query);
        
        // Clean data
        $data['HoTen'] = htmlspecialchars(strip_tags($data['HoTen']));
        $data['Email'] = htmlspecialchars(strip_tags($data['Email']));
        $data['ChuDe'] = htmlspecialchars(strip_tags($data['ChuDe']));
        $data['NoiDung'] = htmlspecialchars(strip_tags($data['NoiDung']));
        $data['TrangThai'] = htmlspecialchars(strip_tags($data['TrangThai']));
        
        // Bind data
        $stmt->bindParam(':hoten', $data['HoTen']);
        $stmt->bindParam(':email', $data['Email']);
        $stmt->bindParam(':chude', $data['ChuDe']);
        $stmt->bindParam(':noidung', $data['NoiDung']);
        $stmt->bindParam(':trangthai', $data['TrangThai']);
        
        return $stmt->execute();
    }

    // Update contact status
    public function updateStatus($id, $status) {
        // Đảm bảo status chỉ có thể là 'Chưa xử lý' hoặc 'Đã xử lý'
        $validStatuses = ['Chưa xử lý', 'Đã xử lý'];
        if (!in_array($status, $validStatuses)) {
            $status = 'Đã xử lý'; // Mặc định là 'Đã xử lý' nếu giá trị không hợp lệ
        }

        $query = "UPDATE {$this->table} SET TrangThai = :status WHERE ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
} 