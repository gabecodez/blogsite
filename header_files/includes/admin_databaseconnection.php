<?php
require_once INCLUDES_PATH . 'databaseconnection.php';

// Database credentials
$servername = getenv("ADMIN_DB_HOST");
$username = getenv("ADMIN_DB_USERNAME");
$password = getenv("ADMIN_DB_PASSWORD");
$dbname = getenv("ADMIN_DB_NAME");

// Create admin connection
$adm_conn = new Database($servername, $username, $password, $dbname);
