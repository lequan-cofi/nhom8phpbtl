<?php
require_once __DIR__ . '/../models/Content.php';

class ContentController {
    private $contentModel;

    public function __construct() {
        $this->contentModel = new Content();
    }

    /**
     * Get all content data for the main page
     * @return array Array containing slider data
     */
    public function getContentData() {
        $stmt = $this->contentModel->getActive();
        $contents = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contents[] = (object)[
                'ID' => $row['ID'],
                'TieuDe' => $row['TieuDe'],
                'MoTa' => $row['MoTa'],
                'NoiDung' => $row['NoiDung'],
                'DuongDanHinhAnh' => $row['DuongDanHinhAnh'],
                'DuongDanLienKet' => $row['DuongDanLienKet'],
                'IsActive' => $row['IsActive'],
                'SortOrder' => $row['SortOrder']
            ];
        }
        
        return $contents;
    }

    /**
     * Handle admin actions
     */
    public function handleAdminAction() {
        $action = $_GET['action'] ?? '';
        $response = ['success' => false, 'message' => ''];

        switch ($action) {
            case 'create':
                $response = $this->handleCreate();
                break;
            case 'update':
                $response = $this->handleUpdate();
                break;
            case 'delete':
                $response = $this->handleDelete();
                break;
            case 'getOne':
                $response = $this->handleGetOne();
                break;
            default:
                $response['message'] = 'Invalid action';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    /**
     * Handle create action
     */
    private function handleCreate() {
        try {
            $uploadDir = __DIR__ . '/../public/assets/img/sliders/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Ưu tiên lấy link ảnh từ trường DuongDanHinhAnhUrl
            if (!empty($_POST['DuongDanHinhAnhUrl'])) {
                $this->contentModel->DuongDanHinhAnh = $_POST['DuongDanHinhAnhUrl'];
            } elseif (isset($_FILES['DuongDanHinhAnhFile']) && $_FILES['DuongDanHinhAnhFile']['error'] == UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['DuongDanHinhAnhFile']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['DuongDanHinhAnhFile']['tmp_name'], $targetPath)) {
                    $this->contentModel->DuongDanHinhAnh = 'assets/img/sliders/' . $fileName;
                } else {
                    return ['success' => false, 'message' => 'Upload file thất bại'];
                }
            } else {
                $this->contentModel->DuongDanHinhAnh = '';
            }

            $this->contentModel->TieuDe = $_POST['TieuDe'];
            $this->contentModel->MoTa = $_POST['MoTa'];
            $this->contentModel->NoiDung = $_POST['NoiDung'];
            $this->contentModel->DuongDanLienKet = $_POST['DuongDanLienKet'];
            $this->contentModel->IsActive = isset($_POST['IsActive']) ? 1 : 0;
            $this->contentModel->SortOrder = $_POST['SortOrder'];

            if ($this->contentModel->create()) {
                return ['success' => true, 'message' => 'Content created successfully'];
            }
            return ['success' => false, 'message' => 'Failed to create content'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Handle update action
     */
    private function handleUpdate() {
        try {
            $this->contentModel->ID = $_POST['ID'];
            $this->contentModel->TieuDe = $_POST['TieuDe'];
            $this->contentModel->MoTa = $_POST['MoTa'];
            $this->contentModel->NoiDung = $_POST['NoiDung'];
            $this->contentModel->DuongDanLienKet = $_POST['DuongDanLienKet'];
            $this->contentModel->IsActive = isset($_POST['IsActive']) ? 1 : 0;
            $this->contentModel->SortOrder = $_POST['SortOrder'];

            // Ưu tiên lấy link ảnh từ trường DuongDanHinhAnhUrl
            if (!empty($_POST['DuongDanHinhAnhUrl'])) {
                $this->contentModel->DuongDanHinhAnh = $_POST['DuongDanHinhAnhUrl'];
            } elseif (isset($_FILES['DuongDanHinhAnhFile']) && $_FILES['DuongDanHinhAnhFile']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/assets/img/sliders/';
                $fileName = basename($_FILES['DuongDanHinhAnhFile']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['DuongDanHinhAnhFile']['tmp_name'], $targetPath)) {
                    $this->contentModel->DuongDanHinhAnh = 'assets/img/sliders/' . $fileName;
                }
            }
            // Nếu không có gì thay đổi thì giữ nguyên ảnh cũ (không set lại)

            if ($this->contentModel->update()) {
                return ['success' => true, 'message' => 'Content updated successfully'];
            }
            return ['success' => false, 'message' => 'Failed to update content'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Handle delete action
     */
    private function handleDelete() {
        try {
            $id = $_GET['id'] ?? 0;
            $this->contentModel->ID = $id;
            
            if ($this->contentModel->delete()) {
                return ['success' => true, 'message' => 'Content deleted successfully'];
            }
            return ['success' => false, 'message' => 'Failed to delete content'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Handle get one action
     */
    private function handleGetOne() {
        try {
            $id = $_GET['id'] ?? 0;
            $this->contentModel->ID = $id;
            $stmt = $this->contentModel->getOne();
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($content) {
                return ['success' => true, 'data' => $content];
            }
            return ['success' => false, 'message' => 'Content not found'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Render the content view
     * @return void
     */
    public function renderContent() {
        $slidersData = $this->getContentData();
        require_once 'views/partials/content.php';
    }

    /**
     * Search contents
     * @param string $keyword Search keyword
     * @return array Array of matching contents
     */
    public function searchContents($keyword) {
        $stmt = $this->contentModel->search($keyword);
        $contents = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contents[] = $row;
        }
        
        return $contents;
    }
}

// Xử lý request AJAX trực tiếp
if (php_sapi_name() !== 'cli' && isset($_GET['action'])) {
    $controller = new ContentController();
    $controller->handleAdminAction();
}
