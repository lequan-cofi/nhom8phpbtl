<?php
require_once __DIR__ . '/../../controllers/LoaithietbiController.php';
$loaithietbiController = new LoaithietbiController();
$deviceTypes = $loaithietbiController->getAllWithProductCount();
?>

<div id="list-product">
  <div class="text-heading">Danh mục sản phẩm</div>

  <!-- Bọc UL trong div để tạo vùng cuộn -->
  <div class="scroll-wrapper">
    <ul class="product">
      <?php foreach ($deviceTypes as $type): ?>
      <li>
        <a href="<?php echo BASE_URL; ?>/index.php?page=categories&category_id=<?php echo $type['ID']; ?>">
          <div class="img-wrapper">
            <?php if (!empty($type['DuongDanHinhAnh'])): ?>
              <img src="<?php echo htmlspecialchars($type['DuongDanHinhAnh']); ?>" alt="<?php echo htmlspecialchars($type['Ten']); ?>" width="180.56px" height="180.56px">
            <?php endif; ?>
          </div>
          <div class="hover-mask">
            <h3><?php echo htmlspecialchars($type['Ten']); ?></h3>
          </div>
          <div class="more-products"><?php echo $type['SoLuongSanPham']; ?> sản phẩm</div>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
