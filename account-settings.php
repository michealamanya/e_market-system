<?php
session_start();

// Database connection
$host = 'localhost'; // Database host
$db = 'e-market'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user is logged in and the user ID is stored in a session
$user_id = $_SESSION['user_id'];

// Fetch the current user data
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Renamed to username
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Only hash the password if the user updated it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user['password']; // Keep the old password if not updated
    }

    // Update user data in the database
    $update_query = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssi", $username, $email, $hashed_password, $user_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Your account information has been updated!";
        // Optionally, fetch the updated user data
        $stmt->execute();
        $user = $result->fetch_assoc();
    } else {
        $error_message = "Failed to update account information. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your own styles here -->
</head>
<body>

<h1>Account Settings</h1>

<?php if (isset($success_message)) : ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php endif; ?>

<?php if (isset($error_message)) : ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<form action="account_settings.php" method="POST">
    <div>
        <label for="username">Username:</label> <!-- Changed to Username -->
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    <div>
        <label for="password">Password: <small>(Leave blank to keep current password)</small></label>
        <input type="password" id="password" name="password" placeholder="Enter new password">
    </div>
    <button type="submit">Update Account</button>
</form>

<a href="user_dashboard.php">Back to Dashboard</a>

</body>
</html>
