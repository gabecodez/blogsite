<?php
// File: search.php
// Author: Gabriel Sullivan
// Purpose: Search page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once HEAD_PATH;
   $pageMeta = new PageMeta(
      "Search - " . SITE_NAME,
      "Search our website.",
      "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
      SITE_URL . "/search",
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
   <?php require_once FOOTER_PATH; ?>
</body>

</html>