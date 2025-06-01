<div class="container py-4">
    <h2>Hồ sơ cá nhân</h2>
    <table class="table table-bordered w-50">
        <tr><th>Họ tên</th><td><?= htmlspecialchars($user['Ten'] ?? '') ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($user['Email'] ?? '') ?></td></tr>
        <tr><th>Số điện thoại</th><td><?= htmlspecialchars($user['SoDienThoai'] ?? '') ?></td></tr>
        <tr><th>Địa chỉ</th><td><?= htmlspecialchars($user['DiaChi'] ?? '') ?></td></tr>
        <tr><th>Giới tính</th><td><?= htmlspecialchars($user['GioiTinh'] ?? '') ?></td></tr>
    </table>
    <a href="?page=user&action=changePassword" class="btn btn-warning">Đổi mật khẩu</a>
    <a href="?page=user&action=address" class="btn btn-info">Sửa địa chỉ</a>
</div> 