<?php require_once 'partials/header.php'; ?>
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
require_once __DIR__ . '/../../controllers/AdminSalesListController.php';
$adminSalesListController = new AdminSalesListController();
$settings = $adminSalesListController->getAllSettings();
$deviceTypes = $adminSalesListController->getDeviceTypes();
?>

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh sách Ưu đãi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Danh sách Ưu đãi</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addSettingModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Loại thiết bị</th>
                                    <th>Số lượng hiển thị</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($settings as $setting): ?>
                                <tr>
                                    <td><?= htmlspecialchars($setting['ID']) ?></td>
                                    <td><?= htmlspecialchars($setting['TenLoaiThietBi']) ?></td>
                                    <td><?= htmlspecialchars($setting['SoLuongHienThi']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $setting['IsActive'] ? 'success' : 'danger' ?>">
                                            <?= $setting['IsActive'] ? 'Hoạt động' : 'Không hoạt động' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-setting"
                                            data-id="<?= $setting['ID'] ?>"
                                            data-loai="<?= $setting['IDLoaiThietBi'] ?>"
                                            data-soluong="<?= $setting['SoLuongHienThi'] ?>"
                                            data-active="<?= $setting['IsActive'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-setting"
                                            data-id="<?= $setting['ID'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm -->
<div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog" aria-labelledby="addSettingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSettingModalLabel">Thêm cài đặt mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSettingForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="IDLoaiThietBi">Loại thiết bị</label>
                        <select class="form-control select2" id="IDLoaiThietBi" name="IDLoaiThietBi" required>
                            <option value="">Chọn loại thiết bị</option>
                            <?php
                            $uniqueDeviceTypes = [];
                            foreach ($deviceTypes as $type) {
                                if (!in_array($type['Ten'], $uniqueDeviceTypes)) {
                                    $uniqueDeviceTypes[] = $type['Ten'];
                                    echo '<option value="' . htmlspecialchars($type['ID']) . '">' . htmlspecialchars($type['Ten']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoLuongHienThi">Số lượng hiển thị</label>
                        <input type="number" class="form-control" id="SoLuongHienThi" name="SoLuongHienThi" min="1" max="100" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="IsActive" name="IsActive" checked>
                            <label class="custom-control-label" for="IsActive">Hoạt động</label>
                        </div>
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
<div class="modal fade" id="editSettingModal" tabindex="-1" role="dialog" aria-labelledby="editSettingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSettingModalLabel">Chỉnh sửa cài đặt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSettingForm">
                <input type="hidden" id="editID" name="ID">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editIDLoaiThietBi">Loại thiết bị</label>
                        <select class="form-control select2" id="editIDLoaiThietBi" name="IDLoaiThietBi" required>
                            <option value="">Chọn loại thiết bị</option>
                            <?php
                            $uniqueDeviceTypes = [];
                            foreach ($deviceTypes as $type) {
                                if (!in_array($type['Ten'], $uniqueDeviceTypes)) {
                                    $uniqueDeviceTypes[] = $type['Ten'];
                                    echo '<option value="' . htmlspecialchars($type['ID']) . '">' . htmlspecialchars($type['Ten']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editSoLuongHienThi">Số lượng hiển thị</label>
                        <input type="number" class="form-control" id="editSoLuongHienThi" name="SoLuongHienThi" min="1" max="100" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="editIsActive" name="IsActive">
                            <label class="custom-control-label" for="editIsActive">Hoạt động</label>
                        </div>
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
$(document).ready(function() {
    // Khởi tạo select2 riêng cho từng modal
    $('#IDLoaiThietBi').select2({
        theme: 'bootstrap4',
        width: '100%',
        dropdownParent: $('#addSettingModal')
    });
    $('#editIDLoaiThietBi').select2({
        theme: 'bootstrap4',
        width: '100%',
        dropdownParent: $('#editSettingModal')
    });

    // Đóng select2 dropdown khi modal đóng để tránh lỗi aria-hidden
    $('.modal').on('hide.bs.modal', function () {
        $(this).find('select.select2').select2('close');
        // Remove focus from any focused elements
        $(this).find(':focus').blur();
    });

    // Ensure proper focus management when modal is shown
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('input:first, select:first').focus();
    });

    // Reset form and select2 when modal is hidden
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $(this).find('select.select2').val('').trigger('change');
    });

    // Thêm mới
    $('#addSettingForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize() + '&IsActive=' + ($('#IsActive').is(':checked') ? 1 : 0);

        $.post('/iStore_PHP_Backend/controllers/AdminSalesListController.php?action=createSetting', formData, function(response) {
            console.log('RESPONSE:', response, typeof response);
            try {
                const res = JSON.parse(response);
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Lỗi!', res.message || 'Có lỗi xảy ra khi thêm cài đặt', 'error');
                }
            } catch (err) {
                // Nếu lỗi parse JSON, vẫn reload trang (bỏ qua thông báo lỗi)
                location.reload();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
            Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
        });
    });

    // Mở modal sửa
    $('.edit-setting').on('click', function() {
        $('#editID').val($(this).data('id'));
        $('#editIDLoaiThietBi').val($(this).data('loai')).trigger('change');
        $('#editSoLuongHienThi').val($(this).data('soluong'));
        $('#editIsActive').prop('checked', $(this).data('active') == 1);
        $('#editSettingModal').modal('show');
    });

    // Cập nhật
    $('#editSettingForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize() + '&IsActive=' + ($('#editIsActive').is(':checked') ? 1 : 0);

        $.post('/iStore_PHP_Backend/controllers/AdminSalesListController.php?action=updateSetting', formData, function(response) {
            console.log('RESPONSE:', response, typeof response);
            try {
                const res = JSON.parse(response);
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Lỗi!', res.message || 'Có lỗi xảy ra khi cập nhật', 'error');
                }
            } catch (err) {
                // Nếu lỗi parse JSON, vẫn reload trang (bỏ qua thông báo lỗi)
                location.reload();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
            Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
        });
    });

    // Xóa
    $('.delete-setting').on('click', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Không thể hoàn tác sau khi xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if (result.isConfirmed) {
                $.post('/iStore_PHP_Backend/controllers/AdminSalesListController.php', {
                    action: 'deleteSetting',
                    id: id
                }, function(response) {
                    console.log('RESPONSE:', response, typeof response);
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Lỗi!', res.message || 'Không thể xóa.', 'error');
                        }
                    } catch (err) {
                        // Nếu lỗi parse JSON, vẫn reload trang (bỏ qua thông báo lỗi)
                        location.reload();
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    Swal.fire('Lỗi!', 'Không thể kết nối đến máy chủ.', 'error');
                });
            }
        });
    });
});
</script>
<?php require_once 'partials/footer.php'; ?>
</body>
</html>
