<?php
require_once __DIR__ . '/../config/database.php';

class HinhanhthietbiModel {
    private $db;
    private $table = 'hinhanhthietbi';

    public function __construct() {
        $this->db = db_connect();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY ID DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByThietBi($idThietBi) {
        $sql = "SELECT * FROM {$this->table} WHERE IDThietBi = ? ORDER BY LaAnhChinh DESC, ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idThietBi]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (IDThietBi, DuongDanHinhAnh, LaAnhChinh) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['IDThietBi'], $data['DuongDanHinhAnh'], $data['LaAnhChinh'] ?? 0]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET IDThietBi = ?, DuongDanHinhAnh = ?, LaAnhChinh = ? WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['IDThietBi'], $data['DuongDanHinhAnh'], $data['LaAnhChinh'] ?? 0, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
