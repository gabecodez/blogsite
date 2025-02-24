<?php
// File: refunds.php
// Author: Gabriel Sullivan
// Purpose: Refund info page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once HEAD_PATH;
   $pageMeta = new PageMeta(
      "Refund policy - " . SITE_NAME,
      "Our refund policy.",
      "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
      SITE_URL . "/shop/refunds",
      SITE_NAME
   );
   $pageMeta->render();
   ?>
</head>

<body>
   <?php
   require_once CONSENT_BANNER_PATH;
   require_once NAVBAR_PATH;
   ?>
   <main class="main-page">
      <div class="article-content">
         <header>
            <h1>Refund Policy</h1>
            <?php
            $breadcrumb = new Breadcrumb();
            $breadcrumb->addCrumb('Home', SITE_URL);
            $breadcrumb->addCrumb('Shop', SITE_URL . '/shop');
            $breadcrumb->addCrumb('Refunds', SITE_URL . '/shop/refunds');
            $breadcrumb->render();
            ?>
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
   <?php require_once FOOTER_PATH; ?>
</body>

</html>