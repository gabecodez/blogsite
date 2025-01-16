<?php
// if an account system is ever implemented this needs to be changed to prevent dangerous user perms
// it should be changed so that its just for user creation
include '../../includes/admin_databaseconnection.php';
session_start();

// this would then also be removed given these circumstances so that users can make users
// but they should only be allowed to make normal users not admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $adm_conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $role);

    if ($stmt->execute()) {
        $success = "User registered successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register User</title>
</head>
<body>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="role">Role:</label>
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
