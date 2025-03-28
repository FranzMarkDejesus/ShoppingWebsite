
<?php
// Session start here
session_start();


// This is to ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Session not set! Please log in again.");
}

$customer_id = $_SESSION['customer_id']; 

// Setting up the connection here
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This is to get the estimated time form the distance recorded
function getDeliveryTime($distance) {
    if ($distance > 0.00 && $distance <= 5.00) {
        return "Same day delivery";
    } elseif ($distance > 5.00 && $distance <= 20.00) {
        return "1-3 days";
    } elseif ($distance > 20.00 && $distance <= 50.00) {
        return "2 weeks";

    } elseif ($distance > 50.00 && $distance <= 100.00){
        return "4 weeks";
    } else {
        return "1 month and 1 week";
    }
}


// This is the location of the store/pinpointed area currently
$storeLat = 14.5995;
$storeLon = 120.9842;


// This is to read the database's contents
$query = "
SELECT order_id, customer_name, address, product_name, quantity, price, latitude, longitude, distance, order_date
FROM orders
ORDER BY order_date ASC, order_id ASC";

$result = $conn->query($query);

$orders = [];

// This is to get the current order date 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groupKey = $row['order_date'];
        $orders[$groupKey][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Management</title>
    <link rel="stylesheet" href="css/order_list.css" type="text/css" />
</head>
<body>

<h2>Order Management</h2>

<?php
$totalGrand = 0;

// This is to check if the items are available and to output it
if (!empty($orders)):
    foreach ($orders as $orderDate => $orderItems):
        $customer = $orderItems[0]['customer_name'];
        $address = $orderItems[0]['address'];
        $distance = $orderItems[0]['distance']; 
        $deliveryTime = getDeliveryTime($distance);

        $orderTotal = 0;
?>

<div class="order-header">Order Date: <?= $orderDate ?> (Estimated Delivery: <?= $deliveryTime ?>)</div>

<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Address</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($orderItems as $item): 
        $totalPrice = $item['quantity'] * $item['price'];
        $orderTotal += $totalPrice;
    ?>
        <tr>
            <td><?= htmlspecialchars($customer) ?></td>
            <td><?= htmlspecialchars($address) ?></td>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= intval($item['quantity']) ?></td>
            <td>$<?= number_format($totalPrice, 2) ?></td>
            <td>
                <form action="process_order.php" method="POST" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= $item['order_id'] ?>">
                    <button type="submit" class="btn btn-received">Order Received</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php 
$totalGrand += $orderTotal; 
endforeach;
else: 
?>
<p style="text-align: center; color: yellow;">No orders found.</p>
<?php endif; ?>

<!-- This is some links where the user will be relocated after pressing -->
<div class="btn-container">
    <a href="cart.php" class="back-btn">Back to Cart</a>
    <a href="order_received.php" class="btn btn-history">History</a>
</div>

</body>
</html>
