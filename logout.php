<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirects to the login page
header("Location: index.php");
exit();
?>
