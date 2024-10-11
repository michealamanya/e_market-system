<?php
// Start a session
session_start();

// Database connection details
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "e-market"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Protect from SQL injection
    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Check if the password matches
        $row = $result->fetch_assoc();
        
        if (password_verify($pass, $row['password'])) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['username'] = $user;
            header("Location: user_dashboard.php");
            exit();
        } else {
            // Invalid password
            $error = "Invalid password.";
        }
    } else {
        // Invalid username
        $error = "Invalid username.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
    <div class="form-container">
        <form id="login-form" class="form" method="POST" action="">
            <h2 class="form-title">Login here</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>

            <button type="submit">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
