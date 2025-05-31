<!--START SAN PHAM MOI-->
<div id="new-product">
    <div class="left">
        <?php
        require_once __DIR__ . '/../../controllers/ThietbiController.php';
        $controller = new ThietBiController();
        $recentProducts = $controller->getRecentProducts();
        
        if (!empty($recentProducts)) {
            $latestProduct = $recentProducts[0]; // Get the newest product
        ?>
        <div class="new-iphone">
            <img src="<?php echo htmlspecialchars($latestProduct['DuongDanLienKet']); ?>" alt="<?php echo htmlspecialchars($latestProduct['Ten']); ?>">
        </div>

        <div class="new-item">
            <div class="text-description">
            </div>

            <div class="text-heading">
                <?php echo htmlspecialchars($latestProduct['Ten']); ?>
            </div>

            <div class="button-2">
                <form action="">
                    <button type="submit">Mua ngay</button>
                </form>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="right">
        <h2>Sản phẩm mới</h2>
        <ul class="list-new-product">
            <?php
            if (!empty($recentProducts)) {
                // Skip the first product as it's already shown in the left section
                array_shift($recentProducts);
                foreach ($recentProducts as $product) {
            ?>
            <li>
                <a href="product-detail.php?id=<?php echo $product['ID']; ?>">
                    <div class="wrapper-product">
                        <?php if (strtotime($product['NgayTao']) > strtotime('-7 days')) { ?>
                        <div class="label">
                            <span>HOT</span>
                        </div>
                        <?php } ?>

                        <img src="<?php echo htmlspecialchars($product['DuongDanLienKet']); ?>" alt="<?php echo htmlspecialchars($product['Ten']); ?>" width="227.34px" height="259.81px">
                        <div class="product-element-bottom">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['Ten']); ?></h3>
                            <div class="product-cats"><?php echo htmlspecialchars($product['TenLoaiThietBi']); ?></div>
                            <div class="product-rating">
                                <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                                <i class="fa-solid fa-star" style="color: #f1d939;"></i>
                            </div>
                            <p class="product-in-stock">
                                <i class="fa-solid fa-check" style="color: #4599e8;"></i>
                                <?php echo $product['SoLuongTonKho'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                            </p>
                            <div class="product-price">
                                <?php echo number_format($product['Gia'], 0, ',', '.'); ?>
                                <i class="fa-solid fa-dong-sign" style="color: #4599e8;"></i>
                            </div>
                            <div class="add-product">
                                <a href="product-detail.php?id=<?php echo $product['ID']; ?>" class="btn-flip" data-back="Thêm vào giỏ" data-front="Mua ngay"></a>
                            </div>
                            <div class="product-code">
                                <div class="product-name">
                                    SKU: 
                                </div>
                                <div class="code">
                                    &#160 <?php echo $product['ID']; ?>
                                </div>
                            </div>

                            <div class="details">
                                <hr>
                                <div class="brand">Thương hiệu: <?php echo htmlspecialchars($product['TenLoaiThietBi']); ?></div>
                                <div class="Series">Series: <?php echo htmlspecialchars($product['TenLoaiThietBi']); ?> Series</div>
                            </div>
                        </div>

                        <div class="product-button">
                            <div class="compare-button">
                                <a href=""><i class="fa-solid fa-code-compare" style="color: #333;"></i></a>
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
            <?php
                }
            }
            ?>
        </ul>
    </div>
</div>
<!--END SAN PHAM MOI-->
