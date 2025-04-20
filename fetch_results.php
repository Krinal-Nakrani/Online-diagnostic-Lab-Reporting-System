<?php
// Start the session to access session variables
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinical_lab";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the username is set via session or GET request
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Use the session username

    // Fetch test results for the specific user
    $sql = "SELECT username, date_time, test, report_file FROM test_results WHERE username = '$username'";
    $result = $conn->query($sql);

    $results = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Make sure the path returned is correct
            // If your 'uploads' folder is in the root directory of your project, this should work
            $row['report_file'] = "../uploads/" . basename($row['report_file']);
            $results[] = $row;
        }
    }

    // Return JSON response
    header("Content-Type: application/json");
    echo json_encode($results);
} else {
    // Return error if no username is found in the session
    http_response_code(400);
    echo json_encode(["error" => "Username is required"]);
}

// Close connection
$conn->close();
?>
