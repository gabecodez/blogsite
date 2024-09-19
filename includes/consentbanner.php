<?php

/**
 * HTML Structure for Consent Banner on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This HTML snippet displays a consent banner informing users about the use
 * of cookies on the website. The banner is designed to enhance user experience
 * by providing options to accept or reject cookie usage.
 *
 * Functionality:
 * - The banner is initially hidden and can be displayed based on user interaction.
 * - It includes a message explaining the use of cookies and links to the privacy policy.
 *
 * Elements:
 * - A paragraph (`<p>`) that conveys the purpose of cookies and includes a link
 *   to the privacy policy for more information.
 * - Two buttons:
 *   - "Accept All": Allows users to consent to all cookies and tracking technologies.
 *   - "Reject All": Allows users to decline all cookie usage.
 *
 * Styling:
 * - The banner features a dark background with white text for visibility.
 * - Buttons are styled with distinct colors for acceptance and rejection actions.
 * - The banner is set to be full-width with a centered text alignment.
 *
 * Behavior:
 * - JavaScript can be utilized to control the display of the banner and
 *   handle user interactions with the buttons. (in consentbannercode.js)
 */


?>

<!-- Consent Banner HTML -->
<div id="consent-banner" style="width: 100%; background: #333; color: #fff; padding: 10px; text-align: center; z-index: 1000; display: none;">
<p style="margin: 0; font-size: 14px; color:white;">
    We use cookies to enhance your experience on our website, to analyze our traffic, and to serve personalized content and advertisements. By clicking "Accept All", you consent to our use of cookies and other tracking technologies. 
    <a href="https://www.langcentral.net/privacy" style="color: #ddd; text-decoration: underline;">Learn more</a>.
  </p>
  <div style="margin-top: 10px;">
    <button id="accept-all" style="margin-right: 10px; padding: 5px 10px; background: #007bff; color: #fff; border: none; cursor: pointer;">Accept All</button>
    <button id="reject-all" style="padding: 5px 10px; background: #6c757d; color: #fff; border: none; cursor: pointer;">Reject All</button>
  </div>
</div>