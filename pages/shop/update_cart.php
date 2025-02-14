<?php
// File: update_cart.php
// Author: Gabriel Sullivan
// Purpose: Update cart function for BlueSky Homesteading
declare(strict_types=1);

header('Content-Type: application/json');
ob_clean();

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/shop_databaseconnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($item_id > 0 && $quantity > 0) {
    try {
        $stmt = $shop_conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();

        // Calculate the updated prices
        $price_stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $price_stmt->bind_param("i", $item_id);
        $price_stmt->execute();
        $product = $price_stmt->get_result()->fetch_assoc();
        $itemTotalPrice = $product['price'] * $quantity;

        $totalPrice = 0;
        $cart_result = $shop_conn->query("SELECT product_id, quantity FROM cart WHERE session_id = '$session_id'");
        while ($cart_item = $cart_result->fetch_assoc()) {
            $prod_stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $prod_stmt->bind_param("i", $cart_item['product_id']);
            $prod_stmt->execute();
            $product = $prod_stmt->get_result()->fetch_assoc();
            $totalPrice += $product['price'] * $cart_item['quantity'];
        }

        echo json_encode([
            'success' => true,
            'itemTotalPrice' => number_format($itemTotalPrice, 2),
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating quantity.']);
    } finally {
        $stmt->close();
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
