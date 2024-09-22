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
<div id="consent-banner" class="consent-banner">
  <div class="consent-content">
    <p>
      We use cookies to enhance your experience on our website. <a href="https://www.blueskyhomesteading.com/privacy">Learn more</a>.
    </p>
    <div class="buttons-div">
      <button id="accept-all" class="accept-all">Accept All</button>
      <button id="reject-all" class="reject-all">Reject All</button>
    </div>
  </div>
</div>