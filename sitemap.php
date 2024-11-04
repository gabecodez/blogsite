<?php
/**
 * PHP Script for Generating XML Sitemap for BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script connects to the database to retrieve articles along with their
 * categories, generating an XML sitemap that can be used by search engines
 * to better index the site. The sitemap includes URLs for the homepage,
 * articles, privacy policy, and other relevant pages.
 *
 * Database Connection:
 * - Requires 'includes/databaseconnection.php' to establish a connection to the database.
 *
 * SQL Query:
 * - Selects the article slug, published date, and associated category slug
 *   from the articles and categories tables using a JOIN on the category name.
 *
 * Output:
 * - Outputs an XML document conforming to the sitemap protocol.
 * - Each URL entry includes the location, last modification date,
 *   change frequency, and priority for search engines.
 * - If articles are found, their respective URLs are included in the sitemap.
 * - The script ensures that special characters are properly escaped for XML.
 *
 * Includes:
 * - 'includes/databaseconnection.php': For establishing the database connection.
 *
 * Frontend:
 * - Generates a valid XML document with appropriate headers.
 * - Ensures compatibility with search engines using the sitemap schema.
 */


include 'includes/databaseconnection.php';

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
