<?php
// File: add_to_cart.php
// Author: Gabriel Sullivan
// Purpose: Add to cart function for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0; // get the product to be added
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // get the quantity of said product
$selected_options = isset($_POST['options']) ? json_decode($_POST['options'], true) : []; // get the options

if (!is_array($selected_options)) {
    echo json_encode(['success' => false, 'message' => 'Please select a valid option.']);
    exit();
}

if ($product_id > 0) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $session_id = session_id();
    try {
        // --- VALIDATION: Get valid options/choices for the product ---
        function get_valid_options($conn, $product_id)
        {
            $options = $conn->fetchAll("SELECT id, name FROM product_options WHERE product_id = ?", [$product_id]);
            $valid_option_map = [];

            foreach ($options as $option) {
                $choices = $conn->fetchAll("SELECT id FROM product_options_choices WHERE option_id = ?", [$option['id']]);
                $choice_ids = array_column($choices, 'id');
                $valid_option_map[$option['name']] = $choice_ids;
            }

            return $valid_option_map;
        }

        $valid_options = get_valid_options($conn, $product_id);

        // --- VALIDATION: Make sure each submitted option is valid ---
        foreach ($selected_options as $option_name => $choice_id) {
            if (
                !isset($valid_options[$option_name]) ||
                !in_array((int)$choice_id, $valid_options[$option_name])
            ) {
                echo json_encode(['success' => false, 'message' => 'Please select a valid option.']);
                $shop_conn->close();
                exit();
            }
        }

        // Ensure all required options are selected
        $missing_options = array_diff_key($valid_options, $selected_options);
        if (!empty($missing_options)) {
            echo json_encode(['success' => false, 'message' => 'Please select all required options.']);
            $shop_conn->close();
            exit();
        }

        ksort($selected_options);
        $options_json = json_encode($selected_options);

        // Fetch the cart item that matches product ID AND options
        $cart_result = $shop_conn->fetchAll(
            "SELECT id, quantity FROM cart WHERE session_id = ? AND product_id = ? AND options = ?",
            [$session_id, $product_id, $options_json]
        );

        // Check if cart_result is not empty
        if (!empty($cart_result)) {
            $cart_item = $cart_result[0];
            $new_quantity = $cart_item['quantity'] + $quantity;

            // Update the cart quantity using the update method
            $data = ['quantity' => $new_quantity, 'options' => json_encode($selected_options)];
            $where = "id = ?";
            $shop_conn->update('cart', $data, $where, [$cart_item['id']]);
        } else {
            $include_for_checkout = 1;

            // Insert a new item into the cart using the insert method
            $data = [
                'session_id' => $session_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'include_for_checkout' => $include_for_checkout,
                'options' => json_encode($selected_options) // Store as JSON
            ];

            $shop_conn->insert('cart', $data);
        }

        echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
    } catch (Exception $e) {
        // Output the error message for debugging
        echo json_encode(['success' => false, 'message' => 'An error occurred.']);
    } finally {
        // Assuming $shop_conn is an instance of Database, use the close method
        $shop_conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid product.']);
}
