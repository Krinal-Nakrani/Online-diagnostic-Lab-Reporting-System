<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aarush_clinical";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointments from the database
$sql = "SELECT * FROM appointment_form";
$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Return data as JSON
header("Content-Type: application/json");
echo json_encode($appointments);

$conn->close();
?>
