<?php require_once 'partials/header.php'; ?>
<?php
require_once '../../config/database.php';
require_once '../../models/Blog.php';

$db = db_connect();
$blogModel = new Blog($db);

// Lấy dữ liệu blog cần sửa nếu có
$editBlog = null;
if (isset($_POST['action']) && $_POST['action'] === 'show_edit') {
    $editBlog = $blogModel->getBlogById($_POST['blog_id']);
}

// Thêm blog
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $image = '';
    if (!empty($_POST['image_url'])) {
        $image = $_POST['image_url'];
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/blogs/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = 'uploads/blogs/' . $fileName;
        }
    }
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'category' => $_POST['category'],
        'author' => 1, // hoặc $_SESSION['user_id']
        'image' => $image,
        'status' => $_POST['status']
    ];
    $blogModel->createBlog($data);
    header('Location: admin_blog.php');
    exit;
}

// Sửa blog
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $image = '';
    if (!empty($_POST['image_url'])) {
        $image = $_POST['image_url'];
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/blogs/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = 'uploads/blogs/' . $fileName;
        }
    } else if (!empty($_POST['old_image'])) {
        $image = $_POST['old_image'];
    }
    $data = [
        'blog_id' => $_POST['blog_id'],
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'category' => $_POST['category'],
        'image' => $image,
        'status' => $_POST['status']
    ];
    $blogModel->updateBlog($data);
    header('Location: admin_blog.php');
    exit;
}

// Xóa blog
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $blogModel->deleteBlog($_POST['blog_id']);
    header('Location: admin_blog.php');
    exit;
}

// Lấy danh sách blog
$blogs = $blogModel->getAllBlogs();

// Tìm kiếm theo tiêu đề
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $blogs = array_filter($blogs, function($blog) use ($search) {
        return stripos($blog['title'], $search) !== false;
    });
}

// Lọc theo trạng thái
$status = isset($_GET['status']) ? $_GET['status'] : '';
if ($status !== '') {
    $blogs = array_filter($blogs, function($blog) use ($status) {
        return $blog['status'] === $status;
    });
}

// Phân trang
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$totalBlogs = count($blogs);
$totalPages = ceil($totalBlogs / $perPage);
$blogs = array_values($blogs); // reset key
$blogs = array_slice($blogs, ($page - 1) * $perPage, $perPage);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog</title>
    <!-- Bootstrap 4.6.0 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome 5.15.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quản lý Blog</h5>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addBlogModal">
                        <i class="fas fa-plus"></i> Thêm mới Blog
                    </button>
                </div>
                <div class="card-body">
                    <!-- Form lọc và tìm kiếm -->
                    <form method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm theo tiêu đề" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="status" class="form-control mr-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="published" <?php if($status=='published') echo 'selected'; ?>>Đã đăng</option>
                            <option value="draft" <?php if($status=='draft') echo 'selected'; ?>>Nháp</option>
                        </select>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Chuyên mục</th>
                                    <th>Tác giả</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blogs as $blog): ?>
                                    <tr>
                                        <td><?php echo $blog['id']; ?></td>
                                        <td><?php echo htmlspecialchars($blog['title']); ?></td>
                                        <td><?php echo htmlspecialchars($blog['category']); ?></td>
                                        <td><?php echo $blog['author']; ?></td>
                                        <td><?php echo $blog['created_date']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $blog['status'] === 'published' ? 'success' : 'warning'; ?>">
                                                <?php echo $blog['status'] === 'published' ? 'Đã đăng' : 'Nháp'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                                <button type="submit" name="action" value="show_edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Sửa</button>
                                            </form>
                                            <form method="post" style="display:inline;" onsubmit="return confirm('Xác nhận xóa?');">
                                                <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                                <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Xóa</button>
                                            </form>
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

<!-- Modal Thêm Blog -->
<div class="modal fade" id="addBlogModal" tabindex="-1" role="dialog" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlogModalLabel">Thêm Blog mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBlogForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Chuyên mục</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">-- Chọn chuyên mục --</option>
                            <option value="technology">Công nghệ</option>
                            <option value="lifestyle">Đời sống</option>
                            <option value="business">Kinh doanh</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Chọn file ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="image_url">Hoặc dán link ảnh</label>
                        <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="published">Đã đăng</option>
                            <option value="draft">Nháp</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Blog -->
<div class="modal fade<?php if($editBlog) echo ' show d-block'; ?>" id="editBlogModal" tabindex="-1" role="dialog" aria-labelledby="editBlogModalLabel" aria-hidden="true" style="<?php if($editBlog) echo 'display:block; background:rgba(0,0,0,0.5);'; ?>">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBlogModalLabel">Sửa Blog</h5>
                <a href="admin_blog.php" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></a>
            </div>
            <form id="editBlogForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="blog_id" value="<?php echo $editBlog['id'] ?? ''; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">Tiêu đề</label>
                        <input type="text" class="form-control" id="edit_title" name="title" value="<?php echo htmlspecialchars($editBlog['title'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_category">Chuyên mục</label>
                        <select class="form-control" id="edit_category" name="category" required>
                            <option value="technology" <?php if(isset($editBlog['category']) && $editBlog['category']==='technology') echo 'selected'; ?>>Công nghệ</option>
                            <option value="lifestyle" <?php if(isset($editBlog['category']) && $editBlog['category']==='lifestyle') echo 'selected'; ?>>Đời sống</option>
                            <option value="business" <?php if(isset($editBlog['category']) && $editBlog['category']==='business') echo 'selected'; ?>>Kinh doanh</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_content">Nội dung</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="5" required><?php echo htmlspecialchars($editBlog['content'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Chọn file ảnh</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="edit_image_url">Hoặc dán link ảnh</label>
                        <input type="url" class="form-control" id="edit_image_url" name="image_url" value="<?php echo htmlspecialchars($editBlog['image'] ?? ''); ?>" placeholder="https://...">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($editBlog['image'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Trạng thái</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="published" <?php if(isset($editBlog['status']) && $editBlog['status']==='published') echo 'selected'; ?>>Đã đăng</option>
                            <option value="draft" <?php if(isset($editBlog['status']) && $editBlog['status']==='draft') echo 'selected'; ?>>Nháp</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="admin_blog.php" class="btn btn-secondary">Đóng</a>
                    <button type="submit" class="btn btn-primary">Cập nhật Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 4.6.0 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>
