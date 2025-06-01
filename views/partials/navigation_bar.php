<?php
if (!empty($_SESSION['user'])) {
    $role = $_SESSION['user']['VaiTro'];
    if ($role === 'Quản trị viên') {
        $accountUrl = '/iStore_PHP_Backend/views/admin/dashboard.php';
    } else {
        $accountUrl = BASE_URL . '/index.php?page=user&action=taikhoankh';
    }
} else {
    $accountUrl = BASE_URL . '/index.php?page=login_signup';
}
?>
<div id="nav">
         <ul class="subnav">
            <li class="first-item">
              <a href="index.php?page=categories" >
                <i class="ti-menu"></i>
                <span>Danh Mục Sản Phẩm</span>
              </a>
            </li>
            <li class="item"><a href="<?php echo BASE_URL; ?>/index.php">Trang Chủ</a></li>
            <li class="item"><a href="<?php echo BASE_URL; ?>/index.php?page=gioithieu">Giới Thiệu</a></li>
            <li class="item"><a href="<?php echo BASE_URL; ?>/index.php?page=cuahang">Cửa Hàng</a></li>
            <li class="item"><a href="<?php echo BASE_URL; ?>/index.php?page=tintuc_layout">Tin Tức</a></li>
            <li class="item"><a href="<?php echo BASE_URL; ?>/index.php?page=lienhe">Liên Hệ</a></li>
            </ul>
        <div class="block"></div>
        <ul class="subnav-2">
            <li> <a href="<?php echo $accountUrl; ?>"> <i class="fa-regular fa-user"></i> </a> </li>
            <li> <a href="#"> <i class="fa-solid fa-code-compare"></i> </a> </li>
            <li> <a id="showWishlistBtnPlaceholder"> <i class="fa-regular fa-heart"></i> </a> </li>
            <li> <a class="last-item" href="#"> <i class="fa-solid fa-cart-shopping"></i> </a> </li>
        </ul>
    </div>