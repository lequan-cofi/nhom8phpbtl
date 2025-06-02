<?php
require_once __DIR__ . '/../config/database.php';

class ChiTietThongSoThietBiModel {
    private $db;
    private $table = 'chitietthongsothietbi';

    public function __construct() {
        $this->db = db_connect();
    }

    /**
     * Lấy tất cả thông số kỹ thuật của một thiết bị
     * @param int $thietBiId ID của thiết bị
     * @return PDOStatement
     */
    public function getThongSoByThietBi($thietBiId) {
        $query = "SELECT ctts.*, ts.Ten as TenThongSo, ts.KieuDuLieu
                 FROM {$this->table} ctts
                 JOIN thongsokythuat ts ON ctts.IDThongSo = ts.ID
                 WHERE ctts.IDThietBi = ? AND ctts.NgayXoa IS NULL
                 ORDER BY ts.Ten ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $thietBiId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lấy thông tin chi tiết của một thông số kỹ thuật
     * @param int $id ID của chi tiết thông số
     * @return PDOStatement
     */
    public function getOne($id) {
        $query = "SELECT ctts.*, ts.Ten as TenThongSo, ts.KieuDuLieu, t.Ten as TenThietBi
                 FROM {$this->table} ctts
                 JOIN thongsokythuat ts ON ctts.IDThongSo = ts.ID
                 JOIN thietbi t ON ctts.IDThietBi = t.ID
                 WHERE ctts.ID = ? AND ctts.NgayXoa IS NULL";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Thêm mới thông số kỹ thuật cho thiết bị
     * @param int $thietBiId ID của thiết bị
     * @param int $thongSoId ID của thông số kỹ thuật
     * @param string $giaTri Giá trị của thông số
     * @return array
     */
    public function create($thietBiId, $thongSoId, $giaTri) {
        $query = "INSERT INTO {$this->table} (IDThietBi, IDThongSo, GiaTri) 
                 VALUES (:thietBiId, :thongSoId, :giaTri)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':thietBiId', $thietBiId, PDO::PARAM_INT);
        $stmt->bindParam(':thongSoId', $thongSoId, PDO::PARAM_INT);
        $stmt->bindParam(':giaTri', $giaTri);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Lỗi khi thêm thông số kỹ thuật!'];
    }

    /**
     * Cập nhật giá trị thông số kỹ thuật
     * @param int $id ID của chi tiết thông số
     * @param string $giaTri Giá trị mới của thông số
     * @return array
     */
    public function update($id, $giaTri) {
        $query = "UPDATE {$this->table} 
                 SET GiaTri = :giaTri 
                 WHERE ID = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':giaTri', $giaTri);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Lỗi khi cập nhật thông số kỹ thuật!'];
    }

    /**
     * Xóa mềm thông số kỹ thuật
     * @param int $id ID của chi tiết thông số
     * @return bool
     */
    public function delete($id) {
        $query = "UPDATE {$this->table} SET NgayXoa = CURRENT_TIMESTAMP WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Lấy danh sách thiết bị theo giá trị thông số kỹ thuật
     * @param int $thongSoId ID của thông số kỹ thuật
     * @param string $giaTri Giá trị cần tìm
     * @return PDOStatement
     */
    public function getThietBiByThongSo($thongSoId, $giaTri) {
        $query = "SELECT t.*, l.Ten AS TenLoaiThietBi
                 FROM thietbi t
                 JOIN {$this->table} ctts ON t.ID = ctts.IDThietBi
                 LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID
                 WHERE ctts.IDThongSo = ? 
                 AND ctts.GiaTri = ?
                 AND t.NgayXoa IS NULL
                 ORDER BY t.ID DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $thongSoId, PDO::PARAM_INT);
        $stmt->bindParam(2, $giaTri);
        $stmt->execute();
        return $stmt;
    }
} 