<?php
// File: category.php
// Author: Gabriel Sullivan
// Purpose: Blog category page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

// Get the category slug from the URL
$category_slug = isset($_GET['category_slug']) ? $_GET['category_slug'] : '';

if ($category_slug) {
    // Retrieve the category from the category_slug
    $stmt = $conn->prepare("SELECT name, subheading, description FROM categories WHERE slug = ?");
    $stmt->bind_param("s", $category_slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category_data = $result->fetch_assoc();
        $category = $category_data['name'];

        // Fetch articles from the given category
        $stmt = $conn->prepare("SELECT slug, title, meta_description FROM articles WHERE category = ? AND public = 1 ORDER BY published_date DESC");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        $articles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        } else {
            $articles = [];
        }

        // Close the statement and result set
        $stmt->close();
        $result->free();
    } else {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php'; // Include 404 content
        http_response_code(404); // Set HTTP status code to 404 Not Found
        exit();
    }
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php'; // Include 404 content
    http_response_code(404); // Set HTTP status code to 404 Not Found
    exit();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php';
   $pageTitle = "Articles in ".htmlspecialchars($category)." - BlueSky Homesteading";
   $pageDescription = htmlspecialchars($category_data['description']);
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/blog/'.$category_slug.'";
   $siteName = "BlueSky Homesteading";
   $twitterHandle = "";
   $creatorHandle = "";
   ?>
   <title><?php echo $pageTitle; ?></title>
   <link rel="canonical" href="<?php echo $pageURL; ?>">
   <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="keywords" content="homesteading, articles, <?php echo htmlspecialchars($category); ?>">
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
            "name": "Articles in '.$category.' - BlueSky Homesteading",
            "url": "https://www.blueskyhomesteading.com/blog/'.$category_slug.'",
            "description": "'.$category_data['description'].'"
        }
    </script>'; ?>
</head>


<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php';; ?>
    <main class="main-page">
        <header class="article__list__header">
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <h3><?php echo htmlspecialchars($category_data['subheading']); ?></h3>
            <p><?php echo htmlspecialchars($category_data['description']); ?></p>
        </header>
        <div class="main-part">
            <?php
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    echo '<a class="latest-article" href="https://www.blueskyhomesteading.com/blog/' . htmlspecialchars($category_slug) . '/' . htmlspecialchars($article['slug']) . '">';
                    echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($article['meta_description']) . '</p>';
                    echo '</a>';
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
