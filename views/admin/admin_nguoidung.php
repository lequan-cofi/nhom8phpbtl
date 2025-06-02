<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../models/nguoidungModel.php';

$nguoiDungModel = new NguoiDungModel();

// Xử lý thêm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $data = [
        'Ten' => $_POST['Ten'],
        'Email' => $_POST['Email'],
        'MatKhau' => password_hash($_POST['MatKhau'], PASSWORD_DEFAULT),
        'DiaChi' => $_POST['DiaChi'] ?? null,
        'SoDienThoai' => $_POST['SoDienThoai'],
        'VaiTro' => $_POST['VaiTro'] ?? 'Người dùng',
        'GioiTinh' => $_POST['GioiTinh'] ?? null
    ];
    $nguoiDungModel->create($data);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $data = [
        'Ten' => $_POST['Ten'],
        'Email' => $_POST['Email'],
        'DiaChi' => $_POST['DiaChi'] ?? null,
        'SoDienThoai' => $_POST['SoDienThoai'],
        'VaiTro' => $_POST['VaiTro'] ?? 'Người dùng',
        'GioiTinh' => $_POST['GioiTinh'] ?? null,
        'XacSuatRoiBo' => $_POST['XacSuatRoiBo'] ?? null,
        'SoNgayMuaCuoi' => $_POST['SoNgayMuaCuoi'] ?? 0,
        'TanSuatMuaHang' => $_POST['TanSuatMuaHang'] ?? 0,
        'GiaTriTienTe' => $_POST['GiaTriTienTe'] ?? 0,
        'TyLeGioHangBiBo' => $_POST['TyLeGioHangBiBo'] ?? null
    ];
    $nguoiDungModel->update($id, $data);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Xử lý xóa mềm
if (isset($_GET['delete'])) {
    $nguoiDungModel->delete($_GET['delete']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Lấy danh sách người dùng
$users = $nguoiDungModel->getAll();

// Lấy thông tin đơn hàng của người dùng
$userOrders = $nguoiDungModel->getUserOrders($users);

// Tìm kiếm theo tên, email, sdt
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $users = array_filter($users, function($user) use ($search) {
        return stripos($user['Ten'], $search) !== false
            || stripos($user['Email'], $search) !== false
            || stripos($user['SoDienThoai'], $search) !== false;
    });
}

// Lọc/sắp xếp ngày tạo
$sortDate = isset($_GET['sort_date']) ? $_GET['sort_date'] : '';
$created_from = isset($_GET['created_from']) ? $_GET['created_from'] : '';
$created_to = isset($_GET['created_to']) ? $_GET['created_to'] : '';
if ($created_from !== '' || $created_to !== '') {
    $users = array_filter($users, function($user) use ($created_from, $created_to) {
        $date = substr($user['NgayTao'], 0, 10);
        if ($created_from !== '' && $date < $created_from) return false;
        if ($created_to !== '' && $date > $created_to) return false;
        return true;
    });
}

// Lọc vai trò
$role = isset($_GET['role']) ? $_GET['role'] : '';
if ($role !== '') {
    $users = array_filter($users, function($user) use ($role) {
        return $user['VaiTro'] === $role;
    });
}

// Lọc theo khoảng số đơn hàng
$order_from = isset($_GET['order_from']) && $_GET['order_from'] !== '' ? intval($_GET['order_from']) : null;
$order_to = isset($_GET['order_to']) && $_GET['order_to'] !== '' ? intval($_GET['order_to']) : null;
if ($order_from !== null || $order_to !== null) {
    $users = array_filter($users, function($user) use ($userOrders, $order_from, $order_to) {
        $soDon = $userOrders[$user['ID']]['so_don'] ?? 0;
        if ($order_from !== null && $soDon < $order_from) return false;
        if ($order_to !== null && $soDon > $order_to) return false;
        return true;
    });
}

// Lọc theo khoảng tổng tiền
$total_from = isset($_GET['total_from']) && $_GET['total_from'] !== '' ? floatval($_GET['total_from']) : null;
$total_to = isset($_GET['total_to']) && $_GET['total_to'] !== '' ? floatval($_GET['total_to']) : null;
if ($total_from !== null || $total_to !== null) {
    $users = array_filter($users, function($user) use ($userOrders, $total_from, $total_to) {
        $tongTien = $userOrders[$user['ID']]['tong_tien'] ?? 0;
        if ($total_from !== null && $tongTien < $total_from) return false;
        if ($total_to !== null && $tongTien > $total_to) return false;
        return true;
    });
}

// Sắp xếp số đơn hàng
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : '';
if ($sortOrder === 'asc') {
    usort($users, function($a, $b) use ($userOrders) {
        $aDon = $userOrders[$a['ID']]['so_don'] ?? 0;
        $bDon = $userOrders[$b['ID']]['so_don'] ?? 0;
        return $aDon - $bDon;
    });
} elseif ($sortOrder === 'desc') {
    usort($users, function($a, $b) use ($userOrders) {
        $aDon = $userOrders[$a['ID']]['so_don'] ?? 0;
        $bDon = $userOrders[$b['ID']]['so_don'] ?? 0;
        return $bDon - $aDon;
    });
}

// Sắp xếp tổng tiền
$sortTotal = isset($_GET['sort_total']) ? $_GET['sort_total'] : '';
if ($sortTotal === 'asc') {
    usort($users, function($a, $b) use ($userOrders) {
        $aTien = $userOrders[$a['ID']]['tong_tien'] ?? 0;
        $bTien = $userOrders[$b['ID']]['tong_tien'] ?? 0;
        return $aTien - $bTien;
    });
} elseif ($sortTotal === 'desc') {
    usort($users, function($a, $b) use ($userOrders) {
        $aTien = $userOrders[$a['ID']]['tong_tien'] ?? 0;
        $bTien = $userOrders[$b['ID']]['tong_tien'] ?? 0;
        return $bTien - $aTien;
    });
}

// Sắp xếp ngày tạo (nếu không sắp xếp theo số đơn hoặc tổng tiền)
if ($sortDate === 'asc' && $sortOrder === '' && $sortTotal === '') {
    usort($users, function($a, $b) { return strcmp($a['NgayTao'], $b['NgayTao']); });
} elseif ($sortDate === 'desc' && $sortOrder === '' && $sortTotal === '') {
    usort($users, function($a, $b) { return strcmp($b['NgayTao'], $a['NgayTao']); });
}

// Phân trang
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $perPage);
$users = array_values($users);
$users = array_slice($users, ($page - 1) * $perPage, $perPage);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Người dùng</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <!-- Form lọc -->
                    <form method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm tên, email, SĐT" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="sort_date" class="form-control mr-2">
                            <option value="">Sắp xếp ngày tạo</option>
                            <option value="asc" <?php if($sortDate=='asc') echo 'selected'; ?>>Tăng dần</option>
                            <option value="desc" <?php if($sortDate=='desc') echo 'selected'; ?>>Giảm dần</option>
                        </select>
                        <label class="mr-2 ml-2">Từ</label>
                        <input type="date" name="created_from" class="form-control mr-2" value="<?php echo htmlspecialchars($created_from); ?>">
                        <label class="mr-2">Đến</label>
                        <input type="date" name="created_to" class="form-control mr-2" value="<?php echo htmlspecialchars($created_to); ?>">
                        <select name="role" class="form-control mr-2">
                            <option value="">Tất cả vai trò</option>
                            <option value="Người dùng" <?php if($role=='Người dùng') echo 'selected'; ?>>Người dùng</option>
                            <option value="Quản trị viên" <?php if($role=='Quản trị viên') echo 'selected'; ?>>Quản trị viên</option>
                        </select>
                        <input type="number" name="order_from" class="form-control mr-2" placeholder="Số đơn từ" value="<?php echo htmlspecialchars($_GET['order_from'] ?? ''); ?>">
                        <input type="number" name="order_to" class="form-control mr-2" placeholder="Số đơn đến" value="<?php echo htmlspecialchars($_GET['order_to'] ?? ''); ?>">
                        <select name="sort_order" class="form-control mr-2">
                            <option value="">Sắp xếp số đơn</option>
                            <option value="asc" <?php if($sortOrder=='asc') echo 'selected'; ?>>Tăng dần</option>
                            <option value="desc" <?php if($sortOrder=='desc') echo 'selected'; ?>>Giảm dần</option>
                        </select>
                        <input type="number" name="total_from" class="form-control mr-2" placeholder="Tổng tiền từ" value="<?php echo htmlspecialchars($_GET['total_from'] ?? ''); ?>">
                        <input type="number" name="total_to" class="form-control mr-2" placeholder="Tổng tiền đến" value="<?php echo htmlspecialchars($_GET['total_to'] ?? ''); ?>">
                        <select name="sort_total" class="form-control mr-2">
                            <option value="">Sắp xếp tổng tiền</option>
                            <option value="asc" <?php if($sortTotal=='asc') echo 'selected'; ?>>Tăng dần</option>
                            <option value="desc" <?php if($sortTotal=='desc') echo 'selected'; ?>>Giảm dần</option>
                        </select>
                        <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-filter"></i> Lọc</button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Xóa bộ lọc</a>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Giới tính</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tạo</th>
                                    <th>Số đơn hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <?php
                                $soDon = $userOrders[$user['ID']]['so_don'] ?? 0;
                                $tongTien = $userOrders[$user['ID']]['tong_tien'] ?? 0;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($user['Ten']); ?></td>
                                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['DiaChi']); ?></td>
                                    <td><?php echo htmlspecialchars($user['SoDienThoai']); ?></td>
                                    <td><?php echo htmlspecialchars($user['GioiTinh']); ?></td>
                                    <td><?php echo htmlspecialchars($user['VaiTro']); ?></td>
                                    <td><?php echo htmlspecialchars($user['NgayTao']); ?></td>
                                    <td><?php echo $soDon; ?></td>
                                    <td><?php echo number_format($tongTien, 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editUserModal<?php echo $user['ID']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="?delete=<?php echo $user['ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- PHÂN TRANG -->
                    <?php if ($totalPages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?<?php
                                        $params = $_GET;
                                        $params['page'] = $i;
                                        echo http_build_query($params);
                                    ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên</label>
                    <input type="text" name="Ten" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="MatKhau" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="DiaChi" class="form-control">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="GioiTinh" class="form-control">
                        <option value="">-- Chọn --</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Vai trò</label>
                    <select name="VaiTro" class="form-control">
                        <option value="Người dùng">Người dùng</option>
                        <option value="Quản trị viên">Quản trị viên</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" name="add_user" class="btn btn-primary">Thêm</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa -->
<?php foreach ($users as $user): ?>
<div class="modal fade" id="editUserModal<?php echo $user['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $user['ID']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['ID']; ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel<?php echo $user['ID']; ?>">Sửa thông tin người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên</label>
                    <input type="text" name="Ten" class="form-control" value="<?php echo htmlspecialchars($user['Ten']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="DiaChi" class="form-control" value="<?php echo htmlspecialchars($user['DiaChi']); ?>">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="SoDienThoai" class="form-control" value="<?php echo htmlspecialchars($user['SoDienThoai']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="GioiTinh" class="form-control">
                        <option value="">-- Chọn --</option>
                        <option value="Nam" <?php if($user['GioiTinh']=='Nam') echo 'selected'; ?>>Nam</option>
                        <option value="Nữ" <?php if($user['GioiTinh']=='Nữ') echo 'selected'; ?>>Nữ</option>
                        <option value="Khác" <?php if($user['GioiTinh']=='Khác') echo 'selected'; ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Vai trò</label>
                    <select name="VaiTro" class="form-control">
                        <option value="Người dùng" <?php if($user['VaiTro']=='Người dùng') echo 'selected'; ?>>Người dùng</option>
                        <option value="Quản trị viên" <?php if($user['VaiTro']=='Quản trị viên') echo 'selected'; ?>>Quản trị viên</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Xác suất rời bỏ</label>
                    <input type="number" step="0.01" name="XacSuatRoiBo" class="form-control" value="<?php echo htmlspecialchars($user['XacSuatRoiBo']); ?>">
                </div>
                <div class="form-group">
                    <label>Số ngày mua cuối</label>
                    <input type="number" name="SoNgayMuaCuoi" class="form-control" value="<?php echo htmlspecialchars($user['SoNgayMuaCuoi']); ?>">
                </div>
                <div class="form-group">
                    <label>Tần suất mua hàng</label>
                    <input type="number" name="TanSuatMuaHang" class="form-control" value="<?php echo htmlspecialchars($user['TanSuatMuaHang']); ?>">
                </div>
                <div class="form-group">
                    <label>Giá trị tiền tệ</label>
                    <input type="number" step="0.01" name="GiaTriTienTe" class="form-control" value="<?php echo htmlspecialchars($user['GiaTriTienTe']); ?>">
                </div>
                <div class="form-group">
                    <label>Tỷ lệ giỏ hàng bị bỏ</label>
                    <input type="number" step="0.01" name="TyLeGioHangBiBo" class="form-control" value="<?php echo htmlspecialchars($user['TyLeGioHangBiBo']); ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" name="edit_user" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>
