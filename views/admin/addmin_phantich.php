<?php require_once 'partials/header.php'; ?>

<?php
require_once __DIR__ . '/../../models/phantichModel.php';
$phanTichModel = new PhanTichModel();

// Xử lý bộ lọc ngày
$from = isset($_GET['from']) && $_GET['from'] !== '' ? $_GET['from'] : date('Y-m-01');
$to = isset($_GET['to']) && $_GET['to'] !== '' ? $_GET['to'] : date('Y-m-d');

// Lấy dữ liệu tổng quan
$tongDoanhThu = $phanTichModel->getTongDoanhThu($from, $to);
$tongDonHang = $phanTichModel->getTongDonHang($from, $to);
$tongTaiKhoan = $phanTichModel->getTongTaiKhoanMoi($from, $to);

// Lấy dữ liệu biểu đồ
$dataDoanhThu = $phanTichModel->getDoanhThuTheoNgay($from, $to);
$dataDonHang = $phanTichModel->getDonHangTheoNgay($from, $to);
$dataTaiKhoan = $phanTichModel->getTaiKhoanMoiTheoNgay($from, $to);

// Chuẩn bị dữ liệu cho Chart.js
$labels = [];
$doanhThuArr = [];
$donHangArr = [];
$taiKhoanArr = [];

// Lấy tất cả ngày trong khoảng để đồng bộ trục X
$period = new DatePeriod(
    new DateTime($from),
    new DateInterval('P1D'),
    (new DateTime($to))->modify('+1 day')
);
foreach ($period as $date) {
    $d = $date->format('Y-m-d');
    $labels[] = $d;
    // Doanh thu
    $found = false;
    foreach ($dataDoanhThu as $row) {
        if ($row['ngay'] === $d) {
            $doanhThuArr[] = (float)$row['doanh_thu'];
            $found = true;
            break;
        }
    }
    if (!$found) $doanhThuArr[] = 0;
    // Đơn hàng
    $found = false;
    foreach ($dataDonHang as $row) {
        if ($row['ngay'] === $d) {
            $donHangArr[] = (int)$row['so_don'];
            $found = true;
            break;
        }
    }
    if (!$found) $donHangArr[] = 0;
    // Tài khoản
    $found = false;
    foreach ($dataTaiKhoan as $row) {
        if ($row['ngay'] === $d) {
            $taiKhoanArr[] = (int)$row['so_tai_khoan'];
            $found = true;
            break;
        }
    }
    if (!$found) $taiKhoanArr[] = 0;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phân tích & Thống kê</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Phân tích & Thống kê</h3>
    <!-- Bộ lọc ngày -->
    <form class="form-inline mb-4" method="get">
        <label class="mr-2">Từ ngày</label>
        <input type="date" name="from" class="form-control mr-2" value="<?php echo htmlspecialchars($from); ?>">
        <label class="mr-2">Đến ngày</label>
        <input type="date" name="to" class="form-control mr-2" value="<?php echo htmlspecialchars($to); ?>">
        <button type="submit" class="btn btn-primary mr-2">Lọc</button>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Xóa bộ lọc</a>
    </form>
    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Tổng doanh thu</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo number_format($tongDoanhThu, 0, ',', '.'); ?> VNĐ</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Tổng đơn hàng</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $tongDonHang; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tài khoản mới</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $tongTaiKhoan; ?></h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Biểu đồ -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <canvas id="chartDoanhThu"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="chartDonHang"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="chartTaiKhoan"></canvas>
        </div>
    </div>
</div>
<script>
const labels = <?php echo json_encode($labels); ?>;
const doanhThuData = <?php echo json_encode($doanhThuArr); ?>;
const donHangData = <?php echo json_encode($donHangArr); ?>;
const taiKhoanData = <?php echo json_encode($taiKhoanArr); ?>;

// Doanh thu
new Chart(document.getElementById('chartDoanhThu'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: doanhThuData,
            backgroundColor: 'rgba(40, 167, 69, 0.5)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
// Đơn hàng
new Chart(document.getElementById('chartDonHang'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Số đơn hàng',
            data: donHangData,
            backgroundColor: 'rgba(23, 162, 184, 0.3)',
            borderColor: 'rgba(23, 162, 184, 1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
// Tài khoản mới
new Chart(document.getElementById('chartTaiKhoan'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Tài khoản mới',
            data: taiKhoanData,
            backgroundColor: 'rgba(0, 123, 255, 0.3)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
