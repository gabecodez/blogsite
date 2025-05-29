<?php
// File: shop/index.php
// Author: Gabriel Sullivan
// Purpose: Shop homepage for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

// Query for all public products
$sql = "SELECT p.id, p.name, p.price, p.preview_image_ids, p.slug AS product_slug, c.slug AS category_slug 
        FROM products AS p 
        JOIN shop_categories AS c ON p.category = c.name 
        WHERE p.public = 1 
        ORDER BY p.id DESC";
$products = $conn->fetchAll($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once HEAD_PATH; ?>
    <title>BlueSky Homesteading Shop - Sustainable Products for a Greener Life</title>
    <meta name="description" content="Shop our selection of sustainable homesteading products at BlueSky Homesteading.">
    <link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/styles.css">
</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>

    <header class="shop-hero">
        <h1>Pure, natural goodness for your skin.</h1>
        <p>Discover sustainable skincare free of synthetic fragrances and toxins from our shop.</p>
    </header>

    <section class="frontpage header_section">
        <div class="page-indent">
            <h2>Our products</h2>
            <div class="content_section">
                <div class="products-showcase">
                    <div class="product-preview-section">
                        <?php
                        $productList = new ProductList($conn);
                        $productList->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once FOOTER_PATH; ?>
</body>

</html>