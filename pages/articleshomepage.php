<?php
// File: articleshomepage.php
// Author: Gabriel Sullivan
// Purpose: Homepage for blog for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

// Query to get the latest articles along with their category slugs
$sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, categories.slug AS category_slug 
        FROM articles 
        JOIN categories ON articles.category = categories.name
        WHERE articles.public = 1 
        ORDER BY articles.published_date DESC 
        LIMIT 10";
$articles = $conn->fetchAll($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        "Latest Blog Posts - " . SITE_NAME,
        "Discover the latest articles and resources for homesteading enthusiasts.",
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL . "/blog",
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
    <main class="main-page">
        <header class="article__list__header">
            <h1>Latest Blog Posts</h1>
            <p>Our most recent articles and resources for homesteading enthusiasts.</p>
        </header>
        <div class="main-part">
            <?php
            if (!empty($articles)) {
                $counter = 1;
                foreach ($articles as $article) {
                    echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) . '">';
                    echo '<div class="frontpage-article-text">';
                    echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($article['meta_description']) . '</p>';
                    echo '</div>';
                    echo '</a>';
                    $counter++;
                }
            } else {
                echo "No articles found.";
            }
            ?>
        </div>
    </main>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>