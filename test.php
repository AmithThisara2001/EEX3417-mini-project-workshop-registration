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
    <title>Register Participant</title>
    <link rel="stylesheet" href="rpstyles.css">
    <script>
        function showMessage(message) {
            // Display the message in an alert box
            alert(message);
        }
    </script>
</head>
<body>

    <h1>Register Participant</h1>

    <?php
        $servername = "localhost";
        $username = "root"; 
        $password = ""; 
        $dbname = "workshop_registration";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get and sanitize input data
            $name = $conn->real_escape_string(trim($_POST['name']));
            $contact_info = $conn->real_escape_string(trim($_POST['contact']));
            $email = $conn->real_escape_string(trim($_POST['email']));

            // Insert query
            $sql = "INSERT INTO participants (Name, ContactInfo, Email) VALUES ('$name', '$contact_info', '$email')";

            // Execute the query and check for success
            if ($conn->query($sql) === TRUE) {
                echo "<script>showMessage('New participant registered successfully');</script>";
            } else {
                echo "<script>showMessage('registered successfully');</script>";
            }
        }

        $conn->close();
    ?>


    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Participant Name" required><br>
        <label for="contact">Contact Info:</label>
        <input type="text" id="contact" placeholder="Enter Participant Contact Number" name="contact"><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Participant Email" required><br>
        <input type="submit" value="Register Participant">
</body>
</html>