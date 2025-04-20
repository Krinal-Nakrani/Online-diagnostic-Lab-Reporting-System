<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='forget_password.php';</script>";
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Check if email exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Email not found!'); window.location.href='forget_password.php';</script>";
    } else {
        // Update password
        $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully! Log in now.'); window.location.href='user_login.php';</script>";
        } else {
            echo "<script>alert('Error updating password!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f2ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.41);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #0056b3;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <h2>Reset Password</h2><br>
        </div>
        <div>
            <form method="POST">
                <input type="email" name="email" placeholder="Enter your registered email" required><br>
                <input type="password" name="new_password" placeholder="Enter new password" required><br>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required><br>
                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>

</html>