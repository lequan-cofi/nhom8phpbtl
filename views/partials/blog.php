<?php
require_once '../config/database.php';
require_once '../models/Blog.php';

$db = db_connect();
$blogModel = new Blog($db);

// Nếu có tham số id, hiển thị chi tiết bài viết
if (isset($_GET['id'])) {
    $blog = $blogModel->getBlogById($_GET['id']);
    if (!$blog || !isset($blog['status']) || $blog['status'] !== 'published') {
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
$blogs = array_filter($blogModel->getAllBlogs(5), function($blog) {
    return isset($blog['status']) && $blog['status'] === 'published';
});
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
                    <a href="javascript:void(0)" class="btn-primary view-blog" data-id="<?= $blog['id'] ?>">Xem thêm</a>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= $blog['category'] ?> | <?= $blog['created_date'] ?></small>
                </div>
            </div>
            <div class="blog-detail-content" id="blog-detail-<?= $blog['id'] ?>" style="display:none;">
                <h1><?= htmlspecialchars($blog['title']) ?></h1>
                <div class="meta">
                    <b>Category:</b> <?= htmlspecialchars($blog['category']) ?> | <b>Date:</b> <?= $blog['created_date'] ?>
                </div>
                <?php if ($blog['image']): ?>
                    <img src="<?= htmlspecialchars($blog['image']) ?>" alt="Blog Image">
                <?php endif; ?>
                <div class="content"><?= nl2br(htmlspecialchars($blog['content'])) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Blog Detail Popup -->
<div id="blogPopup" class="popup-overlay">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <div id="blogDetail">
            <!-- Blog content will be loaded here -->
        </div>
    </div>
</div>

<style>
.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;
}

.popup-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    max-width: 800px;
    max-height: 80vh;
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.close-popup {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #666;
}

.close-popup:hover {
    color: #000;
}

.blog-detail {
    padding: 20px;
}

.blog-detail h1 {
    margin-bottom: 20px;
    color: #333;
}

.blog-detail .meta {
    margin-bottom: 20px;
    color: #666;
}

.blog-detail .content {
    line-height: 1.6;
    color: #444;
}

.blog-detail img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 4px;
}

.loading {
    text-align: center;
    padding: 20px;
    font-size: 18px;
    color: #666;
}

.error-message {
    text-align: center;
    padding: 20px;
    color: #721c24;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    margin: 20px;
}

.error-message button {
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.error-message button:hover {
    background-color: #c82333;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('blogPopup');
    const closeBtn = document.querySelector('.close-popup');
    const blogDetail = document.getElementById('blogDetail');

    closeBtn.onclick = function() {
        popup.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }

    document.querySelectorAll('.view-blog').forEach(button => {
        button.addEventListener('click', function() {
            const blogId = this.getAttribute('data-id');
            const detailDiv = document.getElementById('blog-detail-' + blogId);
            if (detailDiv) {
                blogDetail.innerHTML = detailDiv.innerHTML;
                popup.style.display = "block";
            }
        });
    });
});
</script>

