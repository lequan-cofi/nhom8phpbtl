<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../controllers/LienHeController.php';
$controller = new LienHeController();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Quản lý liên hệ</h1>

    <!-- Filter buttons -->
    <div class="mb-3">
        <button class="btn btn-primary" onclick="loadContacts('all')">Tất cả</button>
        <button class="btn btn-warning" onclick="loadContacts('Chưa xử lý')">Chưa xử lý</button>
        <button class="btn btn-success" onclick="loadContacts('Đã xử lý')">Đã xử lý</button>
    </div>

    <!-- Contacts table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="contactsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Chủ đề</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Response Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Phản hồi liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="responseForm">
                        <input type="hidden" id="contactId" name="IDLienHe">
                        <div class="form-group">
                            <label for="responseContent">Nội dung phản hồi</label>
                            <textarea class="form-control" id="responseContent" name="NoiDung" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="submitResponse()">Gửi phản hồi</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load contacts based on status
function loadContacts(status = 'all') {
    $.ajax({
        url: 'controllers/LienHeController.php',
        type: 'GET',
        data: {
            action: 'getAll'
        },
        success: function(response) {
            if (response.success) {
                let contacts = response.data;
                if (status !== 'all') {
                    contacts = contacts.filter(contact => contact.TrangThai === status);
                }
                displayContacts(contacts);
            }
        }
    });
}

// Display contacts in table
function displayContacts(contacts) {
    const tbody = $('#contactsTable tbody');
    tbody.empty();

    contacts.forEach(contact => {
        const row = `
            <tr>
                <td>${contact.ID}</td>
                <td>${contact.HoTen}</td>
                <td>${contact.Email}</td>
                <td>${contact.ChuDe}</td>
                <td>${contact.NoiDung}</td>
                <td>
                    <span class="badge badge-${contact.TrangThai === 'Chưa xử lý' ? 'warning' : 'success'}">
                        ${contact.TrangThai}
                    </span>
                </td>
                <td>${new Date(contact.NgayTao).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="showResponseModal(${contact.ID})">
                        Phản hồi
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Show response modal
function showResponseModal(contactId) {
    $('#contactId').val(contactId);
    $('#responseContent').val('');
    $('#responseModal').modal('show');
}

// Submit response
function submitResponse() {
    const formData = new FormData($('#responseForm')[0]);
    formData.append('action', 'submitResponse');

    $.ajax({
        url: 'controllers/LienHeController.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#responseModal').modal('hide');
                loadContacts();
                alert('Gửi phản hồi thành công!');
            } else {
                alert('Lỗi: ' + response.message);
            }
        }
    });
}

// Load contacts on page load
$(document).ready(function() {
    loadContacts();
});
</script>

<?php require_once 'partials/footer.php'; ?> 