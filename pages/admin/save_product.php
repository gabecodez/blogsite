<?php
//save_product.php
include '../../includes/admin_databaseconnection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

// Get POST data
$product_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = $_POST['name'] ?? '';
$category = $_POST['category'] ?? '';
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
$description = $_POST['description'] ?? '';
$preview_image_ids = $_POST['preview_image_ids'] ?? '';

// Validate required fields
if (empty($name) || empty($category) || $price <= 0 || empty($description)) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields are required']);
    exit();
}

try {
    if ($product_id > 0) {
        // Update existing product
        $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, description = ?, preview_image_ids = ? WHERE id = ?");
        $stmt->bind_param("ssdsdi", $name, $category, $price, $description, $preview_image_ids, $product_id);
    } else {
        // Insert new product
        $stmt = $conn->prepare("INSERT INTO products (name, category, price, description, preview_image_ids) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $category, $price, $description, $preview_image_ids);
    }

    if ($stmt->execute()) {
        $last_product_id = $product_id > 0 ? $product_id : $stmt->insert_id;

        // Handle multiple image uploads
        if (isset($_FILES['image'])) {
            foreach ($_FILES['image']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['image']['error'][$index] == UPLOAD_ERR_OK) {
                    $image_name = basename($_FILES['image']['name'][$index]);
                    $target_dir = '../../uploads/';
                    $target_file = $target_dir . $image_name;

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $image_path = '/uploads/' . $image_name;
                        $caption = $_POST['caption'][$index] ?? '';
                        $credit = $_POST['credit'][$index] ?? '';
                        $credit_url = $_POST['credit_url'][$index] ?? '';
                        $alttext = $_POST['alttext'][$index] ?? '';

                        // Save image path and metadata to images table
                        $stmt = $conn->prepare("INSERT INTO images (image_url, caption, credit, credit_url, alttext, public) VALUES (?, ?, ?, ?, ?, 1)");
                        $stmt->bind_param("sssss", $image_path, $caption, $credit, $credit_url, $alttext);
                        $stmt->execute();
                    }
                }
            }
        }

        echo json_encode(['success' => true, 'message' => 'Product saved successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to save product']);
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