<div class="container py-4">
    <h2>Đơn hàng của tôi</h2>
    <?php if (empty($orders)): ?>
        <div class="alert alert-warning">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['ID'] ?></td>
                    <td><?= htmlspecialchars($order['NgayTao']) ?></td>
                    <td><?= htmlspecialchars($order['TrangThaiDonHang']) ?></td>
                    <td><?= number_format($order['TongTien'], 0, ',', '.') ?> đ</td>
                    <td>
                        <button class="btn btn-info btn-sm view-details" data-order-id="<?= $order['ID'] ?>">
                            Xem chi tiết
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng #<span id="modalOrderId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="order-info mb-4">
                        <h6>Thông tin đơn hàng</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Ngày đặt:</strong> <span id="modalOrderDate"></span></p>
                                <p><strong>Trạng thái:</strong> <span id="modalOrderStatus"></span></p>
                                <p><strong>Tổng tiền:</strong> <span id="modalOrderTotal"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phương thức thanh toán:</strong> <span id="modalPaymentMethod"></span></p>
                                <p><strong>Ghi chú:</strong> <span id="modalOrderNote"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="order-items">
                        <h6>Danh sách sản phẩm</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="modalOrderItems">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
        
        // Xử lý sự kiện click nút xem chi tiết
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.dataset.orderId;
                fetchOrderDetails(orderId);
            });
        });

        // Hàm lấy chi tiết đơn hàng
        function fetchOrderDetails(orderId) {
            fetch(`<?= BASE_URL ?>/index.php?page=orders&action=getDetails&id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayOrderDetails(data.order, data.details);
                        modal.show();
                    } else {
                        alert('Không thể lấy thông tin đơn hàng');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi lấy thông tin đơn hàng');
                });
        }

        // Hàm hiển thị chi tiết đơn hàng trong modal
        function displayOrderDetails(order, details) {
            document.getElementById('modalOrderId').textContent = order.ID;
            document.getElementById('modalOrderDate').textContent = order.NgayTao;
            document.getElementById('modalOrderStatus').textContent = order.TrangThaiDonHang;
            document.getElementById('modalOrderTotal').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.TongTien);
            document.getElementById('modalPaymentMethod').textContent = order.PhuongThucThanhToan;
            document.getElementById('modalOrderNote').textContent = order.GhiChu || 'Không có';

            const itemsContainer = document.getElementById('modalOrderItems');
            itemsContainer.innerHTML = '';
            
            details.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.TenThietBi}</td>
                    <td>${item.SoLuong}</td>
                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.Gia)}</td>
                    <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.Gia * item.SoLuong)}</td>
                `;
                itemsContainer.appendChild(row);
            });
        }
    });
    </script>
</div> 