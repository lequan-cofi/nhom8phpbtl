<?php
class Signup_Login {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đăng ký tài khoản mới vào bảng nguoidung
    public function signup($ten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh) {
        try {
            // Kiểm tra email đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT Email FROM nguoidung WHERE Email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email đã tồn tại'];
            }

            // Kiểm tra số điện thoại đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT SoDienThoai FROM nguoidung WHERE SoDienThoai = ?");
            $stmt->execute([$sodienthoai]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Số điện thoại đã tồn tại'];
            }

            // Mã hóa mật khẩu
            $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);

            // Thêm tài khoản mới
            $stmt = $this->conn->prepare("INSERT INTO nguoidung (Ten, Email, MatKhau, SoDienThoai, DiaChi, GioiTinh, VaiTro) 
                                        VALUES (?, ?, ?, ?, ?, ?, 'Người dùng')");
            $result = $stmt->execute([$ten, $email, $hashed_password, $sodienthoai, $diachi, $gioitinh]);

            if ($result) {
                return ['success' => true, 'message' => 'Đăng ký thành công'];
            } else {
                return ['success' => false, 'message' => 'Đăng ký thất bại'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    // Đăng nhập với bảng nguoidung
    public function login($email, $matkhau) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM nguoidung WHERE Email = ? AND NgayXoa IS NULL");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($matkhau, $user['MatKhau'])) {
                // Cập nhật thời gian đăng nhập cuối
                $updateStmt = $this->conn->prepare("UPDATE nguoidung SET NgayCapNhat = CURRENT_TIMESTAMP WHERE ID = ?");
                $updateStmt->execute([$user['ID']]);

                // Remove password from user data
                unset($user['MatKhau']);
                return ['success' => true, 'user' => $user];
            }
            
            return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    // Kiểm tra email đã tồn tại chưa
    public function checkEmailExists($email) {
        try {
            $stmt = $this->conn->prepare("SELECT ID FROM nguoidung WHERE Email = ?");
            $stmt->execute([$email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra số điện thoại đã tồn tại chưa
    public function checkPhoneExists($phone) {
        try {
            $stmt = $this->conn->prepare("SELECT ID FROM nguoidung WHERE SoDienThoai = ?");
            $stmt->execute([$phone]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM nguoidung WHERE ID = ? AND NgayXoa IS NULL");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                unset($user['MatKhau']);
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Đổi mật khẩu người dùng
    public function changePassword($id, $newPassword) {
        try {
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE nguoidung SET MatKhau = ? WHERE ID = ?");
            return $stmt->execute([$hashed, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>