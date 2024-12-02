<?php
session_start();
$_SESSION = array(); // Clear all session variables
session_destroy(); // Destroy the session
header("location: admin_login.php"); // Redirect to login page
exit;
?>
