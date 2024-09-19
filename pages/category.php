<?php
include '../includes/databaseconnection.php';

// Get the category slug from the URL
$category_slug = isset($_GET['category_slug']) ? $_GET['category_slug'] : '';

if ($category_slug) {
    // Retrieve the category from the category_slug
    $stmt = $conn->prepare("SELECT name FROM categories WHERE slug = ?");
    $stmt->bind_param("s", $category_slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category_data = $result->fetch_assoc();
        $category = $category_data['name'];

        // Fetch articles from the given category
        $stmt = $conn->prepare("SELECT slug, title, meta_description FROM articles WHERE category = ? ORDER BY published_date DESC");
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
    <?php include '../includes/head.php'; ?>
    <title>Articles in <?php echo htmlspecialchars($category); ?> - LangCentral</title>
    <meta name="description" content="Articles in the category <?php echo htmlspecialchars($category); ?> from LangCentral.">
    <meta name="keywords" content="language learning, articles, <?php echo htmlspecialchars($category); ?>">
    <meta property="og:title" content="Articles in <?php echo htmlspecialchars($category); ?> - LangCentral">
    <meta property="og:description" content="Articles in the category <?php echo htmlspecialchars($category); ?> from LangCentral.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.langcentral.net/<?php echo htmlspecialchars($category_slug); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="https://www.langcentral.net/<?php echo htmlspecialchars($category_slug); ?>">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "LangCentral",
            "url": "https://www.langcentral.net",
            "description": "LangCentral offers articles in the category <?php echo htmlspecialchars($category); ?>."
        }
    </script>
</head>
<body>
    <?php include '../includes/consentbanner.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    <header class="frontpage">
        <div>
            <h1 class="frontpage-header"><?php echo htmlspecialchars($category); ?></h1>
            <p class="frontpage-desc">Explore articles related to <?php echo htmlspecialchars($category); ?>.</p>
        </div>
    </header>
    <main class="main-page">
        <div class="main-part">
            <?php
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    echo '<a class="latest-article" href="https://www.langcentral.net/' . htmlspecialchars($category_slug) . '/' . htmlspecialchars($article['slug']) . '">';
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
