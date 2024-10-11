<?php
/**
 * PHP Script for Displaying About Page on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: October 6, 2024
 * @created    October 2024
 *
 * This script generates the About page for the BlueSky Homesteading website.
 * It provides an overview of the website's mission, history, and core values.
 *
 * Includes:
 * - 'includes/head.php': For common head elements, SEO meta tags, and page title.
 * - 'includes/navbar.php': For site navigation links to other sections of the website.
 * - 'includes/footer.php': For common footer content displayed on all pages.
 *
 * Structure:
 * - Utilizes HTML5 and semantic tags for better accessibility and SEO.
 * - Includes a breadcrumb navigation for user orientation within the site.
 */

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include '../includes/head.php'; ?>
      <title>About Us - BlueSky Homesteading</title>
      <meta name="description" content="Learn more about BlueSky Homesteading and our mission to support sustainable living.">
      <meta name="keywords" content="homesteading, sustainable living, about us, mission">
      <link rel="canonical" href="https://www.blueskyhomesteading.com/about">
   </head>
   <body>
      <?php include '../includes/navbar.php'; ?>
      <header>
         <div class="article-content">
            <h1>About Us</h1>
            <nav aria-label="breadcrumb">
               <ol>
                  <li><a href="https://www.blueskyhomesteading.com">Home</a></li>
                  <li aria-current="page">About Us</li>
               </ol>
            </nav>
         </div>
      </header>
      <main>
         <div class="article-content">
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
      <?php include '../includes/footer.php'; ?>
   </body>
</html>
