<?php
require_once INCLUDES_PATH . 'databaseconnection.php';

// Database credentials
$servername = getenv("SHOP_DB_HOST");
$username = getenv("SHOP_DB_USERNAME");
$password = getenv("SHOP_DB_PASSWORD");
$dbname = getenv("SHOP_DB_NAME");

// Create admin connection
$shop_conn = new Database($servername, $username, $password, $dbname);
