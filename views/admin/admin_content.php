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
require_once __DIR__ . '/../../controllers/ContentController.php';

// Initialize controller
$contentController = new ContentController();
$contents = $contentController->getContentData();

// Now include the header
require_once 'partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nội dung</title>
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
                    <h5 class="mb-0">Quản lý Nội dung</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addContentModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Hình ảnh</th>
                                    <th>Liên kết</th>
                                    <th>Thứ tự</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contents as $content): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($content->ID); ?></td>
                                    <td><?php echo htmlspecialchars($content->TieuDe); ?></td>
                                    <td><?php echo htmlspecialchars($content->MoTa); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($content->DuongDanHinhAnh); ?>" 
                                             alt="<?php echo htmlspecialchars($content->TieuDe); ?>" 
                                             class="img-thumbnail" 
                                             style="max-width: 100px;">
                                    </td>
                                    <td><?php echo htmlspecialchars($content->DuongDanLienKet); ?></td>
                                    <td><?php echo htmlspecialchars($content->SortOrder); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $content->IsActive ? 'success' : 'danger'; ?>">
                                            <?php echo $content->IsActive ? 'Hoạt động' : 'Không hoạt động'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-content" 
                                                data-id="<?php echo $content->ID; ?>"
                                                data-toggle="modal" 
                                                data-target="#editContentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-content"
                                                data-id="<?php echo $content->ID; ?>">
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
<div class="modal fade" id="addContentModal" tabindex="-1" role="dialog" aria-labelledby="addContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContentModalLabel">Thêm nội dung mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addContentForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tieuDe">Tiêu đề</label>
                        <input type="text" class="form-control" id="tieuDe" name="TieuDe" required>
                    </div>
                    <div class="form-group">
                        <label for="moTa">Mô tả</label>
                        <textarea class="form-control" id="moTa" name="MoTa" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="noiDung">Nội dung</label>
                        <textarea class="form-control" id="noiDung" name="NoiDung" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hinhAnh">Hình ảnh</label>
                        <input type="text" class="form-control mb-2" id="hinhAnhUrl" name="DuongDanHinhAnhUrl" placeholder="Dán link ảnh từ Internet (nếu có)">
                        <input type="file" class="form-control-file" id="hinhAnhFile" name="DuongDanHinhAnhFile">
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label for="lienKet">Liên kết</label>
                        <input type="text" class="form-control" id="lienKet" name="DuongDanLienKet" required>
                    </div>
                    <div class="form-group">
                        <label for="thuTu">Thứ tự</label>
                        <input type="number" class="form-control" id="thuTu" name="SortOrder" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="trangThai" name="IsActive" checked>
                            <label class="custom-control-label" for="trangThai">Hoạt động</label>
                        </div>
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
<div class="modal fade" id="editContentModal" tabindex="-1" role="dialog" aria-labelledby="editContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContentModalLabel">Chỉnh sửa nội dung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editContentForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="ID">
                    <div class="form-group">
                        <label for="editTieuDe">Tiêu đề</label>
                        <input type="text" class="form-control" id="editTieuDe" name="TieuDe" required>
                    </div>
                    <div class="form-group">
                        <label for="editMoTa">Mô tả</label>
                        <textarea class="form-control" id="editMoTa" name="MoTa" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editNoiDung">Nội dung</label>
                        <textarea class="form-control" id="editNoiDung" name="NoiDung" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editHinhAnh">Hình ảnh</label>
                        <input type="text" class="form-control mb-2" id="editHinhAnhUrl" name="DuongDanHinhAnhUrl" placeholder="Dán link ảnh từ Internet (nếu có)">
                        <input type="file" class="form-control-file" id="editHinhAnhFile" name="DuongDanHinhAnhFile">
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label for="editLienKet">Liên kết</label>
                        <input type="text" class="form-control" id="editLienKet" name="DuongDanLienKet" required>
                    </div>
                    <div class="form-group">
                        <label for="editThuTu">Thứ tự</label>
                        <input type="number" class="form-control" id="editThuTu" name="SortOrder" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="editTrangThai" name="IsActive">
                            <label class="custom-control-label" for="editTrangThai">Hoạt động</label>
                        </div>
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
    $('#addContentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/ContentController.php?action=create',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Response:', response);
                if(response.success) {
                    alert('Thêm nội dung thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                alert('Có lỗi xảy ra khi thêm nội dung: ' + error);
            }
        });
    });

    // Xử lý chỉnh sửa
    $('.edit-content').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/ContentController.php?action=getOne&id=' + id,
            type: 'GET',
            success: function(response) {
                console.log('Edit Response:', response);
                if(response.success) {
                    var content = response.data;
                    $('#editId').val(content.ID);
                    $('#editTieuDe').val(content.TieuDe);
                    $('#editMoTa').val(content.MoTa);
                    $('#editNoiDung').val(content.NoiDung);
                    $('#editLienKet').val(content.DuongDanLienKet);
                    $('#editThuTu').val(content.SortOrder);
                    $('#editTrangThai').prop('checked', content.IsActive == 1);
                    $('#editHinhAnhUrl').val(content.DuongDanHinhAnh || '');
                    if (content.DuongDanHinhAnh) {
                        if ($('#editImagePreview').length === 0) {
                            $('#editHinhAnhUrl').after('<img id="editImagePreview" src="" style="max-width:150px;display:block;margin-top:10px;">');
                        }
                        $('#editImagePreview').attr('src', content.DuongDanHinhAnh);
                    } else {
                        $('#editImagePreview').remove();
                    }
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                alert('Có lỗi xảy ra khi lấy thông tin: ' + error);
            }
        });
    });

    // Xử lý cập nhật
    $('#editContentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo BASE_URL; ?>/controllers/ContentController.php?action=update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Update Response:', response);
                if(response.success) {
                    alert('Cập nhật thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                alert('Có lỗi xảy ra khi cập nhật: ' + error);
            }
        });
    });

    // Xử lý xóa
    $('.delete-content').click(function() {
        if(confirm('Bạn có chắc chắn muốn xóa nội dung này?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo BASE_URL; ?>/controllers/ContentController.php?action=delete&id=' + id,
                type: 'POST',
                success: function(response) {
                    console.log('Delete Response:', response);
                    if(response.success) {
                        alert('Xóa thành công!');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + (response.message || 'Không xác định'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log('Status:', status);
                    console.log('Response:', xhr.responseText);
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