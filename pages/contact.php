<?php
// reCAPTCHA secret key from Google reCAPTCHA admin console
$secret_key = '6Lf9H28qAAAAAHyKNxZrBjY0apdVpfL-8LPFTWu-';

// Define variables for messages
$success_message = $error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
   // Handle form submission via AJAX
   $recaptcha_response = $_POST['recaptcha_response'];

   // Verify the reCAPTCHA token with Google
   $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
   $response_keys = json_decode($response, true);

   if ($response_keys["success"] && $response_keys["score"] >= 0.5) {
      // reCAPTCHA passed, sanitize inputs
      $name = htmlspecialchars($_POST['name'] ?? '');
      $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST['email']) : '';
      $message = htmlspecialchars($_POST['message'] ?? '');

      // Form validation
      if (!$name || !$email || !$message) {
         $error_message = "Please fill in all required fields correctly.";
      } else {
         // Prepare email content
         $to = 'contact@blueskyhomesteading.com';
         $subject = 'New Contact Form Submission';
         $email_content = "Name: $name\nEmail: $email\nMessage:\n$message\n";
         $headers = "From: $email\r\nReply-To: $email\r\n";

         // Attempt to send the email
         if (mail($to, $subject, $email_content, $headers)) {
            $success_message = "Thank you for contacting us, $name! We'll get back to you shortly.";
         } else {
            $error_message = "There was an error sending your message. Please try again later.";
         }
      }
   } else {
      $error_message = "CAPTCHA verification failed. Please try again.";
   }

   // Return JSON response for AJAX
   echo json_encode(['success' => $success_message, 'error' => $error_message]);
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php include '../includes/head.php'; ?>
   <title>Contact Us - BlueSky Homesteading</title>
   <meta name="description" content="Get in touch with BlueSky Homesteading. We look forward to hearing from you!">
   <meta name="keywords" content="homesteading, contact us, support, inquiries">
   <script src="https://www.google.com/recaptcha/api.js?render=6Lf9H28qAAAAAO9rrWq56gHZnn4gRoN3s5Ul-_OS"></script>
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         // Function to handle form submission
         document.getElementById("contact-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            grecaptcha.ready(function() {
               grecaptcha.execute('6Lf9H28qAAAAAO9rrWq56gHZnn4gRoN3s5Ul-_OS', {
                  action: 'submit'
               }).then(function(token) {
                  // Send the AJAX request with form data and reCAPTCHA token
                  let formData = new FormData(document.getElementById("contact-form"));
                  formData.append("recaptcha_response", token);
                  formData.append("ajax", "true"); // Indicate this is an AJAX request

                  fetch("", {
                        method: "POST",
                        body: formData
                     })
                     .then(response => response.json())
                     .then(data => {
                        // Display success or error message
                        if (data.success) {
                           document.getElementById("form-messages").innerHTML = `<p class="success-message">${data.success}</p>`;
                           document.getElementById("contact-form").style.display = 'none'; // Hide the form
                        } else {
                           document.getElementById("form-messages").innerHTML = `<p class="error-message">${data.error}</p>`;
                        }
                     })
                     .catch(error => {
                        console.error("Error:", error);
                        document.getElementById("form-messages").innerHTML = `<p class="error-message">An error occurred. Please try again later.</p>`;
                     });
               });
            });
         });
      });
   </script>
</head>

<body>
   <?php include '../includes/consentbanner.php'; ?>
   <?php include '../includes/navbar.php'; ?>

   <main class="main-page">
      <div class="article-content">
         <h1>Contact Us</h1>
         <p>If you have any questions, suggestions, or feedback, please reach out using the form below.</p>

         <!-- Form messages container -->
         <div id="form-messages"></div>

         <!-- Contact Form -->
         <form id="contact-form" method="post" class="contact-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <!-- Hidden reCAPTCHA token field -->
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

            <button type="submit">Send Message</button>
         </form>
      </div>
   </main>

   <?php include '../includes/footer.php'; ?>
</body>

</html>