<?php
require_once __DIR__ . '/../../controllers/AdminSalesListController.php';
require_once __DIR__ . '/../../controllers/SalesController.php';
$adminSalesListController = new AdminSalesListController();
$salesController = new SalesController();
$settings = $adminSalesListController->getAllSettings();
?>
<!--START UU DAI-->
<div id="sales">
  <?php foreach ($settings as $setting): ?>
    <div class="text-heading">
      <?php echo htmlspecialchars($setting['TenLoaiThietBi']); ?>
    </div>
    <ul class="list-sales">
      <?php 
        $devices = $salesController->getDevicesByType($setting['IDLoaiThietBi'], $setting['SoLuongHienThi']);
        foreach ($devices as $device):
      ?>
        <li>
          <a href="<?php echo BASE_URL; ?>/index.php?page=product&action=detail&id=<?php echo $device['ID']; ?>">
            <div class="wrapper-product">
              <div class="label">
                <span>HOT</span>
              </div>
              <img src="<?php echo htmlspecialchars($device['HinhAnh'] ?? ''); ?>" alt="<?php echo htmlspecialchars($device['Ten'] ?? ''); ?>" width="227.34px" height="259.81px">
              <div class="product-element-bottom">
                <h3 class="product-title"><?php echo htmlspecialchars($device['Ten'] ?? ''); ?></h3>
                <div class="product-cats"><?php echo htmlspecialchars($device['TenKhuyenMai'] ?? ''); ?></div>
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
                  <span class="original-price"><?php echo isset($device['Gia']) ? number_format($device['Gia'], 0, ',', '.') : ''; ?>đ</span>
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
  <?php endforeach; ?>
</div>
<!--END UU DAI-->
