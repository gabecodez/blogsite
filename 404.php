<?php
/**
 * PHP Script for Displaying 404 Not Found Error Page on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script serves a 404 Not Found error page, providing users with
 * a friendly message and alternative navigation options. It includes
 * relevant meta tags for SEO and social media sharing, along with a
 * structured header for user experience.
 *
 * Includes:
 * - 'includes/head.php': For common head elements and styles.
 * - 'includes/consentbanner.php': For user consent management.
 * - 'includes/navbar.php': For site navigation.
 * - 'includes/footer.php': For common footer content.
 *
 * Output:
 * - Displays a prominent 404 error header along with a user-friendly
 *   message indicating that the requested page cannot be found.
 * - Provides links to the latest blog posts, guides, and community
 *   resources to help users navigate the site.
 *
 * Frontend:
 * - Utilizes HTML5 structure with proper semantic tags for accessibility.
 * - Includes Open Graph and Twitter meta tags for enhanced social sharing.
 * - Structured data (JSON-LD) for better search engine understanding.
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <title>404 Not Found - BlueSky Homesteading</title>
    <meta name="description" content="Oops! The page you're looking for cannot be found. Discover our resources and articles on sustainable living and homesteading.">
    <meta name="keywords" content="404, not found, error, page missing, homesteading, sustainable living">
    <meta property="og:title" content="404 Not Found - BlueSky Homesteading">
    <meta property="og:description" content="Oops! The page you're looking for cannot be found. Discover our resources and articles on sustainable living and homesteading.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.blueskyhomesteading.com/404">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="https://www.blueskyhomesteading.com/404">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "404 Not Found - BlueSky Homesteading",
            "url": "https://www.blueskyhomesteading.com/404",
            "description": "Oops! The page you're looking for cannot be found."
        }
    </script>
</head>
<body>
    <?php include 'includes/consentbanner.php'; ?>
    <?php include 'includes/navbar.php'; ?>
    <header class="error-page-header">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>It seems the page you're looking for doesn't exist. But don’t worry, we have plenty of resources to help you with your homesteading journey!</p>
        <p>Check out our:</p>
        <ul>
            <li><a href="/blog">Latest Blog Posts</a></li>
            <li><a href="/guides">Guides and Tutorials</a></li>
            <li><a href="/community">Join Our Community</a></li>
        </ul>
    </header>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
