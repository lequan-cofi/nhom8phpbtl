<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../controllers/PosterController.php';
$posterController = new PosterController();
$posters = $posterController->getAll();
$promotions = $posterController->getPromotions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Poster</title>
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
                    <h5 class="mb-0">Quản lý Poster</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addPosterModal">
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
                                    <th>Khuyến mãi</th>
                                    <th>Số sản phẩm hiển thị</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posters as $poster): ?>
                                <tr>
                                    <td><?php echo $poster['ID']; ?></td>
                                    <td><?php echo htmlspecialchars($poster['Title']); ?></td>
                                    <td><?php echo htmlspecialchars($poster['Description']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($poster['Image']); ?>" alt="" style="max-width: 100px;">
                                    </td>
                                    <td><?php echo htmlspecialchars($poster['TenKhuyenMai']); ?></td>
                                    <td><?php echo $poster['MaxDisplayProducts']; ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $poster['IsActive'] ? 'success' : 'danger'; ?>">
                                            <?php echo $poster['IsActive'] ? 'Đang hiển thị' : 'Đã ẩn'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-poster" 
                                                data-id="<?php echo $poster['ID']; ?>"
                                                data-title="<?php echo htmlspecialchars($poster['Title']); ?>"
                                                data-description="<?php echo htmlspecialchars($poster['Description']); ?>"
                                                data-image="<?php echo htmlspecialchars($poster['Image']); ?>"
                                                data-idkhuyenmai="<?php echo $poster['IDKhuyenMai']; ?>"
                                                data-max-display="<?php echo $poster['MaxDisplayProducts']; ?>"
                                                data-is-active="<?php echo $poster['IsActive']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-poster" 
                                                data-id="<?php echo $poster['ID']; ?>">
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

<!-- Add Poster Modal -->
<div class="modal fade" id="addPosterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Poster mới</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPosterForm">
                    <div class="form-group">
                        <label>Khuyến mãi</label>
                        <select class="form-control" name="IDKhuyenMai" id="addPromotionSelect" required>
                            <option value="">Chọn khuyến mãi</option>
                            <?php foreach ($promotions as $promotion): ?>
                            <option value="<?php echo $promotion['ID']; ?>" data-title="<?php echo htmlspecialchars($promotion['TenKhuyenMai']); ?>">
                                <?php echo htmlspecialchars($promotion['TenKhuyenMai']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" name="Title" id="addTitle" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Image" id="addImage" placeholder="Nhập URL hình ảnh hoặc upload file" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addImageUpload">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Có thể nhập URL hình ảnh hoặc upload file từ máy tính</small>
                    </div>
                    <div class="form-group">
                        <label>Số sản phẩm hiển thị</label>
                        <input type="number" class="form-control" name="MaxDisplayProducts" min="1" max="10" value="5" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isActive" name="IsActive" value="1" checked>
                            <label class="custom-control-label" for="isActive">Đang hiển thị</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="savePoster">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Poster Modal -->
<div class="modal fade" id="editPosterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Poster</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPosterForm">
                    <input type="hidden" name="ID">
                    <div class="form-group">
                        <label>Khuyến mãi</label>
                        <select class="form-control" name="IDKhuyenMai" id="editPromotionSelect" required>
                            <option value="">Chọn khuyến mãi</option>
                            <?php foreach ($promotions as $promotion): ?>
                            <option value="<?php echo $promotion['ID']; ?>" data-title="<?php echo htmlspecialchars($promotion['TenKhuyenMai']); ?>">
                                <?php echo htmlspecialchars($promotion['TenKhuyenMai']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" name="Title" id="editTitle" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" name="Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Image" id="editImage" placeholder="Nhập URL hình ảnh hoặc upload file" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="editImageUpload">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Có thể nhập URL hình ảnh hoặc upload file từ máy tính</small>
                    </div>
                    <div class="form-group">
                        <label>Số sản phẩm hiển thị</label>
                        <input type="number" class="form-control" name="MaxDisplayProducts" min="1" max="10" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="editIsActive" name="IsActive" value="1">
                            <label class="custom-control-label" for="editIsActive">Đang hiển thị</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="updatePoster">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Function to handle image upload
    function handleImageUpload(inputId, targetInputId) {
        var fileInput = $('<input type="file" accept="image/*" style="display: none;">');
        fileInput.click();
        
        fileInput.on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('image', file);
                
                $.ajax({
                    url: '../../controllers/upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#' + targetInputId).val('/uploads/poster/' + response.filename);
                        } else {
                            alert('Lỗi upload: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload error:', error);
                        alert('Lỗi upload hình ảnh');
                    }
                });
            }
        });
    }

    // Image upload buttons
    $('#addImageUpload').click(function() {
        handleImageUpload('addImageUpload', 'addImage');
    });

    $('#editImageUpload').click(function() {
        handleImageUpload('editImageUpload', 'editImage');
    });

    // Auto-fill title when promotion is selected
    $('#addPromotionSelect').change(function() {
        var selectedOption = $(this).find('option:selected');
        $('#addTitle').val(selectedOption.data('title'));
    });

    $('#editPromotionSelect').change(function() {
        var selectedOption = $(this).find('option:selected');
        $('#editTitle').val(selectedOption.data('title'));
    });

    // Validate image URL
    function validateImageUrl(url) {
        return url.startsWith('http://') || url.startsWith('https://') || url.startsWith('/');
    }

    // Add new poster
    $('#savePoster').click(function() {
        var imageUrl = $('#addImage').val();
        if (!validateImageUrl(imageUrl)) {
            alert('Vui lòng nhập URL hình ảnh hợp lệ hoặc upload file');
            return;
        }

        var formData = $('#addPosterForm').serialize();
        console.log('Sending form data:', formData);
        
        $.ajax({
            url: '../../controllers/PosterController.php?action=create',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    location.reload();
                } else {
                    alert('Lỗi: ' + (response.message || 'Không xác định được lỗi'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', {xhr: xhr, status: status, error: error});
                alert('Lỗi kết nối: ' + error);
            }
        });
    });

    // Edit poster
    $('.edit-poster').click(function() {
        var data = $(this).data();
        var form = $('#editPosterForm');
        form.find('[name=ID]').val(data.id);
        form.find('[name=IDKhuyenMai]').val(data.idkhuyenmai).trigger('change');
        form.find('[name=Description]').val(data.description);
        form.find('[name=Image]').val(data.image);
        form.find('[name=MaxDisplayProducts]').val(data.maxDisplay);
        form.find('[name=IsActive]').prop('checked', data.isActive == 1);
        $('#editPosterModal').modal('show');
    });

    // Update poster
    $('#updatePoster').click(function() {
        var imageUrl = $('#editImage').val();
        if (!validateImageUrl(imageUrl)) {
            alert('Vui lòng nhập URL hình ảnh hợp lệ hoặc upload file');
            return;
        }

        var formData = $('#editPosterForm').serialize();
        console.log('Sending update data:', formData);
        
        $.ajax({
            url: '../../controllers/PosterController.php?action=update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    location.reload();
                } else {
                    alert('Lỗi: ' + (response.message || 'Không xác định được lỗi'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', {xhr: xhr, status: status, error: error});
                alert('Lỗi kết nối: ' + error);
            }
        });
    });

    // Delete poster
    $('.delete-poster').click(function() {
        if (confirm('Bạn có chắc muốn xóa poster này?')) {
            var id = $(this).data('id');
            console.log('Deleting poster ID:', id);
            
            $.ajax({
                url: '../../controllers/PosterController.php?action=delete',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    console.log('Server response:', response);
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Lỗi: ' + (response.message || 'Không xác định được lỗi'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', {xhr: xhr, status: status, error: error});
                    alert('Lỗi kết nối: ' + error);
                }
            });
        }
    });
});
</script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?> 