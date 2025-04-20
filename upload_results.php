<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinical_lab";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $test = mysqli_real_escape_string($conn, $_POST['test']);
    $upload_dir = "../uploads/"; // Absolute path to uploads folder
    $date_time = date("Y-m-d H:i:s");

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // File upload logic
    if (isset($_FILES['report']) && $_FILES['report']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES['report']['name']); // Unique file name
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['report']['tmp_name'], $file_path)) {
            // Save only the relative path for the report file in the database
            $relative_path = "uploads/" . $file_name;

            $sql = "INSERT INTO test_results (username, test, report_file, date_time) 
                    VALUES ('$username', '$test', '$relative_path', '$date_time')";

            if ($conn->query($sql) === TRUE) {
                echo "Test result uploaded successfully!";
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}

$conn->close();
?>
