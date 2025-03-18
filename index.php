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
                        <h1>Explore Nature’s gifts for health.</h1>
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

        <a href="https://www.blueskyhomesteading.com/shop/skincare/tallow-cream" class="frontpage split_section mobile_column_reverse">
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

        <a href="https://www.blueskyhomesteading.com/about" class="frontpage split_section">
            <div class="text_side">
                <h2>From our family to yours.</h2>
                <p>All our products are handcrafted with that small business love you can’t find anywhere else.</p>
                <span>About</span>
            </div>
            <div class="image_side">
                <img src="https://www.blueskyhomesteading.com/images/shop_shelves.jpg" alt="Shop Preview" loading="lazy">
            </div>
        </a>

        <section class="frontpage header_section">
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