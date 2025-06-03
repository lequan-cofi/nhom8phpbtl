<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$action = $_GET['action'] ?? 'profile';

?>


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
        .dropdown-menu { background: #2761e7 !important; }
        .dropdown-item { color: #fff !important; }
        .dropdown-item:hover { background:rgb(101, 123, 168) !important; }
        .admin-info { color: #fff; margin-right: 15px; }
        .admin-info i { margin-right: 5px; }
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
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/iStore_PHP_Backend/views/admin/dashboard.php">Trang chủ</a></li>
                
                <!-- Quản lý thiết bị -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="deviceDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-mobile-alt"></i> Quản lý thiết bị
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_thietbi.php">Thiết bị</a></li>
                        <li><a class="dropdown-item" href="admin_LoaiThietBi.php">Loại thiết bị</a></li>
                        <li><a class="dropdown-item" href="admin_hinhanhthietbi.php">Hình ảnh thiết bị</a></li>
                    </ul>
                </li>

                <!-- Quản lý khuyến mãi -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="promotionDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-tags"></i> Quản lý khuyến mãi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_khuyenmai.php">Khuyến mãi</a></li>
                        <li><a class="dropdown-item" href="admin_sales.php">Sản phẩm khuyến mãi</a></li>
                    </ul>
                </li>

                <!-- Quản lý nội dung -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="contentDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-alt"></i> Quản lý nội dung
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_content.php">Nội dung</a></li>
                        <li><a class="dropdown-item" href="admin_blog.php">Blog</a></li>
                        <li><a class="dropdown-item" href="admin_poster.php">Poster</a></li>
                    </ul>
                </li>

                <!-- Quản lý đơn hàng -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_donhang.php">Đơn hàng</a></li>
                        <li><a class="dropdown-item" href="addmin_phantich.php">Phân tích</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="admin_phanhoi.php"><i class="fas fa-comments"></i> Phản hồi</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_nguoidung.php"><i class="fas fa-users"></i> Người dùng</a></li>
            </ul>

            <!-- Admin Info -->
            <div class="admin-info">
                <i class="fas fa-user-circle"></i>
                <?php 
                if (isset($_SESSION['user']) && !empty($_SESSION['user']['Ten'])) {
                    echo htmlspecialchars($_SESSION['user']['Ten']);
                } else {
                    echo 'Admin';
                }
                ?>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../../public/index.php"><i class="fas fa-store"></i> Về trang người dùng</a></li>
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