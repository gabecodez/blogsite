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

    // Fetch articles from the given category
    $articles = $conn->fetchAll("SELECT slug, title, meta_description FROM articles WHERE category = ? AND public = 1 ORDER BY published_date DESC", [$category]);
} else {
    http_response_code(404); // Set HTTP status code to 404 Not Found
    require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php'; // Include 404 content
    exit();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        "Articles in " . htmlspecialchars($category) . " - " . SITE_NAME,
        $category_data['description'],
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL . "/blog/'.$category_slug.'",
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
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <h3><?php echo htmlspecialchars($category_data['subheading']); ?></h3>
            <p><?php echo htmlspecialchars($category_data['description']); ?></p>
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