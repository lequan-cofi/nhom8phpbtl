<?php
require_once __DIR__ . '/../config/database.php';

class NguoiDungModel {
    protected $db;
    protected $table = 'nguoidung';

    public function __construct() {
        $this->db = db_connect();
    }

    // Lấy tất cả người dùng (chưa bị xóa)
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} WHERE NgayXoa IS NULL ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :id AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo email
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE Email = :email AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm người dùng mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
            (Ten, Email, MatKhau, DiaChi, SoDienThoai, VaiTro, GioiTinh)
            VALUES (:Ten, :Email, :MatKhau, :DiaChi, :SoDienThoai, :VaiTro, :GioiTinh)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'Ten' => $data['Ten'],
            'Email' => $data['Email'],
            'MatKhau' => $data['MatKhau'],
            'DiaChi' => $data['DiaChi'] ?? null,
            'SoDienThoai' => $data['SoDienThoai'],
            'VaiTro' => $data['VaiTro'] ?? 'Người dùng',
            'GioiTinh' => $data['GioiTinh'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    // Cập nhật người dùng
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
            Ten = :Ten,
            Email = :Email,
            DiaChi = :DiaChi,
            SoDienThoai = :SoDienThoai,
            VaiTro = :VaiTro,
            GioiTinh = :GioiTinh,
            XacSuatRoiBo = :XacSuatRoiBo,
            SoNgayMuaCuoi = :SoNgayMuaCuoi,
            TanSuatMuaHang = :TanSuatMuaHang,
            GiaTriTienTe = :GiaTriTienTe,
            TyLeGioHangBiBo = :TyLeGioHangBiBo,
            NgayCapNhat = CURRENT_TIMESTAMP
            WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'Ten' => $data['Ten'],
            'Email' => $data['Email'],
            'DiaChi' => $data['DiaChi'] ?? null,
            'SoDienThoai' => $data['SoDienThoai'],
            'VaiTro' => $data['VaiTro'] ?? 'Người dùng',
            'GioiTinh' => $data['GioiTinh'] ?? null,
            'XacSuatRoiBo' => $data['XacSuatRoiBo'] ?? null,
            'SoNgayMuaCuoi' => $data['SoNgayMuaCuoi'] ?? 0,
            'TanSuatMuaHang' => $data['TanSuatMuaHang'] ?? 0,
            'GiaTriTienTe' => $data['GiaTriTienTe'] ?? 0,
            'TyLeGioHangBiBo' => $data['TyLeGioHangBiBo'] ?? null,
            'id' => $id
        ]);
    }

    // Đổi mật khẩu
    public function changePassword($id, $newPassword) {
        $sql = "UPDATE {$this->table} SET MatKhau = :MatKhau, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['MatKhau' => $newPassword, 'id' => $id]);
    }

    // Xác minh email
    public function verifyEmail($id) {
        $sql = "UPDATE {$this->table} SET EmailDaXacMinh = CURRENT_TIMESTAMP WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Xóa mềm người dùng
    public function delete($id) {
        $sql = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Sau khi lấy $users
    public function getUserOrders($users) {
        $userIds = array_column($users, 'ID');
        $userOrders = [];
        if (!empty($userIds)) {
            $idsStr = implode(',', array_map('intval', $userIds));
            $sql = "SELECT IDNguoiDung, COUNT(*) as so_don, SUM(TongTien) as tong_tien
                    FROM donhang
                    WHERE IDNguoiDung IN ($idsStr) AND NgayXoa IS NULL
                    GROUP BY IDNguoiDung";
            $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $userOrders[$row['IDNguoiDung']] = [
                    'so_don' => $row['so_don'],
                    'tong_tien' => $row['tong_tien']
                ];
            }
        }
        return $userOrders;
    }
}
