<?php
require_once __DIR__ . '/../config/database.php';

class GioHangModel {
    private $db;
    private $table = 'mucgiohang';

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả mục giỏ hàng của 1 người dùng (kèm thông tin thiết bị)
    public function getByUser($userId) {
        $sql = "SELECT g.*, 
                       t.Ten as TenThietBi, t.Gia, t.SoLuongTonKho, t.DuongDanLienKet,
                       t.IDLoaiThietBi
                FROM {$this->table} g
                JOIN thietbi t ON g.IDThietBi = t.ID
                WHERE g.IDNguoiDung = :userId AND g.NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mục vào giỏ hàng
    public function add($userId, $thietBiId, $soLuong = 1) {
        // Kiểm tra đã có trong giỏ chưa
        $sql = "SELECT * FROM {$this->table} WHERE IDNguoiDung = :userId AND IDThietBi = :thietBiId AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId, 'thietBiId' => $thietBiId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Nếu đã có thì cập nhật số lượng
            $sql = "UPDATE {$this->table} SET SoLuong = SoLuong + :soLuong, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['soLuong' => $soLuong, 'id' => $item['ID']]);
        } else {
            // Nếu chưa có thì thêm mới
            $sql = "INSERT INTO {$this->table} (IDNguoiDung, IDThietBi, SoLuong) VALUES (:userId, :thietBiId, :soLuong)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['userId' => $userId, 'thietBiId' => $thietBiId, 'soLuong' => $soLuong]);
        }
    }

    // Cập nhật số lượng mục trong giỏ
    public function updateQuantity($id, $soLuong) {
        $sql = "UPDATE {$this->table} SET SoLuong = :soLuong, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['soLuong' => $soLuong, 'id' => $id]);
    }

    // Xóa cứng mục giỏ hàng
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Xóa toàn bộ giỏ hàng của 1 user
    public function clearByUser($userId) {
        $sql = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE IDNguoiDung = :userId AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['userId' => $userId]);
    }

    public function clearCart($userId) {
        $sql = "DELETE FROM giohang WHERE IDNguoiDung = :userId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['userId' => $userId]);
    }
}
