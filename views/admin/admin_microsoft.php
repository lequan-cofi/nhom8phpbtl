<?php require_once 'partials/header.php'; ?>

<?php 
// Initialize $products if not set
if (!isset($products)) {
    $products = [];
}

// Display success/error messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['success'] . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $_SESSION['error'] . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    unset($_SESSION['error']);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý sản phẩm Microsoft</h3>
                    <div class="card-tools">
                        <form class="form-inline mr-3">
                            <select name="khuyenmai" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="">Tất cả khuyến mãi</option>
                                <?php foreach ($khuyenMaiList as $km): ?>
                                    <option value="<?php echo $km['ID']; ?>" <?php echo (isset($_GET['khuyenmai']) && $_GET['khuyenmai'] == $km['ID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($km['TenKhuyenMai']); ?>
                                        (<?php echo $km['MucGiamGia']; ?>%)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                <i class="fas fa-plus"></i> Thêm mới
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Link sản phẩm</th>
                                <th>Khuyến mãi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['ID']; ?></td>
                                    <td><?php echo $product['Ten']; ?></td>
                                    <td><?php echo number_format($product['Gia'], 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo $product['SoLuongTonKho']; ?></td>
                                    <td>
                                        <a href="<?php echo $product['DuongDanLienKet']; ?>" target="_blank">
                                            <?php echo $product['DuongDanLienKet']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($product['TenKhuyenMai']): ?>
                                            <span class="badge badge-info">
                                                <?php echo htmlspecialchars($product['TenKhuyenMai']); ?>
                                                (<?php echo $product['MucGiamGia']; ?>%)
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Không có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-info edit-btn" 
                                                data-toggle="modal" 
                                                data-target="#editModal"
                                                data-id="<?php echo $product['ID']; ?>"
                                                data-title="<?php echo htmlspecialchars($product['Ten']); ?>"
                                                data-price="<?php echo $product['Gia']; ?>"
                                                data-quantity="<?php echo $product['SoLuongTonKho']; ?>"
                                                data-link="<?php echo htmlspecialchars($product['DuongDanLienKet']); ?>"
                                                data-khuyenmai="<?php echo $product['IDKhuyenMai'] ?? ''; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger delete-btn"
                                                data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-id="<?php echo $product['ID']; ?>"
                                                data-title="<?php echo htmlspecialchars($product['Ten']); ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không có sản phẩm nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Thêm sản phẩm Microsoft mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?controller=microsoft&action=create" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_title">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="create_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="create_price">Giá</label>
                        <input type="number" class="form-control" id="create_price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="create_quantity">Số lượng</label>
                        <input type="number" class="form-control" id="create_quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="create_product_link">Link sản phẩm</label>
                        <input type="text" class="form-control" id="create_product_link" name="product_link" required>
                    </div>
                    <div class="form-group">
                        <label for="create_khuyenmai">Chương trình khuyến mãi</label>
                        <select class="form-control" id="create_khuyenmai" name="khuyenmai_id">
                            <option value="">Không có khuyến mãi</option>
                            <?php foreach ($khuyenMaiList as $km): ?>
                                <option value="<?php echo $km['ID']; ?>">
                                    <?php echo htmlspecialchars($km['TenKhuyenMai']); ?>
                                    (<?php echo $km['MucGiamGia']; ?>%)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm Microsoft</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?controller=microsoft&action=edit" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Giá</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_quantity">Số lượng</label>
                        <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_link">Link sản phẩm</label>
                        <input type="text" class="form-control" id="edit_product_link" name="product_link" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_khuyenmai">Chương trình khuyến mãi</label>
                        <select class="form-control" id="edit_khuyenmai" name="khuyenmai_id">
                            <option value="">Không có khuyến mãi</option>
                            <?php foreach ($khuyenMaiList as $km): ?>
                                <option value="<?php echo $km['ID']; ?>">
                                    <?php echo htmlspecialchars($km['TenKhuyenMai']); ?>
                                    (<?php echo $km['MucGiamGia']; ?>%)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?controller=microsoft&action=delete" method="POST">
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sản phẩm "<span id="delete_title"></span>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');
            var price = this.getAttribute('data-price');
            var quantity = this.getAttribute('data-quantity');
            var link = this.getAttribute('data-link');
            var khuyenmai = this.getAttribute('data-khuyenmai');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_product_link').value = link;
            document.getElementById('edit_khuyenmai').value = khuyenmai;
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');

            document.getElementById('delete_id').value = id;
            document.getElementById('delete_title').textContent = title;
        });
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>
