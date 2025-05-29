<?php
// File: index.php
// Author: Gabriel Sullivan
// Purpose: Homepage for BlueSky Homesteading
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
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        SITE_NAME . " - Your Guide to Sustainable Living",
        "Explore articles and resources on homesteading, sustainable living, gardening, and self-sufficiency.",
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL,
        SITE_NAME
    );
    $pageMeta->render();
    ?>
</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>
    <main>
        <a href="https://www.blueskyhomesteading.com/shop" class="frontpage split_section mobile_column_reverse">
            <div class="text_side">
                <h1>Nourish your skin.</h1>
                <p>Experience the healing power of all-natural skincare.</p>
                <div class="banner-buttons"><span class="btn">Shop skincare</span></div>
            </div>
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/shop_shelves.jpg" alt="Shop Preview" loading="lazy">
            </div>
        </a>

        <section class="frontpage header_section">
            <div class="page-indent">
                <h2>Our top picks</h2>
                <div class="content_section">
                    <div class="products-showcase">
                        <div class="product-preview-section">
                            <?php
                            // Fetch latest products (e.g., the last 3 entries)
                            $products_sql = "SELECT products.slug AS product_slug, products.name, products.price, products.meta_description, products.preview_image_ids, shop_categories.slug AS category_slug
                                FROM products 
                                JOIN shop_categories ON products.category = shop_categories.name
                                WHERE products.public = 1 
                                LIMIT 3";
                            $products = $conn->fetchAll($products_sql);

                            if (!empty($products)) {
                                foreach ($products as $product) {
                                    // Fetch image details if there are any image IDs
                                    $image_data = [];
                                    if (!empty($product['preview_image_ids'])) {
                                        $image_ids = explode(',', $product['preview_image_ids']);

                                        $image_id = trim($image_ids[0]);
                                        // Fetch first image
                                        $images_sql = "SELECT image_url, alttext, public FROM images WHERE id = ? AND public = 1 LIMIT 1";
                                        $image_data = $conn->fetchAll($images_sql, [$image_id]);
                                    }

                                    echo '<a class="product-preview" href="' . SITE_URL . '/shop/' . htmlspecialchars($product['category_slug']) . '/' . htmlspecialchars($product['product_slug']) . '">';
                                    foreach ($image_data as $image) {
                                        echo '<div class="product-image-container">';
                                        echo '<img src="' . htmlspecialchars($image['image_url']) . '" alt="' . htmlspecialchars($image['alttext']) . '">';
                                        echo '</div>';
                                    }
                                    echo '<div class="text">';
                                    echo '<span class="name">' . $product['name'] . '</span>';
                                    echo '<span class="price">' . '$' . number_format($product['price'], 2) . '</span>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="frontpage header_section three-tiled">
            <div class="page-indent">
                <h2>Our values</h2>

                <div class="content_section">
                    <div class="value">
                        <div class="value-image">
                            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#FFFFFF">
                                <path d="M480-80q-73-9-145-39.5T206.5-207Q150-264 115-351T80-560v-40h40q51 0 105 13t101 39q12-86 54.5-176.5T480-880q57 65 99.5 155.5T634-548q47-26 101-39t105-13h40v40q0 122-35 209t-91.5 144q-56.5 57-128 87.5T480-80Zm-2-82q-11-166-98.5-251T162-518q11 171 101.5 255T478-162Zm2-254q15-22 36.5-45.5T558-502q-2-57-22.5-119T480-742q-35 59-55.5 121T402-502q20 17 42 40.5t36 45.5Zm78 236q37-12 77-35t74.5-62.5q34.5-39.5 59-98.5T798-518q-94 14-165 62.5T524-332q12 32 20.5 70t13.5 82Zm-78-236Zm78 236Zm-80 18Zm46-170ZM480-80Z" />
                            </svg>
                        </div>
                        <div class="value-text">
                            <h3>Pure health</h3>
                            <p>Our products are made with natural, organic ingredients that are good for you and the environment.</p>
                        </div>
                    </div>
                    <div class="value">
                        <div class="value-image">
                            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#FFFFFF">
                                <path d="M200-80 40-520l200-120v-240h160v240l200 120L440-80H200Zm480 0q-17 0-28.5-11.5T640-120q0-17 11.5-28.5T680-160h120v-80H680q-17 0-28.5-11.5T640-280q0-17 11.5-28.5T680-320h120v-80H680q-17 0-28.5-11.5T640-440q0-17 11.5-28.5T680-480h120v-80H680q-17 0-28.5-11.5T640-600q0-17 11.5-28.5T680-640h120v-80H680q-17 0-28.5-11.5T640-760q0-17 11.5-28.5T680-800h160q33 0 56.5 23.5T920-720v560q0 33-23.5 56.5T840-80H680Zm-424-80h128l118-326-124-74H262l-124 74 118 326Zm64-200Z" />
                            </svg>
                        </div>
                        <div class="value-text">
                            <h3>All-natural beauty</h3>
                            <p>Embrace the power of nature with our pure and organic skincare products.</p>
                        </div>
                    </div>
                    <div class="value">
                        <div class="value-image">
                            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#FFFFFF">
                                <path d="M216-176q-45-45-70.5-104T120-402q0-63 24-124.5T222-642q35-35 86.5-60t122-39.5Q501-756 591.5-759t202.5 7q8 106 5 195t-16.5 160.5q-13.5 71.5-38 125T684-182q-53 53-112.5 77.5T450-80q-65 0-127-25.5T216-176Zm112-16q29 17 59.5 24.5T450-160q46 0 91-18.5t86-59.5q18-18 36.5-50.5t32-85Q709-426 716-500.5t2-177.5q-49-2-110.5-1.5T485-670q-61 9-116 29t-90 55q-45 45-62 89t-17 85q0 59 22.5 103.5T262-246q42-80 111-153.5T534-520q-72 63-125.5 142.5T328-192Zm0 0Zm0 0Z" />
                            </svg>
                        </div>
                        <div class="value-text">
                            <h3>Self-sustainability</h3>
                            <p>We believe in living in harmony with nature, using resources responsibly, and promoting practices that ensure the well-being of future generations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a href="https://www.blueskyhomesteading.com/about" class="frontpage split_section mobile_column_reverse">
            <div class="text_side">
                <h2>From our family to yours.</h2>
                <p>All our hand-crafted products are handcrafted with that small business love you can’t find anywhere else.</p>
                <div class="banner-buttons"><span class="btn secondary">Read more</span></div>
            </div>
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/whipped_tallow.jpg" alt="Shop Preview" loading="lazy">
            </div>
        </a>

        <section class="frontpage header_section">
            <div class="page-indent">
                <h2>From our blog</h2>
                <div class="blog-articles">

                    <?php
                    // Query to get the latest articles along with their category slugs and image data
                    $sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, categories.slug AS category_slug, 
                images.image_url, images.alttext, images.caption, images.credit, images.credit_url 
                FROM articles 
                JOIN categories ON articles.category = categories.name 
                LEFT JOIN images ON articles.image_id = images.id 
                WHERE articles.public = 1
                ORDER BY articles.published_date DESC 
                LIMIT 10";
                    $articles = $conn->fetchAll($sql);

                    if (!empty($articles)) {
                        foreach ($articles as $article) {
                            echo '<a class="top-article" href="' . SITE_URL . '/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
                            echo '<div class="frontpage-article-image-parent">';
                            if (!empty($article['image_url'])) {
                                echo '<img src="' . htmlspecialchars($article['image_url']) . '" alt="' . htmlspecialchars($article['alttext']) . '" class="frontpage-article-image" loading="lazy">';
                            }
                            echo '</div>';
                            echo '<div class="frontpage-article-text">';
                            echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "No articles found.";
                    }
                    ?>

                </div>
            </div>
        </section>
    </main>
    <?php require_once FOOTER_PATH; ?>
    <?php $conn->close(); ?>
</body>

</html>