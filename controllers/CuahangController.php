<?php
require_once APP_PATH . '/models/CuahangModel.php';

class CuahangController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->model = new CuahangModel($db);
    }

    public function index()
    {
        $cuahangs = $this->model->getAll();
        require APP_PATH . '/views/layouts/cuahang_layout.php';
    }

    // Các hàm cho admin
    public function admin()
    {
        $cuahangs = $this->model->getAll();
        require APP_PATH . '/views/admin/admin_cuahang.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $diachi = $_POST['diachi'];
            $google_map = $_POST['google_map'];
            $this->model->add($ten, $diachi, $google_map);
            header('Location: index.php?page=cuahang&action=admin');
            exit;
        }
        require APP_PATH . '/views/admin/add_cuahang.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('Thiếu ID');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = $_POST['ten'];
            $diachi = $_POST['diachi'];
            $google_map = $_POST['google_map'];
            $this->model->update($id, $ten, $diachi, $google_map);
            header('Location: index.php?page=cuahang&action=admin');
            exit;
        }
        $cuahang = $this->model->getById($id);
        require APP_PATH . '/views/admin/edit_cuahang.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) $this->model->delete($id);
        header('Location: index.php?page=cuahang&action=admin');
        exit;
    }
}