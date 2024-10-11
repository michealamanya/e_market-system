<?php
include_once 'php/db_connect.php';
session_start();
$conn = new mysqli("localhost", "root", "", "e-market");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the product ID is retrieved from the URL
$productId = $_GET['product_id'];
$userId = $_SESSION['user_id'];

// Insert browsing history
$sql = "INSERT INTO browsing_history (user_id, product_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $productId);
$stmt->execute();
$stmt->close();

// Fetch browsing history
$sql = "SELECT p.id, p.name, p.description, p.price, p.image 
        FROM browsing_history bh 
        JOIN products p ON bh.product_id = p.id 
        WHERE bh.user_id = ? 
        ORDER BY bh.timestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Display browsing history
while ($row = $result->fetch_assoc()) {
    echo "<article class='product'>";
    echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
    echo "<h3>" . $row['name'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<span class='price'>$" . $row['price'] . "</span>";
    echo "</article>";
}

$stmt->close();
$conn->close();
?>

// Assuming you have already established a database connection//

session_start();
$userId = $_SESSION['user_id']; // Get the logged-in user's ID
$productId = $_GET['product_id']; // Get the product ID from the URL or request

// Insert into browsing history
$sql = "INSERT INTO browsing_history (user_id, product_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $productId);
$stmt->execute();
$stmt->close();

// Fetch browsing history
$sql = "SELECT p.id, p.name, p.description, p.price, p.image 
        FROM browsing_history bh 
        JOIN products p ON bh.product_id = p.id 
        WHERE bh.user_id = ? 
        ORDER BY bh.timestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Display browsing history
while ($row = $result->fetch_assoc()) {
    echo "<article class='product'>";
    echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
    echo "<h3>" . $row['name'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<span class='price'>$" . $row['price'] . "</span>";
    echo "</article>";
}

$stmt->close();
