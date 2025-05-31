<?php
require_once __DIR__ . '/../../controllers/SidebarController.php';
$sidebarController = new SidebarController();
$deviceTypes = $sidebarController->getDeviceTypes();
?>
<!-- START SIDEBAR -->
<div id="sidebar">
    <ul id="mainsidebar">
        <li class="first-child">
            <a href="">
                <i class="ti-menu"></i>
                <span class="nav-text">Danh mục</span>
            </a>
        </li>
        <?php foreach ($deviceTypes as $type): ?>
        <li>
            <a href="/Danh mục các sản phẩm/<?php echo strtolower($type['Ten']); ?>/<?php echo $type['Ten']; ?>.html">
                <i class="<?php echo strtolower($type['Ten']); ?>"></i>
                <span class="nav-text"><?php echo $type['Ten']; ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
  