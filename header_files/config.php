<?php
declare(strict_types=1);

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']); // Adjust based on your structure
define('INCLUDES_PATH', BASE_PATH . '/../../header_files/blueskyhomesteading/includes/');
define('CLASSES_PATH', BASE_PATH . '/../../header_files/blueskyhomesteading/classes/');
define('VIEWS_PATH', BASE_PATH . '/../../header_files/blueskyhomesteading/views/');

// Load autoloader
require_once BASE_PATH . '/../../header_files/blueskyhomesteading/autoload.php';

// Database Connection
require_once INCLUDES_PATH . 'databaseconnection.php';

// Session Handling
require_once INCLUDES_PATH . 'session_starter.php';
?>