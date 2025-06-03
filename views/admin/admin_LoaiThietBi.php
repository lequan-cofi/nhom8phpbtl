<?php
// Set headers first
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Define BASE_URL if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/iStore_PHP_Backend');
}

// Include required files
require_once __DIR__ . '/../../controllers/LoaithietbiController.php';

// Initialize controller
$loaithietbiController = new LoaithietbiController();
$deviceTypes = $loaithietbiController->getAll();

// Now include the header
require_once 'partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Thiết Bị</title>
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
                    <h5 class="mb-0">Quản lý Loại Thiết Bị</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addDeviceTypeModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên loại thiết bị</th>
                                    <th>Hình ảnh</th>
                                    <th>Liên kết</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deviceTypes as $type): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($type['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($type['Ten']); ?></td>
                                    <td>
                                        <?php if (!empty($type['DuongDanHinhAnh'])): ?>
                                            <img src="<?php echo htmlspecialchars($type['DuongDanHinhAnh']); ?>" alt="<?php echo htmlspecialchars($type['Ten']); ?>" class="img-thumbnail" style="max-width: 100px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($type['DuongDanLienKet'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($type['NgayTao']); ?></td>
                                    <td><?php echo htmlspecialchars($type['NgayCapNhat'] ?? 'Chưa cập nhật'); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-device-type" 
                                                data-id="<?php echo $type['ID']; ?>"
                                                data-toggle="modal" 
                                                data-target="#editDeviceTypeModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-device-type"
                                                data-id="<?php echo $type['ID']; ?>">
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
<div class="modal fade" id="addDeviceTypeModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceTypeModalLabel">Thêm loại thiết bị mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDeviceTypeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten">Tên loại thiết bị</label>
                        <input type="text" class="form-control" id="ten" name="Ten" required>
                    </div>
                    <div class="form-group">
                        <label for="hinhAnh">Hình ảnh</label>
                        <input type="text" class="form-control mb-2" id="hinhAnhUrl" name="DuongDanHinhAnhUrl" placeholder="Dán link ảnh từ Internet (nếu có)">
                        <input type="file" class="form-control-file" id="hinhAnhFile" name="DuongDanHinhAnhFile">
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label for="lienKet">Liên kết</label>
                        <input type="text" class="form-control" id="lienKet" name="DuongDanLienKet" placeholder="Nhập liên kết (nếu có)">
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
<div class="modal fade" id="editDeviceTypeModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeviceTypeModalLabel">Chỉnh sửa loại thiết bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDeviceTypeForm">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="ID">
                    <div class="form-group">
                        <label for="editTen">Tên loại thiết bị</label>
                        <input type="text" class="form-control" id="editTen" name="Ten" required>
                    </div>
                    <div class="form-group">
                        <label for="editHinhAnh">Hình ảnh</label>
                        <input type="text" class="form-control mb-2" id="editHinhAnhUrl" name="DuongDanHinhAnhUrl" placeholder="Dán link ảnh từ Internet (nếu có)">
                        <input type="file" class="form-control-file" id="editHinhAnhFile" name="DuongDanHinhAnhFile">
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label for="editLienKet">Liên kết</label>
                        <input type="text" class="form-control" id="editLienKet" name="DuongDanLienKet" placeholder="Nhập liên kết (nếu có)">
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

<!-- JavaScript cho xử lý form -->
<script>
$(document).ready(function() {
    // Xử lý thêm mới
    $('#addDeviceTypeForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var link = $('#hinhAnhUrl').val();
        if(link) {
            formData.set('DuongDanHinhAnh', link);
        } else if($('#hinhAnhFile')[0].files.length > 0) {
            formData.append('DuongDanHinhAnhFile', $('#hinhAnhFile')[0].files[0]);
        }
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/LoaithietbiController.php?action=create',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    alert('Thêm loại thiết bị thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi thêm loại thiết bị: ' + error);
            }
        });
    });

    // Xử lý chỉnh sửa
    $('.edit-device-type').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/LoaithietbiController.php?action=getOne&id=' + id,
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    var type = response.data;
                    $('#editId').val(type.ID);
                    $('#editTen').val(type.Ten);
                    $('#editHinhAnhUrl').val(type.DuongDanHinhAnh || '');
                    $('#editLienKet').val(type.DuongDanLienKet || '');
                    if (type.DuongDanHinhAnh) {
                        if ($('#editImagePreview').length === 0) {
                            $('#editHinhAnhUrl').after('<img id="editImagePreview" src="" style="max-width:150px;display:block;margin-top:10px;">');
                        }
                        $('#editImagePreview').attr('src', type.DuongDanHinhAnh);
                    } else {
                        $('#editImagePreview').remove();
                    }
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi lấy thông tin: ' + error);
            }
        });
    });

    // Xử lý cập nhật
    $('#editDeviceTypeForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var link = $('#editHinhAnhUrl').val();
        if(link) {
            formData.set('DuongDanHinhAnh', link);
        } else if($('#editHinhAnhFile')[0].files.length > 0) {
            formData.append('DuongDanHinhAnhFile', $('#editHinhAnhFile')[0].files[0]);
        }
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/LoaithietbiController.php?action=update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    alert('Cập nhật thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra khi cập nhật: ' + error);
            }
        });
    });

    // Xử lý xóa
    $('.delete-device-type').click(function() {
        if(confirm('Bạn có chắc chắn muốn xóa loại thiết bị này?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo BASE_URL; ?>/controllers/LoaithietbiController.php?action=delete&id=' + id,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        alert('Xóa thành công!');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra khi xóa: ' + error);
                }
            });
        }
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>
</body>
</html> 