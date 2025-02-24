<?php
// File: remove_from_cart.php
// Author: Gabriel Sullivan
// Purpose: Removing function for cart for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;

if ($item_id > 0) {
    try {
        $stmt = $shop_conn->delete("cart", "product_id = ?", [$item_id]);

        echo json_encode(['success' => true, 'message' => 'Item removed from cart.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error removing item from cart.']);
    } finally {
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
