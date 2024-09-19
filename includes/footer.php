<?php
/**
 * HTML Structure for Footer and JavaScript Includes on BlueSky Homesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This HTML snippet provides the footer for the website and includes
 * necessary JavaScript files for functionality, such as the consent banner
 * and navigation bar.
 *
 * Footer:
 * - Contains a paragraph (`<p>`) that displays the copyright notice,
 *   dynamically generating the current year using PHP.
 * - The copyright notice states that all rights are reserved by LangCentral.
 *
 * JavaScript Includes:
 * - Two script tags are included to load external JavaScript files asynchronously:
 *   - `consentbannercode.js`: Handles the logic for displaying and managing
 *     the consent banner on the website.
 *   - `navbarcode.js`: Manages the behavior and appearance of the website's
 *     navigation bar, ensuring a smooth user experience.
 *
 * Performance:
 * - The `async` attribute on the script tags allows the scripts to load
 *   without blocking the rendering of the page, improving overall performance.
 */

?>

<footer>
    <p>&copy; <?php echo date("Y"); ?> LangCentral. All rights reserved.</p>
</footer>

<!-- Consent Banner JavaScript -->
<script src="https://www.langcentral.net/scripts/consentbannercode.js" async></script>

<script src="https://www.langcentral.net/scripts/navbarcode.js?ver=1.0" async></script>