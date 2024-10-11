<?php
session_start();

// Database connection (replace with your own connection parameters)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-market";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Handle form submission for adding product to the cart
if (isset($_POST['product_id']) && isset($_POST['name']) && isset($_POST['price'])) {
    $product_id = $_POST['product_id'];
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];

    // Add product to the session cart (with user association)
    if (isset($_SESSION['cart'][$user_id])) {
        if (array_key_exists($product_id, $_SESSION['cart'][$user_id])) {
            $_SESSION['cart'][$user_id][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$user_id][$product_id] = [
                'id' => $product_id,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1
            ];
        }
    } else {
        $_SESSION['cart'][$user_id] = [
            $productId => [
                'id' => $product_id,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1
            ]
        ];
    }

    // Check if product already exists in the cartitems table for this user
    $checkQuery = "SELECT * FROM cartitems WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product already exists in the cart, update the quantity and updated_at
        $updateQuery = "UPDATE cartitems SET quantity = quantity + 1, updated_at = NOW() WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    } else {
        // Insert the product into the cartitems table
        $insertQuery = "INSERT INTO cartitems (user_id, product_id, quantity, added_at, updated_at) VALUES (?, ?, 1, NOW(), NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    }

    // Redirect to the cart page with a success message
    header("Location: cartplacement.php?success=1");
    exit();
}

// Handle quantity update
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $newQuantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$user_id][$product_id])) {
        if ($newQuantity > 0) {
            $_SESSION['cart'][$userId][$productId]['quantity'] = $newQuantity;

            // Update the quantity in the database as well
            $updateQuery = "UPDATE cartitems SET quantity = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iii", $newQuantity, $userId, $productId);
            $stmt->execute();
        } else {
            unset($_SESSION['cart'][$userId][$productId]); // Remove product if quantity is set to 0

            // Remove the product from the cartitems table as well
            $deleteQuery = "DELETE FROM cartitems WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        }
    }

    header("Location: cartplacement.php");
    exit();
}

// Handle product removal
if (isset($_POST['remove_product'])) {
    $productId = $_POST['product_id'];

    if (isset($_SESSION['cart'][$user_id][$product_id])) {
        unset($_SESSION['cart'][$user_id][$product_id]);

        // Remove the product from the cartitems table
        $deleteQuery = "DELETE FROM cartitems WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    header("Location: cartplacement.php");
    exit();
}
?>
