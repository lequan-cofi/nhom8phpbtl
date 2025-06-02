<?php require_once 'partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../models/Phanhoi_Model.php';
require_once __DIR__ . '/../../models/Phanhoi_lienheModel.php';

$lienHeModel = new LienHeModel();
$phanHoiModel = new Phanhoi_lienheModel();

// Xử lý thêm phản hồi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reply'])) {
    try {
        // Thêm phản hồi mới
        $data = [
            'IDLienHe' => $_POST['IDLienHe'],
            'NoiDung' => $_POST['NoiDungPhanHoi']
        ];
        
        if ($phanHoiModel->create($data)) {
            // Cập nhật trạng thái liên hệ
            $newStatus = $_POST['TrangThai'] ?? 'Đã xử lý';
            // Đảm bảo giá trị trạng thái hợp lệ
            $validStatuses = ['Chưa xử lý', 'Đã xử lý'];
            if (!in_array($newStatus, $validStatuses)) {
                $newStatus = 'Đã xử lý';
            }
            
            if ($lienHeModel->updateStatus($_POST['IDLienHe'], $newStatus)) {
                $_SESSION['success'] = "Phản hồi đã được gửi thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật trạng thái!";
            }
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi gửi phản hồi!";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
    }
    
    // Chuyển hướng với các tham số tìm kiếm và lọc
    $redirectParams = [];
    if (isset($_GET['search'])) $redirectParams['search'] = $_GET['search'];
    if (isset($_GET['status'])) $redirectParams['status'] = $_GET['status'];
    if (isset($_GET['page'])) $redirectParams['page'] = $_GET['page'];
    
    $redirectUrl = $_SERVER['PHP_SELF'];
    if (!empty($redirectParams)) {
        $redirectUrl .= '?' . http_build_query($redirectParams);
    }
    
    header('Location: ' . $redirectUrl);
    exit();
}

// Lấy tất cả liên hệ
$contacts = $lienHeModel->getAll()->fetchAll(PDO::FETCH_ASSOC);

// Tìm kiếm theo email hoặc ID
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $contacts = array_filter($contacts, function($contact) use ($search) {
        return stripos($contact['Email'], $search) !== false || 
               stripos((string)$contact['ID'], $search) !== false;
    });
}

// Lọc theo trạng thái
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
if ($statusFilter !== 'all') {
    $contacts = array_filter($contacts, function($contact) use ($statusFilter) {
        return $contact['TrangThai'] === $statusFilter;
    });
}

// Phân trang
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$totalContacts = count($contacts);
$totalPages = ceil($totalContacts / $perPage);
$contacts = array_slice($contacts, ($page - 1) * $perPage, $perPage);

// Lấy tất cả phản hồi cho từng liên hệ
$allReplies = [];
foreach ($contacts as $c) {
    $allReplies[$c['ID']] = $phanHoiModel->getByLienHe($c['ID']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phản hồi liên hệ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Quản lý phản hồi liên hệ</h5>
                        <form method="GET" class="form-inline">
                            <input type="text" name="search" class="form-control mr-2" placeholder="Tìm theo Email/ID" value="<?php echo htmlspecialchars($search); ?>">
                            <select name="status" class="form-control mr-2">
                                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>Tất cả trạng thái</option>
                                <option value="Chưa xử lý" <?php echo $statusFilter === 'Chưa xử lý' ? 'selected' : ''; ?>>Chưa xử lý</option>
                                <option value="Đã xử lý" <?php echo $statusFilter === 'Đã xử lý' ? 'selected' : ''; ?>>Đã xử lý</option>
                            </select>
                            <button type="submit" class="btn btn-light">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Chủ đề</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['HoTen']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['ChuDe']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($contact['NoiDung'])); ?></td>
                                    <td>
                                        <?php
                                        $tt = $contact['TrangThai'];
                                        $color = 'gray';
                                        if ($tt == 'Chưa xử lý') $color = '#ffc107'; // vàng
                                        elseif ($tt == 'Đã xử lý') $color = '#28a745'; // xanh lá
                                        ?>
                                        <span style="color:<?php echo $color; ?>;font-weight:bold">
                                            <?php echo htmlspecialchars($tt); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($contact['NgayTao']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#replyModal<?php echo $contact['ID']; ?>">
                                            <i class="fas fa-reply"></i> Phản hồi
                                        </button>
                                        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#historyModal<?php echo $contact['ID']; ?>">
                                            <i class="fas fa-history"></i> Lịch sử phản hồi
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Phân trang -->
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

<!-- Modal Phản hồi -->
<?php foreach ($contacts as $contact): ?>
<div class="modal fade" id="replyModal<?php echo $contact['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel<?php echo $contact['ID']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST">
            <input type="hidden" name="IDLienHe" value="<?php echo $contact['ID']; ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel<?php echo $contact['ID']; ?>">Phản hồi liên hệ #<?php echo $contact['ID']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <strong>Họ tên:</strong> <?php echo htmlspecialchars($contact['HoTen']); ?><br>
                    <strong>Email:</strong> <?php echo htmlspecialchars($contact['Email']); ?><br>
                    <strong>Chủ đề:</strong> <?php echo htmlspecialchars($contact['ChuDe']); ?><br>
                    <strong>Nội dung:</strong> <?php echo nl2br(htmlspecialchars($contact['NoiDung'])); ?><br>
                </div>
                <?php
                $replies = $allReplies[$contact['ID']];
                if ($replies && count($replies) > 0): ?>
                    <div class="mb-2">
                        <strong>Lịch sử phản hồi:</strong>
                        <ul class="list-group mb-2">
                            <?php foreach ($replies as $reply): ?>
                                <li class="list-group-item">
                                    <div><b>Thời gian:</b> <?php echo htmlspecialchars($reply['NgayTao']); ?></div>
                                    <div><b>Nội dung:</b> <?php echo nl2br(htmlspecialchars($reply['NoiDung'])); ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="NoiDungPhanHoi">Nội dung phản hồi</label>
                    <textarea name="NoiDungPhanHoi" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="TrangThai">Cập nhật trạng thái liên hệ</label>
                    <select name="TrangThai" class="form-control">
                        <option value="Đã xử lý" <?php if($contact['TrangThai']=='Đã xử lý') echo 'selected'; ?>>Đã xử lý</option>
                        <option value="Chưa xử lý" <?php if($contact['TrangThai']=='Chưa xử lý') echo 'selected'; ?>>Chưa xử lý</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" name="add_reply" class="btn btn-primary">Gửi phản hồi</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<?php foreach ($contacts as $contact): ?>
<div class="modal fade" id="historyModal<?php echo $contact['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel<?php echo $contact['ID']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel<?php echo $contact['ID']; ?>">Lịch sử phản hồi liên hệ #<?php echo $contact['ID']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $replies = $allReplies[$contact['ID']];
                if ($replies && count($replies) > 0): ?>
                    <ul class="list-group mb-2">
                        <?php foreach ($replies as $reply): ?>
                            <li class="list-group-item">
                                <div><b>Thời gian:</b> <?php echo htmlspecialchars($reply['NgayTao']); ?></div>
                                <div><b>Nội dung:</b> <?php echo nl2br(htmlspecialchars($reply['NoiDung'])); ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-info">Chưa có phản hồi nào.</div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>
