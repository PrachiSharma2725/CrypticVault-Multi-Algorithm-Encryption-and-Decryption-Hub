<?php
// Start session
session_start();

// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "crypticvault";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registration logic
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

     
        if ($password === $confirm_password) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database
            $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                // Retrieve the newly inserted user's information to set the session
                $getUserQuery = "SELECT * FROM user WHERE email = '$email'";
                $result = $conn->query($getUserQuery);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Set session variables
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $row['name'];
                    
                    // Redirect to main index page after registration
                    header("Location: ../index.php");
                    exit;
                }
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match! Please try again.');</script>";
        }
    } elseif (isset($_POST['login'])) {
        // Login logic
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if user exists in the database
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify the hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                header("Location: ../index.php"); // Redirect to main index page after login
                exit;
            } else {
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with that email.');</script>";
        }
    }
}

// Close connection
$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="loginstyles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
<header class="header">
        <div class="logo">
            
            <h1>CrypticVault</h1> <!-- Optional branding text -->
        </div>
        <div class="back-button">
            <a href="../index.php" class="back-link">Back</a>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <button class="toggle-button active" id="loginBtn">Login</button>
                <button class="toggle-button" id="signupBtn">Signup</button>
            </div>

            <div class="form-wrapper">
                <form id="loginForm" class="form active" method="POST" action="">
                    <h2 class="form-title">Login</h2>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                    <p class="switch-form">Don't have an account? <span id="switchToSignup">Sign up</span></p>
                </form>

                <form id="signupForm" class="form" method="POST" action="">
                    <h2 class="form-title">Signup</h2>
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <button type="submit" name="register">Sign Up</button>
                    <p class="switch-form">Already have an account? <span id="switchToLogin">Login</span></p>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<!-- 
23308d16a5959a4ac948b51f -->