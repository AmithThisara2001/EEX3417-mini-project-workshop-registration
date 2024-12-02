<?php
session_start(); // Start session

// Check if the admin is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin_login.php"); // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Workshop</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function showMessage(message) {
            // Display the message in an alert box
            alert(message);
        }
    </script>
</head>
<body>
    <h1>Add Workshop</h1>

    <?php
        $servername = "localhost";
        $username = "root"; 
        $password = ""; 
        $dbname = "workshop_registration";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the POST data safely
            $title = $conn->real_escape_string(trim($_POST['title']));
            $date = $conn->real_escape_string(trim($_POST['date']));
            $location = $conn->real_escape_string(trim($_POST['location']));

            // Prepare SQL statement
            $sql = "INSERT INTO workshops (Title, Date, Location) VALUES ('$title', '$date', '$location')";

            // Execute SQL statement and check for success
            if ($conn->query($sql) === TRUE) {
                echo "<script>showMessage('New workshop added successfully.');</script>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }

        // Close the database connection
        $conn->close();
    ?>

    <!-- HTML Form -->
    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" placeholder="Enter Workshop Title" required><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter Workshop Location" required><br>
        <input type="submit" value="Add Workshop">
    </form>
</body>
</html>