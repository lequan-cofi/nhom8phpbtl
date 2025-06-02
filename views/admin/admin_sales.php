<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../controllers/admin_saleController.php';
$controller = new AdminSaleController();
$sales = $controller->getAll();
$thietbi = $controller->getAllThietBi();
$khuyenmai = $controller->getAllKhuyenMai();

// Lọc khuyến mãi đang diễn ra nếu có tham số GET
$showActive = isset($_GET['active']) && $_GET['active'] == '1';
if ($showActive) {
    $now = date('Y-m-d H:i:s');
    $sales = array_filter($sales, function($sale) use ($now) {
        $start = $sale['NgayBatDau'] ?? null;
        $end = $sale['NgayKetThuc'] ?? null;
        return (!$start || $start <= $now) && (!$end || $end >= $now);
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm Khuyến mãi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Sản phẩm Khuyến mãi</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addSaleModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <form method="get" class="form-inline mb-3">
                        <div class="form-group mr-2">
                            <label for="active" class="mr-1">Chỉ hiển thị khuyến mãi đang diễn ra</label>
                            <input type="checkbox" id="active" name="active" value="1" <?php if($showActive) echo 'checked'; ?> onchange="this.form.submit()">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên thiết bị</th>
                                    <th>Tên khuyến mãi</th>
                                    <th>Giá gốc</th>
                                    <th>Mức giảm (%)</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $sale): ?>
                                <tr>
                                    <td><?= htmlspecialchars($sale['ID'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($sale['TenThietBi'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($sale['TenKhuyenMai'] ?? '') ?></td>
                                    <td><?php echo isset($sale['Gia']) ? number_format($sale['Gia'], 0, ',', '.') : ''; ?></td>
                                    <td><?php echo isset($sale['MucGiamGia']) ? $sale['MucGiamGia'] : ''; ?></td>
                                    <td><?= htmlspecialchars($sale['NgayTao'] ?? '') ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-sale" 
                                                data-id="<?php echo $sale['ID']; ?>"
                                                data-toggle="modal" 
                                                data-target="#editSaleModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-sale"
                                                data-id="<?php echo $sale['ID']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="addSaleModal" tabindex="-1" role="dialog" aria-labelledby="addSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSaleModalLabel">Thêm sản phẩm khuyến mãi mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSaleForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="IDThietBi">Thiết bị</label>
                        <select class="form-control" id="IDThietBi" name="IDThietBi" required>
                            <option value="">-- Chọn thiết bị --</option>
                            <?php foreach ($thietbi as $tb): ?>
                                <option value="<?php echo $tb['ID']; ?>"><?php echo htmlspecialchars($tb['Ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="IDKhuyenMai">Khuyến mãi</label>
                        <select class="form-control" id="IDKhuyenMai" name="IDKhuyenMai" required>
                            <option value="">-- Chọn khuyến mãi --</option>
                            <?php foreach ($khuyenmai as $km): ?>
                                <option value="<?php echo $km['ID']; ?>"><?php echo htmlspecialchars($km['TenKhuyenMai']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Chỉnh sửa -->
<div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSaleModalLabel">Chỉnh sửa sản phẩm khuyến mãi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSaleForm">
                <div class="modal-body">
                    <input type="hidden" id="editID" name="ID">
                    <div class="form-group">
                        <label for="editIDThietBi">Thiết bị</label>
                        <select class="form-control" id="editIDThietBi" name="IDThietBi" required>
                            <option value="">-- Chọn thiết bị --</option>
                            <?php foreach ($thietbi as $tb): ?>
                                <option value="<?php echo $tb['ID']; ?>"><?php echo htmlspecialchars($tb['Ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editIDKhuyenMai">Khuyến mãi</label>
                        <select class="form-control" id="editIDKhuyenMai" name="IDKhuyenMai" required>
                            <option value="">-- Chọn khuyến mãi --</option>
                            <?php foreach ($khuyenmai as $km): ?>
                                <option value="<?php echo $km['ID']; ?>"><?php echo htmlspecialchars($km['TenKhuyenMai']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Thêm mới
    $('#addSaleForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post('/iStore_PHP_Backend/controllers/admin_saleController.php?action=create', formData, function(response) {
            if (typeof response === 'string') response = JSON.parse(response);
            if (response.success) {
                Swal.fire('Thành công!', 'Thêm thành công!', 'success').then(() => location.reload());
            } else {
                Swal.fire('Lỗi!', response.message || 'Có lỗi xảy ra khi thêm', 'error');
            }
        });
    });

    // Sửa
    $('.edit-sale').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/iStore_PHP_Backend/controllers/admin_saleController.php?action=getOne&id=' + id,
            type: 'GET',
            success: function(response) {
                if (typeof response === 'string') response = JSON.parse(response);
                if(response.success) {
                    var sale = response.data;
                    $('#editID').val(sale.ID);
                    $('#editIDThietBi').val(sale.IDThietBi);
                    $('#editIDKhuyenMai').val(sale.IDKhuyenMai);
                } else {
                    Swal.fire('Lỗi!', response.message || 'Không xác định', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Lỗi!', 'Có lỗi khi lấy thông tin: ' + error, 'error');
            }
        });
    });

    // Cập nhật
    $('#editSaleForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/iStore_PHP_Backend/controllers/admin_saleController.php?action=update',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (typeof response === 'string') response = JSON.parse(response);
                if(response.success) {
                    Swal.fire('Cập nhật thành công!', '', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Lỗi!', response.message || 'Có lỗi xảy ra khi cập nhật', 'error');
                }
            }
        });
    });

    // Xóa
    $('.delete-sale').click(function() {
        if(confirm('Bạn có chắc chắn muốn xóa bản ghi này?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/iStore_PHP_Backend/controllers/admin_saleController.php?action=delete',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (typeof response === 'string') response = JSON.parse(response);
                    if(response.success) {
                        Swal.fire('Đã xóa!', 'Xóa thành công!', 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Lỗi!', response.message || 'Không thể xóa.', 'error');
                    }
                }
            });
        }
    });
});
</script>
<?php require_once 'partials/footer.php'; ?>
</body>
</html>
