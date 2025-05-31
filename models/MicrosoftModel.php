<?php
class MicrosoftModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllMicrosoftProducts() {
        try {
            $query = "SELECT t.*, km.TenKhuyenMai, km.MucGiamGia, 
                     (SELECT COUNT(*) FROM sanpham_khuyenmai skm 
                      WHERE skm.IDKhuyenMai = km.ID AND skm.IDThietBi = t.ID) as SoSanPham
                     FROM thietbi t
                     LEFT JOIN sanpham_khuyenmai skm ON t.ID = skm.IDThietBi
                     LEFT JOIN khuyenmai km ON skm.IDKhuyenMai = km.ID
                     WHERE t.NgayXoa IS NULL AND t.IDLoaiThietBi = 2
                     ORDER BY t.NgayTao DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllMicrosoftProducts: " . $e->getMessage());
            return [];
        }
    }

    public function getMicrosoftProductById($id) {
        try {
            $query = "SELECT t.*, km.TenKhuyenMai, km.MucGiamGia
                     FROM thietbi t
                     LEFT JOIN sanpham_khuyenmai skm ON t.ID = skm.IDThietBi
                     LEFT JOIN khuyenmai km ON skm.IDKhuyenMai = km.ID
                     WHERE t.ID = :id AND t.NgayXoa IS NULL AND t.IDLoaiThietBi = 2";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getMicrosoftProductById: " . $e->getMessage());
            return null;
        }
    }

    public function createMicrosoftProduct($data) {
        try {
            $this->db->beginTransaction();

            // Log the incoming data
            error_log("Creating Microsoft product with data: " . print_r($data, true));

            // Insert into thietbi table
            $query = "INSERT INTO thietbi (Ten, Gia, SoLuongTonKho, IDLoaiThietBi, DuongDanLienKet, NgayTao) 
                     VALUES (:title, :price, :quantity, 2, :product_link, NOW())";
            $stmt = $this->db->prepare($query);
            
            $result = $stmt->execute([
                ':title' => $data['title'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity'],
                ':product_link' => $data['product_link']
            ]);

            if (!$result) {
                throw new PDOException("Failed to insert into thietbi table");
            }

            $productId = $this->db->lastInsertId();
            error_log("Created product with ID: " . $productId);

            // If promotion is selected, insert into sanpham_khuyenmai
            if (!empty($data['khuyenmai_id'])) {
                $query = "INSERT INTO sanpham_khuyenmai (IDThietBi, IDKhuyenMai) 
                         VALUES (:product_id, :khuyenmai_id)";
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute([
                    ':product_id' => $productId,
                    ':khuyenmai_id' => $data['khuyenmai_id']
                ]);

                if (!$result) {
                    throw new PDOException("Failed to insert into sanpham_khuyenmai table");
                }
                error_log("Added promotion " . $data['khuyenmai_id'] . " to product " . $productId);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error in createMicrosoftProduct: " . $e->getMessage());
            throw new Exception("Không thể thêm sản phẩm: " . $e->getMessage());
        }
    }

    public function updateMicrosoftProduct($id, $data) {
        try {
            $this->db->beginTransaction();

            // Update thietbi table
            $query = "UPDATE thietbi 
                     SET Ten = :title, 
                         Gia = :price,
                         SoLuongTonKho = :quantity,
                         DuongDanLienKet = :product_link,
                         NgayCapNhat = NOW()
                     WHERE ID = :id AND NgayXoa IS NULL AND IDLoaiThietBi = 2";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':title' => $data['title'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity'],
                ':product_link' => $data['product_link']
            ]);

            // Update promotion
            // First delete existing promotion
            $query = "DELETE FROM sanpham_khuyenmai WHERE IDThietBi = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);

            // Then insert new promotion if selected
            if (!empty($data['khuyenmai_id'])) {
                $query = "INSERT INTO sanpham_khuyenmai (IDThietBi, IDKhuyenMai) 
                         VALUES (:product_id, :khuyenmai_id)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    ':product_id' => $id,
                    ':khuyenmai_id' => $data['khuyenmai_id']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error in updateMicrosoftProduct: " . $e->getMessage());
            return false;
        }
    }

    public function deleteMicrosoftProduct($id) {
        try {
            $query = "UPDATE thietbi SET NgayXoa = NOW() WHERE ID = :id AND IDLoaiThietBi = 2";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in deleteMicrosoftProduct: " . $e->getMessage());
            return false;
        }
    }

    public function getProductsByKhuyenMai($khuyenMaiId) {
        try {
            $query = "SELECT t.*, km.TenKhuyenMai, km.MucGiamGia
                     FROM thietbi t
                     JOIN sanpham_khuyenmai skm ON t.ID = skm.IDThietBi
                     JOIN khuyenmai km ON skm.IDKhuyenMai = km.ID
                     WHERE km.ID = :khuyenmai_id 
                     AND t.NgayXoa IS NULL 
                     AND t.IDLoaiThietBi = 2
                     ORDER BY t.NgayTao DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':khuyenmai_id', $khuyenMaiId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductsByKhuyenMai: " . $e->getMessage());
            return [];
        }
    }
}
?>
