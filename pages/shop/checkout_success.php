<?php
// File: checkout_success.php
// Author: Gabriel Sullivan
// Purpose: Checkout success page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once HEAD_PATH;
   $pageMeta = new PageMeta(
      "Order confirmed - " . SITE_NAME,
      "Learn more about " . SITE_NAME . " and our mission to support sustainable living.",
      "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
      SITE_URL . "/checkout/success",
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
            <h1>Your order has been confirmed!</h1>
         </header>
         <a href="https://www.blueskyhomesteading.com">Return Home</a>
      </div>
   </main>
   <?php require_once FOOTER_PATH; ?>
</body>

</html>