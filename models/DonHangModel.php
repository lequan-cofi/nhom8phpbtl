<?php
require_once __DIR__ . '/../config/database.php';
class DonHangModel {
    protected $db;
    protected $table = 'donhang';
    protected $tableDetail = 'chitietdonhang';

    public function __construct() {
        $this->db = db_connect();
    }
    // Lấy danh sách đơn hàng theo ID người dùng
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE IDNguoiDung = ? AND NgayXoa IS NULL ORDER BY NgayTao DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy chi tiết đơn hàng
   
    public function create($data) {
        $sql = "INSERT INTO donhang 
            (IDNguoiDung, TenKhachHang, GioiTinh, SoDienThoai, DiaChiGiaoHang, PhuongThucThanhToan, GhiChu, TongTien, TrangThaiDonHang, MaChuyenKhoan)
            VALUES (:IDNguoiDung, :TenKhachHang, :GioiTinh, :SoDienThoai, :DiaChiGiaoHang, :PhuongThucThanhToan, :GhiChu, :TongTien, :TrangThaiDonHang, :MaChuyenKhoan)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'IDNguoiDung' => $data['IDNguoiDung'],
            'TenKhachHang' => $data['TenKhachHang'],
            'GioiTinh' => $data['GioiTinh'],
            'SoDienThoai' => $data['SoDienThoai'],
            'DiaChiGiaoHang' => $data['DiaChiGiaoHang'],
            'PhuongThucThanhToan' => $data['PhuongThucThanhToan'],
            'GhiChu' => $data['GhiChu'],
            'TongTien' => $data['TongTien'],
            'TrangThaiDonHang' => $data['TrangThaiDonHang'],
            'MaChuyenKhoan' => $data['MaChuyenKhoan']
        ]);
        return $this->db->lastInsertId();
    }
    

    // Thêm chi tiết đơn hàng
    public function addDetail($orderId, $details) {
        try {
            $sql = "INSERT INTO chitietdonhang (IDDonHang, IDThietBi, SoLuong, Gia)
                    VALUES (:IDDonHang, :IDThietBi, :SoLuong, :Gia)";
            $stmt = $this->db->prepare($sql);
            
            foreach ($details as $item) {
                $stmt->execute([
                    'IDDonHang' => $orderId,
                    'IDThietBi' => $item['IDThietBi'],
                    'SoLuong' => $item['SoLuong'],
                    'Gia' => $item['Gia']
                ]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm chi tiết đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Lấy đơn hàng theo ID người dùng
    public function getByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE IDNguoiDung = :userId AND NgayXoa IS NULL ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết đơn hàng theo ID đơn hàng
    public function getDetail($orderId) {
        $sql = "SELECT c.*, t.Ten as TenThietBi FROM {$this->tableDetail} c
                JOIN thietbi t ON c.IDThietBi = t.ID
                WHERE c.IDDonHang = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin đơn hàng theo ID
    public function getOne($orderId) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status) {
        $sql = "UPDATE {$this->table} SET TrangThaiDonHang = :status, NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = :orderId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['status' => $status, 'orderId' => $orderId]);
    }

    // Xóa mềm đơn hàng
    public function delete($orderId) {
        $sql = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = :orderId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['orderId' => $orderId]);
    }

    // Lấy tất cả đơn hàng
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} WHERE NgayXoa IS NULL ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 