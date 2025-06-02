<?php
require_once __DIR__ . '/../../models/khuyenmaiModel.php';
$kmModel = new KhuyenMaiModel();

// Xử lý thêm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_km'])) {
    $data = [
        'TenKhuyenMai' => $_POST['TenKhuyenMai'],
        'MucGiamGia' => $_POST['MucGiamGia'],
        'NgayBatDau' => $_POST['NgayBatDau'],
        'NgayKetThuc' => $_POST['NgayKetThuc']
    ];
    $kmModel->create($data);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_km'])) {
    $id = $_POST['id'];
    $data = [
        'TenKhuyenMai' => $_POST['TenKhuyenMai'],
        'MucGiamGia' => $_POST['MucGiamGia'],
        'NgayBatDau' => $_POST['NgayBatDau'],
        'NgayKetThuc' => $_POST['NgayKetThuc']
    ];
    $kmModel->update($id, $data);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Xử lý xóa
if (isset($_GET['delete'])) {
    $kmModel->delete($_GET['delete']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Lấy danh sách khuyến mãi
$khuyenmais = $kmModel->getAll();

// Tìm kiếm theo tên
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $khuyenmais = array_filter($khuyenmais, function($km) use ($search) {
        return stripos($km['TenKhuyenMai'], $search) !== false;
    });
}
// Lọc theo khoảng ngày bắt đầu
$ngaybd_from = isset($_GET['ngaybd_from']) ? $_GET['ngaybd_from'] : '';
$ngaybd_to = isset($_GET['ngaybd_to']) ? $_GET['ngaybd_to'] : '';
if ($ngaybd_from !== '' || $ngaybd_to !== '') {
    $khuyenmais = array_filter($khuyenmais, function($km) use ($ngaybd_from, $ngaybd_to) {
        $date = substr($km['NgayBatDau'], 0, 10);
        if ($ngaybd_from !== '' && $date < $ngaybd_from) return false;
        if ($ngaybd_to !== '' && $date > $ngaybd_to) return false;
        return true;
    });
}
// Lọc theo khoảng ngày kết thúc
$ngaykt_from = isset($_GET['ngaykt_from']) ? $_GET['ngaykt_from'] : '';
$ngaykt_to = isset($_GET['ngaykt_to']) ? $_GET['ngaykt_to'] : '';
if ($ngaykt_from !== '' || $ngaykt_to !== '') {
    $khuyenmais = array_filter($khuyenmais, function($km) use ($ngaykt_from, $ngaykt_to) {
        $date = substr($km['NgayKetThuc'], 0, 10);
        if ($ngaykt_from !== '' && $date < $ngaykt_from) return false;
        if ($ngaykt_to !== '' && $date > $ngaykt_to) return false;
        return true;
    });
}
// Phân trang
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$totalKM = count($khuyenmais);
$totalPages = ceil($totalKM / $perPage);
$khuyenmais = array_values($khuyenmais);
$khuyenmais = array_slice($khuyenmais, ($page - 1) * $perPage, $perPage);
?>
<?php require_once 'partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khuyến mãi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý khuyến mãi</h5>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Thêm khuyến mãi
                    </button>
                </div>
                <div class="card-body">
                    <!-- Form lọc -->
                    <form method="GET" class="form-inline mb-3">
                        <div class="form-group mr-3">
                            <label for="search" class="mr-2">Tên khuyến mãi</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Tìm theo tên" value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="form-group mr-3">
                            <label class="mr-2">Ngày bắt đầu</label>
                            <input type="date" name="ngaybd_from" class="form-control mr-1" value="<?php echo htmlspecialchars($ngaybd_from); ?>">
                            <span class="mx-1">-</span>
                            <input type="date" name="ngaybd_to" class="form-control" value="<?php echo htmlspecialchars($ngaybd_to); ?>">
                        </div>
                        <div class="form-group mr-3">
                            <label class="mr-2">Ngày kết thúc</label>
                            <input type="date" name="ngaykt_from" class="form-control mr-1" value="<?php echo htmlspecialchars($ngaykt_from); ?>">
                            <span class="mx-1">-</span>
                            <input type="date" name="ngaykt_to" class="form-control" value="<?php echo htmlspecialchars($ngaykt_to); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên khuyến mãi</th>
                                    <th>Mức giảm giá</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($khuyenmais as $km): ?>
                                <tr>
                                    <td>#<?php echo $km['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($km['TenKhuyenMai']); ?></td>
                                    <td><?php echo $km['MucGiamGia']; ?></td>
                                    <td><?php echo $km['NgayBatDau']; ?></td>
                                    <td><?php echo $km['NgayKetThuc']; ?></td>
                                    <td><?php echo $km['NgayTao']; ?></td>
                                    <td><?php echo $km['NgayCapNhat']; ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $km['ID']; ?>">
                                            <i class="fas fa-edit"></i> Sửa
                                        </button>
                                        <a href="?delete=<?php echo $km['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
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
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title">Thêm khuyến mãi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tên khuyến mãi</label>
                    <input type="text" name="TenKhuyenMai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mức giảm giá</label>
                    <input type="number" step="0.01" name="MucGiamGia" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" name="NgayBatDau" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" name="NgayKetThuc" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" name="add_km" class="btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa -->
<?php foreach ($khuyenmais as $km): ?>
<div class="modal fade" id="editModal<?php echo $km['ID']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <input type="hidden" name="id" value="<?php echo $km['ID']; ?>">
            <div class="modal-header">
                <h5 class="modal-title">Sửa khuyến mãi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tên khuyến mãi</label>
                    <input type="text" name="TenKhuyenMai" class="form-control" value="<?php echo htmlspecialchars($km['TenKhuyenMai']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mức giảm giá</label>
                    <input type="number" step="0.01" name="MucGiamGia" class="form-control" value="<?php echo $km['MucGiamGia']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" name="NgayBatDau" class="form-control" value="<?php echo $km['NgayBatDau'] ? date('Y-m-d\TH:i', strtotime($km['NgayBatDau'])) : ''; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" name="NgayKetThuc" class="form-control" value="<?php echo $km['NgayKetThuc'] ? date('Y-m-d\TH:i', strtotime($km['NgayKetThuc'])) : ''; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" name="edit_km" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
