<?php
// views/khuyenmai/index.php
?>
<div style="padding: 20px;">
    <h2>Khuyến Mãi</h2>
    <div class="promotions-container">
        <?php if (!empty($promotions)): ?>
            <?php foreach ($promotions as $promotion): ?>
                <div class="promotion-item">
                    <img src="<?php echo htmlspecialchars($promotion->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($promotion->TieuDe); ?>">
                    <div class="promotion-content">
                        <h3><?php echo htmlspecialchars($promotion->TieuDe); ?></h3>
                        <p><?php echo htmlspecialchars($promotion->MoTa); ?></p>
                        <?php if ($promotion->DuongDanLienKet): ?>
                            <a href="<?php echo htmlspecialchars($promotion->DuongDanLienKet); ?>" class="btn btn-primary">Xem ngay</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Hiện không có khuyến mãi nào.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.promotions-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.promotion-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.promotion-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.promotion-content {
    padding: 15px;
}

.promotion-content h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.promotion-content p {
    margin: 0 0 15px 0;
    color: #666;
}

.btn-primary {
    display: inline-block;
    padding: 8px 16px;
    background-color: #2761e7;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #1c4bb3;
}
</style> 