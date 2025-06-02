<?php require_once 'partials/header.php'; ?>
<?php
// views/admin/add_cuahang.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm cửa hàng mới - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h4 class="mb-0">Thêm cửa hàng mới</h4>
            </div>
            <div class="col text-right">
                <a href="index.php?page=cuahang&action=admin" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin cửa hàng</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?page=cuahang&action=add" method="POST">
                            <div class="form-group">
                                <label for="ten">Tên cửa hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ten" name="ten" required>
                            </div>
                            <div class="form-group">
                                <label for="diachi">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="diachi" name="diachi" required>
                            </div>
                            <div class="form-group">
                                <label for="google_map">Link Google Map</label>
                                <input type="url" class="form-control" id="google_map" name="google_map" placeholder="https://www.google.com/maps/...">
                                <small class="form-text text-muted">Nhập link Google Maps của cửa hàng (nếu có)</small>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?> 