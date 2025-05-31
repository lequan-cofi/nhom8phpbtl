<?php
// controllers/GioithieuController.php

class GioithieuController {
    public function index() {
        try {
            // Log the attempt to load the layout
            error_log("Attempting to load gioithieu_layout.php");
            
            // Check if the file exists
            $layoutPath = APP_PATH . '/views/layouts/gioithieu_layout.php';
            if (!file_exists($layoutPath)) {
                throw new Exception("Layout file not found at: " . $layoutPath);
            }
            
            // Load the about page layout
            require_once $layoutPath;
            
            error_log("Successfully loaded gioithieu_layout.php");
        } catch (Exception $e) {
            error_log("Error in GioithieuController: " . $e->getMessage());
            echo "An error occurred while loading the page. Please try again later.";
        }
    }
}
?> 