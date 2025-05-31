<?php
require_once 'Database.php';

class BlogModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Create a new blog post
    public function createPost($data) {
        $sql = "INSERT INTO bai_viet (TieuDe, Slug, NoiDungTomTat, NoiDungDayDu, HinhDaiDien, 
                TrangThai, TacGia, DanhMucID, MetaTieuDe, MetaMoTa, NgayXuatBan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TieuDe'],
            $data['Slug'],
            $data['NoiDungTomTat'],
            $data['NoiDungDayDu'],
            $data['HinhDaiDien'],
            $data['TrangThai'],
            $data['TacGia'],
            $data['DanhMucID'],
            $data['MetaTieuDe'],
            $data['MetaMoTa'],
            $data['NgayXuatBan']
        ]);
    }

    // Get all blog posts with pagination
    public function getAllPosts($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT bv.*, dm.TenDanhMuc 
                FROM bai_viet bv 
                LEFT JOIN danh_muc dm ON bv.DanhMucID = dm.ID 
                ORDER BY bv.NgayTao DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single blog post by ID
    public function getPostById($id) {
        $sql = "SELECT bv.*, dm.TenDanhMuc 
                FROM bai_viet bv 
                LEFT JOIN danh_muc dm ON bv.DanhMucID = dm.ID 
                WHERE bv.ID = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a blog post
    public function updatePost($id, $data) {
        $sql = "UPDATE bai_viet SET 
                TieuDe = ?, 
                Slug = ?, 
                NoiDungTomTat = ?, 
                NoiDungDayDu = ?, 
                HinhDaiDien = ?, 
                TrangThai = ?, 
                TacGia = ?, 
                DanhMucID = ?, 
                MetaTieuDe = ?, 
                MetaMoTa = ?, 
                NgayXuatBan = ? 
                WHERE ID = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TieuDe'],
            $data['Slug'],
            $data['NoiDungTomTat'],
            $data['NoiDungDayDu'],
            $data['HinhDaiDien'],
            $data['TrangThai'],
            $data['TacGia'],
            $data['DanhMucID'],
            $data['MetaTieuDe'],
            $data['MetaMoTa'],
            $data['NgayXuatBan'],
            $id
        ]);
    }

    // Delete a blog post
    public function deletePost($id) {
        // First delete related tags
        $sql = "DELETE FROM bai_viet_the WHERE BaiVietID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        // Then delete the post
        $sql = "DELETE FROM bai_viet WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Add tags to a blog post
    public function addTagsToPost($postId, $tagIds) {
        $sql = "INSERT INTO bai_viet_the (BaiVietID, TheID) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        
        foreach ($tagIds as $tagId) {
            $stmt->execute([$postId, $tagId]);
        }
        return true;
    }

    // Get tags for a blog post
    public function getPostTags($postId) {
        $sql = "SELECT t.* FROM the t 
                INNER JOIN bai_viet_the bvt ON t.ID = bvt.TheID 
                WHERE bvt.BaiVietID = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Remove tags from a blog post
    public function removeTagsFromPost($postId, $tagIds) {
        $sql = "DELETE FROM bai_viet_the WHERE BaiVietID = ? AND TheID = ?";
        $stmt = $this->db->prepare($sql);
        
        foreach ($tagIds as $tagId) {
            $stmt->execute([$postId, $tagId]);
        }
        return true;
    }

    // Increment view count
    public function incrementViewCount($id) {
        $sql = "UPDATE bai_viet SET LuotXem = LuotXem + 1 WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Get posts by category
    public function getPostsByCategory($categoryId, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT bv.*, dm.TenDanhMuc 
                FROM bai_viet bv 
                LEFT JOIN danh_muc dm ON bv.DanhMucID = dm.ID 
                WHERE bv.DanhMucID = ? 
                ORDER BY bv.NgayTao DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search posts
    public function searchPosts($keyword, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $keyword = "%$keyword%";
        
        $sql = "SELECT bv.*, dm.TenDanhMuc 
                FROM bai_viet bv 
                LEFT JOIN danh_muc dm ON bv.DanhMucID = dm.ID 
                WHERE bv.TieuDe LIKE ? 
                OR bv.NoiDungTomTat LIKE ? 
                OR bv.NoiDungDayDu LIKE ? 
                ORDER BY bv.NgayTao DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$keyword, $keyword, $keyword, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
