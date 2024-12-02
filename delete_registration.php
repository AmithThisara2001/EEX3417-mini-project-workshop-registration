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

// Delete registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registration_id = $_POST['registration_id'];

    // Delete query
    $sql = "DELETE FROM registrations WHERE RegistrationID=?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $registration_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration Deleted successfully.');
                    setTimeout(function() {
                        window.location.href = 'edit_delete_registration.php'; // Redirect to the view_registrations
                    }, 300); // Redirect after 2 seconds
                  </script>";
        } else {
            echo "Error deleting registration: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
