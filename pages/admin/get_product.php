<?php
// get_product.php
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

// Retrieve the product record.
$products = $conn->fetchAll("SELECT * FROM products WHERE id = ? LIMIT 1", [$product_id]);

if (sizeof($products) <= 0) {
    http_response_code(404);
    echo json_encode(['message' => 'Product not found']);
    exit;
}

$product = $products[0];

// Fetch image paths and metadata.
// Explode the comma-separated string into an array.
$image_ids = explode(',', $product['preview_image_ids']);
$images = [];
foreach ($image_ids as $image_id) {
    $image_id = trim($image_id);

    if (empty($image_id)) continue;

    // IMPORTANT: Select the "id" field along with other columns.
    $images_query = $conn->fetchAll("SELECT id, image_url, caption, credit, credit_url, alttext FROM images WHERE id = ?", [$image_id]);

    if (sizeof($products) <= 0) continue;

    $images[] = $images_query;
}

$product['images'] = $images; // Append the images array to the product data.

echo json_encode($product);

$conn->close();
