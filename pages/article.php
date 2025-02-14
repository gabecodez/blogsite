<?php
// File: article.php
// Author: Gabriel Sullivan
// Purpose: Article page template for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';
 
 // Function to handle 404 errors
 function show404() {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php';
     http_response_code(404);
     exit();
 }
 
 // Validate and retrieve the category slug and article slug from the URL
 $category_slug = isset($_GET['category_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['category_slug']) : '';
 $article_slug = isset($_GET['slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['slug']) : '';
 
 if (!$category_slug || !$article_slug) {
     show404();
 }
 
 try {
     // Prepare a combined statement for efficiency
     $stmt = $conn->prepare("
         SELECT a.title, a.content, a.meta_description, a.meta_keywords, a.image_id, c.name AS category 
         FROM articles AS a 
         JOIN categories AS c ON c.slug = ? AND a.slug = ? AND a.category = c.name 
         WHERE a.public = 1
     ");
     $stmt->bind_param("ss", $category_slug, $article_slug);
     $stmt->execute();
     $result = $stmt->get_result();
 
     if ($result->num_rows > 0) {
         // Fetch the article
         $article = $result->fetch_assoc();
         $page_title = $article['title'];
         $category = $article['category'];
         $meta_description = $article['meta_description'];
         $meta_keywords = $article['meta_keywords'];
         $image_id = $article['image_id'];
         $content = $article['content'];
         http_response_code(200); // Set HTTP status code to 200 OK
     } else {
         show404();
     }
 } catch (Exception $e) {
     // Log the error and show a 404 error page without revealing internal details
     error_log($e->getMessage());
     show404();
 } finally {
     // Close the statement and connection
     $stmt->close();
 }
 

// If article was found, fetch the image details from the images table
if (!empty($image_id)) {
    $stmt = $conn->prepare("SELECT image_url, caption, credit, credit_url, alttext, public FROM images WHERE id = ? AND public = 1");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $image_result = $stmt->get_result();

    if ($image_result->num_rows > 0) {
        $image_data = $image_result->fetch_assoc();
        
        $image_url = $image_data['image_url'];
        $caption = $image_data['caption'];
        $credit = $image_data['credit'];
        $credit_url = $image_data['credit_url'];
        $alttext = $image_data['alttext'];
    }
    
    $stmt->close();
}

// Inject ads into content
$content_with_ads = $content;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php'; ?>
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>">
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
                "@id": "https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>"
            },
            "datePublished": "2023-01-01",
            "dateModified": "<?php echo date('Y-m-d'); ?>"
        }
    </script>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>
    <main class="main-page">
        <div class="article-content">
            <header>
                <h1><?php echo htmlspecialchars($page_title); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol>
                        <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                        <li><a href="https://www.blueskyhomesteading.com/blog">Blog</a></li>
                        <li><a href="https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug); ?>"><?php echo htmlspecialchars(ucfirst($category)); ?></a></li>
                        <li aria-current="page"><a href="https://www.blueskyhomesteading.com/blog/<?php echo htmlspecialchars($category_slug) . '/' . htmlspecialchars($article_slug); ?>"><?php echo htmlspecialchars($page_title); ?></a></li>
                    </ol>
                </nav>
                
                <?php if (!empty($image_url)): ?>
                    <figure class="article-image">
                        <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($alttext); ?>" class="responsive-img">
                        <?php if (!empty($caption)): ?>
                            <figcaption><?php echo htmlspecialchars($caption); ?></figcaption>
                        <?php endif; ?>
                        <?php if (!empty($credit) && !empty($credit_url)): ?>
                            <p class="image-credit">
                                Credit: <a href="<?php echo htmlspecialchars($credit_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars($credit); ?></a>
                            </p>
                        <?php elseif (!empty($credit)): ?>
                            <p class="image-credit">Credit: <?php echo htmlspecialchars($credit); ?></p>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </header>
            <article>
                <?php echo $content_with_ads; ?>
            </article>
        </div>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>
</html>
