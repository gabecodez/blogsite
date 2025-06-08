<?php
// delete_product.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit();
}

// Validate product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid product ID']);
    exit();
}

$query = $conn->delete("products", "id = ?", [$product_id]);
echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);

$conn->close();
