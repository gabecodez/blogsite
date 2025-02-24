<?php
// File: 404.php
// Author: Gabriel Sullivan
// Purpose: 404 page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once HEAD_PATH; ?>
    <title>404 Not Found - BlueSky Homesteading</title>
    <meta name="description" content="Oops! The page you're looking for cannot be found. Discover our resources and articles on sustainable living and homesteading.">
    <meta name="keywords" content="404, not found, error, page missing, homesteading, sustainable living">
    <meta property="og:title" content="404 Not Found - BlueSky Homesteading">
    <meta property="og:description" content="Oops! The page you're looking for cannot be found. Discover our resources and articles on sustainable living and homesteading.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL; ?>/404">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="<?= SITE_URL; ?>/404">
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
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>
    <header class="error-page-header">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>It seems the page you're looking for doesn't exist. But don’t worry, we have plenty of resources to help you with your homesteading journey!</p>
        <p>Check out our <a href="<?= SITE_URL; ?>">homepage</a>.</p>
    </header>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>