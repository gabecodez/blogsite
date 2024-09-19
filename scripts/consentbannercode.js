/**
 * @file consentbannercode.js
 * @description Manages user consent for cookies and tracking on BlueSkyHomesteading.com.
 * @author Gabriel Sullivan
 * @date July 2024
 * @lastUpdated 2024-09-19
 */

/**
 * Updates user consent settings for tracking and ads.
 * It retrieves the user's consent from local storage and updates 
 * the Google Analytics consent settings accordingly.
 *
 * @function updateConsent
 */
function updateConsent() {
    const userConsentForAds = localStorage.getItem('cookie-consent') === 'accepted'; // Adjust this as needed
    const userConsentForAnalytics = userConsentForAds; // You might want separate control for analytics

    gtag('consent', 'update', {
      'ad_storage': 'granted',
      'analytics_storage': 'granted',
      'functionality_storage': 'granted', // Assuming functionality storage is always granted
      'personalization_storage': 'granted',
      'security_storage': 'granted'
    });

    console.log("Consent Granted");
  }

/**
 * Sets up event listeners for the consent buttons.
 * - Accepts all cookies and updates local storage.
 * - Rejects all cookies and updates local storage.
 */

  document.getElementById('accept-all').addEventListener('click', function() {
    localStorage.setItem('cookie-consent', 'accepted');
    document.getElementById('consent-banner').style.display = 'none';
    updateConsent();
  });

  document.getElementById('reject-all').addEventListener('click', function() {
    localStorage.setItem('cookie-consent', 'rejected');
    document.getElementById('consent-banner').style.display = 'none';
  });

/**
 * Checks user consent status on page load.
 * Displays the consent banner if no consent has been recorded.
 */

  window.addEventListener('load', function() {
    if (localStorage.getItem('cookie-consent') === 'accepted') {
      updateConsent();
    } else if (localStorage.getItem('cookie-consent') === 'rejected') {
      // Tracking is disabled, no need to update consent here
    } else {
      document.getElementById('consent-banner').style.display = 'block';
    }
  });