<?php
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if different
$dbname = "hospital_admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$user = isset($_POST['username']) ? $_POST['username'] : null;
$test = isset($_POST['test']) ? $_POST['test'] : null;
$update_status = isset($_POST['update_status']) ? $_POST['update_status'] : null;

if ($user === null || $test === null || $update_status === null) {
    die("Error: All fields are required.");
}

$time_date = date("Y-m-d H:i:s"); // Automatically captures current timestamp

// Check if the user and test exist in the same row in tracking table
$check_sql = "SELECT * FROM tracking WHERE username = ? AND test = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ss", $user, $test);
$check_stmt->execute();
$result = $check_stmt->get_result();
$check_stmt->close();

$tracking_status = "";
switch ($update_status) {
    case 1: $tracking_status = "Sample Collected"; break;
    case 2: $tracking_status = "Sample Processing"; break;
    case 3: $tracking_status = "Process Completed"; break;
    case 4: $tracking_status = "Generating reports"; break;
    case 5: $tracking_status = "Reports Delivered"; break;
    default: $tracking_status = "Unknown Status"; break;
}

if ($result->num_rows > 0) {
    // Update existing tracking record
    $sql = "UPDATE tracking SET update_status=?, tracking_status=?, last_updated=NOW() WHERE username=? AND test=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $update_status, $tracking_status, $user, $test);
} else {
    // Insert new tracking record
    $sql = "INSERT INTO tracking (username, test, update_status, tracking_status, time_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $user, $test, $update_status, $tracking_status, $time_date);
}

// Execute and check
if ($stmt->execute()) {
    echo "Tracking updated successfully! <a href='update_tracking.html'>Go Back</a>";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
