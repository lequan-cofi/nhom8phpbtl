<?php
// models/CuahangModel.php
require_once __DIR__ . '/../config/database.php';

class CuahangModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM cuahang ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM cuahang WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($ten, $diachi, $google_map)
    {
        $stmt = $this->conn->prepare("INSERT INTO cuahang (ten, diachi, google_map) VALUES (?, ?, ?)");
        return $stmt->execute([$ten, $diachi, $google_map]);
    }

    public function update($id, $ten, $diachi, $google_map)
    {
        $stmt = $this->conn->prepare("UPDATE cuahang SET ten=?, diachi=?, google_map=? WHERE id=?");
        return $stmt->execute([$ten, $diachi, $google_map, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM cuahang WHERE id=?");
        return $stmt->execute([$id]);
    }
}