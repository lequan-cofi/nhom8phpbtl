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
<style>
    
  #nav {
  background-color: #e6f2f9;
  height: 60px;
  margin-left: 30px;
  display: flex;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 85;
  }
  
  #nav .subnav {
  margin-top: 13px;
  margin-left: 10px;
  }
  
  #nav .block {
  height: 100%;
  width: 1px;
  }
  
  #nav .subnav a {
  color: #000;
  padding: 0px 14px 0 14px;
  font-size: 14px;
  font-weight: 500;
  }
  
  #nav .first-item a {
  padding-left: 0.5px;
  }
  
  #nav li {
  display: inline-block;
  padding-left: 32px;
  line-height: 45px;
  }
  
  #nav .subnav li {
  border-radius: 15px;
  padding-left: 0px;
  margin-bottom: 4px;
  }
  
  #nav .first-item {
  margin-top: 0px;
  background-color: #fff;
  }
  
  #nav .first-item li {
  margin-bottom: 0px !important;
  }
  
  #nav .ti-menu {
  background-color: #2761e7;
  border-radius: 50%;
  display: inline-block;
  color: #fff;
  font-size: 20px;
  width: 40px;
  height: 40px;
  text-align: center;
  line-height: 40px;
  margin-top: 4px;
  }
  
  /*START NAV-2*/
  
  #nav .subnav-2 {
  margin-top: 13px;
  margin-left: 60px;
  }
  
  #nav .subnav-2 li {
  width: 1px;
  height: 40px;
  margin-bottom: 5px;
  }
  
  #nav .subnav-2 a {
  display: block;
  width: 45px;
  height: 45px;
  background-color: #fff;
  border-radius: 50%;
  color: #000;
  }
  
  #nav .subnav-2 i {
  padding-top: 13px;
  display: flex;
  justify-content: center;
  }
  
  #nav .subnav-2 .last-item {
  color: #fff;
  background-color: #2761e7;
  }
  
  /*END SUBNAV-2*/
  
  /*HOVER*/
  #nav .subnav .item:hover {
  background-color: #b3c7f5;
  transition: 0.3s;
  }
  
  #nav .subnav .item:hover a {
  color: #1c61e7;
  }
  /*END NAV*/
  
</style>
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
            <li> <a class="last-item" href="<?php echo BASE_URL; ?>/index.php?page=cart"> <i class="fa-solid fa-cart-shopping"></i> </a> </li>
        </ul>
    </div>