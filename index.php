<?php
// File: index.php
// Author: Gabriel Sullivan
// Purpose: Homepage for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

$on_homepage = true; // lets navbar know we are on the homepage
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
        <section class="frontpage">
            <div class="page-indent">
                <div class="banner">
                    <div class="banner-image mobile">
                    </div>
                    <div class="banner-content">
                        <h1>Harvest the life you love.</h1>
                        <p>Explore resources to inspire a healthy, sustainable homesteading lifestyle.</p>
                        <div class="banner-buttons">
                            <a href="<?= SITE_URL; ?>/shop" class="btn">Shop our products</a>
                            <a href="<?= SITE_URL; ?>/blog" class="btn secondary">Read our blog</a>
                        </div>
                    </div>

                    <div class="banner-image desktop">
                        
                    </div>
                </div>
            </div>

            <div class="dot-hr">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </section>

        <section class="frontpage blog">
            <div class="page-indent">
                <div class="blog-section">
                    <div class="blog-header">
                        <h2>Latest articles</h2>
                    </div>

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
                            $counter = 1;
                            foreach ($articles as $article) {
                                if ($counter == 1) {
                                    echo '<a class="top-article" href="' . SITE_URL . '/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
                                    echo '<div class="frontpage-article-image-parent">';
                                    if (!empty($article['image_url'])) {
                                        echo '<img src="' . htmlspecialchars($article['image_url']) . '" alt="' . htmlspecialchars($article['alttext']) . '" class="frontpage-article-image" loading="lazy">';
                                    }
                                    echo '</div>';
                                    echo '<div class="frontpage-article-text">';
                                    echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                                    echo '<p>' . htmlspecialchars($article['meta_description']) . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                } else if ($counter == 2) {
                                    echo '<div class="latest-part">';
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
                                } else if ($counter > 2 && $counter <= 3) {
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

                                if ($counter == 3) {
                                    echo '</div>';
                                }

                                $counter++;
                            }
                        } else {
                            echo "No articles found.";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>

        <section class="frontpage products_section">
            <div class="page-indent">
                <div class="products-div">

                    <div class="products-header">
                        <h2>Our products</h2>
                    </div>
                    <div class="products-showcase">
                        <div class="product-preview-section">
                            <?php
                            // Fetch latest products (e.g., the last 3 entries)
                            $products_sql = "SELECT products.slug AS product_slug, products.name, products.meta_description, products.preview_image_ids, shop_categories.slug AS category_slug
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

                            <a href="<?= SITE_URL; ?>/shop" class="see-more-btn">Explore all products</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="frontpage as_seen_at">
            <div class="page-indent">
                <h2>As featured at</h2>

                <div class="company_logos">
                    <a href="https://www.facebook.com/PebblesandLaceGifts/" class="company_logo">
                        <img src="https://www.blueskyhomesteading.com/images/spotlight_logos/pebbles_and_lace.jpg" alt="Pebbles and Lace logo" />
                    </a>
                </div>
            </div>
        </section>
    </main>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>