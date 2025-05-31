<?php require_once 'partials/header.php'; ?>
<?php
// views/admin/admin_cuahang.php
require_once __DIR__ . '/../../models/CuahangModel.php';
require_once __DIR__ . '/../../config/database.php';

// Initialize database connection
try {
    $db = db_connect();
    $model = new CuahangModel($db);

    // Handle AJAX requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => ''];

        try {
            if (!isset($_GET['action'])) {
                throw new Exception('Action không hợp lệ');
            }

            switch ($_GET['action']) {
                case 'add':
                    if (empty($_POST['ten']) || empty($_POST['diachi'])) {
                        throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc');
                    }
                    $result = $model->add($_POST['ten'], $_POST['diachi'], $_POST['google_map'] ?? '');
                    if ($result) {
                        $store = $model->getById($db->lastInsertId());
                        $response = [
                            'success' => true,
                            'message' => 'Thêm cửa hàng thành công',
                            'store' => $store
                        ];
                    } else {
                        throw new Exception('Không thể thêm cửa hàng');
                    }
                    break;

                case 'edit':
                    if (empty($_POST['id']) || empty($_POST['ten']) || empty($_POST['diachi'])) {
                        throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc');
                    }
                    $result = $model->update($_POST['id'], $_POST['ten'], $_POST['diachi'], $_POST['google_map'] ?? '');
                    if ($result) {
                        $store = $model->getById($_POST['id']);
                        $response = [
                            'success' => true,
                            'message' => 'Cập nhật cửa hàng thành công',
                            'store' => $store
                        ];
                    } else {
                        throw new Exception('Không thể cập nhật cửa hàng');
                    }
                    break;

                case 'delete':
                    if (empty($_GET['id'])) {
                        throw new Exception('ID cửa hàng không hợp lệ');
                    }
                    $result = $model->delete($_GET['id']);
                    if ($result) {
                        $response = [
                            'success' => true,
                            'message' => 'Xóa cửa hàng thành công'
                        ];
                    } else {
                        throw new Exception('Không thể xóa cửa hàng');
                    }
                    break;

                default:
                    throw new Exception('Action không hợp lệ');
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        echo json_encode($response);
        exit;
    }

    // Get all stores for display
    $cuahangs = $model->getAll();
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cửa hàng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .action-buttons .btn {
            margin: 0 2px;
        }
        #alertContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <h2>Quản lý cửa hàng</h2>
            </div>
            <div class="col text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm cửa hàng mới
                </button>
            </div>
        </div>

        <div id="alertContainer"></div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên cửa hàng</th>
                                <th>Địa chỉ</th>
                                <th>Google Map</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="storeTableBody">
                            <?php if (!empty($cuahangs)): ?>
                                <?php foreach ($cuahangs as $cuahang): ?>
                                    <tr id="store-<?php echo $cuahang['id']; ?>">
                                        <td><?php echo htmlspecialchars($cuahang['id']); ?></td>
                                        <td><?php echo htmlspecialchars($cuahang['ten']); ?></td>
                                        <td><?php echo htmlspecialchars($cuahang['diachi']); ?></td>
                                        <td>
                                            <?php if (!empty($cuahang['google_map'])): ?>
                                                <a href="<?php echo htmlspecialchars($cuahang['google_map']); ?>" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-map-marker-alt"></i> Xem bản đồ
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($cuahang['created_at'])); ?></td>
                                        <td class="action-buttons">
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    onclick="editStore(<?php echo htmlspecialchars(json_encode($cuahang)); ?>)" 
                                                    title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete(<?php echo $cuahang['id']; ?>, '<?php echo htmlspecialchars($cuahang['ten']); ?>')" 
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm cửa hàng mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/iStore_PHP_Backend/public/index.php?page=cuahang&action=add" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ten" class="form-label">Tên cửa hàng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ten" name="ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="diachi" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="diachi" name="diachi" required>
                        </div>
                        <div class="mb-3">
                            <label for="google_map" class="form-label">Link Google Map</label>
                            <input type="url" class="form-control" id="google_map" name="google_map" 
                                   placeholder="https://www.google.com/maps/...">
                            <div class="form-text">Nhập link Google Maps của cửa hàng (nếu có)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Sửa thông tin cửa hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_ten" class="form-label">Tên cửa hàng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_ten" name="ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_diachi" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_diachi" name="diachi" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_google_map" class="form-label">Link Google Map</label>
                            <input type="url" class="form-control" id="edit_google_map" name="google_map" 
                                   placeholder="https://www.google.com/maps/...">
                            <div class="form-text">Nhập link Google Maps của cửa hàng (nếu có)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa cửa hàng "<span id="deleteStoreName"></span>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentDeleteId = null;

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            alertContainer.appendChild(alert);
            setTimeout(() => alert.remove(), 5000);
        }

        function editStore(store) {
            document.getElementById('edit_id').value = store.id;
            document.getElementById('edit_ten').value = store.ten;
            document.getElementById('edit_diachi').value = store.diachi;
            document.getElementById('edit_google_map').value = store.google_map || '';
            document.getElementById('editForm').action = `/iStore_PHP_Backend/public/index.php?page=cuahang&action=edit&id=${store.id}`;
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteStoreName').textContent = name;
            document.getElementById('deleteForm').action = `/iStore_PHP_Backend/public/index.php?page=cuahang&action=delete&id=${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>