<?php
// File: calculate_total.php
// Author: Gabriel Sullivan
// Purpose: Calculate the total for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

$item_data = json_decode($_POST['item_data'], true);
$totalPrice = 0;

try {
    foreach ($item_data as $item) {
        $item_id = $item['id'];
        $quantity = $item['quantity'];

        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            $totalPrice += $product['price'] * $quantity;
        }
    }

    echo json_encode(['totalPrice' => number_format($totalPrice, 2)]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error calculating total.']);
}
