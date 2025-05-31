<?php
// views/layouts/lienhe_layout.php
// BASE_URL đã được define trong public/index.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($data['pageTitle'] ?? 'iStore'); ?></title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
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
            // Nạp nội dung navigation từ partial
            $navigationPath = APP_PATH . '/views/partials/navigation_bar.php';
            if (file_exists($navigationPath)) {
                require $navigationPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file navigation_bar.php</p>";
            }
        ?>
    </div>

    <div id="content" style="margin-left: 58px; padding: 20px;">
        <?php
            // Nạp nội dung trang liên hệ
            $contentPath = APP_PATH . '/views/lienhe.php';
            if (file_exists($contentPath)) {
                require $contentPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file lienhe.php</p>";
            }
        ?>
    </div>

    <div id="footer">
        <?php
            // Nạp nội dung footer từ partial
            $footerPath = APP_PATH . '/views/partials/footer_content.php';
            if (file_exists($footerPath)) {
                require $footerPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file footer_content.php</p>";
            }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>