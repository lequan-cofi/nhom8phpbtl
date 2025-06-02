<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - iStore</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .admin-navbar { background: #2761e7; }
        .admin-navbar .navbar-brand, .admin-navbar .nav-link, .admin-navbar .navbar-text { color: #fff !important; }
        .admin-navbar .nav-link.active { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg admin-navbar mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/iStore_PHP_Backend/views/admin/dashboard.php"><i class="fas fa-cogs"></i> Admin iStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/iStore_PHP_Backend/views/admin/dashboard.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="addmin_phantich.php">Phân tích</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_phanhoi.php">Phản hồi</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_donhang.php">Đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_cuahang.php">Cửa hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_thietbi.php">Thiết bị</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_LoaiThietBi.php">Loại Thiết bị</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_hinhanhthietbi.php">Hình ảnh Thiết bị</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_khuyenmai.php">Khuyến mãi</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_sales.php">Sản phẩm KM</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_saleslist.php">DS Ưu đãi</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_poster.php">Poster</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_nguoidung.php">Người dùng</a></li>
                <li class="nav-item"><a class="nav-link" href="../../public/index.php">Về trang người dùng</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="../../public/index.php?page=user&action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</nav>



    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid"> 