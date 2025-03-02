// File: navbarcode.js
// Author: Gabriel Sullivan
// Purpose: Navigation bar handling for BlueSky Homesteading
// File: NavbarController.js
// Author: Gabriel Sullivan / Improved version by ChatGPT
// Purpose: Object-oriented navigation bar handling for BlueSky Homesteading

class NavbarController {
  constructor() {
    this.mobileMenuButton = document.getElementById("mobile-menu");
    this.mobileNavPanel = document.getElementById("mobile-nav-panel");
    this.closePanelButton = document.querySelector(".close-panel");
    this.bars = document.getElementsByClassName("bar");
    this.navbar = document.getElementById("navbar");
    this.bindEvents();
    console.log("NavbarController loaded");
  }

  bindEvents() {
    this.mobileMenuButton.addEventListener("click", () =>
      this.toggleMobileMenu()
    );
    this.closePanelButton.addEventListener("click", () =>
      this.closeMobileMenu()
    );
    window.addEventListener("scroll", () => this.handleScroll());
  }

  toggleMobileMenu() {
    this.mobileNavPanel.classList.toggle("open");
    const isExpanded = this.mobileNavPanel.classList.contains("open");
    this.mobileMenuButton.setAttribute("aria-expanded", isExpanded);
    Array.from(this.bars).forEach((bar) => bar.classList.toggle("menu-open"));
    console.log("Mobile menu toggled");
  }

  closeMobileMenu() {
    this.mobileNavPanel.classList.remove("open");
    this.mobileMenuButton.setAttribute("aria-expanded", false);
    Array.from(this.bars).forEach((bar) => bar.classList.remove("menu-open"));
    console.log("Mobile menu closed");
  }

  handleScroll() {
    if (window.scrollY > 10) {
      this.navbar.classList.add("scrolled");
    } else {
      this.navbar.classList.remove("scrolled");
    }
  }
}

// Initialize the controller when the DOM is ready.
document.addEventListener("DOMContentLoaded", () => {
  new NavbarController();
});

// Get DOM elements for mobile menu interactions
const mobileMenuButton = document.getElementById("mobile-menu");
const mobileNavPanel = document.getElementById("mobile-nav-panel");
const closePanelButton = document.querySelector(".close-panel");
const bars = document.getElementsByClassName("bar");
console.log("Loaded");
/**
 * Toggles the mobile menu panel open and closed.
 * Updates the aria-expanded attribute based on the menu state
 * and animates the hamburger menu icon.
 */
mobileMenuButton.addEventListener("click", function () {
  console.log("Menu open");
  mobileNavPanel.classList.toggle("open");
  const isExpanded = mobileNavPanel.classList.contains("open");
  mobileMenuButton.setAttribute("aria-expanded", isExpanded);

  // Toggle hamburger menu animation
  for (let i = 0; i < bars.length; i++) {
    bars[i].classList.toggle("menu-open");
  }
});

/**
 * Closes the mobile menu panel when the close button is clicked.
 * Resets the aria-expanded attribute and removes the hamburger menu animation.
 */
closePanelButton.addEventListener("click", function () {
  mobileNavPanel.classList.remove("open");
  mobileMenuButton.setAttribute("aria-expanded", false);

  // Reset hamburger menu animation
  for (let i = 0; i < bars.length; i++) {
    bars[i].classList.remove("menu-open");
  }
});

// makes navbar change when scrolled down
window.addEventListener("scroll", function () {
  const navbar = document.getElementById("navbar");
  if (window.scrollY > 10) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});
