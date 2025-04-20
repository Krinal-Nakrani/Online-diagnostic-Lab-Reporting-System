<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for localhost
$password = ""; // Default password for localhost
$dbname = "hospital_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert into database
    $sql = "INSERT INTO admins (admin_id, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $admin_id, $password);

    if ($stmt->execute()) {
        echo "Admin added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
