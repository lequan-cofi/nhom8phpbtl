<?php
// views/layouts/main_layout.php
// BASE_URL đã được define trong public/index.php

// Lấy danh sách loại thiết bị
require_once __DIR__ . '/../../controllers/LoaithietbiController.php';
$loaiModel = new LoaiThietBiModel();
$hinhanhthietbi = new HinhAnhThietBiModel();
$deviceTypes = $loaiModel->getAllWithProductCount()->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách thiết bị nếu có category_id
$devices = [];
$selectedType = null;
if (isset($_GET['category_id'])) {
    $selectedType = (int)$_GET['category_id'];
    $thietbiModel = new ThietBiModel();
    $devices = $thietbiModel->getByCategory($selectedType)->fetchAll(PDO::FETCH_ASSOC);
}

require_once __DIR__ . '/../../controllers/HinhanhthietbiController.php';
$hinhanhController = new HinhanhthietbiController();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Danh Mục Sản Phẩm</title>
    
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
  

    
      
            <div id="list-product">
                <div class="text-heading">Loại thiết bị</div>
                <div class="scroll-wrapper">
                    <ul class="product">
                        <?php foreach ($deviceTypes as $type): ?>
                        <li>
                            <a href="?page=categories&category_id=<?php echo $type['ID']; ?>" class="<?php echo ($selectedType == $type['ID']) ? 'active' : ''; ?>">
                                <div class="img-wrapper">
                                    <?php if (!empty($type['DuongDanHinhAnh'])): ?>
                                        <img src="<?php echo htmlspecialchars($type['DuongDanHinhAnh']); ?>" alt="<?php echo htmlspecialchars($type['Ten']); ?>" width="180.56px" height="180.56px">
                                    <?php endif; ?>
                                </div>
                                <div class="hover-mask">
                                    <h3><?php echo htmlspecialchars($type['Ten']); ?></h3>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        
        <div class="col-md-9">
            <div id="sales">
                <?php if ($selectedType && !empty($devices)): ?>
                    <ul class="list-sales">
                        <?php foreach ($devices as $device): ?>
                        <?php
                        $images = $hinhanhController->getByThietBi($device['ID']);
                        $firstImage = !empty($images) ? $images[0]['DuongDanHinhAnh'] : '';
                        ?>
                        <li>
                            <a href="<?php echo !empty($device['DuongDanLienKet']) ? htmlspecialchars($device['DuongDanLienKet']) : '#'; ?>">
                                <div class="wrapper-product">
                                    <div class="label">
                                        <span>HOT</span>
                                    </div>
                                    <img src="<?php echo htmlspecialchars($firstImage); ?>" alt="<?php echo htmlspecialchars($device['Ten'] ?? ''); ?>" width="227.34px" height="259.81px">
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
                                            <span class="discount-price"><?php echo isset($device['GiaKhuyenMai']) ? number_format($device['GiaKhuyenMai'], 0, ',', '.') : ''; ?></span>
                                        </div>
                                        <div class="add-product">
                                            <a href="<?php echo !empty($device['DuongDanLienKet']) ? htmlspecialchars($device['DuongDanLienKet']) : '#'; ?>" class="btn-flip" data-back="Thêm vào giỏ" data-front="Mua ngay"></a>
                                        </div>
                                        <div class="product-code">
                                            <div class="product-name">SKU:</div>
                                            <div class="code">&#160;<?php echo htmlspecialchars($device['ID'] ?? ''); ?></div>
                                        </div>
                                    </div>
                                    <div class="product-button">
                                        <div class="compare-button">
                                            <a href="#"><i class="fa-solid fa-code-compare" style="color: #333;"></i></a>
                                        </div>
                                        <div class="search-button">
                                            <a><i class="fa-solid fa-magnifying-glass" style="color: #333;"></i></a>
                                        </div>
                                        <div class="love-button">
                                            <a><i class="fa-regular fa-heart" style="color: #333;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif ($selectedType): ?>
                    <div class="alert alert-warning">Không có thiết bị nào thuộc loại này.</div>
                <?php else: ?>
                    <div class="alert alert-info">Hãy chọn một loại thiết bị để xem sản phẩm.</div>
                <?php endif; ?>
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

    <div class="cart-page">
        <i class="ti-close" id="closeWishlistBtnPlaceholder"></i>
        <p style="padding:20px;">Nội dung giỏ hàng/yêu thích sẽ ở đây.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/app.js"></script>
</body>
</html>