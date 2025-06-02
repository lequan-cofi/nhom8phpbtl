<?php require_once 'partials/header.php'; ?>
<div class="container mt-4">
    <h2>Danh sách toàn bộ phản hồi</h2>
    <a href="../../controllers/phanhoi_controler.php" class="btn btn-secondary mb-3">Quay lại quản lý liên hệ</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Liên hệ</th>
                <th>Nội dung phản hồi</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($phanhois as $ph): ?>
            <tr>
                <td><?= $ph['ID'] ?></td>
                <td><?= $ph['IDLienHe'] ?></td>
                <td><?= htmlspecialchars($ph['NoiDung']) ?></td>
                <td><?= $ph['NgayTao'] ?></td>
                <td><?= $ph['NgayCapNhat'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'partials/footer.php'; ?>