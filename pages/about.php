<?php
// File: about.php
// Author: Gabriel Sullivan
// Purpose: About page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php';
   $pageTitle = "About Us - BlueSky Homesteading";
   $pageDescription = "Learn more about BlueSky Homesteading and our mission to support sustainable living.";
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/about";
   $siteName = "BlueSky Homesteading";
   $twitterHandle = "";
   $creatorHandle = "";
   ?>
   <title><?php echo $pageTitle; ?></title>
   <link rel="canonical" href="<?php echo $pageURL; ?>">
   <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="keywords" content="homesteading, sustainable living, about us, mission">
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
   <script type="application/ld+json">
      {
         "@context": "https://schema.org",
         "@type": "WebSite",
         "name": "<?php echo $pageTitle; ?>",
         "url": "<?php echo $pageURL; ?>",
         "description": "<?php echo $pageDescription; ?>"
      }
   </script>
</head>

<body>
   <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
   <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>
   <main class="main-page">
      <div class="article-content">
         <header>
            <h1>About Us</h1>
            <nav aria-label="breadcrumb">
               <ol>
                  <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                  <li aria-current="page"><a href="https://www.blueskyhomesteading.com/about">About Us</a></li>
               </ol>
            </nav>
         </header>
         <article>
            <h2>Who We Are</h2>
            <p>BlueSky Homesteading is dedicated to helping individuals and families embrace a sustainable, self-sufficient lifestyle. From practical tips on gardening and animal care to DIY projects and sustainable practices, we are passionate about empowering people to live in harmony with nature.</p>
            <h2>Our Mission</h2>
            <p>Our mission is to provide high-quality resources, tools, and inspiration for those looking to start or enhance their homesteading journey. We believe in sharing knowledge that promotes sustainable living, resilience, and health.</p>
            <h2>Our Values</h2>
            <ul>
               <li>Self-Sufficiency</li>
               <li>Community Support</li>
               <li>Innovation and Learning</li>
            </ul>
         </article>
      </div>
   </main>
   <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>

</html>