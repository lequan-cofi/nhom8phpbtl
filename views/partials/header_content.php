<?php
// views/partials/header_content.php
// BASE_URL đã được define trong public/index.php và có sẵn ở main_layout.php
?>

<a class="logo" href="<?php echo BASE_URL; ?>/index.php">
    <img src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt="iStore Logo" width="220px" height="40px" />
</a>
<form action="<?php echo BASE_URL; ?>/index.php" method="get"  class="search-bar">
    <input type="hidden" name="page" value="search">
    <input type="text" name="q" autocomplete="off" placeholder="Tìm kiếm sản phẩm...">
    <button type="submit"><i class="ti-search"></i></button>
</form>
<ul class="subnav">
    <li>
        <a href="tel:0123456789"> <i class="ti-mobile"></i> </a>
    </li>
    <li>
        <a href="tel:0123456789">
            <p>Hỗ trợ 24/7</p>
            <p class="sub-text">0123.456.789</p>
        </a>
    </li>
    <li>
        <a href="#"> <i class="ti-world"></i> </a>
    </li>
    <li>
        <a href="#">
            <p>Giao hàng</p>
            <p class="sub-text">Toàn Quốc</p>
        </a>
    </li>
</ul>
