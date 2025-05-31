<?php
require_once __DIR__ . '/../models/Blog.php';

class Tintuc_layoutController {
    public function index() {
        $db = db_connect();
        $blogModel = new Blog($db);
        $blogs = $blogModel->getAllBlogs(); // Lấy tất cả blog, có thể giới hạn nếu muốn
        // Truyền biến $blogs sang layout
        $data = [
            'blogs' => $blogs,
            'pageTitle' => 'Tin Tức - iStore'
        ];
        if (isset($data) && is_array($data)) extract($data);
        require_once __DIR__ . '/../views/layouts/tintuc_layout.php';
    }
} 