<?php

/**
 * PHP Script for Displaying Featured Articles on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script connects to the database and retrieves the latest articles,
 * displaying them on the front page along with their associated category slugs.
 * It also includes meta tags for SEO and social media sharing, along with a
 * structured header for the website.
 *
 * Database Connection:
 * - Requires 'includes/databaseconnection.php' to establish a connection to the database.
 *
 * SQL Query:
 * - Selects the latest 10 articles along with their title, meta description,
 *   image URL, image alt text, and category slug.
 * - Articles are ordered by their published date in descending order.
 *
 * Output:
 * - If articles are found, the script will display the first article prominently,
 *   followed by a list of the next four articles. If no articles are available,
 *   a message will indicate that no articles were found.
 *
 * Includes:
 * - 'includes/head.php': For common head elements and styles.
 * - 'includes/consentbanner.php': For user consent management.
 * - 'includes/navbar.php': For site navigation.
 * - 'includes/footer.php': For common footer content.
 *
 * Frontend:
 * - Utilizes HTML5 structure with proper semantic tags for accessibility.
 * - Includes Open Graph and Twitter meta tags for enhanced social sharing.
 * - Structured data (JSON-LD) for better search engine understanding.
 */

include 'includes/databaseconnection.php';

session_start();
$session_id = session_id();

// Query to get the latest articles along with their category slugs and image data
$sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, categories.slug AS category_slug, 
               images.image_url, images.alttext, images.caption, images.credit, images.credit_url 
        FROM articles 
        JOIN categories ON articles.category = categories.name 
        LEFT JOIN images ON articles.image_id = images.id 
        WHERE articles.public = 1
        ORDER BY articles.published_date DESC 
        LIMIT 10";
$result = $conn->query($sql);

$articles = [];
if ($result->num_rows > 0) {
    // Fetch the articles along with category slugs
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
} else {
    $articles = [];
}

// Fetch latest products (e.g., the last 5 entries)
$products_sql = "SELECT products.slug AS product_slug, products.name, products.meta_description, products.preview_image_ids, shop_categories.slug AS category_slug
        FROM products 
        JOIN shop_categories ON products.category = shop_categories.name
        WHERE products.public = 1 
        LIMIT 3";
$result = $conn->query($products_sql);

$products = [];
if ($result->num_rows > 0) {
    // Fetch the articles along with category slugs
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$on_homepage = true; // lets navbar know we are on the homepage
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/head.php'; ?>
    <title>BlueSky Homesteading - Your Guide to Sustainable Living</title>
    <meta name="description" content="Explore articles and resources on homesteading, sustainable living, gardening, and self-sufficiency.">
    <meta name="keywords" content="homesteading, gardening, sustainable living, self-sufficiency, articles">
    <meta property="og:title" content="BlueSky Homesteading - Your Guide to Sustainable Living">
    <meta property="og:description" content="Explore articles and resources on homesteading, sustainable living, gardening, and self-sufficiency.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.blueskyhomesteading.com">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="https://www.blueskyhomesteading.com">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "BlueSky Homesteading",
            "url": "https://www.blueskyhomesteading.com",
            "description": "Explore articles and resources on homesteading, sustainable living, gardening, and self-sufficiency."
        }
    </script>
</head>

<body>
    <?php include 'includes/consentbanner.php'; ?>
    <?php include 'includes/navbar.php'; ?>
    <main>
        <div class="video-container">
            <video autoplay muted loop playsinline>
                <source src="https://www.blueskyhomesteading.com/videos/field_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="overlay">
                <div class="banner-content">
                    <h1>Harvest the life you love.</h1>
                    <p>Explore resources to inspire a healthy, sustainable homesteading lifestyle.</p>
                    <div class="banner-buttons">
                        <a href="https://www.blueskyhomesteading.com/blog" class="btn">Read our blog</a>
                        <a href="https://www.blueskyhomesteading.com/shop" class="btn secondary">See our shop</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="frontpage as_seen_at">
            <div class="page-indent">
                <h2>As featured at</h2>

                <div class="company_logos">
                    <a href="https://columbiapamarkethouse.org/" class="company_logo">
                        <img src="https://www.blueskyhomesteading.com/images/spotlight_logos/columbia_market.svg" alt="Columbia Market logo" />
                    </a>
                    <a href="https://www.facebook.com/p/Fount-and-Fill-100079901063870/" class="company_logo">
                        <img src="https://www.blueskyhomesteading.com/images/spotlight_logos/fount_and_fill.jpeg" alt="Fount and Fill logo" />
                    </a>
                    <a href="https://www.facebook.com/PebblesandLaceGifts/" class="company_logo">
                        <img src="https://www.blueskyhomesteading.com/images/spotlight_logos/pebbles_and_lace.jpg" alt="Pebbles and Lace logo" />
                    </a>
                    <div class="company_logo">
                        <img src="https://www.blueskyhomesteading.com/images/spotlight_logos/a_tiny_homestead.jpeg" alt="A Tiny Homestead logo" />
                    </div>
                </div>
            </div>
        </section>

        <section class="frontpage products_section">
            <div class="page-indent">
                <h2>Shop our products</h2>
                <div class="product-preview-section">
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            // Fetch image details if there are any image IDs
                            $image_data = [];
                            if (!empty($product['preview_image_ids'])) {
                                $image_ids = explode(',', $product['preview_image_ids']);

                                $image_id = trim($image_ids[0]);
                                $stmt = $conn->prepare("SELECT image_url, alttext, public FROM images WHERE id = ? AND public = 1 LIMIT 1");
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
                            echo '<span class="buy-btn">View</span>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }

                    $conn->close();
                    ?>

                    <a href="https://www.blueskyhomesteading.com/shop" class="see-more-btn">Explore all products</a>
                </div>
            </div>
        </section>

        <section class="frontpage blog">
            <div class="page-indent">
                <h2>Read our blog</h2>
                <?php
                if (!empty($articles)) {
                    $counter = 1;
                    foreach ($articles as $article) {
                        if ($counter == 1) {
                            echo '<a class="top-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
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
                            echo '<a class="top-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
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
                            echo '<a class="top-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
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
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>