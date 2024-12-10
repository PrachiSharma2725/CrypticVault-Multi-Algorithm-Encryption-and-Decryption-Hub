<?php
// Start session
session_start();

// Clear session data
session_unset();

// Destroy the session
session_destroy();

// Clear cookies related to the user session (if any)
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600, '/'); // Expire the cookie
}

// Redirect to the home page (index.php)
header("Location: ../index.php");
exit;
?>
