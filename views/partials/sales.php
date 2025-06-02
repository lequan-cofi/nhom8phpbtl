<?php
  require_once __DIR__ . '/../../controllers/AdminSalesListController.php';

require_once __DIR__ . '/../../controllers/salesController.php';
$salesController = new SalesController();
$sales = $salesController->getAllSales();

// Lọc chỉ các sản phẩm trong ưu đãi đang diễn ra
$now = date('Y-m-d H:i:s');
$sales = array_filter($sales, function($sale) use ($now) {
  $start = $sale['NgayBatDau'] ?? null;
  $end = $sale['NgayKetThuc'] ?? null;
  return (!$start || $start <= $now) && (!$end || $end >= $now);
});
?>
<!--START UU DAI-->
<div id="sales">
  <div class="text-heading">
    Ưu đãi
  </div>
  <ul class="list-sales">
    <?php foreach ($sales as $sale): ?>
      <li>
        <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $sale['IDThietBi']; ?>">
          <div class="wrapper-product">
            <div class="label">
              <span>HOT</span>
            </div>
            <img src="<?php echo htmlspecialchars($sale['HinhAnh'] ?? ''); ?>" alt="<?php echo htmlspecialchars($sale['TenThietBi'] ?? ''); ?>" width="227.34px" height="259.81px">
            <div class="product-element-bottom">
              <h3 class="product-title"><?php echo htmlspecialchars($sale['TenThietBi'] ?? ''); ?></h3>
              <div class="product-cats"><?php echo htmlspecialchars($sale['TenKhuyenMai'] ?? ''); ?></div>
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
                <span class="original-price" style="text-decoration: line-through;"><?php echo isset($sale['Gia']) ? number_format($sale['Gia'], 0, ',', '.') : ''; ?></span>
                <span class="discount-price"><?php echo isset($sale['GiaKhuyenMai']) ? number_format($sale['GiaKhuyenMai'], 0, ',', '.') : ''; ?></span>
              </div>
              <div class="add-product">
                <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $sale['IDThietBi']; ?>" class="btn-flip" data-back="Thêm vào giỏ" data-front="Mua ngay"></a>
              </div>
              <div class="product-code">
                <div class="product-name">
                  SKU: 
                </div>
                <div class="code">
                  &#160;<?php echo htmlspecialchars($sale['ID'] ?? ''); ?>
                </div>
              </div>
            </div>
            <div class="product-button">
              <div class="compare-button">
                <a href="#"><i class="fa-solid fa-code-compare" style="color: #333;"></i></a>
              </div>
              <div class="search-button">
                <a>  <i class="fa-solid fa-magnifying-glass" style="color: #333;"></i>
                </a>       
              </div>
              <div class="love-button">
                <a>  <i class="fa-regular fa-heart" style="color: #333;"></i>
                </a>
              </div>
            </div>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<!--END UU DAI-->