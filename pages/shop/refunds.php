<?php
// File: refunds.php
// Author: Gabriel Sullivan
// Purpose: Refund info page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php';
   $pageTitle = "Refund Policy - BlueSky Homesteading";
   $pageDescription = "Our refund policy.";
   $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
   $pageURL = "https://www.blueskyhomesteading.com/shop/refunds";
   $siteName = "BlueSky Homesteading";
   $creatorHandle = "";
   $twitterHandle = "";
   ?>
   <title><?php echo $pageTitle; ?></title>
   <link rel="canonical" href="<?php echo $pageURL; ?>">
   <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
   <meta name="keywords" content="homesteading, refund, policy, resources, tips">
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
            <h1>Refund Policy</h1>
            <nav aria-label="breadcrumb">
               <ol>
                  <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                  <li><a href="https://www.blueskyhomesteading.com/shop">Shop</a></li>
                  <li aria-current="page"><a href="https://www.blueskyhomesteading.com/shop/refunds">Refunds</a></li>
               </ol>
            </nav>
         </header>
         <article>
            <p>Effective Date: 11/12/2024</p>
            <h2>1. Introduction</h2>
            <p>At BlueSky Homesteading, we strive to ensure customer satisfaction. This Refund Policy explains the conditions and processes for obtaining a refund for eligible products or services.</p>
            <h2>2. Refund Eligibility</h2>
            <p>All sales are final. However, refunds can be handled on a case-by-case basis. Please <a href="https://www.blueskyhomesteading.com/contact">contact us</a> for support.</p>
         </article>
      </div>
   </main>
   <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>

</html>
