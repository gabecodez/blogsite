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
    <div class="footer-container">
        <!-- Use a <nav> element for better SEO as it's a set of navigation links -->
        <nav aria-label="Footer navigation">
            <ul class="footer-links">
                <li><a href="https://www.blueskyhomesteading.com/about" title="About Us">About Us</a></li>
                <li><a href="https://www.blueskyhomesteading.com/contact" title="Contact Us">Contact</a></li>
                <li><a href="https://www.blueskyhomesteading.com/privacy" title="Privacy Policy">Privacy Policy</a></li>
                <li><a href="https://www.blueskyhomesteading.com/shop/refunds" title="Refunds">Refunds</a></li>
                <li><a href="https://www.blueskyhomesteading.com/search" title="Contact Us">Search</a></li>
                <li><a href="https://www.facebook.com/BlueSky.Homestead23/" title="Facebook">Facebook</a></li>
                <li><a href="https://www.instagram.com/bluesky.homestead/" title="Instagram">Instagram</a></li>
                <li><a href="https://xt8aq0-3j.myshopify.com/" title="Shopify">Shopify</a></li>
            </ul>
        </nav>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> BlueSky Homesteading LLC. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Consent Banner JavaScript -->
<script src="https://www.blueskyhomesteading.com/scripts/consentbannercode.js" async></script>
<script src="https://www.blueskyhomesteading.com/scripts/navbarcode.js?ver=1.0" async></script>