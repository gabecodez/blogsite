<?php
require_once INCLUDES_PATH . 'databaseconnection.php';

// Database credentials
$servername = $_ENV["ADMIN_DB_HOST"];
$username = $_ENV["ADMIN_DB_USER"];
$password = $_ENV["ADMIN_DB_PASSWORD"];
$dbname = $_ENV["ADMIN_DB_NAME"];

// Create admin connection
$adm_conn = new Database($servername, $username, $password, $dbname);
