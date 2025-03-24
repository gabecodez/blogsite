<?php
require_once CLASSES_PATH . 'Database.php';

// Database credentials
$servername = $_ENV["DB_HOST"];
$username = $_ENV["DB_USER"];
$password = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];

// Create connection
$conn = new Database($servername, $username, $password, $dbname);
