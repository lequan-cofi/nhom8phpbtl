<?php
require_once __DIR__ . '/../config/database.php';

class ThongSoKyThuatModel {
    private $db;
    private $table = 'thongsokythuat';
    private $tableChiTiet = 'chitietthongsothietbi';

    public function __construct() {
        $this->db = db_connect();
    }

    /**
     * Lấy tất cả thông số kỹ thuật (chưa bị xóa)
     * @return PDOStatement
     */
    public function getAll() {
        $query = "SELECT * FROM {$this->table} WHERE NgayXoa IS NULL ORDER BY Ten ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lấy thông số kỹ thuật theo ID
     * @param int $id ID của thông số kỹ thuật
     * @return PDOStatement
     */
    public function getOne($id) {
        $query = "SELECT * FROM {$this->table} WHERE ID = ? AND NgayXoa IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lấy tất cả thông số kỹ thuật của một thiết bị
     * @param int $thietBiId ID của thiết bị
     * @return PDOStatement
     */
    public function getThongSoByThietBi($thietBiId) {
        $query = "SELECT ts.*, ctts.GiaTri, ctts.ID as ChiTietID
                 FROM {$this->table} ts
                 JOIN {$this->tableChiTiet} ctts ON ts.ID = ctts.IDThongSo
                 WHERE ctts.IDThietBi = ? 
                 AND ts.NgayXoa IS NULL 
                 AND ctts.NgayXoa IS NULL
                 ORDER BY ts.Ten ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $thietBiId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Thêm mới thông số kỹ thuật
     * @param string $ten Tên thông số
     * @param string $kieuDuLieu Kiểu dữ liệu
     * @return array
     */
    public function create($ten, $kieuDuLieu = 'string') {
        $query = "INSERT INTO {$this->table} (Ten, KieuDuLieu) VALUES (:ten, :kieuDuLieu)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':kieuDuLieu', $kieuDuLieu);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm thông số kỹ thuật!'];
    }

    /**
     * Cập nhật thông số kỹ thuật
     * @param int $id ID của thông số
     * @param string $ten Tên mới
     * @param string $kieuDuLieu Kiểu dữ liệu mới
     * @return array
     */
    public function update($id, $ten, $kieuDuLieu) {
        $query = "UPDATE {$this->table} 
                 SET Ten = :ten, KieuDuLieu = :kieuDuLieu 
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':kieuDuLieu', $kieuDuLieu);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật thông số kỹ thuật!'];
    }

    /**
     * Xóa mềm thông số kỹ thuật
     * @param int $id ID của thông số
     * @return bool
     */
    public function delete($id) {
        $query = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Thêm giá trị thông số kỹ thuật cho thiết bị
     * @param int $thietBiId ID của thiết bị
     * @param int $thongSoId ID của thông số
     * @param string $giaTri Giá trị của thông số
     * @return array
     */
    public function themGiaTriThongSo($thietBiId, $thongSoId, $giaTri) {
        $query = "INSERT INTO {$this->tableChiTiet} (IDThietBi, IDThongSo, GiaTri) 
                 VALUES (:thietBiId, :thongSoId, :giaTri)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':thietBiId', $thietBiId, PDO::PARAM_INT);
        $stmt->bindParam(':thongSoId', $thongSoId, PDO::PARAM_INT);
        $stmt->bindParam(':giaTri', $giaTri);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm giá trị thông số!'];
    }

    /**
     * Cập nhật giá trị thông số kỹ thuật của thiết bị
     * @param int $chiTietId ID của chi tiết thông số
     * @param string $giaTri Giá trị mới
     * @return array
     */
    public function capNhatGiaTriThongSo($chiTietId, $giaTri) {
        $query = "UPDATE {$this->tableChiTiet} 
                 SET GiaTri = :giaTri 
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $chiTietId, PDO::PARAM_INT);
        $stmt->bindParam(':giaTri', $giaTri);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật giá trị thông số!'];
    }

    /**
     * Xóa giá trị thông số kỹ thuật của thiết bị
     * @param int $chiTietId ID của chi tiết thông số
     * @return bool
     */
    public function xoaGiaTriThongSo($chiTietId) {
        $query = "UPDATE {$this->tableChiTiet} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$chiTietId]);
    }
} 