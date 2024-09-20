<?php
/**
 * Google Tag Manager Integration Script for BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script integrates Google Tag Manager (gtag.js) to manage analytics,
 * ads, and user consent settings for the BlueSky Homesteading website.
 * It initializes the Google Analytics configuration while setting up consent
 * modes for various storage types.
 *
 * Integration Steps:
 * - Loads the Google Tag Manager script asynchronously for performance.
 * - Initializes the data layer for tracking and analytics purposes.
 * - Configures default consent settings for ad storage, analytics storage,
 *   functionality storage, personalization storage, and security storage.
 *
 * Output:
 * - The script executes upon page load and initializes tracking for users,
 *   with specific consent management.
 *
 * Includes:
 * - Links to external CSS stylesheets for website styling.
 * - Preconnect to Google Fonts for improved loading times.
 * - Sets up various meta tags including viewport settings for responsive design.
 *
 * Frontend:
 * - Ensures proper charset and responsive design settings are applied.
 * - Incorporates favicon and apple-touch-icon for branding.
 * - Loads additional scripts for ads and consent messaging as needed.
 */
?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RQE6HS5H7S"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    // Initialize consent mode
    gtag('consent', 'default', {
        'ad_storage': 'denied',
        'analytics_storage': 'denied',
        'functionality_storage': 'granted',
        'personalization_storage': 'denied',
        'security_storage': 'granted'
    });

    gtag('config', 'G-RQE6HS5H7S');
</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/styles.css?ver=1.21">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="icon" href="https://www.langcentral.net/images/favicon/langcentralfavicon.png" type="image/png">
<link rel="apple-touch-icon" href="https://www.langcentral.net/images/favicon/langcentralfavicon.png">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Nunito:ital,wght@0,900;1,900&display=swap" rel="stylesheet">