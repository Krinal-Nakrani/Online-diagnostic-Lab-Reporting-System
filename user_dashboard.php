<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['full_name'])) {
    echo "<script>alert('Please log in first!'); 
    window.location.href = '../user_login.php';</script>";
    exit();
}

// Retrieve session details
$username = $_SESSION['username'];
$fullName = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
</head>

<body>
    <!-- Dashboard Structure -->
    <div class="container">
        <!-- Left Sidebar -->
        <div class="section left">
        <div class="user-photo">
                <img src="user_logo.png">
            </div>
            <div class="use r-info">
                <h3 id="username"><?= $username ?></h3>
                <p id="fullname"><?= $fullName ?></p>
            </div>
            <button onclick="loadPage('appointment_form.html')">Appointment Form</button>
            <button onclick="loadPage('track_my_test.php')">Track Your Test</button>
            <button onclick="loadPage('my_test_results.html')">My Test Results</button>
            <button onclick="logout()">Logout</button>
        </div>

        <!-- Right Content Section -->
        <div class="section right">
            <div class="top">
                <h1 style="text-align: center; color: #000;">Welcome to Aarush Clinical Laboratory</h1>
            </div>
            <div class="bottom">
                <iframe id="contentFrame" src="logo_display.html" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <script src="user_dashboard.js">
        function logout() {
            window.location.href = 'feedback.html';
        }
    </script>
</body>

</html>