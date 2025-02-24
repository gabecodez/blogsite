<?php
// File: calculate_total.php
// Author: Gabriel Sullivan
// Purpose: Calculate the total for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$item_data = json_decode($_POST['item_data'], true);
$totalPrice = 0;

try {
    foreach ($item_data as $item) {
        $item_id = $item['id'];
        $quantity = $item['quantity'];

        $product = $conn->fetchAll("SELECT price FROM products WHERE id = ? LIMIT 1", [$item_id]);

        if ($product[0]) {
            $totalPrice += $product[0]['price'] * $quantity;
        }
    }

    echo json_encode(['totalPrice' => number_format($totalPrice, 2)]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error calculating total.']);
}
