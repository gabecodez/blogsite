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
      <?php include '../includes/head.php'; ?>
      <title>BlueSky Homesteading - Search</title>
      <meta name="description" content="Search our website.">
      <meta name="keywords" content="homesteading, privacy, policy, resources, tips">
      <link rel="canonical" href="https://www.blueskyhomesteading.com/search">
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
