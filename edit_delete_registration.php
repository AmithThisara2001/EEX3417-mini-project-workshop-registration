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

// Fetch all registrations
$sql = "SELECT r.RegistrationID, p.Name, w.Title, r.RegistrationDate 
        FROM registrations r 
        JOIN participants p ON r.ParticipantID = p.ParticipantID 
        JOIN workshops w ON r.WorkshopID = w.WorkshopID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit/Delete Registrations</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <h1>Edit/Delete Registrations</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Registration ID</th>
                <th>Participant Name</th>
                <th>Workshop Title</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["RegistrationID"]; ?></td>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo $row["RegistrationDate"]; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <form action="edit_registration.php" method="POST" style="display:inline;">
                            <input type="hidden" name="registration_id" value="<?php echo $row['RegistrationID']; ?>">
                            <input type="submit" value="Edit">
                        </form>
                        <!-- Delete Button -->
                        <form action="delete_registration.php" method="POST" style="display:inline;">
                            <input type="hidden" name="registration_id" value="<?php echo $row['RegistrationID']; ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this registration?');">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No registrations found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
