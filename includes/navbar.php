<?php
/**
 * PHP Script for Main Navigation on BlueSkyHomesteading
 *
 * @package    BlueSkyHomesteading
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script creates the main navigation bar for the BlueSkyHomesteading website,
 * allowing users to easily access different sections such as homesteading guides and resources.
 * It includes responsive design features to adapt to mobile devices and enhance
 * user experience.
 *
 * Structure:
 * - The navigation bar consists of a logo, tagline, and links to various homesteading
 *   resources such as gardening, DIY, and sustainability articles.
 * - A mobile toggle button is provided for expanding and collapsing the menu 
 *   on smaller screens.
 *
 * Accessibility:
 * - ARIA attributes are used throughout to ensure the navigation is accessible
 *   for screen readers, including labels for toggling and dropdown menus.
 *
 * Dropdown Menus:
 * - The navbar includes dropdown menus for navigating to specific homesteading
 *   resources and articles. These menus are expandable and collapse as needed.
 *
 * Mobile Navigation:
 * - A separate mobile navigation panel is implemented for smaller screens,
 *   ensuring all navigation links are easily accessible on mobile devices.
 *
 * Includes:
 * - The script assumes the presence of relevant CSS for styling the navbar,
 *   ensuring it displays correctly on both desktop and mobile platforms.
 *
 * Frontend:
 * - Utilizes HTML5 structure with proper semantic tags for better accessibility.
 * - The navigation bar is designed to be visually appealing and user-friendly,
 *   incorporating a logo and tagline for branding.
 */
?>

<nav class="navbar" aria-label="Main Navigation">
    <div class="navbar-indent">    
        <div class="navbar-brand">
            <a href="https://www.blueskyhomesteading.com" aria-label="BlueSky Homesteading Home">
                <img src="https://www.blueskyhomesteading.com/images/logos/blueskylogoblack.svg" alt="BlueSky Homesteading Logo" class="logo">
            </a>
            <span class="tagline">Your Homesteading Journey Starts Here</span>
        </div>
        <div class="navbar-toggle" id="mobile-menu" aria-expanded="false" aria-controls="mobile-nav-panel" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar-menu">
            <li class="navbar-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Homesteading Guides ⬎</a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.blueskyhomesteading.com/gardening">Gardening</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/diy">DIY Projects</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/sustainability">Sustainability</a></li>
                </ul>
            </li>
            <li class="navbar-item dropdown">
                <a href="https://www.blueskyhomesteading.com/resources" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Resources ⬎</a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.blueskyhomesteading.com/tools">Homesteading Tools</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/articles">Latest Articles</a></li>
                </ul>
            </li>
            <li class="navbar-item">
                <a href="https://www.blueskyhomesteading.com/about" class="nav-link">About Us</a>
            </li>
        </ul>
    </div>
    <div class="mobile-nav-panel" id="mobile-nav-panel">
        <button class="close-panel" aria-label="Close navigation">✖</button>
        <ul>
            <li><a href="#">Homesteading Guides</a>
                <ul>
                    <li><a href="https://www.blueskyhomesteading.com/gardening">Gardening</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/diy">DIY Projects</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/sustainability">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="https://www.blueskyhomesteading.com/resources">Resources</a>
                <ul>
                    <li><a href="https://www.blueskyhomesteading.com/tools">Homesteading Tools</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/articles">Latest Articles</a></li>
                </ul>
            </li>
            <li><a href="https://www.blueskyhomesteading.com/about">About Us</a></li>
        </ul>
    </div>
</nav>
