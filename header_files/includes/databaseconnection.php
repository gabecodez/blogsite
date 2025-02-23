<?php
require_once CLASSES_PATH . 'Database.php';

// Database credentials
$servername = "localhost";
$username = "gwdhzhmy_regular_user";
$password = "ThisOldLadyIs23!";
$dbname = "gwdhzhmy_bluesky";

// Create connection
$conn = new Database($servername, $username, $password, $dbname);

?>