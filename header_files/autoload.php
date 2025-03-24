<?php
// custom autoload.php

spl_autoload_register(function ($class) {
    // Define base directory for class files
    $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/classes/';

    // Convert class name to file path
    $file = $baseDir . $class . '.php';

    // If file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});
