<?php
// views/layouts/main_layout.php
// BASE_URL đã được define trong public/index.php
//require_once APP_PATH . '/controllers/ContentController.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gioi thieu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
</head>
<style>
    .about-container { max-width: 1200px; margin: 0 auto; padding: 40px 0; font-family: Arial, sans-serif; }
    .about-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 60px; }
    .about-header-text { max-width: 40%; }
    .about-header-title { font-size: 2rem; font-weight: bold; color: #2d3559; margin-bottom: 10px; }
    .about-header-desc { color: #555; font-size: 1rem; }
    .about-header-img img { max-width: 350px; border-radius: 20px; }
    .about-section-title { text-align: center; font-size: 1.3rem; font-weight: bold; margin: 40px 0 30px; color: #2d3559; }
    .featured-products { display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; }
    .product-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #eee; width: 320px; padding: 20px; }
    .product-card img { width: 100%; border-radius: 10px; margin-bottom: 10px; }
    .product-title { font-weight: bold; color: #2d3559; margin-bottom: 5px; }
    .product-desc { color: #555; font-size: 0.97rem; }
    .commitments { display: flex; justify-content: center; gap: 60px; margin: 50px 0 0; flex-wrap: wrap; }
    .commitment-item { text-align: center; }
    .commitment-item img { height: 90px; margin-bottom: 10px; }
    .commitment-title { font-weight: bold; color: #f7b500; font-size: 1.1rem; }
    @media (max-width: 900px) {
        .about-header { flex-direction: column; align-items: flex-start; }
        .about-header-img { margin-top: 20px; }
        .featured-products { flex-direction: column; align-items: center; }
        .commitments { flex-direction: column; gap: 30px; }
    }
</style>
<body>
    

<!-- views/layouts/gioithieu_layout.php -->

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
  
<div class="about-container">
    <!-- Phần giới thiệu -->
    <div class="about-header">
        <div class="about-header-text">
            <div class="about-header-title">Chào mừng đến với iStore,</div>
            <div class="about-header-desc">
                Tại iStore, chúng tôi chuyên cung cấp các thiết bị Apple chính hãng với chất lượng hàng đầu. Từ iPhone, iPad, MacBook đến các phụ kiện Apple chính hãng, iStore cam kết mang đến cho bạn trải nghiệm mua sắm đáng tin cậy, thuận tiện và an tâm tuyệt đối. Hãy khám phá thế giới công nghệ đẳng cấp cùng dịch vụ hỗ trợ khách hàng tận tâm tại iStore!
            </div>
        </div>
        <div class="about-header-img">
            <img src="https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-40-refurb-202408?wid=800&hei=1000&fmt=p-jpg&qlt=95&.v=MTZ5STlsTFBndFBGTjdlaHEreGY1YTFsUjh2RWUzeU9adTZtZmNMZDNMVnd5b1hKY2V3T2V4alVLZTRFVTdOK0tRNjVHZTlIV04vVjZjbEh0Rm5SYzM3NnQydDdpK3FzN25MQVFxVVVwNmc" alt="iStore Banner">
        </div>
    </div>

    <!-- Sản phẩm nổi bật -->
    <div class="about-section-title">Sản phẩm nổi bật</div>
    <div class="featured-products">
        <div class="product-card">
            <img src="https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-ipad-nav-202405?wid=400&hei=260&fmt=png-alpha&.v=dW5XbHI1eDVpd01qWUU4bFRtWGZXNGFLQTJVNnlNQmQrVmRBYnZYei9jckUzelNmMnRxajE0NHhmMWtLazl6eG53M0FRZHBXNTh1U1lFVEtSR2YzTm5qbE56RWRpRFNIRXZvbkd2S0l5dTg" alt="Oppo">
            <div class="product-title">iPad</div>
            <div class="product-desc">
               iPad – máy tính bảng đa năng, lý tưởng cho cả công việc lẫn giải trí với màn hình sắc nét và khả năng xử lý linh hoạt.
            </div>
        </div>
        <div class="product-card">
            <img src="https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-iphone-nav-202502_GEO_US?wid=400&hei=260&fmt=png-alpha&.v=dW5XbHI1eDVpd01qWUU4bFRtWGZXMGIwbkQ3THNNRjRsZmFuY3ZnUksrQTA2bGFaODVwaytiT1psSXc2dlhUWUwyZnhVM3hmakh4cEVIbk1pcnBIRXFpaVlBSTdOOXplUDUwZUNmQnR2OUxuakp5ZFBaaHhUOUJXVGFwbk9vT2k" alt="Apple">
            <div class="product-title">iPhone</div>
            <div class="product-desc">
               iPhone – chiếc điện thoại thông minh biểu tượng với thiết kế tinh tế, hiệu năng mạnh mẽ và khả năng chụp ảnh vượt trội.
            </div>
        </div>
        <div class="product-card">
                <img src="https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/store-card-13-mac-nav-202503?wid=400&hei=260&fmt=png-alpha&.v=M1Q3OGxnb1lBaHhqNjZ2OVRXZmx4VEpBUDFBeEhMZS9GUnNSYXdEd0hscisrUlZaSVRoWVYzU0Qra0FoTmUwNng2bitObzZwQzk4cEorV1dZdzhIazVVcFlOTkdoMWg4ZkdDS1ovMUlzcW8" alt="Samsung">
            <div class="product-title">Macbook</div>
            <div class="product-desc">
               MacBook – dòng laptop cao cấp với hiệu suất ổn định, thiết kế sang trọng và hệ điều hành macOS mượt mà, tối ưu cho người dùng sáng tạo và chuyên nghiệp.
            </div>
        </div>
    </div>

    <!-- Cam kết -->
    <div class="about-section-title" style="margin-top:60px;">Cam kết</div>
    <div class="commitments">
        <div class="commitment-item">
            <img src="https://image.pngaaa.com/478/5481478-middle.png" alt="Hoàn tiền">
            <div class="commitment-title">Hoàn tiền 100% nếu bạn không hài lòng</div>
        </div>
      
        <div class="commitment-item">
            <img src="https://static.vecteezy.com/system/resources/previews/021/595/691/non_2x/fast-delivery-truck-icon-lorry-with-quick-delivery-service-fast-product-delivery-design-illustration-free-png.png" alt="Giao nhanh">
            <div class="commitment-title">Giao hàng nhanh</div>
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
</body>
</html>