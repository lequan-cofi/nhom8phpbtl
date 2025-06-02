<?php
require_once __DIR__ . '/../config/database.php';

class Phanhoi_lienheModel {
    private $db;
    private $table = 'phanhoi';

    public function __construct() {
        $this->db = db_connect();
    }

    // Thêm phản hồi mới
    public function create($data) {
        $query = "INSERT INTO {$this->table} (IDLienHe, NoiDung) VALUES (:id_lienhe, :noidung)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_lienhe', $data['IDLienHe']);
        $stmt->bindParam(':noidung', $data['NoiDung']);
        return $stmt->execute();
    }

    // Lấy tất cả phản hồi
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy phản hồi theo liên hệ
    public function getByLienHe($idLienHe) {
        $query = "SELECT * FROM {$this->table} WHERE IDLienHe = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $idLienHe);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}