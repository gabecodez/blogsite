<?php
// File: sitemap.php
// Author: Gabriel Sullivan
// Purpose: Generates the sitemap.xml file for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';

// Query to get all articles with their categories
$sql = "SELECT articles.slug AS article_slug, articles.published_date, categories.slug AS category_slug 
        FROM articles 
        JOIN categories ON articles.category = categories.name
        WHERE articles.public = 1"; // Match article category name with categories table
$result = $conn->query($sql);

// Prepare the XML document
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    echo '<url>';
        echo '<loc>https://www.blueskyhomesteading.com</loc>';
        echo '<lastmod>2024-07-30</lastmod>';
        echo '<changefreq>daily</changefreq>';
        echo '<priority>1</priority>';
    echo '</url>';
    echo '<url>';
        echo '<loc>https://www.blueskyhomesteading.com/blog</loc>';
        echo '<lastmod>2024-07-30</lastmod>';
        echo '<changefreq>daily</changefreq>';
        echo '<priority>0.8</priority>';
    echo '</url>';
    echo '<url>';
        echo '<loc>https://www.blueskyhomesteading.com/privacy</loc>';
        echo '<lastmod>2024-07-30</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.8</priority>';
    echo '</url>';

// Check if there are any results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_slug = htmlspecialchars($row['category_slug'], ENT_XML1, 'UTF-8');
        $article_slug = htmlspecialchars($row['article_slug'], ENT_XML1, 'UTF-8');
        $last_modified = htmlspecialchars($row['published_date'], ENT_XML1, 'UTF-8'); // Format date if necessary

        // Print URL entry for each article
        echo '<url>';
        echo '<loc>https://www.blueskyhomesteading.com/blog/' . $category_slug . '/' . $article_slug . '</loc>';
        echo '<lastmod>' . date('Y-m-d', strtotime($last_modified)) . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
}

// Close the XML document
echo '</urlset>';

// Close the database connection
$conn->close();
?>
