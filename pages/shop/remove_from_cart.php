<?php
// File: remove_from_cart.php
// Author: Gabriel Sullivan
// Purpose: Removing function for cart for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/shop_databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;

if ($item_id > 0) {
    try {
        $stmt = $shop_conn->prepare("DELETE FROM cart WHERE product_id = ?");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Item removed from cart.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error removing item from cart.']);
    } finally {
        $stmt->close();
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
