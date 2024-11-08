<?php

/**
 * PHP Script for Displaying Search Results on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: October 6, 2024
 * @created    October 2024
 *
 * This script generates the Search Results page for the BlueSky Homesteading website.
 * It provides users with search functionality to find relevant content across the site.
 *
 * Includes:
 * - 'includes/head.php': For common head elements, SEO meta tags, and page title.
 * - 'includes/consentbanner.php': For managing user consent regarding cookies and tracking.
 * - 'includes/navbar.php': For site navigation links to other sections of the website.
 * - 'includes/footer.php': For common footer content displayed on all pages.
 *
 * Structure:
 * - Utilizes HTML5 and semantic tags for better accessibility and SEO.
 * - Includes a breadcrumb navigation for user orientation within the site.
 *
 * Content:
 * - Displays search results based on the query input by the user.
 * - Provides pagination to manage large sets of search results.
 *
 * Compliance:
 * - Ensures users are informed about search functionalities, their data rights, and the use of cookies for tracking user behavior.
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   include '../includes/head.php';
   $pageTitle = "Search - BlueSky Homesteading";
   $pageDescription = "Search our website.";
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/search";
   $siteName = "BlueSky Homesteading";
   ?>
   <title><?php echo $pageTitle; ?></title>
   <link rel="canonical" href="<?php echo $pageURL; ?>">
   <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="keywords" content="homesteading, shop search, blog search, search">
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
   <?php include '../includes/consentbanner.php'; ?>
   <?php include '../includes/navbar.php'; ?>

   <main class="main-page">
      <div class="article-content">
         <header>
            <div class="article-content">
               <h1>Search</h1>
               <p>Functionality is provided by Google.</p>
            </div>
         </header>
         <div>
            <script async src="https://cse.google.com/cse.js?cx=04cf003aa450442c3">
            </script>
            <div class="gcse-search"></div>
         </div>
      </div>
   </main>
   <?php include '../includes/footer.php'; ?>
</body>

</html>