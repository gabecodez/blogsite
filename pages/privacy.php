<?php
// File: privacy.php
// Author: Gabriel Sullivan
// Purpose: Privacy page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   include '../includes/head.php';
   $pageTitle = "Privacy Policy - BlueSky Homesteading";
   $pageDescription = "Our privacy policy.";
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/privacy";
   $siteName = "BlueSky Homesteading";
   $twitterHandle = "";
   $creatorHandle = "";
   ?>
   <title><?php echo $pageTitle; ?></title>
   <link rel="canonical" href="<?php echo $pageURL; ?>">
   <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="keywords" content="homesteading, privacy, policy, resources, tips">
   <meta name="author" content="BlueSky Homesteading">
   <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
   <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta property="og:image" content="<?php echo htmlspecialchars($imageURL); ?>">
   <meta property="og:url" content="<?php echo htmlspecialchars($pageURL); ?>">
   <meta property="og:type" content="website">
   <meta property="og:site_name" content="<?php echo htmlspecialchars($siteName); ?>">
   <meta property="og:locale" content="en_US">
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:site" content="<?php echo htmlspecialchars($twitterHandle); ?>">
   <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
   <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="twitter:image" content="<?php echo htmlspecialchars($imageURL); ?>">
   <meta name="twitter:url" content="<?php echo htmlspecialchars($pageURL); ?>">
   <meta name="twitter:creator" content="<?php echo htmlspecialchars($creatorHandle); ?>">
   <meta name="linkedin:card" content="summary_large_image">
   <meta name="linkedin:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
   <meta name="linkedin:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="linkedin:image" content="<?php echo htmlspecialchars($imageURL); ?>">
   <meta name="twitter:domain" content="blueskyhomesteading.com">
   <?php echo '<script type="application/ld+json">
      {
         "@context": "https://schema.org",
         "@type": "WebSite",
         "name": "'.$pageTitle.'",
         "url": "'.$pageURL.'",
         "description": "'.$pageDescription.'"
      }
   </script>'; ?>
</head>

<body>
   <?php include '../includes/consentbanner.php'; ?>
   <?php include '../includes/navbar.php'; ?>
   <main class="main-page">
      <div class="article-content">
         <header>
            <h1>Privacy Policy</h1>
            <nav aria-label="breadcrumb">
               <ol>
                  <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                  <li aria-current="page"><a href="https://www.blueskyhomesteading.com/privacy">Privacy</a></li>
               </ol>
            </nav>
         </header>
         <article>
            <p>Effective Date: 09/19/2024</p>
            <h2>1. Introduction</h2>
            <p>Welcome to BlueSky Homesteading (blueskyhomesteading.com). Your privacy is important to us. This Privacy Policy outlines how we collect, use, and safeguard your information when you visit our website. By using our site, you consent to the terms of this Privacy Policy.</p>
            <h2>2. Information We Collect</h2>
            <p><strong>Personal Information:</strong> We do not collect personal information unless you voluntarily provide it through forms or other interactive features on our site.</p>
            <p><strong>Non-Personal Information:</strong> We collect non-personal information, such as your IP address, browser type, and browsing behavior via Google Analytics.</p>
            <h2>3. How We Use Your Information</h2>
            <p><strong>Analytics:</strong> We use Google Analytics to gain insights into how our visitors use the site, helping us enhance our content and user experience.</p>
            <p><strong>Advertising:</strong> We utilize Google AdSense and Media.net to display advertisements on our site, which may use cookies to serve ads based on your visits to our site and others.</p>
            <h2>4. Cookies and Tracking Technologies</h2>
            <p><strong>Cookies:</strong> We employ cookies to improve your experience on our website. Cookies are small text files placed on your device that help us remember your preferences and monitor visits.</p>
            <p><strong>Opt-Out:</strong> You can adjust your cookie preferences through your browser settings. Please note that disabling cookies may affect your experience on our site.</p>
            <h2>5. User Consent</h2>
            <p>Upon your initial visit, you will be prompted to consent to our use of cookies and tracking technologies via a pop-up notification.</p>
            <h2>6. Third-Party Links</h2>
            <p>Our website may feature links to third-party sites. We are not responsible for the privacy practices or content of these external websites.</p>
            <h2>7. Data Security</h2>
            <p>We implement reasonable security measures to protect your information from unauthorized access, disclosure, or misuse. However, no method of transmission over the internet or electronic storage is entirely secure.</p>
            <h2>8. Changes to This Privacy Policy</h2>
            <p>We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated effective date. We encourage you to review this policy regularly.</p>
         </article>
      </div>
   </main>
   <?php include '../includes/footer.php'; ?>
</body>

</html>