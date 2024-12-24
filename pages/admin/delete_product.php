<?php
//delete_product.php
include '../../includes/admin_databaseconnection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

// Validate product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid product ID']);
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to delete product']);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
} finally {
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>
