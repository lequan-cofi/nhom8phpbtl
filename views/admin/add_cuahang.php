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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col">
                <h2>Thêm cửa hàng mới</h2>
            </div>
            <div class="col text-end">
                <a href="index.php?page=cuahang&action=admin" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="index.php?page=cuahang&action=add" method="POST">
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên cửa hàng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ten" name="ten" required>
                    </div>

                    <div class="mb-3">
                        <label for="diachi" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="diachi" name="diachi" required>
                    </div>

                    <div class="mb-3">
                        <label for="google_map" class="form-label">Link Google Map</label>
                        <input type="url" class="form-control" id="google_map" name="google_map" 
                               placeholder="https://www.google.com/maps/...">
                        <div class="form-text">Nhập link Google Maps của cửa hàng (nếu có)</div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?> 