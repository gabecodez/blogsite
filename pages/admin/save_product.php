<?php
declare(strict_types=1);
include '../../includes/admin_databaseconnection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

// Helper: Clean and validate input
function sanitize(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Parse POST data
$productId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = sanitize($_POST['name'] ?? '');
$category = sanitize($_POST['category'] ?? '');
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
$description = sanitize($_POST['description'] ?? '');

// Validate fields
if (!$name || !$category || $price <= 0 || !$description) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required and must be valid.']);
    exit();
}

try {
    // Image upload logic
    $uploadedImages = [];
    if (isset($_FILES['image'])) {
        $targetDir = '../../uploads/';
        foreach ($_FILES['image']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['image']['error'][$index] === UPLOAD_ERR_OK) {
                $uniqueFileName = uniqid() . '_' . basename($_FILES['image']['name'][$index]);
                $targetPath = $targetDir . $uniqueFileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $uploadedImages[] = [
                        'url' => "/uploads/$uniqueFileName",
                        'caption' => sanitize($_POST['caption'][$index] ?? ''),
                        'credit' => sanitize($_POST['credit'][$index] ?? ''),
                        'credit_url' => sanitize($_POST['credit_url'][$index] ?? ''),
                        'alttext' => sanitize($_POST['alttext'][$index] ?? '')
                    ];
                }
            }
        }
    }

    // Save images and collect their IDs
    $imageIds = [];
    foreach ($uploadedImages as $image) {
        $stmt = $conn->prepare("
            INSERT INTO images (image_url, caption, credit, credit_url, alttext, public)
            VALUES (?, ?, ?, ?, ?, 1)
        ");
        $stmt->bind_param(
            'sssss',
            $image['url'],
            $image['caption'],
            $image['credit'],
            $image['credit_url'],
            $image['alttext']
        );
        $stmt->execute();
        $imageIds[] = $stmt->insert_id;
    }

    $previewImageIds = implode(',', $imageIds);

    // Insert or update product
    if ($productId > 0) {
        $stmt = $conn->prepare("
            UPDATE products
            SET name = ?, category = ?, price = ?, description = ?, preview_image_ids = ?
            WHERE id = ?
        ");
        $stmt->bind_param('ssdssi', $name, $category, $price, $description, $previewImageIds, $productId);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO products (name, category, price, description, preview_image_ids)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('ssdss', $name, $category, $price, $description, $previewImageIds);
    }

    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Product saved successfully.']);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An internal server error occurred.']);
} finally {
    $conn->close();
}
