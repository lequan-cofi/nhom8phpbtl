<?php
require_once '../config/database.php';
require_once '../models/Blog.php';

$db = db_connect();
$blogModel = new Blog($db);

// Nếu có tham số id, hiển thị chi tiết bài viết
if (isset($_GET['id'])) {
    $blog = $blogModel->getBlogById($_GET['id']);
    if (!$blog) {
        echo "<h2>Blog not found!</h2>";
        exit;
    }
    ?>
    <div class="blog-container">
        <div class="blog-detail">
            <a href="blog.php" class="btn-secondary">&larr; Tin Tức</a>
            <h1><?= htmlspecialchars($blog['title']) ?></h1>
            <div class="meta">
                <b>Category:</b> <?= htmlspecialchars($blog['category']) ?> | <b>Date:</b> <?= $blog['created_date'] ?>
            </div>
            <div class="content"><?= nl2br(htmlspecialchars($blog['content'])) ?></div>
            <?php if ($blog['image']): ?>
                <img src="<?= htmlspecialchars($blog['image']) ?>" alt="Blog Image">
            <?php endif; ?>
        </div>
    </div>
    <?php
    exit;
}

// Nếu không có id, hiển thị danh sách
$blogs = $blogModel->getAllBlogs(5);
?>
<div class="blog-container">
    <h1>Tin Tức</h1>
    <div class="blog-list">
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-card">
                <?php if ($blog['image']): ?>
                    <img src="<?= htmlspecialchars($blog['image']) ?>" alt="Blog Image">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars(mb_substr($blog['content'], 0, 100)) ?>...</p>
                    <a href="blog.php?id=<?= $blog['id'] ?>" class="btn-primary">Xem thêm</a>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= $blog['category'] ?> | <?= $blog['created_date'] ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

