<?php
// File: 404.php
// Author: Gabriel Sullivan
// Purpose: 404 page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        "404 Not Found - " . SITE_NAME,
        "Oops! The page you're looking for cannot be found. Discover our resources and articles on sustainable living and homesteading.",
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL . "/404",
        SITE_NAME
    );
    $pageMeta->render();
    ?>
</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    ?>
    <nav class="navbar homepage" id="navbar" aria-label="Main Navigation">
        <div class="navbar-indent">
            <div class="navbar-brand">
                <a href="https://www.blueskyhomesteading.com" aria-label="BlueSky Homesteading Home">
                    <img src="https://www.blueskyhomesteading.com/images/logos/blueskylogoblack.svg" alt="BlueSky Homesteading Logo" class="logo">
                </a>
                <span class="tagline">Explore Nature’s gifts for health.</span>
            </div>
            </ul>
        </div>
    </nav>

    <header class="error-page-header">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>It seems the page you're looking for doesn't exist. But don’t worry, we have plenty of resources to help you with your homesteading journey!</p>
        <p>Check out our <a href="<?= SITE_URL; ?>">homepage</a>.</p>
    </header>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>