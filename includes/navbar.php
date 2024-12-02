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

<nav class="navbar" id="navbar" aria-label="Main Navigation">
    <div class="navbar-indent">    
        <div class="navbar-brand">
            <a href="https://www.blueskyhomesteading.com" aria-label="BlueSky Homesteading Home">
                <img src="https://www.blueskyhomesteading.com/images/logos/blueskylogoblack.svg" alt="BlueSky Homesteading Logo" class="logo">
            </a>
            <span class="tagline">Your Homesteading Hub</span>
        </div>
        <div class="navbar-toggle" id="mobile-menu" aria-expanded="false" aria-controls="mobile-nav-panel" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar-menu">
            <li class="navbar-item dropdown">
                <a href="https://www.blueskyhomesteading.com/blog" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Blog <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M200-200v-400h80v264l464-464 56 56-464 464h264v80H200Z"/></svg></a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.blueskyhomesteading.com/blog/gardening">Gardening</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/blog/recipes">Recipes</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/blog/sustainability">Sustainability</a></li>
                </ul>
            </li>
            <li class="navbar-item dropdown">
                <a href="https://www.blueskyhomesteading.com/shop" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Shop <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M200-200v-400h80v264l464-464 56 56-464 464h264v80H200Z"/></svg></a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.blueskyhomesteading.com/shop/skincare">Skincare</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/shop/hardware">Hardware and Tools</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/shop/antiques">Antiques</a></li>
                </ul>
            </li>
            <li class="navbar-item dropdown"><a href="https://www.blueskyhomesteading.com/search" class="nav-link"><span>Search</span> <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg></a></li>
            <li class="navbar-item dropdown"><a href="https://www.blueskyhomesteading.com/shop/cart" class="nav-link"><span>Cart</span> <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg></a></li>
        </ul>
    </div>
    <div class="mobile-nav-panel" id="mobile-nav-panel">
        <button class="close-panel" aria-label="Close navigation">✖</button>
        <ul>
            <li><a href="https://www.blueskyhomesteading.com/blog">Blog</a>
                <ul>
                    <li><a href="https://www.blueskyhomesteading.com/blog/gardening">Gardening</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/blog/recipes">Recipes</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/blog/sustainability">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="https://www.blueskyhomesteading.com/shop">Shop</a>
                <ul>
                    <li><a href="https://www.blueskyhomesteading.com/shop/skincare">Skincare</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/hardware">Hardware and Tools</a></li>
                    <li><a href="https://www.blueskyhomesteading.com/antiques">Antiques</a></li>
                </ul>
            </li>
            <li><a href="https://www.blueskyhomesteading.com/search">Search</a></li>
            <li><a href="https://www.blueskyhomesteading.com/shop/cart">Cart</a></li>
        </ul>
    </div>
</nav>
