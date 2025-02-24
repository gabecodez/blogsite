<?php
// File: login.php
// Author: Gabriel Sullivan
// Purpose: (temporary) login page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'admin_databaseconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_data = $adm_conn->fetchAll("SELECT id, username, password_hash, role FROM users WHERE username = ?", [$username]);

    if (!empty($user_data) && isset($user_data[0]['username'])) {
        $user = $user_data[0];

        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: https://www.blueskyhomesteading.com/admin/dashboard");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "User not found.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
