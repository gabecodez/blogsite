<?php
require_once INCLUDES_PATH . 'databaseconnection.php';

// Database credentials
$servername = $_ENV["SHOP_DB_HOST"];
$username = $_ENV["SHOP_DB_USER"];
$password = $_ENV["SHOP_DB_PASSWORD"];
$dbname = $_ENV["SHOP_DB_NAME"];

// Create admin connection
$shop_conn = new Database($servername, $username, $password, $dbname);
