<?php
// Session start here
session_start();
require 'db_connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// To ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Error: User not logged in. Session data is empty. Please Login again.");
}
$customer_id = $_SESSION['customer_id'];

// To read from the database
$query = "SELECT c.cart_id, c.product_id, p.product_name, c.quantity, p.price
          FROM cart c
          JOIN products p ON c.product_id = p.product_ID
          WHERE c.customer_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// To store the items in the cart
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

// TO display the items recorded
foreach ($cart_items as $item) {
    if (!isset($_SESSION['cart'][$item['product_id']])) {
        $_SESSION['cart'][$item['product_id']] = [
            'name' => $item['product_name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'image' => 'path/to/default/image.jpg' 
        ];
    }
}

// This is for the proceed checkout function
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceed_checkout'])) {
    $_SESSION['checkout_items'] = [];

    if (isset($_POST['selected_items'])) {
        foreach ($_POST['selected_items'] as $selectedID) {
            if (isset($_SESSION['cart'][$selectedID])) {
                $_SESSION['checkout_items'][$selectedID] = $_SESSION['cart'][$selectedID];
            }
        }
    }

    if (!empty($_SESSION['checkout_items'])) {
        header("Location: checkout.php");
        exit();
    } else {
        echo "<script>alert('Please select at least one item to checkout.');</script>";
    }
}

// This is to remove the items in the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    $delete_query = "DELETE FROM cart WHERE product_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $id, $customer_id);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}

// This is to update the cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity));
        }
    }
    header("Location: cart.php");
    exit();
}

// To help with the proceeding to checkout
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proceed_to_checkout'])) {
    $_SESSION['checkout_items'] = [];
    if (!empty($_POST['selected_items'])) {
        foreach ($_POST['selected_items'] as $id) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['checkout_items'][$id] = $_SESSION['cart'][$id];
            }
        }
    }
    // Head to checkout.php after it activates
    header("Location: checkout.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/Cart.css" type="text/css" />
    <title>Your Shopping Cart</title>
</head>
<body>
<h2 style="text-align: center; font-size: 2.2rem;" class="title">Your Shopping Cart</h2>

<form method="post" action="cart.php">
<fieldset class="contain">
    <table>
        <tr>
            <th><input type="checkbox" id="select_all" onclick="toggleSelectAll(this)"></th> 
            <th class="image">Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>


        <?php 
        if (!empty($_SESSION['cart'])) :
            $total = 0;

            foreach ($_SESSION['cart'] as $key => $item) :
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
        ?>
        <!-- This is where the tables begins -->
            <tr>
                <td><input type="checkbox" name="selected_items[]" value="<?= htmlspecialchars($key); ?>"></td> 
                <td class="image"><img src="<?= htmlspecialchars($item['image']); ?>" width="70"></td>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td>
                    <!-- Quantity control for the the amount of items the client is going to order -->
                    <div class="quantity-controls">
                        <button type="button" onclick="decreaseQuantity('<?= $key; ?>')">-</button>
                        <input type="number" id="quantity_<?= $key; ?>" name="quantity[<?= htmlspecialchars($key); ?>]" value="<?= intval($item['quantity']); ?>" min="1">
                        <button type="button" onclick="increaseQuantity('<?= $key; ?>')">+</button>
                    </div>
                </td>
                <td>$<?= number_format($item['price'], 2); ?></td>
                <td>$<?= number_format($subtotal, 2); ?></td>
                <td>
                    <a href="cart.php?action=remove&id=<?= urlencode($key); ?>" class="remove-btn">Remove</a>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="5"><strong>Total</strong></td>
                <td><strong>$<?= number_format($total, 2); ?></strong></td>
                <td></td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="7">Your cart is empty.</td>
            </tr>
        <?php endif; ?>
    </table>
</fieldset>
<!-- This is for the functions -->
<div class="btn-container">
    <button type="submit" name="update_cart" class="btn">Update Cart</button>
    <a href="index.php" class="btn">Continue Shopping</a>
    <?php if (!empty($_SESSION['cart'])) : ?>
        <button type="submit" name="proceed_checkout" class="btn">Proceed to Checkout</button>
    <?php endif; ?>
    <a href="order_received.php" class="btn">Order History</a>


</div>
</form>
<script src="javascript/scriptCart.js"></script>
</body>
</html>
