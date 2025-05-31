<?php
require_once __DIR__ . '/../models/LienHeModel.php';
require_once __DIR__ . '/../controllers/LienHeController.php';

class Lienhe_layoutController {
    private $lienHeModel;
    private $lienHeController;

    public function __construct() {
        $this->lienHeModel = new LienHeModel();
        $this->lienHeController = new LienHeController();
    }

    public function index() {
        // Set page title
        $data['pageTitle'] = 'Liên hệ - iStore';
        
        // Load the contact page layout
        require_once APP_PATH . '/views/layouts/lienhe_layout.php';
    }

    public function submitContact() {
        $this->lienHeController->submitContact();
    }
}

// Handle the request
$controller = new Lienhe_layoutController();
$action = $_GET['action'] ?? 'index';
$controller->$action(); 