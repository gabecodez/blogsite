<?php
//get_product.php
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
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Fetch image paths and metadata
        $image_ids = explode(',', $product['preview_image_ids']);
        $images = [];
        foreach ($image_ids as $image_id) {
            $stmt = $conn->prepare("SELECT image_url, caption, credit, credit_url, alttext FROM images WHERE id = ?");
            $stmt->bind_param("i", $image_id);
            $stmt->execute();
            $image_result = $stmt->get_result();
            if ($image_result->num_rows > 0) {
                $images[] = $image_result->fetch_assoc();
            }
        }
        $product['images'] = $images;

        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found']);
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