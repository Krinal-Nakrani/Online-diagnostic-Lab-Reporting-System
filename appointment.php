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

// Retrieve form data
$name = $_POST['name'];
$age = $_POST['age'];
$birthdate = $_POST['birthdate'];
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$address = $_POST['address'];
$test = $_POST['test'];
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];

// Handle file upload
$prescription_path = null;
if (isset($_FILES['prescription']) && $_FILES['prescription']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "prescription/" . preg_replace("/[^a-zA-Z0-9]/", "_", $name) . "/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $prescription_path = "prescription/" .  "/" . basename($_FILES['prescription']['name']);

    //$prescription_path = $upload_dir . basename($_FILES['prescription']['name']);
    move_uploaded_file($_FILES['prescription']['tmp_name'], $prescription_path);
}

// Insert into database
$sql = "INSERT INTO appointment_form (name, age, birthdate, gender, contact, email, address, test, appointment_date, appointment_time, prescription) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssssssss", $name, $age, $birthdate, $gender, $contact, $email, $address, $test, $appointment_date, $appointment_time, $prescription_path);

if ($stmt->execute()) {
    echo "<script>alert('Appointment successfully booked!'); window.location.href='appointment_form.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
