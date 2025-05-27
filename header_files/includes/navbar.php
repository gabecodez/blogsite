<?php
// File: navbar.php
// Author: Gabriel Sullivan
// Purpose: Navigation bar for BlueSky Homesteading

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

$navbar = new Navbar($shop_conn, $session_id);
echo $navbar->render();
