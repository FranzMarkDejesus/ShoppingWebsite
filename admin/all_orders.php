<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Only allow admins
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("<h2 style='color: red; text-align: center;'>Access Denied! Admins only.</h2>");
}

// ✅ Fetch all permanent records
$result = $conn->query("SELECT * FROM permanent_orders ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders (Admin Only)</title>
    <link rel="stylesheet" href="../css/order_received.css" type="text/css" />
</head>
<body>

<h2 style="text-align: center;">All Customer Orders (Admin Only)</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Product</th>
            <th>Total</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td>$<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= $row['order_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center; color: yellow;">No orders found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="btn-container">
    <a href="../order_list.php" class="btn back-btn">Back to Orders</a>
</div>

</body>
</html>
