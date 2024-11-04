<?php
session_start();
include '../../includes/shop_databaseconnection.php';

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id > 0) {
    $session_id = session_id();
    try {
        $stmt = $shop_conn->prepare("SELECT id, quantity FROM cart WHERE session_id = ? AND product_id = ?");
        $stmt->bind_param("si", $session_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cart_item = $result->fetch_assoc();
            $new_quantity = $cart_item['quantity'] + $quantity;
            $stmt = $shop_conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_quantity, $cart_item['id']);
            $stmt->execute();
        } else {
            $stmt = $shop_conn->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $session_id, $product_id, $quantity);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred.']);
    } finally {
        $stmt->close();
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid product.']);
}
?>
