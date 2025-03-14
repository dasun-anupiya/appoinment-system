<?php
session_start(); // Start the session

// Destroy all session data
session_unset();   // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the homepage
header("Location: ../index.html");
exit();  // Ensure no further code is executed
?>
