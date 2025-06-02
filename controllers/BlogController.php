<?php

require_once 'models/Blog.php';

class BlogController {
    private $blogModel;
    private $uploadDir = 'uploads/blogs/';

    public function __construct($db) {
        $this->blogModel = new Blog($db);
        
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function list() {
        try {
            $blogs = $this->blogModel->getAllBlogs();
            // Chỉ lấy blog published
            $blogs = array_filter($blogs, function($blog) {
                return isset($blog['status']) && $blog['status'] === 'published';
            });
            echo json_encode(['status' => 'success', 'data' => array_values($blogs)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function get($id) {
        try {
            $blog = $this->blogModel->getBlogById($id);
            if ($blog && isset($blog['status']) && $blog['status'] === 'published') {
                echo json_encode(['status' => 'success', 'data' => $blog]);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Blog not found or not published']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function create() {
        try {
            // Handle file upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleFileUpload($_FILES['image']);
            }

            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'author' => $_SESSION['user_id'] ?? 1, // Default to admin user if not set
                'image' => $imagePath,
                'status' => $_POST['status']
            ];

            if ($this->blogModel->createBlog($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Blog created successfully']);
            } else {
                throw new Exception('Failed to create blog');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update() {
        try {
            $data = [
                'blog_id' => $_POST['blog_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'status' => $_POST['status']
            ];

            // Handle file upload if new image is provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $this->handleFileUpload($_FILES['image']);
            } else {
                // Keep existing image
                $existingBlog = $this->blogModel->getBlogById($_POST['blog_id']);
                $data['image'] = $existingBlog['image'];
            }

            if ($this->blogModel->updateBlog($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Blog updated successfully']);
            } else {
                throw new Exception('Failed to update blog');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete() {
        try {
            $id = $_POST['blog_id'];
            
            // Get blog to delete its image
            $blog = $this->blogModel->getBlogById($id);
            if ($blog && $blog['image']) {
                $imagePath = $this->uploadDir . basename($blog['image']);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            if ($this->blogModel->deleteBlog($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Blog deleted successfully']);
            } else {
                throw new Exception('Failed to delete blog');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function handleFileUpload($file) {
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $this->uploadDir . $fileName;

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
        }

        // Validate file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception('File size too large. Maximum size is 5MB.');
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $this->uploadDir . $fileName;
        } else {
            throw new Exception('Failed to upload file');
        }
    }
}
