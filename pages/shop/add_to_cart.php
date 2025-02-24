<?php
// File: add_to_cart.php
// Author: Gabriel Sullivan
// Purpose: Add to cart function for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id > 0) {
    $session_id = session_id();
    try {
        // Fetch the cart result using the $database instance
        $cart_result = $shop_conn->fetchAll("SELECT id, quantity FROM cart WHERE session_id = ? AND product_id = ?", [$session_id, $product_id]);

        // Check if cart_result is not empty
        if (!empty($cart_result)) {
            $cart_item = $cart_result[0];
            $new_quantity = $cart_item['quantity'] + $quantity;

            // Update the cart quantity using the update method
            $data = ['quantity' => $new_quantity];
            $where = "id = ?";
            $shop_conn->update('cart', $data, $where, [$cart_item['id']]);
        } else {
            $include_for_checkout = 1;

            // Insert a new item into the cart using the insert method
            $data = [
                'session_id' => $session_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'include_for_checkout' => $include_for_checkout
            ];
            $shop_conn->insert('cart', $data);
        }

        echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
    } catch (Exception $e) {
        // Output the error message for debugging
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    } finally {
        // Assuming $shop_conn is an instance of Database, use the close method
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid product.']);
}
