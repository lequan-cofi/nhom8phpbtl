<?php
require_once 'Database.php';

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Create a new category
    public function createCategory($data) {
        $sql = "INSERT INTO danh_muc (TenDanhMuc, Slug, MoTa, ParentID) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TenDanhMuc'],
            $data['Slug'],
            $data['MoTa'],
            $data['ParentID']
        ]);
    }

    // Get all categories
    public function getAllCategories() {
        $sql = "SELECT * FROM danh_muc ORDER BY TenDanhMuc ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single category by ID
    public function getCategoryById($id) {
        $sql = "SELECT * FROM danh_muc WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a category
    public function updateCategory($id, $data) {
        $sql = "UPDATE danh_muc SET 
                TenDanhMuc = ?, 
                Slug = ?, 
                MoTa = ?, 
                ParentID = ? 
                WHERE ID = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['TenDanhMuc'],
            $data['Slug'],
            $data['MoTa'],
            $data['ParentID'],
            $id
        ]);
    }

    // Delete a category
    public function deleteCategory($id) {
        // First update posts in this category to have no category
        $sql = "UPDATE bai_viet SET DanhMucID = NULL WHERE DanhMucID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        // Then delete the category
        $sql = "DELETE FROM danh_muc WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Get child categories
    public function getChildCategories($parentId) {
        $sql = "SELECT * FROM danh_muc WHERE ParentID = ? ORDER BY TenDanhMuc ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$parentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get category tree
    public function getCategoryTree() {
        $categories = $this->getAllCategories();
        $tree = [];
        
        foreach ($categories as $category) {
            if ($category['ParentID'] === null) {
                $tree[] = $this->buildCategoryTree($category, $categories);
            }
        }
        
        return $tree;
    }

    private function buildCategoryTree($category, $allCategories) {
        $category['children'] = [];
        
        foreach ($allCategories as $child) {
            if ($child['ParentID'] == $category['ID']) {
                $category['children'][] = $this->buildCategoryTree($child, $allCategories);
            }
        }
        
        return $category;
    }

    // Get category path (breadcrumb)
    public function getCategoryPath($categoryId) {
        $path = [];
        $currentId = $categoryId;
        
        while ($currentId !== null) {
            $category = $this->getCategoryById($currentId);
            if ($category) {
                array_unshift($path, $category);
                $currentId = $category['ParentID'];
            } else {
                break;
            }
        }
        
        return $path;
    }
} 