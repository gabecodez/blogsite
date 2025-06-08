<?php
// admin_page.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

// Ensure that the user is an authenticated admin.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit();
}

// Generate a CSRF token if not already set.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once HEAD_PATH; ?>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/admin.css">
</head>

<body>
    <?php require_once NAVBAR_PATH; ?>
    <main class="main-page">
        <h1>Admin Dashboard</h1>
        <button id="createProductBtn">Create New Product</button>
        <!-- Products Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all products.
                $products = $conn->fetchAll("SELECT * FROM products", []);
                foreach ($products as $product):
                ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td>
                            <button class="editBtn" data-id="<?php echo $product['id']; ?>">Edit</button>
                            <button class="deleteBtn" data-id="<?php echo $product['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal for Create/Edit -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Create Product</h2>
            <!-- Include the CSRF token in the form -->
            <form id="productForm" enctype="multipart/form-data">
                <input type="hidden" id="productId" name="id">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <!-- Image Upload Section -->
                <div id="imageUploadContainer"></div>
                <button type="button" id="addImageBtn">+ Add Another Image</button>
                <button type="submit" id="submitProductBtn">Save</button>
            </form>
        </div>
    </div>

    <script src="scripts/admin_panel.js"></script>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>