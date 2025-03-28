<?php
// Session start here
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// TO ensure the user is logged in
if (!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == 0) {
    die("Unauthorized access. Please log in again.");
}

$customer_id = intval($_SESSION['customer_id']);

// This is to clear the current history of the account
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear_history"])) {
    $clearQuery = "DELETE FROM received_orders WHERE customer_id = ?";
    $stmt = $conn->prepare($clearQuery);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        echo "<p style='color: lime; text-align: center;'>Your history has been cleared successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error clearing history: " . $conn->error . "</p>";
    }
}

// This is to setup the connection of the received_orders
$query = "SELECT * FROM received_orders WHERE customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Received Orders</title>
    <link rel="stylesheet" href="css/order_received.css" type="text/css" />
</head>
<body>

<h2 style="text-align: center;">Your Received Orders</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Total</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
        <!-- This is the table where the items will be shown -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td>$<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= $row['order_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; color: yellow;">No order history found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- This is where the functions will be available to select -->
<div class="btn-container">
    <a href="order_list.php" class="btn back-btn">Back to Orders</a>
    <form method="POST" style="display: inline;">
        <button type="submit" name="clear_history" class="btn clear-btn">Clear History</button>
    </form>
</div>

</body>
</html>
