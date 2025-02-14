<?php
// File: 404.php
// Author: Gabriel Sullivan
// Purpose: 404 page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php'; ?>
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
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>
    <header class="error-page-header">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>It seems the page you're looking for doesn't exist. But don’t worry, we have plenty of resources to help you with your homesteading journey!</p>
        <p>Check out our <a href="https://www.blueskyhomesteading.com">homepage</a>.</p>
    </header>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>
</html>
