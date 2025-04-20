<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "aarush_clinical";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comments = isset($_POST['comments']) ? $conn->real_escape_string($_POST['comments']) : '';

    // Insert data into the feedback table
    $sql = "INSERT INTO feedback (username, rating, comments) VALUES ('$username', '$rating', '$comments')";

    if ($conn->query($sql) === TRUE) {
       
            // Display popup message
            echo "<script>alert('Thank you for your feedback!'); window.location.href='../home/home.html';</script>";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
