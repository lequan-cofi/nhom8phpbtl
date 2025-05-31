<?php
// Get promotion data from controller
$promotions = $khuyenmaiController->getKhuyenmaiData();
$mainPromotion = isset($promotions[0]) ? $promotions[0] : null;
$rightPromotion1 = isset($promotions[1]) ? $promotions[1] : null;
$rightPromotion2 = isset($promotions[2]) ? $promotions[2] : null;
$rightPromotion3 = isset($promotions[3]) ? $promotions[3] : null;
?>

<!-- START PROMOTION -->
<div id="khuyenmai">
    <div class="left">
        <?php if ($mainPromotion): ?>
        <div class="list">
            <div class="item-1">
                <img class="img-1" src="<?php echo htmlspecialchars($mainPromotion->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($mainPromotion->TieuDe); ?>">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($mainPromotion->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($mainPromotion->MoTa); ?>
                    </div>
                    <div class="button-1">
                        <form action="<?php echo htmlspecialchars($mainPromotion->DuongDanLienKet); ?>" class="button-1-1">
                            <button type="submit">Xem ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="right">
        <?php if ($rightPromotion1): ?>
        <div class="first-right">
            <img class="img-2" src="<?php echo htmlspecialchars($rightPromotion1->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightPromotion1->TieuDe); ?>" width="250px" height="250px">
            <div class="text-content">
                <div class="text-heading">
                    <?php echo htmlspecialchars($rightPromotion1->TieuDe); ?>
                </div>
                <div class="text-description2">
                    <?php echo htmlspecialchars($rightPromotion1->MoTa); ?>
                </div>
                <div class="button-2">
                    <form action="<?php echo htmlspecialchars($rightPromotion1->DuongDanLienKet); ?>">
                        <button type="submit">Mua ngay</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="subright">
            <?php if ($rightPromotion2): ?>
            <div class="subright1">
                <img src="<?php echo htmlspecialchars($rightPromotion2->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightPromotion2->TieuDe); ?>" class="img-3" width="150px" height="150px">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($rightPromotion2->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($rightPromotion2->MoTa); ?>
                    </div>
                    <div class="button-2 button-3">
                        <form action="<?php echo htmlspecialchars($rightPromotion2->DuongDanLienKet); ?>">
                            <button type="submit">Xem ngay</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($rightPromotion3): ?>
            <div class="subright2">
                <img src="<?php echo htmlspecialchars($rightPromotion3->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightPromotion3->TieuDe); ?>" class="img-3" width="150px" height="150px">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($rightPromotion3->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($rightPromotion3->MoTa); ?>
                    </div>
                    <div class="button-2 button-3">
                        <form action="<?php echo htmlspecialchars($rightPromotion3->DuongDanLienKet); ?>">
                            <button type="submit">Mua ngay</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--END PROMOTION --> 