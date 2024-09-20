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

// Query to get the latest articles along with their category slugs
$sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_url, articles.image_alt_text, categories.slug AS category_slug 
        FROM articles 
        JOIN categories ON articles.category = categories.name 
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
    <header class="frontpage">
         <h1 class="frontpage-header">
            Sow, harvest, and flourish—your homestead journey starts here.
         </h1>
         <p class="frontpage-desc">Your guide to sustainable living and homesteading resources.</p>

         <h2 class="section-header">Featured Articles</h2>
    </header>
    <main class="main-page">
        <?php
        if (!empty($articles)) {
            $counter = 1;
            foreach ($articles as $article) {
                if($counter == 1) {
                    echo '<a class="top-article" href="https://www.blueskyhomesteading.com/'.htmlspecialchars($article['category_slug']).'/'.htmlspecialchars($article['article_slug']).'">';
                    echo '<img src="'.$article['image_url'].'" alt="'.$article['image_alt_text'].'" class="frontpage-article-image" />';
                } else if($counter == 2) {
                    echo '<div class="latest-part">';
                        echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/'.htmlspecialchars($article['category_slug']).'/'.htmlspecialchars($article['article_slug']).'">';
                } else if($counter > 2 && $counter <= 5) {
                    echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/'.htmlspecialchars($article['category_slug']).'/'.htmlspecialchars($article['article_slug']).'">';
                }
                echo '<div class="frontpage-article-text">';
                    echo '<h3>'.htmlspecialchars($article['title']).'</h3>';
                    if($counter == 1) {
                        echo '<p>'.htmlspecialchars($article['meta_description']).'</p>';
                    }
                echo '</div>';
                echo '</a>';

                if($counter == 5) {
                    echo '</div>';
                }

                $counter++;
            }
        } else {
            echo "No articles found.";
        }
        ?>
        <div class="guides-part">
            <h2 class="section-header">Homesteading Guides</h2>
            <ul class="side-list">
                <li><a href="https://www.blueskyhomesteading.com/gardening">Gardening</a></li>
                <li><a href="https://www.blueskyhomesteading.com/raising-chickens">Raising Chickens</a></li>
                <li><a href="https://www.blueskyhomesteading.com/preserving-food">Preserving Food</a></li>
                <!-- Add more guides as needed -->
            </ul>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
