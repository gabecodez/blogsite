<?php
/**
 * PHP Script for Displaying Individual Articles on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script retrieves a specific article based on the provided category
 * and article slugs from the URL. It fetches the article details from the
 * database and displays them on the page, including SEO metadata for 
 * improved visibility on search engines and social media platforms.
 *
 * Database Connection:
 * - Requires 'includes/databaseconnection.php' to connect to the database.
 *
 * URL Parameters:
 * - Expects 'category_slug' and 'slug' parameters in the URL to identify 
 *   the correct article.
 *
 * SQL Queries:
 * - The first query retrieves the category name based on the category slug.
 * - The second query retrieves the article details (title, content, 
 *   meta description, keywords, image URL, and alt text) based on the 
 *   article slug and the corresponding category.
 *
 * Output:
 * - If the article is found, it is displayed along with its title, content,
 *   and relevant metadata. If not found, a 404 error page is shown.
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

include '../includes/databaseconnection.php';

// Get the category slug and article slug from the URL
$category_slug = $_GET['category_slug'] ?? '';
$article_slug = $_GET['slug'] ?? '';

// Initialize variables for article data
$page_title = $meta_description = $meta_keywords = $image_url = $image_alt_text = $content = '';

// Function to handle 404 errors
function show404() {
    include '../404.php';
    http_response_code(404);
    exit();
}

if ($category_slug && $article_slug) {
    // Retrieve the category
    $stmt = $conn->prepare("SELECT name FROM categories WHERE slug = ?");
    $stmt->bind_param("s", $category_slug);
    $stmt->execute();
    $category_result = $stmt->get_result();

    if ($category_result->num_rows > 0) {
        $category_data = $category_result->fetch_assoc();
        $category = $category_data['name'];
        
        // Fetch the article based on slug and category
        $stmt = $conn->prepare("SELECT title, content, meta_description, meta_keywords, image_url, image_alt_text FROM articles WHERE slug = ? AND category = ?");
        $stmt->bind_param("ss", $article_slug, $category);
        $stmt->execute();
        $article_result = $stmt->get_result();

        if ($article_result->num_rows > 0) {
            // Fetch the article
            $article = $article_result->fetch_assoc();
            $page_title = $article['title'];
            $meta_description = $article['meta_description'];
            $meta_keywords = $article['meta_keywords'];
            $image_url = $article['image_url'];
            $image_alt_text = $article['image_alt_text'];
            $content = $article['content'];
            http_response_code(200); // Set HTTP status code to 200 OK
        } else {
            show404();
        }
        
        // Close the article statement
        $stmt->close();
    } else {
        show404();
    }
} else {
    show404();
}

// Close the database connection
$conn->close();

// Inject ads into content
$content_with_ads = $content;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/head.php'; ?>
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://www.blueskyhomesteading.com/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="https://www.blueskyhomesteading.com/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "<?php echo htmlspecialchars($page_title); ?>",
            "description": "<?php echo htmlspecialchars($meta_description); ?>",
            "author": {
                "@type": "Person",
                "name": "Author Name"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Blue Sky Homesteading",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://example.com/logo.png"
                }
            },
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://www.blueskyhomesteading.com/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>"
            },
            "datePublished": "2023-01-01",
            "dateModified": "<?php echo date('Y-m-d'); ?>"
        }
    </script>
</head>
<body>
    <?php include '../includes/consentbanner.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    <main class="main-page">
        <div class="article-content">
            <header>
                <h1><?php echo htmlspecialchars($page_title); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol>
                        <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                        <li><a href="https://www.blueskyhomesteading.com/<?php echo htmlspecialchars($category_slug); ?>"><?php echo htmlspecialchars(ucfirst($category)); ?></a></li>
                        <li aria-current="page"><a href="https://www.blueskyhomesteading.com/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>"><?php echo htmlspecialchars($page_title); ?></a></li>
                    </ol>
                </nav>
                <?php if ($image_url) : ?>
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt_text; ?>" class="article-img">
                <?php endif; ?>
            </header>
            <article>
                <?php echo $content_with_ads; ?>
            </article>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
