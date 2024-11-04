<?php
session_start();
include '../../includes/shop_databaseconnection.php';

$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($item_id > 0 && $quantity > 0) {
    try {
        $stmt = $shop_conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Quantity updated.']);
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
