<?php
// File: checkout.php
// Author: Gabriel Sullivan
// Purpose: Checkout functionality for BlueSky Homesteading
declare(strict_types=1);

require $_SERVER['DOCUMENT_ROOT'] . '/../../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

function getProductById($conn, $id)
{
    return $conn->fetchAll("SELECT name, price FROM products WHERE id = ?", [$id]);
}

session_start();
$session_id = session_id();
$line_items = [];

try {
    // Retrieve cart items for this session
    $cart_items = $shop_conn->fetchAll("SELECT product_id, quantity, options FROM cart WHERE session_id = ?", [$session_id]);

    if (!empty($cart_items)) {
        foreach ($cart_items as $cart_item) {
            // Fetch product details
            $product = getProductById($conn, $cart_item['product_id']);

            if (!empty($product)) {
                $product = $product[0];

                // Fetch the selected options for this product
                $selected_options = json_decode($cart_item['options'], true);
                $options_description = '';

                // Build a description of the selected options
                foreach ($selected_options as $option_id => $choice_id) {
                    // Validate the selected choices
                    $choice_data = $conn->fetchAll("SELECT name FROM product_options_choices WHERE id = ?", [$choice_id]);
                    if (!empty($choice_data)) {
                        $options_description .= $choice_data[0]['name'] . ', ';
                    }
                }

                // Trim the trailing comma and space
                $options_description = rtrim($options_description, ', ');

                $line_item = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product['name'],
                        ],
                        'unit_amount' => $product['price'] * 100, // Stripe expects the amount in cents
                    ],
                    'quantity' => $cart_item['quantity'],
                ];

                // Only add 'description' if $options_description is not empty
                if (!empty($options_description)) {
                    $line_item['price_data']['product_data']['description'] = $options_description;
                }

                $line_items[] = $line_item;
            }
        }
    } else {
        echo 'An error has occurred.';
        exit();
    }
    //}

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
