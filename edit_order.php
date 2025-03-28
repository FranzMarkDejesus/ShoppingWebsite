<?php
// Start the database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);

$orderID = intval($_GET['id']);

// This is to update the orders
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = htmlspecialchars($_POST['product']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    $stmt = $conn->prepare("
        UPDATE orders 
        SET product_name = ?, quantity = ?, price = ? 
        WHERE order_ID = ?
    ");
    $stmt->bind_param("sidi", $product, $quantity, $price, $orderID);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}

$result = $conn->query("SELECT * FROM orders WHERE order_ID = $orderID");
$order = $result->fetch_assoc();
?>

<!-- This is for the contents that can be edited -->
<form method="POST">
    <label>Product: <input type="text" name="product" value="<?= $order['product_name']; ?>"></label>
    <label>Quantity: <input type="number" name="quantity" value="<?= $order['quantity']; ?>"></label>
    <label>Price: <input type="text" name="price" value="<?= $order['price']; ?>"></label>
    <button type="submit">Update</button>
</form>

<a href="orders.php">Back to Orders</a>
