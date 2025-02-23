<?php
// File: articleshomepage.php
// Author: Gabriel Sullivan
// Purpose: Homepage for blog for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

// Query to get the latest articles along with their category slugs
$sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, categories.slug AS category_slug 
        FROM articles 
        JOIN categories ON articles.category = categories.name
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php';
    $pageTitle = "Latest Blog Posts - BlueSky Homesteading";
    $pageDescription = "Discover the latest articles and resources for homesteading enthusiasts.";
    $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
    $pageURL = "https://www.blueskyhomesteading.com/blog";
    $siteName = "BlueSky Homesteading";
    $creatorHandle = "";
    $twitterHandle = "";

    ?>
    <title><?php echo $pageTitle; ?></title>
    <link rel="canonical" href="<?php echo $pageURL; ?>">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="homesteading, articles, resources, tips, self-sufficiency">
    <meta name="author" content="BlueSky Homesteading">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageURL); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteName); ?>">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo htmlspecialchars($twitterHandle); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($pageURL); ?>">
    <meta name="twitter:creator" content="<?php echo htmlspecialchars($creatorHandle); ?>">
    <meta name="linkedin:card" content="summary_large_image">
    <meta name="linkedin:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="linkedin:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="linkedin:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta name="twitter:domain" content="blueskyhomesteading.com">
    <?php echo '<script type="application/ld+json">
      {
         "@context": "https://schema.org",
         "@type": "WebSite",
         "name": "'.$pageTitle.'",
         "url": "'.$pageURL.'",
         "description": "'.$pageDescription.'"
      }
   </script>'; ?>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>
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
                echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/blog/'.htmlspecialchars($article['category_slug']).'/'.htmlspecialchars($article['article_slug']).'">';
                    echo '<div class="frontpage-article-text">';
                    echo '<h3>'.htmlspecialchars($article['title']).'</h3>';
                    echo '<p>'.htmlspecialchars($article['meta_description']).'</p>';
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
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>
</html>
