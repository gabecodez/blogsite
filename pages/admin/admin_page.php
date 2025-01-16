<?php
include '../../includes/admin_databaseconnection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: https://www.blueskyhomesteading.com/admin/login");
    exit();
}

// Fetch all products
$products = [];
try {
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
} finally {
    if (isset($stmt)) $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../../includes/head.php'; ?>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/admin.css">
</head>

<body>
    <?php include '../../includes/navbar.php'; ?>

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
                <?php foreach ($products as $product): ?>
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

        <!-- Modal for Create/Edit -->
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Create Product</h2>
                <form id="productForm" enctype="multipart/form-data">
                    <input type="hidden" id="productId" name="id">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" required>
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                    <label for="preview_image_ids">Preview Image IDs (comma-separated):</label>
                    <input type="text" id="preview_image_ids" name="preview_image_ids">
                    
                    <!-- Image Upload Section -->
                    <div id="imageUploadContainer">
                        <div class="image-upload">
                            <label for="image">Upload Image:</label>
                            <input type="file" id="image" name="image[]" accept="image/*">
                            <div id="imagePreview"></div>
                            <label for="caption">Caption:</label>
                            <input type="text" id="caption" name="caption[]">
                            <label for="credit">Credit:</label>
                            <input type="text" id="credit" name="credit[]">
                            <label for="credit_url">Credit URL:</label>
                            <input type="text" id="credit_url" name="credit_url[]">
                            <label for="alttext">Alt Text:</label>
                            <input type="text" id="alttext" name="alttext[]">
                        </div>
                    </div>
                    <button type="button" id="addImageBtn">+ Add Another Image</button>
                    
                    <button type="submit" id="submitProductBtn">Save</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Modal handling
        const modal = document.getElementById('productModal');
        const createBtn = document.getElementById('createProductBtn');
        const closeModal = document.querySelector('.close');
        const productForm = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const productIdInput = document.getElementById('productId');
        const submitBtn = document.getElementById('submitProductBtn');
        const imageUploadContainer = document.getElementById('imageUploadContainer');
        const addImageBtn = document.getElementById('addImageBtn');

        // Open modal for creating a product
        createBtn.onclick = () => {
            modalTitle.textContent = 'Create Product';
            productForm.reset();
            productIdInput.value = '';
            imageUploadContainer.innerHTML = getImageUploadHTML();
            modal.style.display = 'block';
        };

        // Open modal for editing a product
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.onclick = () => {
                modalTitle.textContent = 'Edit Product';
                const productId = btn.dataset.id;

                fetch(`/pages/admin/get_product.php?id=${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        productIdInput.value = data.id;
                        document.getElementById('name').value = data.name;
                        document.getElementById('category').value = data.category;
                        document.getElementById('price').value = data.price;
                        document.getElementById('description').value = data.description;
                        document.getElementById('preview_image_ids').value = data.preview_image_ids;
                        imageUploadContainer.innerHTML = '';
                        if (data.images && data.images.length > 0) {
                            data.images.forEach(image => {
                                imageUploadContainer.innerHTML += getImageUploadHTML(image);
                            });
                        } else {
                            imageUploadContainer.innerHTML = getImageUploadHTML();
                        }
                        modal.style.display = 'block';
                    });
            };
        });

        // Handle close
        closeModal.onclick = () => {
            modal.style.display = 'none';
        };

        // Add new image upload section
        addImageBtn.onclick = () => {
            imageUploadContainer.innerHTML += getImageUploadHTML();
        };

        // Function to get image upload HTML
        function getImageUploadHTML(image = {}) {
            return `
                <div class="image-upload">
                    <label for="image">Upload Image:</label>
                    <input type="file" id="image" name="image[]" accept="image/*">
                    <div class="image-preview">${image.image_url ? `<img src="${image.image_url}" alt="${image.alttext}" style="max-width: 100%;">` : ''}</div>
                    <label for="caption">Caption:</label>
                    <input type="text" id="caption" name="caption[]" value="${image.caption || ''}">
                    <label for="credit">Credit:</label>
                    <input type="text" id="credit" name="credit[]" value="${image.credit || ''}">
                    <label for="credit_url">Credit URL:</label>
                    <input type="text" id="credit_url" name="credit_url[]" value="${image.credit_url || ''}">
                    <label for="alttext">Alt Text:</label>
                    <input type="text" id="alttext" name="alttext[]" value="${image.alttext || ''}">
                </div>
            `;
        }

        // Submit form
        productForm.onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(productForm);

            fetch('/pages/admin/save_product.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                });
        };

        // Handle delete
        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.onclick = () => {
                if (confirm('Are you sure you want to delete this product?')) {
                    fetch(`/pages/admin/delete_product.php?id=${btn.dataset.id}`, {
                            method: 'DELETE'
                        })
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) location.reload();
                        });
                }
            };
        });
    </script>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>