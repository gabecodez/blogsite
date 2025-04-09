<?php
// File: category.php
// Author: Gabriel Sullivan
// Purpose: Blog category page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

// Get the category slug from the URL
$category_slug = isset($_GET['category_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['category_slug']) : '';

// Retrieve the category from the category_slug
$category_data = $conn->fetchAll("SELECT name, subheading, description FROM categories WHERE slug = ?", [$category_slug]);

if (!empty($category_data) && isset($category_data[0]['name'])) {
    $category = $category_data[0]['name'];
    $category_row = $category_data[0];
} else {
    http_response_code(404); // Set HTTP status code to 404 Not Found
    require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php'; // Include 404 content
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        "Articles in " . htmlspecialchars($category) . " - " . SITE_NAME,
        $category_row['description'],
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL . "/blog/" . $category_slug,
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
    <main class="page-indent">
        <header class="article__list__header">
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <h3><?php echo htmlspecialchars($category_row['subheading']); ?></h3>
            <p><?php echo htmlspecialchars($category_row['description']); ?></p>
        </header>
        <div class="blog-articles">
            <?php
            // Query to get the latest articles along with their category slugs and image data
            $sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, 
                images.image_url, images.alttext, images.caption, images.credit, images.credit_url 
                FROM articles
                LEFT JOIN images ON articles.image_id = images.id 
                WHERE articles.category = ? AND articles.public = 1
                ORDER BY articles.published_date DESC 
                LIMIT 10";
            $articles = $conn->fetchAll($sql, [$category]);

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

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </main>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>