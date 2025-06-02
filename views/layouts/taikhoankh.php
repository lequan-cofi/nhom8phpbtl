<?php
$action = $_GET['action'] ?? 'profile';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['pageTitle'] ?? 'iStore'); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; }
        .account-sidebar {
            background: #fff;
            border-radius: 12px;
            padding: 24px 16px;
            min-height: 400px;
        }
        .account-info {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }
        .account-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #eee;
            margin-right: 16px;
        }
        .account-name { font-weight: 600; font-size: 18px; }
        .account-phone { color: #888; font-size: 14px; }
        .account-link { font-size: 13px; color: #007bff; text-decoration: underline; cursor: pointer; }
        .member-box {
            background: #fff7e6;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .member-box .btn {
            background: #ff4d00;
            color: #fff;
            border-radius: 6px;
            font-weight: 500;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin-bottom: 12px;
        }
        .sidebar-menu li.active, .sidebar-menu li:hover {
            background: #ffece3;
            border-radius: 6px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            color: #333;
            text-decoration: none;
            padding: 8px 12px;
            font-size: 15px;
        }
        .sidebar-menu i {
            margin-right: 10px;
            font-size: 17px;
        }
        .main-content {
            background: #fff;
            border-radius: 12px;
            padding: 32px 24px;
            min-height: 400px;
        }
        .nav-tabs .nav-link.active {
            color: #ff4d00;
            border-color: #ff4d00 #ff4d00 #fff;
            font-weight: 600;
        }
        .empty-state {
            text-align: center;
            margin-top: 60px;
        }
        .empty-state img {
            width: 180px;
            margin-bottom: 24px;
        }
        .empty-state .btn {
            background: #ff4d00;
            color: #fff;
            border-radius: 6px;
            font-weight: 500;
        }
        a {
  text-decoration: none;
}
    </style>
</head>
<body>
    
<div id="sidebar">
        <?php
            // Nạp nội dung sidebar từ partial
            $sidebarPath = APP_PATH . '/views/partials/sidebar.php';
            if (file_exists($sidebarPath)) {
                require $sidebarPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file sidebar.php</p>";
            }
        ?>
    </div>
    <div class="overlay"></div>
    <div id="header">
        <?php
            // Nạp nội dung header từ partial
            $headerPath = APP_PATH . '/views/partials/header_content.php';
            if (file_exists($headerPath)) {
                require $headerPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file header_content.php</p>";
            }
        ?>
    </div>
    <div id="nav">
<?php
$navigationPath = APP_PATH . '/views/partials/navigation_bar.php';
if (file_exists($navigationPath)) {
    require $navigationPath;
} else {
    echo "<p style='color:red;'>Lỗi: Không tìm thấy file navigation_bar.php</p>";
}
?>
</div>
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="account-info">
                <div class="account-avatar">
                    <img src="https://iili.io/FHTMlUP.jpg" alt="Avatar" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                </div>
                <div>
                    <div class="account-name">Lê Xuân Thành Quân</div>
                    <div class="account-phone">0836357898</div>
                    <div><a class="account-link" href="?page=user&action=profile">Xem hồ sơ</a></div>
                </div>
            </div>
            <div class="member-box">
                <div>
                    <div><b>Tiếp tục mua sắm</b></div>
                </div>
                <a href="index.php" class="btn btn-sm">Quay lại trang chủ</a>
            </div>
            <ul class="sidebar-menu">
                <li class="<?= $action === 'orders' ? 'active' : '' ?>"><a href="?page=user&action=orders"><i class="fas fa-box"></i> Đơn hàng của tôi</a></li>
                <li class="<?= $action === 'profile' ? 'active' : '' ?>"><a href="?page=user&action=profile"><i class="fas fa-user"></i> Hồ sơ cá nhân</a></li>
                <li class="<?= $action === 'address' ? 'active' : '' ?>"><a href="?page=user&action=address"><i class="fas fa-map-marker-alt"></i> Địa chỉ nhận hàng</a></li>
                <li class="<?= $action === 'changePassword' ? 'active' : '' ?>"><a href="?page=user&action=changePassword"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                <li><a href="?page=user&action=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="main-content">
                <?php
                // Hiển thị view động theo action
                $userViewPath = __DIR__ . '/../user/';
                switch ($action) {
                    case 'orders':
                        if (file_exists($userViewPath . 'orders.php')) include $userViewPath . 'orders.php';
                        break;
                    case 'address':
                        if (file_exists($userViewPath . 'address.php')) include $userViewPath . 'address.php';
                        break;
                    case 'changePassword':
                        if (file_exists($userViewPath . 'change_password.php')) include $userViewPath . 'change_password.php';
                        break;
                    case 'logout':
                        // Đăng xuất sẽ được xử lý ở controller, có thể chuyển hướng luôn
                        echo '<div class="alert alert-info">Đang đăng xuất...</div>';
                        header('Location: /index.php?page=user&action=logout');
                        exit;
                        break;
                    case 'profile':
                    default:
                        if (file_exists($userViewPath . 'profile.php')) include $userViewPath . 'profile.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div id="main-footer" style="margin-left: 58px;">
    <?php
        $footerPath = APP_PATH . '/views/partials/footer_content.php';
        if (file_exists($footerPath)) {
            require $footerPath;
        } else {
            echo "<p style='color:red;'>Lỗi: Không tìm thấy file footer_content.php</p>";
        }
        ?>
    </div>
    <div id="cro-buttons">
        <?php
            // Nạp nội dung header từ partial
            $headerPath = APP_PATH . '/views/partials/cro-buttons.php';
            if (file_exists($headerPath)) {
                require $headerPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file cro-buttons.php</p>";
            }
        ?>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
