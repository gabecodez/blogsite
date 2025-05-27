<?php
// File: sitemap.php
// Author: Gabriel Sullivan
// Purpose: Generates the sitemap.xml file for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

// Query to get all articles with their categories
$articles_sql = "SELECT articles.slug AS article_slug, articles.published_date, categories.slug AS category_slug 
        FROM articles 
        JOIN categories ON articles.category = categories.name
        WHERE articles.public = 1"; // Match article category name with categories table
$articles = $conn->fetchAll($articles_sql);

// Fetch latest products (e.g., the last 3 entries)
$products_sql = "SELECT products.slug AS product_slug, products.name, products.meta_description, products.preview_image_ids, shop_categories.slug AS category_slug
                FROM products 
                JOIN shop_categories ON products.category = shop_categories.name
                WHERE products.public = 1 
                LIMIT 3";
$products = $conn->fetchAll($products_sql);



// Prepare the XML document
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
echo '<url>';
echo '<loc>' . SITE_URL . '</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>daily</changefreq>';
echo '<priority>1</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/blog</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>daily</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/privacy</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/contact</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/shop</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/shop/refunds</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/about</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/search</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';
echo '<url>';
echo '<loc>' . SITE_URL . '/contact</loc>';
echo '<lastmod>2025-05-27</lastmod>';
echo '<changefreq>monthly</changefreq>';
echo '<priority>0.8</priority>';
echo '</url>';

// Check if there are any results
if (!empty($articles)) {
    foreach ($articles as $article) {
        $category_slug = htmlspecialchars($article['category_slug'], ENT_XML1, 'UTF-8');
        $article_slug = htmlspecialchars($article['article_slug'], ENT_XML1, 'UTF-8');
        $last_modified = htmlspecialchars($article['published_date'], ENT_XML1, 'UTF-8'); // Format date if necessary

        // Print URL entry for each article
        echo '<url>';
        echo '<loc>' . SITE_URL . '/blog/' . $category_slug . '/' . $article_slug . '</loc>';
        echo '<lastmod>' . date('Y-m-d', strtotime($last_modified)) . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
}

if (!empty($products)) {
    foreach ($products as $product) {
        $category_slug = htmlspecialchars($product['category_slug'], ENT_XML1, 'UTF-8');
        $article_slug = htmlspecialchars($product['product_slug'], ENT_XML1, 'UTF-8');

        // Print URL entry for each product
        echo '<url>';
        echo '<loc>' . SITE_URL . '/shop/' . $category_slug . '/' . $article_slug . '</loc>';
        echo '<lastmod>2025-05-27</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
}



// Close the XML document
echo '</urlset>';

// Close the database connection
$conn->close();
