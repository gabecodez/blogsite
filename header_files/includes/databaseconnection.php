<?php
require_once CLASSES_PATH . 'Database.php';

// Database credentials
$servername = getenv("DB_HOST");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$dbname = getenv("DB_NAME");

// Create connection
$conn = new Database($servername, $username, $password, $dbname);
