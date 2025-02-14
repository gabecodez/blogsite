<?php
// File: update-include-for-checkout.php
// Author: Gabriel Sullivan
// Purpose: update-include-for-checkout for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/shop_databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

$item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
$include_for_checkout = filter_input(INPUT_POST, 'include_for_checkout', FILTER_VALIDATE_INT);

if ($item_id === null || $include_for_checkout === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid item data.']);
    exit;
}

$session_id = session_id();

try {
    $stmt = $shop_conn->prepare("UPDATE cart SET include_for_checkout = ? WHERE session_id = ? AND product_id = ?");
    $stmt->bind_param("isi", $include_for_checkout, $session_id, $item_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found or update failed.']);
    }
    
    $stmt->close();
    $shop_conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred.']);
}
?>
