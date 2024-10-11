<?php
// Start a session
session_start();

// Database connection details
$servername = "localhost"; // Your database server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "e-market"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Validate input
    if (empty($firstname) || empty($lastname) || empty($user) || empty($email) || empty($pass)) {
        $error = "All fields are required.";
    } else {
        // Sanitize inputs
        $firstname = mysqli_real_escape_string($conn, $firstname);
        $lastname = mysqli_real_escape_string($conn, $lastname);
        $user = mysqli_real_escape_string($conn, $user);
        $email = mysqli_real_escape_string($conn, $email);
        $pass = mysqli_real_escape_string($conn, $pass);

        // Check if the username or email already exists
        $sql = "SELECT * FROM users WHERE username = '$user' OR email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User already exists
            $error = "Username or email already exists. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql = "INSERT INTO users (firstname, lastname, username, email, password) 
                    VALUES ('$firstname', '$lastname', '$user', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to login page after successful sign-up
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="signup-styles.css">
</head>
<body>
    <div class="form-container">
        <form id="signup-form" class="form" method="POST" action="">
            <h2>Sign Up Here</h2>
            <div class="input-container">

                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

            </div>

            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>

            <button type="submit">Sign Up</button>
           <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
