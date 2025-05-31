<?php
// views/layouts/main_layout.php
// BASE_URL đã được define trong public/index.php
require_once APP_PATH . '/controllers/ContentController.php';
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
        // Khởi tạo ContentController
        $contentController = new ContentController();
        
        // Nạp nội dung content từ partial
        $contentPath = APP_PATH . '/views/partials/content.php';
        if (file_exists($contentPath)) {
            require $contentPath;
        } else {
            echo "<p style='color:red;'>Lỗi: Không tìm thấy file content.php</p>";
        }
    ?>
</div>
<div class="list-product">
   <?php
   $sidebarPath = APP_PATH . '/views/partials/list-product.php';
   if (file_exists($sidebarPath)) {
       require $sidebarPath;
   } else {
       echo "<p style='color:red;'>Lỗi: Không tìm thấy file danhmuc.php</p>";
   }
   ?>
</div>
<div id="sales">
   <?php
   $sidebarPath = APP_PATH . '/views/partials/sales.php';
   if (file_exists($sidebarPath)) {
       require $sidebarPath;
   } else {
       echo "<p style='color:red;'>Lỗi: Không tìm thấy file sales.php</p>";
   }
   ?>
</div>
<div id="new-product">
<?php
$sidebarPath = APP_PATH . '/views/partials/new-product.php';
if (file_exists($sidebarPath)) {
    require $sidebarPath;
} else {
    echo "<p style='color:red;'>Lỗi: Không tìm thấy file new-product.php</p>";
}
?>
</div>
<div id="poster">
<?php
$sidebarPath = APP_PATH . '/views/partials/poster.php';
if (file_exists($sidebarPath)) {
    require $sidebarPath;
} else {
    echo "<p style='color:red;'>Lỗi: Không tìm thấy file poster.php</p>";
}
?>
</div>
<div id="sales">
<?php
$sidebarPath = APP_PATH . '/views/partials/saleslist.php';
if (file_exists($sidebarPath)) {
    require $sidebarPath;
} else {
    echo "<p style='color:red;'>Lỗi: Không tìm thấy file saleslist.php</p>";
}
?>
</div>
<div id="blog">
    <?php
    $sidebarPath = APP_PATH . '/views/partials/blog.php';
    if (file_exists($sidebarPath)) {
        require $sidebarPath;
    } else {
        echo "<p style='color:red;'>Lỗi: Không tìm thấy file blog.php</p>";
    }
    ?>
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

    <div class="cart-page">
        <i class="ti-close" id="closeWishlistBtnPlaceholder"></i>
        <p style="padding:20px;">Nội dung giỏ hàng/yêu thích sẽ ở đây.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/app.js"></script>
</body>
</html>