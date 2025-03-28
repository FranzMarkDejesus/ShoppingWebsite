<?php
// This is to setup the connection to the database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This is to read from the orders table
$orderID = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_ID = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
</head>
<body>
<h2>Order Details</h2>

<!-- This is to display the information of the following -->
<?php if ($order) : ?>
    <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($order['address']); ?></p>
    <p><strong>Product:</strong> <?= htmlspecialchars($order['product_name']); ?></p>
    <p><strong>Quantity:</strong> <?= $order['quantity']; ?></p>
    <p><strong>Price:</strong> $<?= number_format($order['price'], 2); ?></p>
    <p><strong>Total:</strong> $<?= number_format($order['quantity'] * $order['price'], 2); ?></p>
<?php else : ?>
    <p>Order not found.</p>
<?php endif; ?>

<a href="orders.php">Back to Orders</a>

<?php $stmt->close(); $conn->close(); ?>
</body>
</html>
