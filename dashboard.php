<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin_login.php"); // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="adminlogindashboard.css"> <!-- Link to CSS file -->
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>You are logged in as an admin.</p>

        <!-- Navigation Links -->
        <div class="nav-links">
            <a href="add_workshop.php">Add Workshop</a>
            <a href="register_participant.php">Register Participant</a>
            <a href="register_workshop.php">Register for Workshop</a>
            <a href="edit_delete_registration.php">Manage Registrations</a>
            <a href="view_registrations.php">View Registrations</a>
            <a href="logout.php" class="logout-button">Logout</a> 
        </div>
    </div>
</body>
</html>
