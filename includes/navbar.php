<?php
/**
 * PHP Script for Main Navigation on LangCentral
 *
 * @package    LangCentral
 * @author     Gabriel Sullivan
 * @version    1.0
 * @date       Last updated: September 19, 2024
 * @created    July 2024
 *
 * This script creates the main navigation bar for the LangCentral website,
 * allowing users to easily access different sections such as languages and articles.
 * It includes responsive design features to adapt to mobile devices and enhance
 * user experience.
 *
 * Structure:
 * - The navigation bar consists of a logo, tagline, and links to various 
 *   language resources and articles.
 * - A mobile toggle button is provided for expanding and collapsing the menu 
 *   on smaller screens.
 *
 * Accessibility:
 * - ARIA attributes are used throughout to ensure the navigation is accessible
 *   for screen readers, including labels for toggling and dropdown menus.
 *
 * Dropdown Menus:
 * - The navbar includes dropdown menus for navigating to specific language 
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
            <a href="https://www.langcentral.net" aria-label="LangCentral Home">
                <img src="https://www.langcentral.net/images/logos/langcentrallogoweb.svg" alt="LangCentral Logo" class="logo">
            </a>
            <span class="tagline">Your Language Learning Hub</span>
        </div>
        <div class="navbar-toggle" id="mobile-menu" aria-expanded="false" aria-controls="mobile-nav-panel" aria-label="Toggle navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar-menu">
            <li class="navbar-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Languages ⬎</a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.langcentral.net/german">German</a></li>
                </ul>
            </li>
            <li class="navbar-item dropdown">
                <a href="https://www.langcentral.net/articles" class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">Articles ⬎</a>
                <ul class="dropdown-menu">
                    <li><a href="https://www.langcentral.net/language-learning">Language Learning</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="mobile-nav-panel" id="mobile-nav-panel">
        <button class="close-panel" aria-label="Close navigation">✖</button>
        <ul>
            <li><a href="#">Languages</a>
                <ul>
                    <li><a href="https://www.langcentral.net/german">German</a></li>
                </ul>
            </li>
            <li><a href="https://www.langcentral.net/articles">Articles</a>
                <ul>
                    <li><a href="https://www.langcentral.net/language-learning">Language Learning</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
