<?php
// File: articleshomepage.php
// Author: Gabriel Sullivan
// Purpose: Homepage for blog for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
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
                $blogPostList = new BlogPostList($conn);
                $blogPostList->render($sql);
                ?>
            </div>
            </main>
            <?php require_once FOOTER_PATH; ?>
</body>

</html>