<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - TestSapoLayVanChuyen</title>
    <style>
        /* CSS Variables */
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --text-primary: #1a1a1a;
            --text-secondary: #374151;
            --border-color: #e5e7eb;
            --background-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --shadow-light: 0 8px 25px rgba(102, 126, 234, 0.15);
            --shadow-medium: 0 15px 35px rgba(102, 126, 234, 0.4);
            --shadow-heavy: 0 20px 40px rgba(0, 0, 0, 0.1);
            --border-radius-sm: 12px;
            --border-radius-md: 16px;
            --border-radius-lg: 24px;
            --spacing-xs: 8px;
            --spacing-sm: 15px;
            --spacing-md: 20px;
            --spacing-lg: 30px;
            --spacing-xl: 40px;
            --transition: all 0.3s ease;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            padding: var(--spacing-md);
            line-height: 1.6;
        }

        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: var(--spacing-lg);
            align-items: start;
        }

        /* Glass Card Effect */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-heavy);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .main-content {
            padding: var(--spacing-xl);
        }

        .sidebar {
            padding: var(--spacing-lg);
            position: sticky;
            top: var(--spacing-md);
        }

        /* Typography */
        .header {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-xl);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            background: var(--background-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section {
            margin-bottom: var(--spacing-xl);
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--spacing-md);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--background-gradient);
            border-radius: 2px;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-xs);
            font-size: 14px;
        }

        input, select, textarea {
            padding: var(--spacing-md);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 16px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Components */
        .shipping-notice {
            color: var(--primary-color);
            font-weight: 500;
            text-align: center;
            padding: var(--spacing-sm);
            background: rgba(102, 126, 234, 0.1);
            border-radius: var(--border-radius-sm);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .payment-methods {
            display: grid;
            gap: var(--spacing-sm);
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: var(--spacing-md);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-md);
            cursor: pointer;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .payment-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .payment-option.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.05));
        }

        .payment-option input[type="radio"] {
            margin-right: var(--spacing-sm);
            transform: scale(1.2);
        }

        .payment-option label {
            font-weight: 500;
            cursor: pointer;
            margin: 0;
        }

        /* Order Summary */
        .order-summary {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border-radius: var(--border-radius-md);
            padding: 25px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .order-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--spacing-md);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius-sm);
            background: var(--background-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: var(--border-radius-sm);
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .product-price {
            color: var(--primary-color);
            font-weight: 600;
        }

        .discount-code {
            display: flex;
            gap: 10px;
            margin: var(--spacing-md) 0;
        }

        .discount-input {
            flex: 1;
            padding: 12px var(--spacing-md);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 14px;
        }

        .btn {
            padding: 12px var(--spacing-md);
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--background-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .btn-large {
            width: 100%;
            padding: 18px;
            font-size: 16px;
            margin-top: var(--spacing-md);
            letter-spacing: 0.5px;
        }

        .btn-large:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
        }

        .order-total {
            border-top: 2px solid rgba(102, 126, 234, 0.1);
            padding-top: var(--spacing-md);
            margin-top: var(--spacing-md);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .total-row.final {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: var(--spacing-sm);
            padding-top: var(--spacing-sm);
            border-top: 1px solid rgba(102, 126, 234, 0.1);
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-top: var(--spacing-sm);
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--secondary-color);
            transform: translateX(-5px);
        }

        /* Animations */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
                gap: var(--spacing-md);
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            :root {
                --spacing-xl: 25px;
                --spacing-lg: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            body {
                padding: var(--spacing-sm);
            }
        }

        @media (max-width: 480px) {
            .form-grid {
                gap: var(--spacing-sm);
            }
            
            .discount-code {
                flex-direction: column;
            }
            
            .btn {
                padding: var(--spacing-sm);
            }
        }

        /* Popup Styles */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .success-icon {
            font-size: 64px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .order-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .btn-continue {
            display: inline-block;
            padding: 12px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-continue:hover {
            background: #45a049;
        }

        /* Thêm CSS cho QR Code Section */
        .qr-code-section {
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius-md);
            border: 1px solid var(--border-color);
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .qr-code-section.active {
            display: block;
        }

        .bank-info {
            text-align: center;
        }

        .bank-info h4 {
            color: var(--text-primary);
            margin-bottom: 15px;
            font-size: 18px;
        }

        .bank-details {
            background: rgba(102, 126, 234, 0.05);
            padding: 15px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 20px;
        }

        .bank-details p {
            margin: 8px 0;
            color: var(--text-secondary);
        }

        .bank-details strong {
            color: var(--text-primary);
        }

        .qr-code-container {
            max-width: 300px;
            margin: 0 auto;
            padding: 15px;
            background: white;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow-light);
        }

        .qr-code {
            width: 100%;
            height: auto;
            border-radius: var(--border-radius-sm);
        }

        .qr-note {
            margin-top: 10px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .transfer-amount {
            color: var(--primary-color);
            font-weight: 600;
        }

        .transfer-content {
            color: var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php
    $user = $_SESSION['user'] ?? [];
    $cartItems = $cartItems ?? []; // Controller phải truyền biến này sang
    require_once __DIR__ . '/../../models/salesModel.php';
    $salesModel = new SalesModel();
    ?>
    <div class="container">
        <div class="main-content glass-card">
            <div class="header">
                <h1>Tiền hành đặt hàng </h1>
            </div>
            <form id="checkout-form" method="post" action="<?php echo BASE_URL; ?>/index.php?page=thanhtoan&action=datHang">
            <div class="section">
                <h2 class="section-title">Thông tin nhận hàng</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="SoDienThoai" value="<?php echo htmlspecialchars($user['SoDienThoai'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="Email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input type="text" id="name" name="TenKhachHang" value="<?php echo htmlspecialchars($user['Ten'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <select id="gender" name="GioiTinh">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" <?php if(($user['GioiTinh'] ?? '') == 'Nam') echo 'selected'; ?>>Nam</option>
                            <option value="Nữ" <?php if(($user['GioiTinh'] ?? '') == 'Nữ') echo 'selected'; ?>>Nữ</option>
                            <option value="Khác" <?php if(($user['GioiTinh'] ?? '') == 'Khác') echo 'selected'; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label for="address">Địa chỉ giao hàng</label>
                        <input type="text" id="address" name="DiaChiGiaoHang" value="<?php echo htmlspecialchars($user['DiaChi'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="note">Ghi chú</label>
                        <textarea id="note" placeholder="Ghi chú thêm cho đơn hàng (tùy chọn)"></textarea>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Vận chuyển</h2>
                <div class="shipping-notice">
                    Vui lòng nhập thông tin giao hàng
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Thanh toán</h2>
                <div class="payment-methods">
                    <div class="payment-option selected" data-payment="bank">
                        <input type="radio" id="bank" name="payment" checked>
                        <label for="bank">Chuyển khoản</label>
                    </div>
                    <div class="payment-option" data-payment="cod">
                        <input type="radio" id="cod" name="payment">
                        <label for="cod">Thu hộ (COD)</label>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div id="qrCodeSection" class="qr-code-section">
                    <div class="bank-info">
                        <h4>Thông tin chuyển khoản</h4>
                        <div class="bank-details">
                            <p><strong>Ngân hàng:</strong> Vietcombank</p>
                            <p><strong>Số tài khoản:</strong> 1234567890</p>
                            <p><strong>Chủ tài khoản:</strong> CÔNG TY TNHH ISTORE</p>
                            <p><strong>Số tiền:</strong> <span class="transfer-amount">0</span> VNĐ</p>
                            <p><strong>Nội dung chuyển khoản:</strong> <span class="transfer-content">ISTORE_</span></p>
                        </div>
                        <div class="qr-code-container">
                            <img src="https://iili.io/FHEQRLv.jpg" alt="QR Code" class="qr-code">
                            <p class="qr-note">Quét mã QR để chuyển khoản</p>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="IDNguoiDung" value="<?php echo $user['ID'] ?? $user['id'] ?? ''; ?>">
            <input type="hidden" name="TongTien" value="<?php echo $total; ?>">
            <input type="hidden" name="PhuongThucThanhToan" id="paymentMethod" value="Chuyển khoản">
            <input type="hidden" name="MaChuyenKhoan" id="maChuyenKhoanInput" value="">
            
            <button class="btn btn-primary btn-large" id="checkout-btn" type="submit">Đặt hàng</button>
           
            
            <a href="<?php echo BASE_URL; ?>/index.php?page=giohang" class="back-link">
                ← Quay về giỏ hàng
            </a>
        </div>

        <div class="sidebar glass-card">
            <div class="order-summary">
                <h3 class="order-title">🛒 Đơn hàng </h3>
                
                <?php $total = 0; ?>
                <?php foreach ($cartItems as $item): ?>
                    <?php 
                        $promotionInfo = $salesModel->getSaleById($item['IDThietBi']);
                        $isSale = $promotionInfo && isset($promotionInfo['GiaKhuyenMai']) && $promotionInfo['GiaKhuyenMai'] < $item['Gia'];
                        $displayPrice = $isSale ? $promotionInfo['GiaKhuyenMai'] : $item['Gia'];
                        $itemTotal = $displayPrice * $item['SoLuong'];
                        $total += $itemTotal;
                    ?>
                    <div class="product-item">
                    <?php
                            $hinhAnhModel = new HinhanhthietbiModel();
                            $hinhAnh = $hinhAnhModel->getByThietBi($item['IDThietBi']);
                            $anhChinh = !empty($hinhAnh) ? $hinhAnh[0]['DuongDanHinhAnh'] : '';
                        ?>
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($anhChinh); ?>" alt="<?php echo htmlspecialchars($item['TenThietBi'] ?? ''); ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-name"><?php echo htmlspecialchars($item['TenThietBi'] ?? ''); ?> (<?php echo $item['SoLuong']; ?>)</div>
                            <div class="product-price">
                                <?php if ($isSale): ?>
                                    <span style="text-decoration: line-through; color: #86868b; margin-right: 8px;">
                                        <?php echo number_format($item['Gia'], 0, ',', '.'); ?>₫
                                    </span>
                                    <span style="color: #d71a19; font-weight: bold;">
                                        <?php echo number_format($promotionInfo['GiaKhuyenMai'], 0, ',', '.'); ?>₫
                                    </span>
                                    <span style="color: #d71a19; font-size: 13px;">
                                        <?php echo htmlspecialchars($promotionInfo['TenKhuyenMai']); ?> - Giảm <?php echo $promotionInfo['MucGiamGia']; ?>%
                                    </span>
                                <?php else: ?>
                                    <?php echo number_format($item['Gia'], 0, ',', '.'); ?>₫
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

               

                <div class="order-total">
                    <div class="total-row">
                        <span>Tạm tính</span>
                        <span><?php echo number_format($total, 0, ',', '.'); ?>₫</span>
                    </div>
                    <div class="total-row">
                        <span>Phí vận chuyển</span>
                        <span>—</span>
                    </div>
                    <div class="total-row final">
                        <span>Tổng cộng</span>
                        <span style="color: var(--primary-color);"><?php echo number_format($total, 0, ',', '.'); ?>₫</span>
                    </div>
                </div>

                
                    <button class="btn btn-primary btn-large" id="checkout-btn" type="submit">Đặt hàng</button>
                </form>
                
                <a href="<?php echo BASE_URL; ?>/index.php?page=giohang" class="back-link">
                    ← Quay về giỏ hàng
                </a>
            </div>
        </div>
    </div>

    <!-- Thêm popup success -->
    <div id="success-popup" class="popup" style="display: none;">
        <div class="popup-content">
            <div class="success-icon">✓</div>
            <h2>Đặt hàng thành công!</h2>
            <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
            <div class="order-info">
                <p>Mã đơn hàng: <span id="order-id"></span></p>
                <p>Tổng tiền: <span id="order-total"></span></p>
            </div>
            <a href="<?php echo BASE_URL; ?>/index.php" class="btn-continue">Tiếp tục mua sắm</a>
        </div>
    </div>

    <script>
        // Payment option selection with QR code handling
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
                
                // Cập nhật giá trị phương thức thanh toán
                const paymentMethod = this.querySelector('label').textContent.trim();
                const paymentInput = document.getElementById('paymentMethod');
                if (paymentInput) paymentInput.value = paymentMethod;

                // Xử lý hiển thị/ẩn QR code
                const qrSection = document.getElementById('qrCodeSection');
                if (this.dataset.payment === 'bank') {
                    qrSection.classList.add('active');
                    // Cập nhật thông tin chuyển khoản
                    updateTransferInfo();
                } else {
                    qrSection.classList.remove('active');
                }
            });
        });

        function generateTransferCode() {
            const userId = <?php echo json_encode($user['ID'] ?? $user['id'] ?? 0); ?>;
            const now = Date.now();
            const random = Math.floor(Math.random() * 10000);
            return `ISTORE_${userId}_${now}_${random}`;
        }

        function updateTransferInfo() {
            const total = <?php echo $total; ?>;
            const transferAmount = document.querySelector('.transfer-amount');
            const transferContent = document.querySelector('.transfer-content');
            let transferCode = '';

            if (document.querySelector('.payment-option.selected').dataset.payment === 'bank') {
                transferCode = generateTransferCode();
                // Gán vào input hidden để gửi lên server
                document.getElementById('maChuyenKhoanInput').value = transferCode;
            }

            if (transferAmount) {
                transferAmount.textContent = new Intl.NumberFormat('vi-VN').format(total);
            }
            if (transferContent) {
                transferContent.textContent = transferCode;
            }
        }

        // Cập nhật thông tin chuyển khoản khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            updateTransferInfo();
        });

        // Form animations
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Discount code application
        document.querySelector('.btn').addEventListener('click', function() {
            const input = document.querySelector('.discount-input');
            if (input.value.trim()) {
                const originalText = this.textContent;
                this.textContent = 'Đã áp dụng';
                this.style.background = '#10b981';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.background = '';
                }, 2000);
            }
        });

        // Checkout button
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('checkout-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner">⏳</span> Đang xử lý...';
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị popup thành công
                    document.getElementById('order-id').textContent = '#' + data.order_id;
                    document.getElementById('order-total').textContent = 
                        new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })
                            .format(data.total);
                    document.getElementById('success-popup').style.display = 'flex';
                    
                    // Xóa form
                    this.reset();
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi đặt hàng');
                    console.log(data);
                }
            })
            .catch(error => {
                alert('Có lỗi hệ thống hoặc kết nối server!');
                console.error(error);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
            });
        });
    </script>
</body>
</html>