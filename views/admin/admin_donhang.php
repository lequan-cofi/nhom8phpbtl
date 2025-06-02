<?php
require_once __DIR__ . '/../../models/DonHangModel.php';
require_once __DIR__ . '/../../models/GiaoDichThanhToanModel.php';
$donHangModel = new DonHangModel();
$giaoDichModel = new GiaoDichThanhToanModel();

// Các trạng thái đơn hàng
$orderStatuses = [
    'all' => 'Tất cả',
    'Chờ xử lý' => 'Chờ xử lý',
    'Đang xử lý' => 'Đang xử lý',
    'Đã vận chuyển' => 'Đã vận chuyển',
    'Hoàn thành' => 'Hoàn thành',
    'Đã hủy' => 'Đã hủy',
];

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    $donHangModel->updateStatus($orderId, $newStatus);
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
    exit();
}
// Xử lý thêm giao dịch thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_gd'])) {
    $data = [
        'CongThanhToan' => $_POST['CongThanhToan'],
        'NgayGiaoDich' => $_POST['NgayGiaoDich'],
        'SoTienChuyen' => $_POST['SoTienChuyen'],
        'TrangThaiGiaoDich' => $_POST['TrangThaiGiaoDich'],
        'LoaiGiaoDich' => $_POST['LoaiGiaoDich'],
        'MaGiaoDichCongTT' => $_POST['MaGiaoDichCongTT'] ?? null,
        'NoiDung' => $_POST['NoiDung'] ?? null,
        'MoTa' => $_POST['MoTa'] ?? null,
        'SoTaiKhoan' => $_POST['SoTaiKhoan'] ?? null,
        'TaiKhoanPhu' => $_POST['TaiKhoanPhu'] ?? null,
        'MaDonHangThamChieu' => $_POST['add_gd_order_id'],
        'IDNguoiDung' => null // Có thể lấy từ đơn hàng nếu muốn
    ];
    $giaoDichModel->create($data);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=' . ($_GET['page'] ?? 1));
    exit();
}
// Xử lý sửa giao dịch thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_gd'])) {
    $id = $_POST['edit_gd_id'];
    $data = [
        'CongThanhToan' => $_POST['CongThanhToan'],
        'NgayGiaoDich' => $_POST['NgayGiaoDich'],
        'SoTienChuyen' => $_POST['SoTienChuyen'],
        'TrangThaiGiaoDich' => $_POST['TrangThaiGiaoDich'],
        'LoaiGiaoDich' => $_POST['LoaiGiaoDich'],
        'MaGiaoDichCongTT' => $_POST['MaGiaoDichCongTT'] ?? null,
        'NoiDung' => $_POST['NoiDung'] ?? null,
        'MoTa' => $_POST['MoTa'] ?? null,
        'SoTaiKhoan' => $_POST['SoTaiKhoan'] ?? null,
        'TaiKhoanPhu' => $_POST['TaiKhoanPhu'] ?? null
    ];
    $giaoDichModel->update($id, $data);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=' . ($_GET['page'] ?? 1));
    exit();
}
// Xử lý xoá giao dịch thanh toán
if (isset($_GET['delete_gd'])) {
    $giaoDichModel->delete($_GET['delete_gd']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?page=' . ($_GET['page'] ?? 1));
    exit();
}

// Lấy danh sách đơn hàng
$orders = $donHangModel->getAll();

// Lọc theo trạng thái nếu có
$selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
if ($selectedStatus !== 'all') {
    $orders = array_filter($orders, function($order) use ($selectedStatus) {
        return $order['TrangThaiDonHang'] === $selectedStatus;
    });
    $orders = array_values($orders);
}

// Tìm kiếm theo mã đơn hàng hoặc số điện thoại
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $orders = array_filter($orders, function($order) use ($search) {
        return stripos((string)$order['ID'], $search) !== false || stripos($order['SoDienThoai'], $search) !== false;
    });
    $orders = array_values($orders); // Reset key
}

// Phân trang
$perPage = isset($_GET['perPage']) ? max(1, intval($_GET['perPage'])) : 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalOrders = count($orders);
$totalPages = ceil($totalOrders / $perPage);
$orders = array_slice($orders, ($page - 1) * $perPage, $perPage);

?>
<?php require_once 'partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    .form-inline { display: flex; align-items: center; }
    .form-control { margin-right: 15px; width: 200px; }
</style>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Đơn hàng</h5>
                    <form method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Mã đơn/SĐT" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="status" class="form-control mr-2">
                            <?php foreach ($orderStatuses as $key => $label): ?>
                                <option value="<?php echo $key; ?>" <?php echo $selectedStatus === $key ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-light"><i class="fas fa-search"></i> Lọc</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($order['TenKhachHang']); ?></td>
                                    <td><?php echo htmlspecialchars($order['SoDienThoai']); ?></td>
                                    <td><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <?php
                                        $tt = $order['TrangThaiDonHang'];
                                        $color = 'secondary';
                                        $label = $tt;
                                        if ($tt == 'Chờ xử lý') {
                                            $color = 'warning'; $label = 'Chờ xử lý';
                                        } elseif ($tt == 'Đang xử lý') {
                                            $color = 'info'; $label = 'Đang xử lý';
                                        } elseif ($tt == 'Hoàn thành') {
                                            $color = 'success'; $label = 'Hoàn thành';
                                        } elseif ($tt == 'Đã hủy') {
                                            $color = 'danger'; $label = 'Đã hủy';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $color; ?> text-dark">
                                            <?php echo $label; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($order['NgayTao'])); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['ID']; ?>">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $order['ID']; ?>">
                                            <i class="fas fa-edit"></i> Cập nhật
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- PHÂN TRANG -->
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Render toàn bộ modal ở đây -->
<?php foreach ($orders as $order): ?>
    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal fade" id="orderModal<?php echo $order['ID']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết đơn hàng #<?php echo $order['ID']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php 
                    $orderDetails = $donHangModel->getDetail($order['ID']);
                    $giaoDichs = $giaoDichModel->getByOrderId($order['ID']);
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenKhachHang']); ?></p>
                            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['SoDienThoai']); ?></p>
                            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['DiaChiGiaoHang']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?></p>
                            <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['GhiChu']); ?></p>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderDetails as $detail): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detail['TenThietBi']); ?></td>
                                <td><?php echo $detail['SoLuong']; ?></td>
                                <td><?php echo number_format($detail['Gia'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo number_format($detail['Gia'] * $detail['SoLuong'], 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng tiền:</strong></td>
                                <td><strong><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Giao dịch thanh toán -->
                    <hr>
                    <h6>Giao dịch thanh toán</h6>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Cổng TT</th>
                                <th>Ngày GD</th>
                                <th>Số tiền</th>
                                <th>Trạng thái</th>
                                <th>Loại GD</th>
                                <th>Mã GD</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($giaoDichs as $gd): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($gd['CongThanhToan']); ?></td>
                                <td><?php echo htmlspecialchars($gd['NgayGiaoDich']); ?></td>
                                <td><?php echo number_format($gd['SoTienChuyen'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($gd['TrangThaiGiaoDich']); ?></td>
                                <td><?php echo htmlspecialchars($gd['LoaiGiaoDich']); ?></td>
                                <td><?php echo htmlspecialchars($gd['MaGiaoDichCongTT']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editGiaoDichModal<?php echo $gd['ID']; ?>">Sửa</button>
                                    <a href="?delete_gd=<?php echo $gd['ID']; ?>&order_id=<?php echo $order['ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá giao dịch này?');">Xoá</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addGiaoDichModal<?php echo $order['ID']; ?>">Thêm giao dịch</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cập nhật trạng thái -->
    <div class="modal fade" id="updateModal<?php echo $order['ID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật trạng thái đơn hàng #<?php echo $order['ID']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" value="<?php echo $order['ID']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Trạng thái hiện tại:</label>
                            <p class="form-control-static"><?php echo $orderStatuses[$order['TrangThaiDonHang']] ?? ucfirst($order['TrangThaiDonHang']); ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="new_status" class="form-label">Cập nhật trạng thái:</label>
                            <select class="form-select" name="new_status" id="new_status" required>
                                <?php foreach ($orderStatuses as $key => $label):
                                    if ($key === 'all') continue; // Bỏ qua 'Tất cả'
                                ?>
                                    <option value="<?php echo $key; ?>" <?php if($order['TrangThaiDonHang'] === $key) echo 'selected'; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Thêm giao dịch -->
    <div class="modal fade" id="addGiaoDichModal<?php echo $order['ID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm giao dịch thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="add_gd_order_id" value="<?php echo $order['ID']; ?>">
                        <div class="mb-2">
                            <label>Cổng thanh toán</label>
                            <input type="text" name="CongThanhToan" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Ngày giao dịch</label>
                            <input type="datetime-local" name="NgayGiaoDich" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Số tiền chuyển</label>
                            <input type="number" name="SoTienChuyen" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Trạng thái</label>
                            <select name="TrangThaiGiaoDich" class="form-control" required>
                                <option value="Chờ xử lý">Chờ xử lý</option>
                                <option value="Thành công">Thành công</option>
                                <option value="Thất bại">Thất bại</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Loại giao dịch</label>
                            <select name="LoaiGiaoDich" class="form-control" required>
                                <option value="Thanh toán">Thanh toán</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Hoàn tiền">Hoàn tiền</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Mã giao dịch cổng TT</label>
                            <input type="text" name="MaGiaoDichCongTT" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Nội dung</label>
                            <input type="text" name="NoiDung" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Mô tả</label>
                            <input type="text" name="MoTa" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Số tài khoản</label>
                            <input type="text" name="SoTaiKhoan" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Tài khoản phụ</label>
                            <input type="text" name="TaiKhoanPhu" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="add_gd" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Sửa giao dịch -->
    <?php foreach ($giaoDichs as $gd): ?>
    <div class="modal fade" id="editGiaoDichModal<?php echo $gd['ID']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa giao dịch thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_gd_id" value="<?php echo $gd['ID']; ?>">
                        <div class="mb-2">
                            <label>Cổng thanh toán</label>
                            <input type="text" name="CongThanhToan" class="form-control" value="<?php echo htmlspecialchars($gd['CongThanhToan']); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label>Ngày giao dịch</label>
                            <input type="datetime-local" name="NgayGiaoDich" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($gd['NgayGiaoDich'])); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label>Số tiền chuyển</label>
                            <input type="number" name="SoTienChuyen" class="form-control" value="<?php echo $gd['SoTienChuyen']; ?>" required>
                        </div>
                        <div class="mb-2">
                            <label>Trạng thái</label>
                            <select name="TrangThaiGiaoDich" class="form-control" required>
                                <option value="Chờ xử lý" <?php if($gd['TrangThaiGiaoDich']=='Chờ xử lý') echo 'selected'; ?>>Chờ xử lý</option>
                                <option value="Thành công" <?php if($gd['TrangThaiGiaoDich']=='Thành công') echo 'selected'; ?>>Thành công</option>
                                <option value="Thất bại" <?php if($gd['TrangThaiGiaoDich']=='Thất bại') echo 'selected'; ?>>Thất bại</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Loại giao dịch</label>
                            <select name="LoaiGiaoDich" class="form-control" required>
                                <option value="Thanh toán" <?php if($gd['LoaiGiaoDich']=='Thanh toán') echo 'selected'; ?>>Thanh toán</option>
                                <option value="Chuyển khoản" <?php if($gd['LoaiGiaoDich']=='Chuyển khoản') echo 'selected'; ?>>Chuyển khoản</option>
                                <option value="Hoàn tiền" <?php if($gd['LoaiGiaoDich']=='Hoàn tiền') echo 'selected'; ?>>Hoàn tiền</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Mã giao dịch cổng TT</label>
                            <input type="text" name="MaGiaoDichCongTT" class="form-control" value="<?php echo htmlspecialchars($gd['MaGiaoDichCongTT']); ?>">
                        </div>
                        <div class="mb-2">
                            <label>Nội dung</label>
                            <input type="text" name="NoiDung" class="form-control" value="<?php echo htmlspecialchars($gd['NoiDung']); ?>">
                        </div>
                        <div class="mb-2">
                            <label>Mô tả</label>
                            <input type="text" name="MoTa" class="form-control" value="<?php echo htmlspecialchars($gd['MoTa']); ?>">
                        </div>
                        <div class="mb-2">
                            <label>Số tài khoản</label>
                            <input type="text" name="SoTaiKhoan" class="form-control" value="<?php echo htmlspecialchars($gd['SoTaiKhoan']); ?>">
                        </div>
                        <div class="mb-2">
                            <label>Tài khoản phụ</label>
                            <input type="text" name="TaiKhoanPhu" class="form-control" value="<?php echo htmlspecialchars($gd['TaiKhoanPhu']); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="edit_gd" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
