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

$conn->close();
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
    <main class="main-page">
        <header class="banner">
            <div class="banner-content">
                <h1>Sow, harvest, and flourish — your homestead journey starts here.</h1>
                <div class="banner-buttons">
                    <a href="https://www.blueskyhomesteading.com/shop" class="btn">Shop</a>
                    <a href="https://www.blueskyhomesteading.com/blog" class="btn secondary">Blog</a>
                </div>
            </div>
        </header>
        <section class="frontpage">
            <h2 class="section-header">Featured Articles</h2>
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
                        echo '</div>';
                        echo '</a>';
                    } else if ($counter == 2) {
                        echo '<div class="latest-part">';
                        echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
                        /*echo '<div class="article-image">';
                                    if (!empty($article['image_url'])) {
                                        echo '<img src="'.htmlspecialchars($article['image_url']).'" alt="'.htmlspecialchars($article['alttext']).'" class="responsive-img" loading="lazy">';
                                    }
                                    echo '</div>';*/
                        echo '<div class="frontpage-article-text">';
                        echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                        echo '<p>' . htmlspecialchars($article['meta_description']) . '</p>';
                        echo '</div>';
                        echo '</a>';
                    } else if ($counter > 2 && $counter <= 3) {
                        echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
                        echo '<div class="frontpage-article-text">';
                        echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                        echo '</div>';
                        echo '</a>';
                    }
                    if ($counter == 5) {
                        echo '</div>';
                    }

                    $counter++;
                }
            } else {
                echo "No articles found.";
            }
            ?>
        </section>

        <section class="frontpage">
            <h2 class="section-header">Featured Products</h2>

        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>