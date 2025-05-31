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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Blog Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Blog Management</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                            <i class="fas fa-plus"></i> Add New Blog
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blogs as $blog): ?>
                                        <tr>
                                            <td><?= $blog['id'] ?></td>
                                            <td><?= htmlspecialchars($blog['title']) ?></td>
                                            <td><?= htmlspecialchars($blog['category']) ?></td>
                                            <td><?= $blog['author'] ?></td>
                                            <td><?= $blog['created_date'] ?></td>
                                            <td>
                                                <span class="badge bg-<?= $blog['status'] === 'published' ? 'success' : 'warning' ?>">
                                                    <?= $blog['status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                                                    <button type="submit" name="action" value="show_edit" class="btn btn-sm btn-primary">Edit</button>
                                                </form>
                                                <form method="post" style="display:inline;" onsubmit="return confirm('Xác nhận xóa?');">
                                                    <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
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

    <!-- Add Blog Modal -->
    <div class="modal fade" id="addBlogModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addBlogForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="technology">Technology</option>
                                <option value="lifestyle">Lifestyle</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Chọn file ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Hoặc dán link ảnh</label>
                            <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Blog</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Blog Modal -->
    <div class="modal fade <?php if($editBlog) echo 'show d-block'; ?>" id="editBlogModal" tabindex="-1" style="<?php if($editBlog) echo 'display:block; background:rgba(0,0,0,0.5);'; ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Blog</h5>
                    <a href="admin_blog.php" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <form id="editBlogForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="blog_id" value="<?= $editBlog['id'] ?? '' ?>">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" value="<?= htmlspecialchars($editBlog['title'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category" class="form-label">Category</label>
                            <select class="form-select" id="edit_category" name="category" required>
                                <option value="technology" <?= (isset($editBlog['category']) && $editBlog['category']==='technology')?'selected':'' ?>>Technology</option>
                                <option value="lifestyle" <?= (isset($editBlog['category']) && $editBlog['category']==='lifestyle')?'selected':'' ?>>Lifestyle</option>
                                <option value="business" <?= (isset($editBlog['category']) && $editBlog['category']==='business')?'selected':'' ?>>Business</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_content" class="form-label">Content</label>
                            <textarea class="form-control" id="edit_content" name="content" rows="5" required><?= htmlspecialchars($editBlog['content'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Chọn file ảnh</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="edit_image_url" class="form-label">Hoặc dán link ảnh</label>
                            <input type="url" class="form-control" id="edit_image_url" name="image_url" value="<?= htmlspecialchars($editBlog['image'] ?? '') ?>" placeholder="https://...">
                            <input type="hidden" name="old_image" value="<?= htmlspecialchars($editBlog['image'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="published" <?= (isset($editBlog['status']) && $editBlog['status']==='published')?'selected':'' ?>>Published</option>
                                <option value="draft" <?= (isset($editBlog['status']) && $editBlog['status']==='draft')?'selected':'' ?>>Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Blog</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="admin_blog.php" class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>
