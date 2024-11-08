<?php
// checkout.php

require '../../../../vendor/autoload.php'; // Ensure you have the Stripe PHP library installed via Composer
include '../../includes/databaseconnection.php';
include '../../includes/shop_databaseconnection.php';

\Stripe\Stripe::setApiKey('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');

session_start();
$session_id = session_id();
$line_items = [];

// Check if a product_id is passed for direct purchase
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    
    // Fetch product details
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $product['name'],
                ],
                'unit_amount' => $product['price'] * 100, // Stripe expects the amount in cents
            ],
            'quantity' => 1, // Default quantity for direct purchases
        ];
    }
} else {
    // Retrieve cart items for this session
    $stmt = $shop_conn->prepare("SELECT product_id, quantity FROM cart WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($cart_item = $result->fetch_assoc()) {
            // Fetch product details to create line items
            $product_stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
            $product_stmt->bind_param("i", $cart_item['product_id']);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();

            if ($product_result->num_rows > 0) {
                $product = $product_result->fetch_assoc();
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product['name'],
                        ],
                        'unit_amount' => $product['price'] * 100, // Stripe expects the amount in cents
                    ],
                    'quantity' => $cart_item['quantity'],
                ];
            }
        }
    } else {
        echo 'An error has occurred.';
        exit();
    }
}

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'https://www.blueskyhomesteading.com/shop/checkout/success',
    'cancel_url' => 'https://www.blueskyhomesteading.com/shop/cart?status=1',
]);

header('Location: ' . $session->url);
exit();
?>
