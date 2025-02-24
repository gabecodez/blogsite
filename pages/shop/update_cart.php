<?php
// File: update_cart.php
// Author: Gabriel Sullivan
// Purpose: Update cart function for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($item_id > 0 && $quantity > 0) {
    try {
        $stmt = $shop_conn->fetchAll("UPDATE cart SET quantity = ? WHERE product_id = ?", [$quantity, $item_id]);

        // Calculate the updated prices
        $product = $conn->fetchAll("SELECT price FROM products WHERE id = ? LIMIT 1", [$item_id]);
        $itemTotalPrice = $product[0]['price'] * $quantity;

        $totalPrice = 0;
        $cart_result = $shop_conn->fetchAll("SELECT product_id, quantity FROM cart WHERE session_id = ?", [$session_id]);
        foreach($cart_result as $cart_item) {
            $product = $conn->fetchAll("SELECT price FROM products WHERE id = ?", [$cart_item['product_id']]);
            $totalPrice += $product[0]['price'] * $cart_item['quantity'];
        }

        echo json_encode([
            'success' => true,
            'itemTotalPrice' => number_format($itemTotalPrice, 2),
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating quantity.']);
    } finally {
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
