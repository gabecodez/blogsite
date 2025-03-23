<?php
// File: checkout.php
// Author: Gabriel Sullivan
// Purpose: Checkout functionality for BlueSky Homesteading
declare(strict_types=1);

require '../../../../vendor/autoload.php'; // Ensure you have the Stripe PHP library installed via Composer
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

function getProductById($conn, $id)
{
    return $conn->fetchAll("SELECT name, price FROM products WHERE id = ?", [$id]);
}

session_start();
$session_id = session_id();
$line_items = [];

try {
    // Check if a product_id is passed for direct purchase
    if (isset($_GET['product_id'])) {
        $product_id = (int)$_GET['product_id'];

        // Fetch product details
        $product = getProductById($conn, $product_id);

        if (!empty($product)) {
            $product = $product[0];
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
        $cart_items = $shop_conn->fetchAll("SELECT product_id, quantity FROM cart WHERE session_id = ?", [$session_id]);

        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                // Fetch product details
                $product = getProductById($conn, $cart_item['product_id']);

                if (!empty($product)) {
                    $product = $product[0];
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

    // Create Stripe Checkout Session
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'https://www.blueskyhomesteading.com/shop/checkout/success',
        'cancel_url' => 'https://www.blueskyhomesteading.com/shop/cart?status=1',
        'phone_number_collection' => ['enabled' => true],
        'billing_address_collection' => 'required',
        'automatic_tax' => ['enabled' => true],
        'shipping_address_collection' => ['allowed_countries' => ['US', 'CA']],
        'shipping_options' => [
            [
                'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                        'amount' => 500,
                        'currency' => 'usd',
                    ],
                    'display_name' => 'Standard shipping',
                    'delivery_estimate' => [
                        'minimum' => ['unit' => 'business_day', 'value' => 5],
                        'maximum' => ['unit' => 'business_day', 'value' => 7],
                    ],
                ],
            ],
            [
                'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                        'amount' => 1500,
                        'currency' => 'usd',
                    ],
                    'display_name' => 'Next day air',
                    'delivery_estimate' => [
                        'minimum' => ['unit' => 'business_day', 'value' => 1],
                        'maximum' => ['unit' => 'business_day', 'value' => 1],
                    ],
                ],
            ],
        ],
    ]);

    // Close the database connections
    $conn->close();
    $shop_conn->close();

    // Redirect to Stripe Checkout
    header('Location: ' . $session->url);
    exit();
} catch (DatabaseException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}
