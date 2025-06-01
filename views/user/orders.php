<div class="container py-4">
    <h2>Đơn hàng của tôi</h2>
    <?php if (empty($orders)): ?>
        <div class="alert alert-warning">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['ID']) ?></td>
                    <td><?= htmlspecialchars($order['NgayTao']) ?></td>
                    <td><?= htmlspecialchars($order['TrangThaiDonHang']) ?></td>
                    <td><?= number_format($order['TongTien'], 0, ',', '.') ?> đ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div> 