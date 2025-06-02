<?php
// Không cần require controller ở đây!
// Chỉ sử dụng biến $thietBiData, $thongSoNhom đã được truyền từ controller

if (!isset($thietBiData) || !$thietBiData) {
    echo "<h2>Không tìm thấy sản phẩm!</h2>";
    exit;
}
if (!isset($thongSoNhom)) {
    $thongSoNhom = [];
}

// Kiểm tra khuyến mãi
$khuyenMaiModel = new KhuyenMaiModel();
$salesModel = new SalesModel();

// Lấy thông tin khuyến mãi của sản phẩm
$promotionInfo = $salesModel->getSaleById($thietBiData['ID']);
$discountedPrice = $thietBiData['Gia'];
$hasPromotion = false;

// Debug information
error_log("Product ID: " . $thietBiData['ID']);
error_log("Promotion Info: " . print_r($promotionInfo, true));

if ($promotionInfo && isset($promotionInfo['MucGiamGia']) && $promotionInfo['MucGiamGia'] > 0) {
    $hasPromotion = true;
    $discountedPrice = $promotionInfo['GiaKhuyenMai'];
    error_log("Has promotion: true");
    error_log("Discounted price: " . $discountedPrice);
} else {
    error_log("No promotion found or invalid discount");
}

$hinhAnh = $hinhAnhList ?? [];
if (empty($hinhAnh)) {
    $hinhAnh = [['DuongDanHinhAnh' => 'default.jpg']];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($thietBiData['Ten']); ?> - Apple</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($data['pageTitle'] ?? 'iStore'); ?></title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f7;
            color: #1d1d1f;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .product-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .size-selector {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .size-btn {
            padding: 12px 24px;
            border: 2px solid #d2d2d7;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .size-btn.active {
            border-color: #0071e3;
            background: #0071e3;
            color: white;
        }

        .size-btn:hover:not(.active) {
            border-color: #86868b;
        }

        .product-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1d1d1f;
        }

        .price-info {
            font-size: 18px;
            color: #86868b;
            margin-bottom: 30px;
        }

        .buy-btn {
            background: #0071e3;
            color: white;
            padding: 14px 32px;
            border: none;
            border-radius: 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 113, 227, 0.3);
        }

        .buy-btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 113, 227, 0.4);
        }

        .product-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            margin-bottom: 80px;
        }

        .product-image {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .image-carousel {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .carousel-container {
            display: flex;
            width: 400%;
            height: 100%;
            transition: transform 0.5s ease;
        }

        .carousel-slide {
            width: 25%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 100%);
        }

        .carousel-slide:nth-child(1) {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        .carousel-slide:nth-child(2) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .carousel-slide:nth-child(3) {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .carousel-slide:nth-child(4) {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        .slide-content {
            text-align: center;
            color: white;
            padding: 40px;
        }

        .slide-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: block;
        }

        .slide-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .slide-subtitle {
            font-size: 16px;
            opacity: 0.8;
        }

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            color: #1d1d1f;
            transition: all 0.3s ease;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .nav-button.prev {
            left: 20px;
        }

        .nav-button.next {
            right: 20px;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;   
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #d2d2d7;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: #0071e3;
            transform: scale(1.2);
        }

        .indicator:hover:not(.active) {
            background: #86868b;
        }

        .color-selector {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .color-option {
            padding: 10px 20px;
            border: 2px solid #d2d2d7;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
            color: #1d1d1f;
        }

        .color-option:hover:not(.active) {
            border-color: #86868b;
            background: #f5f5f7;
        }

        .color-option.active {
            border-color: #0071e3;
            background: #0071e3;
            color: white;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .feature {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .feature-icon.m4 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .feature-icon.battery {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .feature-icon.intelligence {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #ff6b6b;
        }

        .feature-icon.display {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #667eea;
        }

        .feature-icon.camera {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #ff8a80;
        }

        .feature-icon.connectivity {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .feature-content h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1d1d1f;
        }

        .feature-content p {
            color: #86868b;
            line-height: 1.6;
        }

        .superscript {
            font-size: 0.8em;
            vertical-align: super;
            color: #86868b;
        }

        .explore-link {
            text-align: center;
            margin-top: 40px;
        }

        .explore-link a {
            color: #0071e3;
            text-decoration: none;
            font-weight: 500;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .explore-link a:hover {
            color: #0056b3;
        }

        .explore-link a::after {
            content: ' →';
            transition: transform 0.3s ease;
        }

        .explore-link a:hover::after {
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .product-section {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-title {
                font-size: 36px;
            }

            .container {
                padding: 20px;
            }

            .feature {
                padding: 20px;
            }

            .features-list {
                gap: 20px;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature {
            animation: fadeInUp 0.6s ease forwards;
        }

        .feature:nth-child(1) { animation-delay: 0.1s; }
        .feature:nth-child(2) { animation-delay: 0.2s; }
        .feature:nth-child(3) { animation-delay: 0.3s; }
        .feature:nth-child(4) { animation-delay: 0.4s; }
        .feature:nth-child(5) { animation-delay: 0.5s; }
        .feature:nth-child(6) { animation-delay: 0.6s; }
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
    <div class="container">
        <div class="product-header">
            <h1 class="product-title"><?php echo htmlspecialchars($thietBiData['Ten']); ?></h1>
            <div class="price-info">
                <?php if ($hasPromotion && $discountedPrice < $thietBiData['Gia']): ?>
                    <span class="original-price" style="text-decoration: line-through; color: #86868b; margin-right: 10px;">
                        <?php echo number_format($thietBiData['Gia'], 0, ',', '.'); ?> VNĐ
                    </span>
                    <span class="discounted-price" style="color: #d71a19; font-weight: bold;">
                        <?php echo number_format($discountedPrice, 0, ',', '.'); ?> VNĐ
                    </span>
                    <div class="promotion-badge" style="display: inline-block; background: #d71a19; color: white; padding: 4px 8px; border-radius: 4px; margin-left: 10px; font-size: 14px;">
                        <?php echo htmlspecialchars($promotionInfo['TenKhuyenMai']); ?> - Giảm <?php echo $promotionInfo['MucGiamGia']; ?>%
                    </div>
                <?php else: ?>
                    <span class="price" style="color: #0056b3; font-weight: bold;">
                        <?php echo number_format($thietBiData['Gia'], 0, ',', '.'); ?> VNĐ
                    </span>
                <?php endif; ?>
            </div>
            <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=cart&action=add">
                <input type="hidden" name="product_id" value="<?php echo $thietBiData['ID']; ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="buy-btn">Mua</button>
            </form>
        </div>

        <div class="product-section">
            <div class="product-image">
                <div class="image-carousel">
                    <div class="carousel-container" id="carouselContainer">
                        <?php foreach ($hinhAnh as $img): ?>
                            <div class="carousel-slide">
                                <img src="<?php echo htmlspecialchars($img['DuongDanHinhAnh']); ?>" alt="<?php echo htmlspecialchars($thietBiData['Ten']); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button class="nav-button prev" onclick="changeSlide(-1)">‹</button>
                    <button class="nav-button next" onclick="changeSlide(1)">›</button>
                </div>
                
                <div class="carousel-indicators">
                    <?php for ($i = 0; $i < count($hinhAnh); $i++): ?>
                        <div class="indicator <?php echo $i === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $i + 1; ?>)"></div>
                    <?php endfor; ?>
                </div>
                
               
            </div>

            <div class="features-list">
                <?php
                // Hiển thị thông số kỹ thuật theo nhóm
                foreach ($thongSoNhom as $nhom => $thongSoList):
                    $iconClass = strtolower(str_replace(' ', '-', $nhom));
                ?>
                    <div class="feature">
                        <div class="feature-icon <?php echo $iconClass; ?>">
                            <?php echo $this->getIconForNhom($nhom); ?>
                        </div>
                        <div class="feature-content">
                            <h3><?php echo htmlspecialchars($nhom); ?></h3>
                            <ul>
                            <?php foreach ($thongSoList as $ts): ?>
                                <li><?php echo htmlspecialchars($ts['Ten']); ?>: <b><?php echo htmlspecialchars($ts['GiaTri']); ?></b></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
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
    <script>
        // Carousel functionality
        let currentSlideIndex = 0;
        const totalSlides = <?php echo count($hinhAnh); ?>;

        function changeSlide(direction) {
            currentSlideIndex += direction;
            
            if (currentSlideIndex >= totalSlides) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = totalSlides - 1;
            }
            
            updateCarousel();
        }

        function currentSlide(n) {
            currentSlideIndex = n - 1;
            updateCarousel();
        }

        function updateCarousel() {
            const carousel = document.getElementById('carouselContainer');
            const indicators = document.querySelectorAll('.indicator');
            
            carousel.style.transform = `translateX(-${currentSlideIndex * 25}%)`;
            
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlideIndex);
            });
        }

        // Auto-play carousel
        setInterval(() => {
            changeSlide(1);
        }, 4000);

        // Size selector functionality
        const sizeButtons = document.querySelectorAll('.size-btn');
        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                sizeButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const title = document.querySelector('.product-title');
                if (btn.textContent === '16"') {
                    title.textContent = 'MacBook Pro 16-inch';
                } else {
                    title.textContent = 'MacBook Pro 14-inch';
                }
            });
        });

        // Color selector functionality
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', () => {
                colorOptions.forEach(o => o.classList.remove('active'));
                option.classList.add('active');
            });
        });

        // Add hover effects to features
        const features = document.querySelectorAll('.feature');
        features.forEach(feature => {
            feature.addEventListener('mouseenter', () => {
                feature.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            feature.addEventListener('mouseleave', () => {
                feature.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Buy button animation
        const buyBtn = document.querySelector('.buy-btn');
        buyBtn.addEventListener('click', () => {
            buyBtn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                buyBtn.style.transform = 'scale(1)';
            }, 150);
        });

        function updateQuantity(itemId, change) {
            const qtySpan = document.getElementById('qty-' + itemId);
            let qty = parseInt(qtySpan.textContent) + change;
            if (qty < 1) qty = 1;
            qtySpan.textContent = qty;

            // Lấy giá gốc từ data-price
            const itemPriceDiv = qtySpan.closest('.item-content').querySelector('.item-price');
            const price = parseFloat(itemPriceDiv.getAttribute('data-price'));
            // Cập nhật tổng từng sản phẩm
            const itemTotal = price * qty;
            const itemTotalDiv = document.getElementById('item-total-' + itemId);
            itemTotalDiv.textContent = 'Tổng: ' + itemTotal.toLocaleString('vi-VN') + '₫';

            // Cập nhật tổng giỏ hàng
            updateCartTotals();

            // Gọi AJAX cập nhật số lượng trên server
            fetch('<?php echo BASE_URL; ?>/index.php?page=cart&action=updateQuantity', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'item_id=' + encodeURIComponent(itemId) + '&quantity=' + encodeURIComponent(qty)
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Cập nhật số lượng thất bại!');
                }
            })
            .catch(() => alert('Lỗi kết nối server!'));
        }
    </script>
</body>
</html>