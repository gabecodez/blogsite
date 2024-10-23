<?php
/**
 * PHP Script for Displaying Privacy Policy on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    September 2024
 *
 * This script generates the Privacy Policy page for the BlueSky Homesteading website.
 * It outlines how user data is collected, used, and protected, ensuring transparency
 * and compliance with privacy regulations.
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
 * - Details the effective date, the type of information collected, usage, cookies,
 *   user consent, third-party links, data security measures, and how changes to the
 *   policy will be communicated.
 *
 * Compliance:
 * - Ensures users are informed about their rights regarding their personal information,
 *   adhering to best practices in privacy policy disclosures.
 */

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include '../includes/head.php'; ?>
      <title>BlueSky Homesteading - Privacy Policy</title>
      <meta name="description" content="Our privacy policy.">
      <meta name="keywords" content="homesteading, privacy, policy, resources, tips">
      <link rel="canonical" href="https://www.blueskyhomesteading.com/privacy">
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
