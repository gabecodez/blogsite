<?php
// Filename: head.php
// Purpose: Contains the code for the general <head> tags
?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-R3VZFYJ575"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    // Initialize consent mode
    gtag('consent', 'default', {
        'ad_storage': 'denied',
        'analytics_storage': 'denied',
        'functionality_storage': 'granted',
        'personalization_storage': 'denied',
        'security_storage': 'granted'
    });

    gtag('config', 'G-R3VZFYJ575');
</script>

<!-- Favicon Preload -->
<link rel="preload" href="https://www.blueskyhomesteading.com/images/logos/blueskyfav.png" as="image" type="image/png">
<link rel="icon" href="https://www.blueskyhomesteading.com/images/logos/blueskyfav.png" type="image/png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100..900;1,9..144,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">
<!-- Stylesheet -->
<link rel="stylesheet" href="https://www.blueskyhomesteading.com/styles/styles.css?ver=1.5">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">

<!-- Ads (deferred loading) -->
<script defer src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7669980320440394" crossorigin="anonymous"></script>