<?php

class Blog {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllBlogs($limit = null) {
        $query = "SELECT * FROM blogs ORDER BY created_date DESC";
        if ($limit !== null) {
            $query .= " LIMIT :limit";
        }
        $stmt = $this->db->prepare($query);
        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBlogById($id) {
        $query = "SELECT * FROM blogs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBlog($data) {
        $query = "INSERT INTO blogs (title, content, category, author, image, status, created_date) 
                 VALUES (:title, :content, :category, :author, :image, :status, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    public function updateBlog($data) {
        $query = "UPDATE blogs SET 
                 title = :title,
                 content = :content,
                 category = :category,
                 image = :image,
                 status = :status,
                 updated_date = NOW()
                 WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $data['blog_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    public function deleteBlog($id) {
        $query = "DELETE FROM blogs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
} 