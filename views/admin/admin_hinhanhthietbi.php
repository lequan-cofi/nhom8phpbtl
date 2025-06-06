<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../controllers/HinhanhthietbiController.php';
require_once __DIR__ . '/../../config/database.php';

$controller = new HinhanhthietbiController();
$images = $controller->getAll();

$db = db_connect();
$thietbi = $db->query("SELECT t.ID, t.Ten, l.Ten AS TenLoaiThietBi, t.IDLoaiThietBi FROM thietbi t LEFT JOIN loaithietbi l ON t.IDLoaiThietBi = l.ID WHERE t.NgayXoa IS NULL")->fetchAll(PDO::FETCH_ASSOC);
$thietbiMap = [];
$loaiThietBi = [];
foreach ($thietbi as $tb) {
    $thietbiMap[$tb['ID']] = $tb;
    if ($tb['IDLoaiThietBi'] && $tb['TenLoaiThietBi']) {
        $loaiThietBi[$tb['IDLoaiThietBi']] = $tb['TenLoaiThietBi'];
    }
}

// Lọc
$filterLoai = isset($_GET['loai']) ? $_GET['loai'] : '';
$filterAnhChinh = isset($_GET['anhchinh']) ? $_GET['anhchinh'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sortName = isset($_GET['sort_name']) ? $_GET['sort_name'] : '';

$images = array_filter($images, function($img) use ($filterLoai, $filterAnhChinh, $search, $thietbiMap) {
    $tb = $thietbiMap[$img['IDThietBi']] ?? null;
    if (!$tb) return false;
    if ($filterLoai !== '' && $tb['IDLoaiThietBi'] != $filterLoai) return false;
    if ($filterAnhChinh !== '' && $img['LaAnhChinh'] != $filterAnhChinh) return false;
    if ($search !== '' && stripos($tb['Ten'], $search) === false && stripos($tb['TenLoaiThietBi'], $search) === false) return false;
    return true;
});

// Sắp xếp tên thiết bị alpha
if ($sortName === 'az') {
    usort($images, function($a, $b) use ($thietbiMap) {
        return strcmp($thietbiMap[$a['IDThietBi']]['Ten'], $thietbiMap[$b['IDThietBi']]['Ten']);
    });
} elseif ($sortName === 'za') {
    usort($images, function($a, $b) use ($thietbiMap) {
        return strcmp($thietbiMap[$b['IDThietBi']]['Ten'], $thietbiMap[$a['IDThietBi']]['Ten']);
    });
}

// Phân trang
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$totalImages = count($images);
$totalPages = ceil($totalImages / $perPage);
$images = array_values($images);
$images = array_slice($images, ($page - 1) * $perPage, $perPage);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Hình ảnh Thiết bị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Hình ảnh Thiết bị</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <!-- Form lọc -->
                    <form method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm theo tên hoặc loại thiết bị" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="loai" class="form-control mr-2">
                            <option value="">Tất cả loại thiết bị</option>
                            <?php foreach ($loaiThietBi as $id => $ten): ?>
                                <option value="<?php echo $id; ?>" <?php if($filterLoai == $id) echo 'selected'; ?>><?php echo htmlspecialchars($ten); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="anhchinh" class="form-control mr-2">
                            <option value="">Tất cả ảnh</option>
                            <option value="1" <?php if($filterAnhChinh==='1') echo 'selected'; ?>>Ảnh chính</option>
                            <option value="0" <?php if($filterAnhChinh==='0') echo 'selected'; ?>>Ảnh phụ</option>
                        </select>
                        <select name="sort_name" class="form-control mr-2">
                            <option value="">Sắp xếp tên thiết bị</option>
                            <option value="az" <?php if($sortName==='az') echo 'selected'; ?>>A-Z</option>
                            <option value="za" <?php if($sortName==='za') echo 'selected'; ?>>Z-A</option>
                        </select>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc/Sắp xếp</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Thiết bị</th>
                                    <th>Loại thiết bị</th>
                                    <th>Hình ảnh</th>
                                    <th>Ảnh chính</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($images as $img): ?>
                                <tr>
                                    <td><?= $img['ID'] ?></td>
                                    <td><?= htmlspecialchars($thietbiMap[$img['IDThietBi']]['Ten'] ?? 'Không rõ') ?></td>
                                    <td><?= htmlspecialchars($thietbiMap[$img['IDThietBi']]['TenLoaiThietBi'] ?? 'Không rõ') ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($img['DuongDanHinhAnh']) ?>" alt="Ảnh thiết bị" class="img-thumbnail" style="max-width: 100px;">
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $img['LaAnhChinh'] ? 'success' : 'secondary' ?>">
                                            <?= $img['LaAnhChinh'] ? 'Chính' : 'Phụ' ?>
                                        </span>
                                    </td>
                                    <td><?= $img['NgayTao'] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-image" data-id="<?= $img['ID'] ?>" data-toggle="modal" data-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-image" data-id="<?= $img['ID'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- PHÂN TRANG -->
                    <?php if ($totalPages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?<?php
                                        $params = $_GET;
                                        $params['page'] = $i;
                                        echo http_build_query($params);
                                    ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Thêm hình ảnh thiết bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Thiết bị</label>
                        <select name="IDThietBi" class="form-control" required>
                            <?php foreach ($thietbi as $tb): ?>
                                <option value="<?= $tb['ID'] ?>"><?= htmlspecialchars($tb['Ten']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <div class="input-group">
                            <input type="text" name="DuongDanHinhAnh" class="form-control" id="DuongDanHinhAnh" required placeholder="Dán link hoặc upload file">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="btnUpload">Upload</button>
                                <input type="file" id="fileUpload" style="display:none" accept="image/*">
                            </div>
                        </div>
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label>Ảnh chính?</label>
                        <select name="LaAnhChinh" class="form-control">
                            <option value="0">Phụ</option>
                            <option value="1">Chính</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Sửa hình ảnh thiết bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="ID" id="editID">
                    <div class="form-group">
                        <label>Thiết bị</label>
                        <select name="IDThietBi" class="form-control" id="editIDThietBi" required>
                            <?php foreach ($thietbi as $tb): ?>
                                <option value="<?= $tb['ID'] ?>"><?= htmlspecialchars($tb['Ten']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <div class="input-group">
                            <input type="text" name="DuongDanHinhAnh" class="form-control" id="editDuongDanHinhAnh" required placeholder="Dán link hoặc upload file">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="btnEditUpload">Upload</button>
                                <input type="file" id="editFileUpload" style="display:none" accept="image/*">
                            </div>
                        </div>
                        <small class="form-text text-muted">Chọn 1 trong 2: dán link ảnh hoặc upload file. Nếu nhập cả 2 sẽ ưu tiên link.</small>
                    </div>
                    <div class="form-group">
                        <label>Ảnh chính?</label>
                        <select name="LaAnhChinh" class="form-control" id="editLaAnhChinh">
                            <option value="0">Phụ</option>
                            <option value="1">Chính</option>
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

<script>
$('#addForm').on('submit', function(e) {
    e.preventDefault();
    $.post('../../controllers/HinhanhthietbiController.php?action=create', $(this).serialize(), function(res) {
        if(res.success) location.reload();
        else alert('Lỗi: ' + (res.message || 'Không xác định'));
    }, 'json');
});

$('.delete-image').click(function() {
    if(confirm('Bạn có chắc chắn muốn xoá hình ảnh này?')) {
        var id = $(this).data('id');
        $.post('../../controllers/HinhanhthietbiController.php?action=delete', {id: id}, function(res) {
            if(res.success) location.reload();
            else alert('Lỗi: ' + (res.message || 'Không xác định'));
        }, 'json');
    }
});

$('.edit-image').click(function() {
    var id = $(this).data('id');
    $.get('../../controllers/HinhanhthietbiController.php?action=getOne&id=' + id, function(res) {
        if(res.success) {
            var img = res.data;
            $('#editID').val(img.ID);
            $('#editIDThietBi').val(img.IDThietBi);
            $('#editDuongDanHinhAnh').val(img.DuongDanHinhAnh);
            $('#editLaAnhChinh').val(img.LaAnhChinh);
            $('#editModal').modal('show');
        } else {
            alert('Không tìm thấy dữ liệu!');
        }
    }, 'json');
});

$('#editForm').on('submit', function(e) {
    e.preventDefault();
    $.post('../../controllers/HinhanhthietbiController.php?action=update', $(this).serialize(), function(res) {
        if(res.success) location.reload();
        else alert('Lỗi: ' + (res.message || 'Không xác định'));
    }, 'json');
});

// Upload cho thêm mới
$('#btnUpload').click(function() {
    $('#fileUpload').click();
});
$('#fileUpload').change(function() {
    var file = this.files[0];
    if (!file) return;
    var formData = new FormData();
    formData.append('image', file);
    $.ajax({
        url: '../../controllers/upload.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.success) {
                $('#DuongDanHinhAnh').val(res.path);
            } else {
                alert('Lỗi upload: ' + (res.message || 'Không xác định'));
            }
        }
    });
});
// Upload cho sửa
$('#btnEditUpload').click(function() {
    $('#editFileUpload').click();
});
$('#editFileUpload').change(function() {
    var file = this.files[0];
    if (!file) return;
    var formData = new FormData();
    formData.append('image', file);
    $.ajax({
        url: '../../controllers/upload.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.success) {
                $('#editDuongDanHinhAnh').val(res.path);
            } else {
                alert('Lỗi upload: ' + (res.message || 'Không xác định'));
            }
        }
    });
});
</script>
<?php require_once 'partials/footer.php'; ?>
</body>
</html>