<?php
header('Content-Type: application/json');
$targetDir = __DIR__ . '/../uploads/hinhanh/';
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

if (!isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}
$file = $_FILES['image'];
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('img_') . '.' . $ext;
$targetFile = $targetDir . $filename;
if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    echo json_encode(['success' => true, 'path' => '/uploads/hinhanh/' . $filename]);
} else {
    echo json_encode(['success' => false, 'message' => 'Upload failed']);
} 