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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rpstyles.css">
    <title>Workshop Registration</title>
    <script>
        function showMessage(message) {
            // Display the message in an alert box
            alert(message);
        }
    </script>
</head>
<body>

<h1>Workshop Registration</h1>

<?php
$servername = "localhost";
$username = "root"; // Change as needed
$password = ""; // Change as needed
$dbname = "workshop_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the participant name and workshop name from POST data
    $participant_name_input = $conn->real_escape_string(trim($_POST['participant_id']));
    $workshop_name_input = $conn->real_escape_string(trim($_POST['workshop_id']));

    // Query to get ParticipantID based on participant name
    $participant_query = "SELECT ParticipantID FROM participants WHERE `Name`='$participant_name_input'";
    $participant_result = $conn->query($participant_query);

    // Check if a participant was found
    if ($participant_result && $participant_result->num_rows > 0) {
        // Fetch ParticipantID
        $participant_row = $participant_result->fetch_assoc();
        $participant_id = $participant_row['ParticipantID'];

        // Query to get WorkshopID based on workshop name
        $workshop_query = "SELECT WorkshopID FROM workshops WHERE `Title`='$workshop_name_input'";
        $workshop_result = $conn->query($workshop_query);

        // Check if a workshop was found
        if ($workshop_result && $workshop_result->num_rows > 0) {
            // Fetch WorkshopID
            $workshop_row = $workshop_result->fetch_assoc();
            $workshop_id = $workshop_row['WorkshopID'];

            // Insert ParticipantID and WorkshopID into registrations table
            $sql = "INSERT INTO registrations (ParticipantID, WorkshopID) VALUES ('$participant_id', '$workshop_id')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>showMessage('Successfully registered for workshop');</script>";
            } else {
                echo "<script>showMessage('Error: " . addslashes($conn->error) . "');</script>";
            }
        } else {
            echo "<script>showMessage('No workshop found with that name.');</script>";
        }
    } else {
        echo "<script>showMessage('No participant found with that username.');</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML Form -->
<form method="post" action="">
    <label for="participant_id">Participant Name:</label>
    <input type="text" name="participant_id" id="participant_id" placeholder="Enter Participant Name" required>
    <label for="workshop_id">Workshop Name:</label>
    <input type="text" name="workshop_id" id="workshop_id" placeholder="Enter Workshop Title" required>
    <input type="submit" value="Register for Workshop">
</form>

</body>
</html>