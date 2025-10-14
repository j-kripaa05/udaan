<?php
session_start();
session_unset();    // Remove all session variables
session_destroy();  // Destroy the session completely

// Redirect the user to the login page after logging out
header("Location: login.php");
exit();
?>