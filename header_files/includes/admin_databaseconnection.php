<?php
require_once INCLUDES_PATH . 'databaseconnection.php';

// Database credentials
$servername = "localhost";
$username = "gwdhzhmy_admin";
$password = "ThisOldDudeIs67!";
$dbname = "gwdhzhmy_bluesky_users";

// Create admin connection
$adm_conn = new Database($servername, $username, $password, $dbname);

?>