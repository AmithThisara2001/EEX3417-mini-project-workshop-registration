<?php
session_start(); // Start session

// Check if the admin is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin_login.php"); // Redirect to login if not logged in
    exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Registrations</title>
    <link rel="stylesheet" href="viewrstyles.css"> <!-- Link to the CSS file -->
</head>
</html>
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

$sql = "SELECT r.RegistrationID, p.Name, w.Title, r.RegistrationDate 
        FROM registrations r 
        JOIN participants p ON r.ParticipantID = p.ParticipantID 
        JOIN workshops w ON r.WorkshopID = w.WorkshopID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Registration ID</th><th>Participant Name</th><th>Workshop Title</th><th>Registration Date</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["RegistrationID"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Title"]. "</td><td>" . $row["RegistrationDate"]. "</td></tr>";
    }
    
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
