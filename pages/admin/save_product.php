<?php
// File: save_product.php
// Author: Gabriel Sullivan
// Purpose: Admin save product function for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/admin_databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

// Check that the user is authenticated.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

// CSRF token check.
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token.']);
    exit();
}

// Helper function for sanitizing input.
function sanitize(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Validate and sanitize input.
$productId   = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name        = sanitize($_POST['name'] ?? '');
$category    = sanitize($_POST['category'] ?? '');
$price       = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
$description = sanitize($_POST['description'] ?? '');

// Validate required fields.
if (!$name || !$category || $price <= 0 || !$description) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required and must be valid.']);
    exit();
}

// Define file upload parameters.
$maxFileSize = 2 * 1024 * 1024; // 2MB file size limit.
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

// Process removals.
if (!empty($_POST['remove_image_ids'])) {
    foreach ($_POST['remove_image_ids'] as $removeId) {
        // Fetch image record to get file path.
        $stmt = $conn->prepare("SELECT image_url FROM images WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed (removal select): " . $conn->error);
            continue;
        }
        $stmt->bind_param("i", $removeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Convert the URL to a real file system path.
            $filePath = realpath(__DIR__ . '/../../' . ltrim($row['image_url'], '/'));
            if ($filePath && file_exists($filePath)) {
                if (!unlink($filePath)) {
                    error_log("Failed to delete file: " . $filePath);
                }
            }
        }
        $stmt->close();
        // Delete the database record.
        $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed (removal delete): " . $conn->error);
            continue;
        }
        $stmt->bind_param("i", $removeId);
        $stmt->execute();
        $stmt->close();
    }
}

// Initialize final image IDs array as empty.
$finalImageIds = [];

// --- Process Existing Images ---
// We expect that the edit form includes hidden inputs named 'existing_image_ids[]',
// 'existing_image_url[]', and text inputs for captions, credits, etc.
if (!empty($_POST['existing_image_ids']) && is_array($_POST['existing_image_ids'])) {
    $existingIds        = $_POST['existing_image_ids'];
    $existingUrls       = $_POST['existing_image_url'] ?? [];
    $existingCaptions   = $_POST['existing_caption'] ?? [];
    $existingCredits    = $_POST['existing_credit'] ?? [];
    $existingCreditUrls = $_POST['existing_credit_url'] ?? [];
    $existingAlttexts   = $_POST['existing_alttext'] ?? [];
    
    // Also get list of images marked for removal.
    $removed = !empty($_POST['remove_image_ids']) ? $_POST['remove_image_ids'] : [];
    
    // Loop over each existing image from the POST.
    foreach ($existingIds as $index => $imgId) {
        // Skip any images that were marked for removal.
        if (in_array($imgId, $removed, true)) {
            continue;
        }
        
        // Determine whether a new file was provided.
        $newFileProvided = false;
        if (isset($_FILES['existing_file']) && isset($_FILES['existing_file']['error'][$index])) {
            if ($_FILES['existing_file']['error'][$index] === UPLOAD_ERR_OK &&
                !empty($_FILES['existing_file']['name'][$index])) {
                $newFileProvided = true;
            }
        }
        
        if ($newFileProvided) {
            // Validate file size.
            if ($_FILES['existing_file']['size'][$index] > $maxFileSize) {
                error_log("File too large for image ID: $imgId");
                // Even if file is too large, we retain the current image.
                $finalImageIds[] = $imgId;
                continue;
            }
            // Validate MIME type.
            $tmpName = $_FILES['existing_file']['tmp_name'][$index];
            $imgInfo = getimagesize($tmpName);
            if ($imgInfo === false || !in_array($imgInfo['mime'], $allowedMimeTypes, true)) {
                error_log("Invalid image file for image ID: $imgId");
                $finalImageIds[] = $imgId;
                continue;
            }
            // Process the new file upload.
            $originalName   = basename($_FILES['existing_file']['name'][$index]);
            $uniqueFileName = uniqid() . '_' . $originalName;
            $targetDir      = realpath(__DIR__ . '/../../uploads') ?: (__DIR__ . '/../../uploads');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $uniqueFileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $newUrl = "https://www.blueskyhomesteading.com/uploads/$uniqueFileName";
                // Delete the old file.
                $oldFilePath = realpath(__DIR__ . '/../../' . ltrim($existingUrls[$index] ?? '', '/'));
                if ($oldFilePath && file_exists($oldFilePath)) {
                    if (!unlink($oldFilePath)) {
                        error_log("Failed to delete old image file: $oldFilePath");
                    }
                }
                // Update record with new URL and text fields.
                $stmt = $conn->prepare("UPDATE images SET image_url = ?, caption = ?, credit = ?, credit_url = ?, alttext = ? WHERE id = ?");
                if (!$stmt) {
                    error_log("Prepare failed (existing update with file): " . $conn->error);
                    $finalImageIds[] = $imgId;
                    continue;
                }
                $caption    = sanitize($existingCaptions[$index] ?? '');
                $credit     = sanitize($existingCredits[$index] ?? '');
                $credit_url = sanitize($existingCreditUrls[$index] ?? '');
                $alttext    = sanitize($existingAlttexts[$index] ?? '');
                $stmt->bind_param('sssssi', $newUrl, $caption, $credit, $credit_url, $alttext, $imgId);
                $stmt->execute();
                if ($stmt->error) {
                    error_log("Update error (with file): " . $stmt->error);
                }
                $stmt->close();
            } else {
                error_log("Failed to move uploaded file for image ID: $imgId");
            }
        } else {
            // No new file provided; update text fields only.
            $stmt = $conn->prepare("UPDATE images SET caption = ?, credit = ?, credit_url = ?, alttext = ? WHERE id = ?");
            if (!$stmt) {
                error_log("Prepare failed (existing update no file): " . $conn->error);
                $finalImageIds[] = $imgId;
                continue;
            }
            $caption    = sanitize($existingCaptions[$index] ?? '');
            $credit     = sanitize($existingCredits[$index] ?? '');
            $credit_url = sanitize($existingCreditUrls[$index] ?? '');
            $alttext    = sanitize($existingAlttexts[$index] ?? '');
            $stmt->bind_param('ssssi', $caption, $credit, $credit_url, $alttext, $imgId);
            $stmt->execute();
            if ($stmt->error) {
                error_log("Update error (no file): " . $stmt->error);
            }
            $stmt->close();
        }
        // In either case, add this image's ID to the final list.
        $finalImageIds[] = $imgId;
    }
}

// --- Fallback: If no existing image IDs were received from POST, then retrieve current product data.
// This helps if, for example, no file inputs were sent at all.
if (empty($finalImageIds) && $productId > 0) {
    $stmt = $conn->prepare("SELECT preview_image_ids FROM products WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (!empty($row['preview_image_ids'])) {
                // Explode the stored comma-separated list into an array.
                $finalImageIds = explode(',', $row['preview_image_ids']);
            }
        }
        $stmt->close();
    }
}

// --- Process New Images ---
if (isset($_FILES['new_file'])) {
    $newFilesCount = count($_FILES['new_file']['name']);
    $newCaptions   = $_POST['new_caption'] ?? [];
    $newCredits    = $_POST['new_credit'] ?? [];
    $newCreditUrls = $_POST['new_credit_url'] ?? [];
    $newAlttexts   = $_POST['new_alttext'] ?? [];
    
    for ($i = 0; $i < $newFilesCount; $i++) {
        if ($_FILES['new_file']['error'][$i] === UPLOAD_ERR_OK && !empty($_FILES['new_file']['name'][$i])) {
            // Validate file size.
            if ($_FILES['new_file']['size'][$i] > $maxFileSize) {
                error_log("New file too large at index: $i");
                continue;
            }
            // Validate MIME type.
            $tmpName = $_FILES['new_file']['tmp_name'][$i];
            $imgInfo = getimagesize($tmpName);
            if ($imgInfo === false || !in_array($imgInfo['mime'], $allowedMimeTypes, true)) {
                error_log("Invalid new image file at index: $i");
                continue;
            }
            $originalName   = basename($_FILES['new_file']['name'][$i]);
            $uniqueFileName = uniqid() . '_' . $originalName;
            $targetDir      = realpath(__DIR__ . '/../../uploads') ?: (__DIR__ . '/../../uploads');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $uniqueFileName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $newUrl   = "https://www.blueskyhomesteading.com/uploads/$uniqueFileName";
                $caption    = sanitize($newCaptions[$i] ?? '');
                $credit     = sanitize($newCredits[$i] ?? '');
                $credit_url = sanitize($newCreditUrls[$i] ?? '');
                $alttext    = sanitize($newAlttexts[$i] ?? '');
                $stmt = $conn->prepare("INSERT INTO images (image_url, caption, credit, credit_url, alttext, public) VALUES (?, ?, ?, ?, ?, 1)");
                if (!$stmt) {
                    error_log("Prepare failed (new image insert): " . $conn->error);
                    continue;
                }
                $stmt->bind_param('sssss', $newUrl, $caption, $credit, $credit_url, $alttext);
                $stmt->execute();
                if ($stmt->error) {
                    error_log("Insert error (new image): " . $stmt->error);
                }
                $newImageId = $stmt->insert_id;
                $stmt->close();
                $finalImageIds[] = $newImageId;
            } else {
                error_log("Failed to move new uploaded file at index: $i");
            }
        }
    }
}

// Remove any duplicate image IDs.
$finalImageIds = array_unique($finalImageIds);
// Build a comma-separated list. (Consider using a proper relational design in the future.)
$previewImageIds = implode(',', $finalImageIds);

// Insert or update the product record.
if ($productId > 0) {
    $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, description = ?, preview_image_ids = ? WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed (product update): " . $conn->error);
        echo json_encode(['error' => 'Database error.']);
        exit();
    }
    $stmt->bind_param('ssdssi', $name, $category, $price, $description, $previewImageIds, $productId);
} else {
    $stmt = $conn->prepare("INSERT INTO products (name, category, price, description, preview_image_ids) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare failed (product insert): " . $conn->error);
        echo json_encode(['error' => 'Database error.']);
        exit();
    }
    $stmt->bind_param('ssdss', $name, $category, $price, $description, $previewImageIds);
}
$stmt->execute();
if ($stmt->error) {
    error_log("Product insert/update error: " . $stmt->error);
    echo json_encode(['error' => 'Failed to save product.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

echo json_encode(['success' => true, 'message' => 'Product saved successfully.']);
$conn->close();
?>
