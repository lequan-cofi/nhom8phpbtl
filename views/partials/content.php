<?php
// Get content data from controller
$contents = $contentController->getContentData();
$mainContent = isset($contents[0]) ? $contents[0] : null;
$rightContent1 = isset($contents[1]) ? $contents[1] : null;
$rightContent2 = isset($contents[2]) ? $contents[2] : null;
$rightContent3 = isset($contents[3]) ? $contents[3] : null;
?>

<!-- START CONTENT -->
<div id="content">
    <div class="left">
        <?php if ($mainContent): ?>
        <div class="list">
            <div class="item-1">
                <img class="img-1" src="<?php echo htmlspecialchars($mainContent->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($mainContent->TieuDe); ?>">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($mainContent->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($mainContent->MoTa); ?>
                    </div>
                    <div class="button-1">
                        <form action="<?php echo htmlspecialchars($mainContent->DuongDanLienKet); ?>" class="button-1-1">
                            <button type="submit">Xem ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="right">
        <?php if ($rightContent1): ?>
        <div class="first-right">
            <img class="img-2" src="<?php echo htmlspecialchars($rightContent1->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightContent1->TieuDe); ?>" width="250px" height="250px">
            <div class="text-content">
                <div class="text-heading">
                    <?php echo htmlspecialchars($rightContent1->TieuDe); ?>
                </div>
                <div class="text-description2">
                    <?php echo htmlspecialchars($rightContent1->MoTa); ?>
                </div>
                <div class="button-2">
                    <form action="<?php echo htmlspecialchars($rightContent1->DuongDanLienKet); ?>">
                        <button type="submit">Mua ngay</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="subright">
            <?php if ($rightContent2): ?>
            <div class="subright1">
                <img src="<?php echo htmlspecialchars($rightContent2->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightContent2->TieuDe); ?>" class="img-3" width="150px" height="150px">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($rightContent2->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($rightContent2->MoTa); ?>
                    </div>
                    <div class="button-2 button-3">
                        <form action="<?php echo htmlspecialchars($rightContent2->DuongDanLienKet); ?>">
                            <button type="submit">Xem ngay</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($rightContent3): ?>
            <div class="subright2">
                <img src="<?php echo htmlspecialchars($rightContent3->DuongDanHinhAnh); ?>" alt="<?php echo htmlspecialchars($rightContent3->TieuDe); ?>" class="img-3" width="150px" height="150px">
                <div class="text-content">
                    <div class="text-heading">
                        <?php echo htmlspecialchars($rightContent3->TieuDe); ?>
                    </div>
                    <div class="text-description">
                        <?php echo htmlspecialchars($rightContent3->MoTa); ?>
                    </div>
                    <div class="button-2 button-3">
                        <form action="<?php echo htmlspecialchars($rightContent3->DuongDanLienKet); ?>">
                            <button type="submit">Mua ngay</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--END CONTENT -->