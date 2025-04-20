<?php
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

// Fetch test results
$sql = "SELECT name, date_time, test, report_file FROM test_results";
$result = $conn->query($sql);

$results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

// Return JSON response
header("Content-Type: application/json");
echo json_encode($results);

// Close connection
$conn->close();
?>
