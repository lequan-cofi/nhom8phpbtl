<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Apple</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/font/icon/themify-icons-font/themify-icons/themify-icons.css"/>
    <script src="https://kit.fontawesome.com/eec2044d74.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f7;
            color: #1d1d1f;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .cart-item {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
        }

        .item-content {
            display: grid;
            grid-template-columns: 120px 1fr auto;
            gap: 20px;
            align-items: start;
        }

        .item-image {
            width: 120px;
            height: 120px;
            background: #f5f5f7;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .case-image {
            width: 100x;
            height: 100px;
            border-radius: 8px;
            position: relative;
        }

        .case-ultramarine {
            background: linear-gradient(135deg, #4a6cf7 0%, #3b82f6 100%);
        }

        .case-lake-green {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .camera-cutout {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 35px;
            height: 35px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .camera-lens {
            width: 12px;
            height: 12px;
            background: #333;
            border-radius: 50%;
            margin: 2px;
            border: 1px solid #666;
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-size: 20px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        .item-subtitle {
            font-size: 16px;
            color: #86868b;
            margin-bottom: 16px;
        }

        .quantity-selector {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .quantity-btn {
            background: #f5f5f7;
            border: 1px solid #d2d2d7;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: #1d1d1f;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background: #e8e8ed;
        }

        .quantity-display {
            min-width: 40px;
            text-align: center;
            font-weight: 500;
        }

        .item-availability {
            font-size: 14px;
            color: #86868b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .availability-text {
            color: #0066cc;
            cursor: pointer;
        }

        .availability-text:hover {
            text-decoration: underline;
        }

        .store-pickup {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #86868b;
            margin-bottom: 16px;
        }

        .pickup-icon {
            width: 16px;
            height: 16px;
            background: #0066cc;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
        }

        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 14px;
        }

        .action-link {
            color: #0066cc;
            text-decoration: none;
            cursor: pointer;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .item-price {
            text-align: right;
        }

        .price-current {
            font-size: 20px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 4px;
        }

        .price-installment {
            font-size: 14px;
            color: #86868b;
        }

        .cart-summary {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f7;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 20px;
            margin-top: 10px;
            border-top: 2px solid #f5f5f7;
        }

        .summary-label {
            font-size: 16px;
            color: #1d1d1f;
        }

        .summary-value {
            font-size: 16px;
            color: #1d1d1f;
            font-weight: 500;
        }

        .total-label {
            font-size: 20px;
            font-weight: 600;
            color: #1d1d1f;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
            color: #1d1d1f;
        }

        .tax-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #86868b;
        }

        .info-icon {
            width: 16px;
            height: 16px;
            background: #86868b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            cursor: pointer;
        }

        .daily-cash {
            font-size: 14px;
            color: #86868b;
            text-align: right;
            margin-top: 8px;
        }

        .checkout-section {
            margin-top: 40px;
        }

        .checkout-title {
            font-size: 22px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 30px;
        }

        .payment-option {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .payment-method {
            font-size: 18px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        .payment-amount {
            font-size: 24px;
            font-weight: 700;
            color: #1d1d1f;
            margin-bottom: 30px;
        }

        .checkout-btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 12px;
        }

        .btn-primary {
            background: #0071e3;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 113, 227, 0.3);
        }

        .btn-secondary {
            background: #1d1d1f;
            color: white;
        }

        .btn-secondary:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .item-content {
                grid-template-columns: 100px 1fr;
                gap: 15px;
            }

            .item-price {
                grid-column: 1 / -1;
                text-align: left;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #f5f5f7;
            }

            .item-image {
                width: 100px;
                height: 100px;
            }

            .cart-summary {
                padding: 20px;
            }

            .payment-option {
                padding: 20px;
            }
        }

        .shipping-free {
            color: #1d6b00;
            font-weight: 500;
        }

        .remove-item {
            color: #d70015;
        }

        .remove-item:hover {
            color: #a50010;
        }
    </style>
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
$navigationPath = APP_PATH . '/views/partials/navigation_bar.php';
if (file_exists($navigationPath)) {
    require $navigationPath;
} else {
    echo "<p style='color:red;'>Lỗi: Không tìm thấy file navigation_bar.php</p>";
}
?>
</div>
    <div class="container">
        <?php if (!empty($cartItems)): ?>
            <?php 
                $subtotal = 0;
                foreach ($cartItems as $item): 
                    $itemTotal = $item['Gia'] * $item['SoLuong'];
                    $subtotal += $itemTotal;
            ?>
            <div class="cart-item">
                <div class="item-content">
                    <div class="item-image">
                        <?php
                            $hinhAnhModel = new HinhanhthietbiModel();
                            $hinhAnh = $hinhAnhModel->getByThietBi($item['IDThietBi']);
                            $anhChinh = !empty($hinhAnh) ? $hinhAnh[0]['DuongDanHinhAnh'] : '';
                        ?>
                        <img src="<?php echo htmlspecialchars($anhChinh); ?>" alt="<?php echo htmlspecialchars($item['TenThietBi'] ?? ''); ?>" class="case-image">
                    </div>
                    <div class="item-details">
                        <h3 class="item-title"><?php echo htmlspecialchars($item['TenThietBi'] ?? ''); ?></h3>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['ID']; ?>, -1)">-</button>
                            <span class="quantity-display" id="qty-<?php echo $item['ID']; ?>"><?php echo $item['SoLuong']; ?></span>
                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['ID']; ?>, 1)">+</button>
                        </div>
                        <div class="item-actions">
                            <a href="#" class="action-link remove-item" data-id="<?php echo $item['ID']; ?>">Remove</a>
                        </div>
                    </div>
                    <div class="item-price" data-price="<?php echo $item['Gia']; ?>">
                        <div class="price-current"><?php echo number_format($item['Gia'], 0, ',', '.'); ?>₫</div>
                        <div class="price-installment" id="item-total-<?php echo $item['ID']; ?>">
                            Tổng: <?php echo number_format($itemTotal, 0, ',', '.'); ?>₫
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value" id="subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Shipping</span>
                    <span class="summary-value shipping-free">FREE</span>
                </div>
                <div class="summary-row">
                    <span class="total-label">Total</span>
                    <div>
                        <div class="total-value" id="total"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</div>
                    </div>
                </div>
            </div>

            <!-- Checkout Section -->
            <div class="checkout-section">
                <h2 class="checkout-title">Thanh toán</h2>
                <div class="payment-option">
                    <div class="payment-method">Thanh toán toàn bộ</div>
                    <div class="payment-amount" id="payment-amount"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</div>
                    <a href="<?php echo BASE_URL; ?>/index.php?page=thanhtoan" class="checkout-btn btn-primary">Tiến hành thanh toán</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
        <?php endif; ?>
    </div>
    <div id="main-footer" style="margin-left: 58px;">
    <?php
        $footerPath = APP_PATH . '/views/partials/footer_content.php';
        if (file_exists($footerPath)) {
            require $footerPath;
        } else {
            echo "<p style='color:red;'>Lỗi: Không tìm thấy file footer_content.php</p>";
        }
        ?>
</div>
    <script>
        // JS cập nhật số lượng và xóa sản phẩm (cần AJAX thực tế)
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    const cartItem = this.closest('.cart-item');
                    const itemId = this.getAttribute('data-id');
                    // Gọi AJAX xóa trên server
                    fetch('<?php echo BASE_URL; ?>/index.php?page=cart&action=delete', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'item_id=' + encodeURIComponent(itemId)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            cartItem.remove();
                            updateCartTotals();
                        } else {
                            alert(data.message || 'Xóa không thành công!');
                        }
                    })
                    .catch(() => alert('Lỗi kết nối server!'));
                }
            });
        });
        // Hàm cập nhật số lượng (cần AJAX thực tế)
        function updateQuantity(itemId, change) {
            const qtySpan = document.getElementById('qty-' + itemId);
            let qty = parseInt(qtySpan.textContent) + change;
            if (qty < 1) qty = 1;
            qtySpan.textContent = qty;

            // Lấy giá gốc từ data-price
            const itemPriceDiv = qtySpan.closest('.item-content').querySelector('.item-price');
            const price = parseFloat(itemPriceDiv.getAttribute('data-price'));
            // Cập nhật tổng từng sản phẩm
            const itemTotal = price * qty;
            const itemTotalDiv = document.getElementById('item-total-' + itemId);
            itemTotalDiv.textContent = 'Tổng: ' + itemTotal.toLocaleString('vi-VN') + '₫';

            // Cập nhật tổng giỏ hàng
            updateCartTotals();
            // TODO: Gọi AJAX cập nhật số lượng trên server nếu muốn
            fetch('<?php echo BASE_URL; ?>/index.php?page=cart&action=updateQuantity', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'item_id=' + encodeURIComponent(itemId) + '&quantity=' + encodeURIComponent(qty)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Handle success
                } else {
                    alert(data.message || 'Cập nhật số lượng không thành công!');
                }
            })
            .catch(() => alert('Lỗi kết nối server!'));
        }

        function updateCartTotals() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(function(cartItem) {
                const qty = parseInt(cartItem.querySelector('.quantity-display').textContent);
                const price = parseFloat(cartItem.querySelector('.item-price').getAttribute('data-price'));
                subtotal += qty * price;
            });
            document.getElementById('subtotal').textContent = subtotal.toLocaleString('vi-VN') + '₫';
            document.getElementById('total').textContent = subtotal.toLocaleString('vi-VN') + '₫';
            document.getElementById('payment-amount').textContent = subtotal.toLocaleString('vi-VN') + '₫';
        }
    </script>
</body>
</html>