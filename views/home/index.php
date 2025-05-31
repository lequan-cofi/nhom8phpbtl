<?php
// views/home/index.php
require_once __DIR__ . '/../../controllers/ContentController.php';
$contentController = new ContentController();
?>
<div style="padding: 20px;">
    <h2>Chào mừng đến với iStore!</h2>
    <?php $contentController->renderContent(); ?>
</div>