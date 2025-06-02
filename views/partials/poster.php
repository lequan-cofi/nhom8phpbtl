<!--START POSTER-->
<?php
require_once __DIR__ . '/../../controllers/PosterController.php';
require_once __DIR__ . '/../../controllers/SalesController.php';

$posterController = new PosterController();
$salesController = new SalesController();

// Lấy poster đang active
$poster = $posterController->getActivePoster();

if ($poster) {
    // Lấy sản phẩm khuyến mãi thuộc chương trình khuyến mãi của poster
    $promotionalProducts = $salesController->getPromotionalProductsByPromotion($poster['IDKhuyenMai']);
    $maxDisplay = $poster['MaxDisplayProducts'] ?? 5;
    $promotionalProducts = array_slice($promotionalProducts, 0, $maxDisplay);
?>
<div id="poster">
    <div class="main-content">
        <div class="main-img">
            <img src="<?php echo htmlspecialchars($poster['Image'] ?? ''); ?>" alt="">
        </div>
        <div class="block"></div>
        <div class="text-content">
            <div class="text-heading">
                <?php echo htmlspecialchars($poster['Title'] ?? ''); ?>
            </div>
            <div class="text-description">
                <?php echo htmlspecialchars($poster['Description'] ?? ''); ?>
            </div>
            <div class="add-product">
                <?php if (!empty($poster['IDKhuyenMai'])): ?>
                <a href="/khuyenmai/<?php echo htmlspecialchars($poster['IDKhuyenMai']); ?>" style="text-decoration: none; color: inherit;">
                    <span>Mua ngay<i class="fa-solid fa-angle-right" style="color: #ffffff;"></i></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="list-item">
        <?php foreach ($promotionalProducts as $product): ?>
        <div class="item">
            <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $product['IDThietBi']; ?>">
                <?php
                $imgSrc = !empty($product['HinhAnh']) ? htmlspecialchars($product['HinhAnh']) : '/assets/no-image.png';
                ?>
                <img src="<?php echo $imgSrc; ?>" alt="" style="background:#f3f3f3;object-fit:cover;max-width:100px;max-height:100px;">
            </a>
            <div class="text-content">
                <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $product['IDThietBi']; ?>">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($product['TenThietBi'] ?? ''); ?>
                    </div>
                </a>
                <div class="rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                    <?php endfor; ?>
                </div>
                <div class="price">
                    <?php echo isset($product['GiaKhuyenMai']) ? number_format($product['GiaKhuyenMai'], 0, ',', '.') : '0'; ?>
                    <i class="fa-solid fa-dong-sign" style="color: #4599e8;"></i>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php } ?>
<!-- END POSTER -->