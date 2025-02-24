<?php
// File: about.php
// Author: Gabriel Sullivan
// Purpose: About page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php
   require_once HEAD_PATH;
   $pageMeta = new PageMeta(
      "About Us - " . SITE_NAME,
      "Learn more about " . SITE_NAME . " and our mission to support sustainable living.",
      "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
      SITE_URL . "/about",
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
            <h1>About Us</h1>
            <?php
            $breadcrumb = new Breadcrumb();
            $breadcrumb->addCrumb('Home', SITE_URL);
            $breadcrumb->addCrumb('About Us', SITE_URL . '/about');
            $breadcrumb->render();
            ?>
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
   <?php require_once FOOTER_PATH; ?>
</body>

</html>