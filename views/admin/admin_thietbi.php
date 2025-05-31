<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../controllers/ThietbiController.php';
require_once __DIR__ . '/../../models/LoaiThietBiModel.php';

// Lấy danh sách thiết bị
$thietbiController = new ThietBiController();
$thietbi = $thietbiController->getAll();

// Lấy danh sách loại thiết bị
$loaiThietBiModel = new LoaiThietBiModel();
$loaiThietBi = $loaiThietBiModel->getAll()->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Thiết bị</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Thiết bị</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addDeviceModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên thiết bị</th>
                                    <th>Loại thiết bị</th>
                                    <th>Giá</th>
                                    <th>Số lượng tồn kho</th>
                                    <th>Đường dẫn liên kết</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($thietbi as $tb): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($tb['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($tb['Ten']); ?></td>
                                    <td><?php echo htmlspecialchars($tb['TenLoaiThietBi']); ?></td>
                                    <td><?php echo number_format($tb['Gia'], 0, ',', '.'); ?> đ</td>
                                    <td><?php echo htmlspecialchars($tb['SoLuongTonKho']); ?></td>
                                    <td><?php echo htmlspecialchars($tb['DuongDanLienKet'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($tb['NgayTao']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-device" 
                                                data-id="<?php echo $tb['ID']; ?>"
                                                data-toggle="modal" 
                                                data-target="#editDeviceModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-device"
                                                data-id="<?php echo $tb['ID']; ?>">
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
<div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">Thêm thiết bị mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDeviceForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Ten">Tên thiết bị</label>
                        <input type="text" class="form-control" id="Ten" name="Ten" required>
                    </div>
                    <div class="form-group">
                        <label for="IDLoaiThietBi">Loại thiết bị</label>
                        <select class="form-control" id="IDLoaiThietBi" name="IDLoaiThietBi" required>
                            <option value="">-- Chọn loại thiết bị --</option>
                            <?php foreach ($loaiThietBi as $ltb): ?>
                                <option value="<?php echo $ltb['ID']; ?>"><?php echo htmlspecialchars($ltb['Ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Gia">Giá</label>
                        <input type="number" class="form-control" id="Gia" name="Gia" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="SoLuongTonKho">Số lượng tồn kho</label>
                        <input type="number" class="form-control" id="SoLuongTonKho" name="SoLuongTonKho" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="DuongDanLienKet">Đường dẫn liên kết</label>
                        <input type="text" class="form-control" id="DuongDanLienKet" name="DuongDanLienKet">
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
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeviceModalLabel">Chỉnh sửa thiết bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDeviceForm">
                <div class="modal-body">
                    <input type="hidden" id="editID" name="ID">
                    <div class="form-group">
                        <label for="editTen">Tên thiết bị</label>
                        <input type="text" class="form-control" id="editTen" name="Ten" required>
                    </div>
                    <div class="form-group">
                        <label for="editIDLoaiThietBi">Loại thiết bị</label>
                        <select class="form-control" id="editIDLoaiThietBi" name="IDLoaiThietBi" required>
                            <option value="">-- Chọn loại thiết bị --</option>
                            <?php foreach ($loaiThietBi as $ltb): ?>
                                <option value="<?php echo $ltb['ID']; ?>"><?php echo htmlspecialchars($ltb['Ten']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editGia">Giá</label>
                        <input type="number" class="form-control" id="editGia" name="Gia" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="editSoLuongTonKho">Số lượng tồn kho</label>
                        <input type="number" class="form-control" id="editSoLuongTonKho" name="SoLuongTonKho" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="editDuongDanLienKet">Đường dẫn liên kết</label>
                        <input type="text" class="form-control" id="editDuongDanLienKet" name="DuongDanLienKet">
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
    $('#addDeviceForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/iStore_PHP_Backend/controllers/ThietbiController.php?action=create',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    alert('Thêm thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi khi thêm: ' + error);
            }
        });
    });

    // Sửa
    $('.edit-device').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/iStore_PHP_Backend/controllers/ThietbiController.php?action=getOne&id=' + id,
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    var device = response.data;
                    $('#editID').val(device.ID);
                    $('#editTen').val(device.Ten);
                    $('#editIDLoaiThietBi').val(device.IDLoaiThietBi);
                    $('#editGia').val(device.Gia);
                    $('#editSoLuongTonKho').val(device.SoLuongTonKho);
                    $('#editDuongDanLienKet').val(device.DuongDanLienKet);
                } else {
                    alert('Có lỗi: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi khi lấy thông tin: ' + error);
            }
        });
    });

    // Cập nhật
    $('#editDeviceForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/iStore_PHP_Backend/controllers/ThietbiController.php?action=update',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    alert('Cập nhật thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi khi cập nhật: ' + error);
            }
        });
    });

    // Xóa
    $('.delete-device').click(function() {
        if(confirm('Bạn có chắc chắn muốn xóa thiết bị này?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/iStore_PHP_Backend/controllers/ThietbiController.php?action=delete&id=' + id,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        alert('Xóa thành công!');
                        location.reload();
                    } else {
                        alert('Có lỗi: ' + (response.message || 'Không xác định'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi khi xóa: ' + error);
                }
            });
        }
    });
});
</script>
<?php require_once 'partials/footer.php'; ?>
</body>
</html> 