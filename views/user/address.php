<div class="container py-4">
    <h2>Địa chỉ nhận hàng</h2>
    <form method="post" class="w-50">
        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['DiaChi'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div> 