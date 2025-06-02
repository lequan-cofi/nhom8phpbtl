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
<style>

    #sales{
        margin-left: 58px;
    }
</style>
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
  

<div id="sales">
    <div class="text-heading">Kết quả tìm kiếm</div>
    <ul class="list-sales">
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $device): ?>
                <li>
                    <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $device['ID']; ?>">
                        <div class="wrapper-product">
                            <div class="label"><span>HOT</span></div>
                            <img src="<?php echo htmlspecialchars($device['HinhAnh'] ?? ''); ?>" alt="<?php echo htmlspecialchars($device['Ten'] ?? ''); ?>" width="227.34px" height="259.81px">
                            <div class="product-element-bottom">
                                <h3 class="product-title"><?php echo htmlspecialchars($device['Ten'] ?? ''); ?></h3>
                                <div class="product-cats"><?php echo htmlspecialchars($device['TenLoaiThietBi'] ?? ''); ?></div>
                                <div class="product-rating">
                                    <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                    <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                    <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                    <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                    <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                </div>
                                <p class="product-in-stock">
                                    <i class="fa-solid fa-check" style="color: #4599e8;"></i>
                                    Còn hàng
                                </p>
                                <div class="product-price">
                                    <span class="original-price"><?php echo isset($device['Gia']) ? number_format($device['Gia'], 0, ',', '.') : ''; ?></span>
                                </div>
                                <div class="add-product">
                                    <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $device['ID']; ?>" class="btn-flip" data-back="Thêm vào giỏ" data-front="Mua ngay"></a>
                                </div>
                                <div class="product-code">
                                    <div class="product-name">SKU:</div>
                                    <div class="code">&#160;<?php echo htmlspecialchars($device['ID'] ?? ''); ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Không tìm thấy sản phẩm phù hợp.</li>
        <?php endif; ?>
    </ul>
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