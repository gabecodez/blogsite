<?php
// File: update-include-for-checkout.php
// Author: Gabriel Sullivan
// Purpose: update-include-for-checkout for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
$include_for_checkout = filter_input(INPUT_POST, 'include_for_checkout', FILTER_VALIDATE_INT);

if ($item_id === null || $include_for_checkout === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid item data.']);
    exit;
}

$session_id = session_id();

try {
    // Initialize Database connection (update with actual credentials)
    $shop_conn = new Database("host", "username", "password", "database_name");

    // Define the table and data for the update
    $table = "cart";
    $data = ["include_for_checkout" => $include_for_checkout];
    $where = "session_id = ? AND product_id = ?";
    $params = [$session_id, $item_id];

    // Execute the update
    $shop_conn->update($table, $data, $where, $params);

    // Check if rows were affected
    if ($shop_conn->query("SELECT ROW_COUNT()")->fetchColumn() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found or update failed.']);
    }

    // Close the connection
    $shop_conn->close();
} catch (DatabaseException $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}

?>
