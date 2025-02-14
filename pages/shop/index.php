<?php
// File: shop/index.php
// Author: Gabriel Sullivan
// Purpose: Shop homepage for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

// Query for all public products
$sql = "SELECT p.id, p.name, p.price, p.preview_image_ids, p.slug AS product_slug, c.slug AS category_slug 
        FROM products AS p 
        JOIN shop_categories AS c ON p.category = c.name 
        WHERE p.public = 1 
        ORDER BY p.id DESC";
$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php'; ?>
    <title>BlueSky Homesteading Shop - Sustainable Products for a Greener Life</title>
    <meta name="description" content="Shop our selection of sustainable homesteading products at BlueSky Homesteading.">
    <link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/styles.css">
    <style>
        /* Extra CSS for the shop homepage */
        .shop-hero {
            background: url('https://www.blueskyhomesteading.com/images/shop-hero.jpg') center/cover no-repeat;
            padding: 80px 0;
            text-align: center;
            color: #fff;
        }
        .shop-hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .shop-hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .shop-hero .btn {
            padding: 15px 30px;
            font-size: 1em;
            background-color: #2c7;
            border: none;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            padding: 40px 0;
        }
        .product-card {
            border: 1px solid #e0e0e0;
            padding: 15px;
            text-align: center;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }
        .product-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        .product-card .product-name {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .product-card .product-price {
            font-size: 1em;
            margin-bottom: 15px;
        }
        .product-card .view-details {
            text-decoration: none;
            background-color: #2c7;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .product-card .view-details:hover {
            background-color: #279;
        }
    </style>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>

    <header class="shop-hero">
        <h1>Welcome to Our Shop</h1>
        <p>Discover sustainable products curated for a healthier lifestyle.</p>
    </header>

    <section class="frontpage products_section">
            <div class="page-indent">
                <h2>Our products</h2>
                <div class="product-preview-section">
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            // Fetch image details if there are any image IDs
                            $image_data = [];
                            if (!empty($product['preview_image_ids'])) {
                                $image_ids = explode(',', $product['preview_image_ids']);

                                $image_id = trim($image_ids[0]);
                                $stmt = $conn->prepare("SELECT image_url, alttext, public FROM images WHERE id = ? AND public = 1 LIMIT 4");
                                $stmt->bind_param("i", $image_id);
                                $stmt->execute();
                                $image_result = $stmt->get_result();

                                if ($image_result->num_rows > 0) {
                                    $image_data[] = $image_result->fetch_assoc();
                                }

                                $stmt->close();
                            }

                            echo '<a class="product-preview" href="https://www.blueskyhomesteading.com/shop/' . htmlspecialchars($product['category_slug']) . '/' . htmlspecialchars($product['product_slug']) . '">';
                            foreach ($image_data as $image) {
                                echo '<img src="' . htmlspecialchars($image['image_url']) . '" alt="' . htmlspecialchars($image['alttext']) . '">';
                            }
                            echo '<div class="text">';
                            echo '<span class="name">' . $product['name'] . '</span>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </section>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>
</html>
