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
    <script>
        function showMessage(message) {
            // Display the message in an alert box
            alert(message);
        }
    </script>
</head>
<body>
    
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

// Update registration details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registration_id = $_POST['registration_id'];
    $name = $_POST['name'];
    $contact_info = $_POST['contact'];
    $email = $_POST['email'];

    // Update query
    $sql = "UPDATE participants SET Name=?, ContactInfo=?, Email=? WHERE ParticipantID=(SELECT ParticipantID FROM registrations WHERE RegistrationID=?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $name, $contact_info, $email, $registration_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration updated successfully.');
                    setTimeout(function() {
                        window.location.href = 'dashboard.php'; // Redirect to the dashboard
                    }, 300); // Redirect after 2 seconds
                  </script>";
        } else {
            echo "<script>showMessage('Error updating registration:  . $stmt->error;');</script>";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
</body>
</html>