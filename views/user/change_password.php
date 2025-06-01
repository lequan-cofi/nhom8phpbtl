<div class="container py-4">
    <h2>Đổi mật khẩu</h2>
    <?php if (!empty($msg)): ?>
        <div class="alert alert-info"> <?= htmlspecialchars($msg) ?> </div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div> 