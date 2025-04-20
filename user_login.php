<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        $fullName = $_POST['name'];
        $userName = $_POST['username'];
        $email = $_POST['email'];

        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            echo "<script>alert('Please enter a valid Gmail address (e.g., example@gmail.com)'); 
            window.location.href='user_login.php';</script>";
            exit();
        }
        
       $password = $_POST['password']; // Get raw password before hashing

// Password validation using regex
$password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?':{}|<>]).{8,}$/";

if (!preg_match($password_regex, $password)) {
    echo "<script>alert('Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.'); 
    window.location.href='user_login.php';</script>";
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash only if valid

        // Check if email or username already exists
        $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email or Username already exists! Please log in.'); 
            window.location.href='user_login.php';</script>";
        } else {
            // Insert new user
            $sql = "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $fullName, $userName, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Log in now!'); 
                window.location.href='user_login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
        $stmt->close();
    } elseif (isset($_POST['login'])) {
        $userName = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['full_name'] = $row['full_name'];

                echo "<script>alert('Login successful! Welcome, {$row['full_name']}'); 
                window.location.href='user dashboard/user_dashboard.php';</script>";
            } else {
                echo "<script>alert('Invalid password!');</script>";
            }
        } else {
            echo "<script>alert('No user found!');</script>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_login.css">
    <title>USER LOGIN/SIGNIN</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" pattern="[A-Za-z\s]+" required>


                <input type="text" name="username" placeholder="Username"
                    pattern="^[A-Za-z0-9._]+$"
                    title="Username can only contain letters (A-Z, a-z), numbers (0-9), dots (.) and underscores (_)"
                    required
                    oninvalid="this.setCustomValidity('Please use only letters, numbers, dots, and underscores. No spaces or special characters allowed.')"
                    oninput="this.setCustomValidity('')">

                <input type="mail" name="email" placeholder="Email" required>


                <input type="password" id="password" name="password" placeholder="Password" required>
                <small id="passwordError" style="color: red; display: none;">Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.</small>

                <br>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="POST">
                <h2>Log In</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <a style="color: white; right: 05px; " href="forget_password.php">Forgot password?</a><br><!-- Added Forgot Password Link -->
                <button type="submit" name="login">Log In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome</h1>
                    <p>Let's put health on top priority with Regular Checkups.</p>
                    <p style="color: rgb(0, 68, 255)">Already have an account?</p>
                    <button class="press" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>AARUSH CLINICAL HOSPITAL</h1>
                    <p>Accurate and Efficient diagnostics for better healthcare.</p>
                    <p style="color: rgb(0, 68, 255)">Don't have an account?</p>
                    <button class="press" id="signUp" style="color: rgb(57, 49, 5)">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const signUpButton = document.getElementById("signUp");
        const signInButton = document.getElementById("signIn");
        const container = document.getElementById("container");

        signUpButton.addEventListener("click", () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener("click", () => {
            container.classList.remove("right-panel-active");
        });

        
    document.getElementById("password").addEventListener("input", function () {
        const password = this.value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?':{}|<>]).{8,}$/;
        const errorElement = document.getElementById("passwordError");

        if (regex.test(password)) {
            errorElement.style.display = "none"; // Hide error message
            
        } else {
            errorElement.style.display = "block"; // Show error message
        }
    });
</script>
    
</body>

</html>