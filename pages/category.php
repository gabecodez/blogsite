<?php
/**
 * PHP Script for Displaying Articles by Category on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script retrieves articles from a specified category based on the
 * category slug provided in the URL. It connects to the database,
 * fetches category information, and retrieves the relevant articles.
 * The results are displayed on the front page with appropriate SEO
 * meta tags and a structured header.
 *
 * Database Connection:
 * - Requires 'includes/databaseconnection.php' to establish a connection to the database.
 *
 * SQL Queries:
 * - The first query fetches the category name based on the category slug.
 * - The second query retrieves articles belonging to that category, ordered by their published date in descending order.
 *
 * Output:
 * - If articles are found, they are displayed as links with titles and meta descriptions.
 * - If no articles or an invalid category slug is provided, a 404 error page is included.
 *
 * Includes:
 * - 'includes/head.php': For common head elements and styles.
 * - 'includes/consentbanner.php': For user consent management.
 * - 'includes/navbar.php': For site navigation.
 * - 'includes/footer.php': For common footer content.
 *
 * Frontend:
 * - Utilizes HTML5 structure with semantic tags for accessibility.
 * - Includes Open Graph and Twitter meta tags for enhanced social sharing.
 * - Structured data (JSON-LD) is used to provide search engines with better context about the website.
 */


include '../includes/databaseconnection.php';

session_start();
$session_id = session_id();

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
        include '../404.php'; // Include 404 content
        http_response_code(404); // Set HTTP status code to 404 Not Found
        exit();
    }
} else {
    include '../404.php'; // Include 404 content
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
   include '../includes/head.php';
   $pageTitle = "Articles in ".htmlspecialchars($category)." - BlueSky Homesteading";
   $pageDescription = htmlspecialchars($category_data['description']);
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug); ?>";
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
   <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Articles in <?php echo htmlspecialchars($category); ?> - BlueSky Homesteading",
            "url": "https://www.blueskyhomesteading.com/blog<php echo htmlspecialchars($category_slug); ?>",
            "description": "<?php echo htmlspecialchars($category_data['description']); ?>"
        }
    </script>
</head>


<body>
    <?php include '../includes/consentbanner.php'; ?>
    <?php include '../includes/navbar.php'; ?>
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
    <?php include '../includes/footer.php'; ?>
</body>
</html>
