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
        <section class="frontpage hero_section">
            <div class="page-indent">
                <div class="banner">
                    <div class="banner-content">
                        <h1>Explore Nature’s gifts for healthier skin and a healthier life.</h1>
                    </div>
                    <div class="banner-action">
                        <div class="banner-buttons">
                            <a href="<?= SITE_URL; ?>/shop" class="btn">Shop skincare</a>
                            <a href="<?= SITE_URL; ?>/blog" class="btn secondary">Read our blog</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a href="https://www.blueskyhomesteading.com/shop/skincare/tallow-cream" class="frontpage split_section">
            <div class="text_side">
                <h2>Grass-Fed Whipped Tallow</h2>
                <p>Experience the nourishing power of all-natural skincare.</p>
                <span>Shop now</span>
            </div>
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/whipped_tallow.jpg" alt="Shop Preview" loading="lazy">
            </div>
        </a>

        <a href="https://www.blueskyhomesteading.com/shop/skincare/tallow-lip-balm" class="frontpage split_section">
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/tallow_balms.jpg" alt="Shop Preview" loading="lazy">
            </div>
            <div class="text_side">
                <h2>Beef Tallow Lip Balms</h2>
                <p>Nourish your lips.</p>
                <span>Shop now</span>
            </div>
        </a>

        <section class="frontpage header_section three-tiled">
            <div class="page-indent">
                <h2>Our values</h2>

                <div class="content_section">
                    <div class="value">
                        <div class="value-image">
                            <img src="https://www.blueskyhomesteading.com/images/icons/cross.svg" alt="Crpss icon" loading="lazy">
                        </div>
                        <div class="value-text">
                            <h3>Pure health</h3>
                            <p>Our products are made with natural, organic ingredients that are good for you and the environment.</p>
                        </div>
                    </div>
                    <div class="value">
                        <div class="value-image">
                            <img src="https://www.blueskyhomesteading.com/images/icons/lips.svg" alt="Lips icon" loading="lazy">
                        </div>
                        <div class="value-text">
                            <h3>All-natural beauty</h3>
                            <p>Embrace the power of nature with our pure and organic skincare products.</p>
                        </div>
                    </div>
                    <div class="value">
                        <div class="value-image">
                            <img src="https://www.blueskyhomesteading.com/images/icons/leaf.svg" alt="Leaf icon" loading="lazy">
                        </div>
                        <div class="value-text">
                            <h3>Self-sustainability</h3>
                            <p>We believe in living in harmony with nature, using resources responsibly, and promoting practices that ensure the well-being of future generations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="frontpage split_section">
            <div class="text_side">
                <h2>From our family to yours.</h2>
                <p>All our products are handcrafted with that small business love you can’t find anywhere else.</p>
            </div>
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/shop_shelves.jpg" alt="Shop Preview" loading="lazy">
            </div>
        </section>

        <section class="frontpage header_section">
            <div class="page-indent">
                <h2>Latest articles</h2>
                <div class="content_section">
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
    <?php $conn->close(); ?>
</body>

</html>