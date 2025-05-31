<?php
require_once __DIR__ . '/../config/database.php';

class PhanHoiModel {
    private $db;
    private $table = 'phanhoi';

    public function __construct() {
        $this->db = db_connect();
    }

    // Create new response
    public function create($data) {
        $query = "INSERT INTO {$this->table} (IDLienHe, NoiDung) VALUES (:idlienhe, :noidung)";
        
        $stmt = $this->db->prepare($query);
        
        // Clean data
        $data['NoiDung'] = htmlspecialchars(strip_tags($data['NoiDung']));
        
        // Bind data
        $stmt->bindParam(':idlienhe', $data['IDLienHe']);
        $stmt->bindParam(':noidung', $data['NoiDung']);

        if($stmt->execute()) {
            // Update contact status to processed
            $lienHeModel = new LienHeModel();
            $lienHeModel->updateStatus($data['IDLienHe'], 'Đã xử lý');
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi gửi phản hồi!'];
    }

    // Get response by contact ID
    public function getByLienHeId($idLienHe) {
        $query = "SELECT * FROM {$this->table} WHERE IDLienHe = ? ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $idLienHe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Update response
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET NoiDung = :noidung WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        
        // Clean data
        $data['NoiDung'] = htmlspecialchars(strip_tags($data['NoiDung']));
        
        // Bind data
        $stmt->bindParam(':noidung', $data['NoiDung']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete response
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 