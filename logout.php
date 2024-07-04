<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // Destroy the session
    session_destroy();
    // Redirect to login page with a logout message
    header("Location: login.php?logout=1");
    exit();
} else {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>
