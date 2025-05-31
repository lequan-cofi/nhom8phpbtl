<?php
// Group products by promotion
$groupedProducts = [];
foreach ($products as $product) {
    $promoId = $product['KhuyenMaiID'] ?? 'no_promo';
    if (!isset($groupedProducts[$promoId])) {
        $groupedProducts[$promoId] = [
            'promo_name' => $product['KhuyenMaiTen'] ?? 'Không có khuyến mãi',
            'promo_image' => $product['KhuyenMaiHinhAnh'] ?? '',
            'products' => []
        ];
    }
    $groupedProducts[$promoId]['products'][] = $product;
}
?>

<div class="container-fluid">
    <?php foreach ($groupedProducts as $promoId => $group): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <?php if ($promoId !== 'no_promo'): ?>
                        <img src="<?php echo htmlspecialchars($group['promo_image']); ?>" alt="" style="max-height: 40px; margin-right: 10px;">
                    <?php endif; ?>
                    <?php echo htmlspecialchars($group['promo_name']); ?>
                    <small class="ml-2">(<?php echo count($group['products']); ?> sản phẩm)</small>
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($group['products'] as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if ($product['HinhAnh']): ?>
                                    <img src="<?php echo htmlspecialchars($product['HinhAnh']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($product['Ten']); ?>"
                                         style="height: 200px; object-fit: contain;">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['Ten']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['Mota']); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="<?php echo htmlspecialchars($product['DuongDanLienKet']); ?>" 
                                           class="btn btn-primary" 
                                           target="_blank">
                                            Xem chi tiết
                                        </a>
                                        <small class="text-muted">
                                            Thứ tự: <?php echo $product['display_order']; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.card {
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style> 