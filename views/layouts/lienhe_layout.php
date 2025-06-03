<?php
// views/layouts/lienhe_layout.php
// BASE_URL đã được define trong public/index.php
$user = $_SESSION['user'] ?? [];
$hoTen = $user['Ten'] ?? '';
$email = $user['Email'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($data['pageTitle'] ?? 'iStore'); ?></title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="sidebar">
        <?php
            // Nạp nội dung sidebar từ partial
            $sidebarPath = APP_PATH . '/views/partials/sidebar.php';
            if (file_exists($sidebarPath)) {
                require $sidebarPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file sidebar.php</p>";
            }
        ?>
    </div>
    <div class="overlay"></div>
    <div id="header">
        <?php
            // Nạp nội dung header từ partial
            $headerPath = APP_PATH . '/views/partials/header_content.php';
            if (file_exists($headerPath)) {
                require $headerPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file header_content.php</p>";
            }
        ?>
    </div>
    <div id="nav">
        <?php
            // Nạp nội dung navigation từ partial
            $navigationPath = APP_PATH . '/views/partials/navigation_bar.php';
            if (file_exists($navigationPath)) {
                require $navigationPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file navigation_bar.php</p>";
            }
        ?>
    </div>

 <!-- Contact Start -->
 <div class="contact">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="form">
                            <form id="contactForm" method="post" action="<?php echo BASE_URL; ?>/index.php?page=lienhe&action=submitContact">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" name="HoTen" placeholder="Tên của bạn" value="<?php echo htmlspecialchars($hoTen); ?>" <?php echo $hoTen ?  : ''; ?> />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" <?php echo $email ?  : ''; ?> />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="ChuDe" placeholder="Chủ đề *" required />
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="NoiDung" rows="5" placeholder="Lời gửi của bạn *" required></textarea>
                                </div>
                                <div><button type="submit">Gửi</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="contact-info">
                            <div class="section-header">
                                <h3>iStore xin chào</h3>
                                <p>
                                  Chúng tôi luôn sẵn sàng lắng nghe và tiếp nhận mọi góp ý từ quý khách hàng với tinh thần cầu thị, nhằm không ngừng cải thiện và nâng cao chất lượng trải nghiệm mua sắm. Mỗi ý kiến đóng góp của bạn là nguồn động lực quý giá để chúng tôi hoàn thiện dịch vụ, mang lại sự hài lòng và tiện lợi tối ưu nhất cho mọi khách hàng. Hãy cùng chúng tôi xây dựng một môi trường mua sắm hiện đại, thân thiện và đáp ứng mọi nhu cầu của bạn!                                </p>
                            </div>
                            <h4><i class="fa fa-map-marker"></i>12 Chùa Bộc, Quang Trung, Đống Đa, Hà Nội</h4>
                            <h4><i class="fa fa-envelope"></i>istore@cskh.com</h4>
                            <h4><i class="fa fa-phone"></i>0123.456.789</h4>
                            <div class="social">
                                <a href=""><i class="fa fa-twitter"></i></a>
                                <a href="https://www.facebook.com/share/nXsbHEG9g485rYvQ/?mibextid=kFxxJD"><i class="fa fa-facebook"></i></a>
                                <a href=""><i class="fa fa-linkedin"></i></a>
                                <a href=""><i class="fa fa-instagram"></i></a>
                                <a href=""><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

    <div id="main-footer" style="margin-left: 58px;">
        <?php
            // Nạp nội dung footer từ partial
            $footerPath = APP_PATH . '/views/partials/footer_content.php';
            if (file_exists($footerPath)) {
                require $footerPath;
            } else {
                echo "<p style='color:red;'>Lỗi: Không tìm thấy file footer_content.php</p>";
            }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>