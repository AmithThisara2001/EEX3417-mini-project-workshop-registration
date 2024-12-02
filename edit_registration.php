<?php
session_start(); // Start session

// Check if the admin is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: admin_login.php"); // Redirect to login if not logged in
    exit;
}
?>

<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "workshop_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch registration details for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registration_id = $_POST['registration_id'];
    
    // Fetch the specific registration details
    $sql = "SELECT r.RegistrationID, p.Name, p.ContactInfo, p.Email, w.Title 
            FROM registrations r 
            JOIN participants p ON r.ParticipantID = p.ParticipantID 
            JOIN workshops w ON r.WorkshopID = w.WorkshopID 
            WHERE r.RegistrationID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $registration_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No registration found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <h1>Edit Registration</h1>

    <form action="update_registration.php" method="POST">
        <input type="hidden" name="registration_id" value="<?php echo $row['RegistrationID']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['Name']); ?>" required><br>

        <label for="contact">Contact Info:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($row['ContactInfo']); ?>"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" required><br>

        <label for="workshop">Workshop Title:</label>
        <input type="text" id="workshop" name="workshop_title" value="<?php echo htmlspecialchars($row['Title']); ?>" readonly><br>

        <input type="submit" value="Update Registration">
    </form>

</body>
</html>

<?php
$conn->close();
?>
