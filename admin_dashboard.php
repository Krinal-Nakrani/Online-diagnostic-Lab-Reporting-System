<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Please log in first!'); 
    window.location.href = '../admin.html';</script>";
    exit();
}

// Get the logged-in admin ID
$admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .section {
            flex: 1;
        }

        .left {
            background-color: #C5D3C0;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-info {
            margin-top: 00px;
        }

        .user-photo {
            position: relative;
            cursor: pointer;
        }

        .user-photo img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        .upload-btn {
            display: none;
        }

        .right {
            flex: 3;
            background-color: #415546;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .top {
            background-color: #C5D3C0;
            padding: 10px;
            margin-bottom: 10px;
        }

        .bottom {
            flex: 3;
            background-color: #fefefe;
            padding: 10px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px;
            margin: 15px;
            margin-left: 20px;
            width: 290px;
            background-color: #415546;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #7C9381;
            color: #C5D3C0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="section left">
            <div class="user-photo">
                <img src="admin_dashboard_photo.jpg" alt="Admin Photo">
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($admin_id); ?></h3>
            </div>
            <button onclick="loadPage()">Appointment List</button><br>
            <button onclick="loadPage2()">Registered Users</button><br>
            <button onclick="loadPage6()">Update Tracking</button><br>
            <button onclick="loadPage3()">Upload Test Reports</button><br>
            <button onclick="loadPage5()">Add New Admin</button><br>
            <button onclick="loadPage4()">Logout</button>
        </div>
        <div class="section right">
            <div class="top">
                <h1 style="text-align: center; color: #000;">Welcome to Aarush Clinical Laboratory</h1>
            </div>
            <div class="bottom">
                <iframe id="contentFrame" src="../user dashboard/logo_display.html" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <script>
        function loadPage() {
            var iframe = document.getElementById('contentFrame');
            iframe.src = "appointment_list.html";
            iframe.style.display = "block";
        }

        function loadPage2() {
            var iframe = document.getElementById('contentFrame');
            iframe.src = "registered_users.php";
            iframe.style.display = "block";
        }

        function loadPage3() {
            var iframe = document.getElementById('contentFrame');
            iframe.src = "upload_test_results.html";
            iframe.style.display = "block";
        }

        function loadPage6() {
            var iframe = document.getElementById('contentFrame');
            iframe.src = "update_tracking.html";
            iframe.style.display = "block";
        }

        function loadPage4() {
                var confirmLogout = confirm("Do you want to log out?");
                if (confirmLogout) {
                    window.location.href = '../home/home.html';
                }
        }

        function loadPage5() {
            var iframe = document.getElementById('contentFrame');
            iframe.src = "add_admin.html";
            iframe.style.display = "block";
        }
    </script>
</body>

</html>