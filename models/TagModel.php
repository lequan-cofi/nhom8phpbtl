<?php
require_once 'Database.php';

class TagModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Create a new tag
    public function createTag($data) {
        $sql = "INSERT INTO the (TenThe, Slug, MoTa) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TenThe'],
            $data['Slug'],
            $data['MoTa']
        ]);
    }

    // Get all tags
    public function getAllTags() {
        $sql = "SELECT * FROM the ORDER BY TenThe ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single tag by ID
    public function getTagById($id) {
        $sql = "SELECT * FROM the WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a tag
    public function updateTag($id, $data) {
        $sql = "UPDATE the SET 
                TenThe = ?, 
                Slug = ?, 
                MoTa = ? 
                WHERE ID = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TenThe'],
            $data['Slug'],
            $data['MoTa'],
            $id
        ]);
    }

    // Delete a tag
    public function deleteTag($id) {
        // First delete tag associations
        $sql = "DELETE FROM bai_viet_the WHERE TheID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        // Then delete the tag
        $sql = "DELETE FROM the WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Get posts by tag
    public function getPostsByTag($tagId, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT bv.*, dm.TenDanhMuc 
                FROM bai_viet bv 
                INNER JOIN bai_viet_the bvt ON bv.ID = bvt.BaiVietID 
                LEFT JOIN danh_muc dm ON bv.DanhMucID = dm.ID 
                WHERE bvt.TheID = ? 
                ORDER BY bv.NgayTao DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tagId, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get popular tags
    public function getPopularTags($limit = 10) {
        $sql = "SELECT t.*, COUNT(bvt.BaiVietID) as post_count 
                FROM the t 
                INNER JOIN bai_viet_the bvt ON t.ID = bvt.TheID 
                GROUP BY t.ID 
                ORDER BY post_count DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search tags
    public function searchTags($keyword) {
        $keyword = "%$keyword%";
        $sql = "SELECT * FROM the WHERE TenThe LIKE ? OR MoTa LIKE ? ORDER BY TenThe ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 