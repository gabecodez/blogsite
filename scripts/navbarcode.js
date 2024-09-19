/**
 * @file navbarcode.js
 * @description Manages the mobile navigation menu interactions for BlueSkyHomesteading.com.
 * @author Gabriel Sullivan
 * @date July 2024
 * @lastUpdated 2024-09-19
 */

// Get DOM elements for mobile menu interactions
const mobileMenuButton = document.getElementById('mobile-menu');
const mobileNavPanel = document.getElementById('mobile-nav-panel');
const closePanelButton = document.querySelector('.close-panel');
const bars = document.getElementsByClassName('bar');
console.log('Loaded');
/**
 * Toggles the mobile menu panel open and closed.
 * Updates the aria-expanded attribute based on the menu state
 * and animates the hamburger menu icon.
 */
mobileMenuButton.addEventListener('click', function() {
    console.log('Menu open');
    mobileNavPanel.classList.toggle('open');
    const isExpanded = mobileNavPanel.classList.contains('open');
    mobileMenuButton.setAttribute('aria-expanded', isExpanded);

    // Toggle hamburger menu animation
    for (let i = 0; i < bars.length; i++) {
        bars[i].classList.toggle('menu-open');
    }
});

/**
 * Closes the mobile menu panel when the close button is clicked.
 * Resets the aria-expanded attribute and removes the hamburger menu animation.
 */
closePanelButton.addEventListener('click', function() {
    mobileNavPanel.classList.remove('open');
    mobileMenuButton.setAttribute('aria-expanded', false);

    // Reset hamburger menu animation
    for (let i = 0; i < bars.length; i++) {
        bars[i].classList.remove('menu-open');
    }
});
