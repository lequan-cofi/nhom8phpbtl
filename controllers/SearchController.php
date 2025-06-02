<?php
require_once __DIR__ . '/../models/ThietbiModel.php';

class SearchController {
    private $thietbiModel;

    public function __construct() {
        $this->thietbiModel = new ThietBiModel();
    }

    // Trang tìm kiếm
    public function index() {
        $keyword = $_GET['q'] ?? '';
        $results = [];
        if ($keyword) {
            // Debug keyword
            error_log('Search keyword: ' . $keyword);
            $results = $this->thietbiModel->search($keyword);
            error_log('Search result count: ' . count($results));
            if (empty($results)) {
                error_log('No results found for keyword: ' . $keyword);
            } else {
                error_log('First result: ' . print_r($results[0], true));
            }
        }
        require_once APP_PATH . '/views/layouts/searchlist_layout.php';
    }

    public function suggest() {
        header('Content-Type: application/json');
        $keyword = $_GET['q'] ?? '';
        $results = [];
        if ($keyword) {
            $results = $this->thietbiModel->search($keyword);
        }
        // Có thể trả về 2 phần: gợi ý tên và sản phẩm
        $suggestNames = [];
        foreach ($results as $item) {
            $suggestNames[] = $item['Ten'];
        }
        echo json_encode([
            'success' => true,
            'suggestions' => array_slice(array_unique($suggestNames), 0, 5),
            'products' => array_slice($results, 0, 5)
        ]);
        exit;
    }
}
