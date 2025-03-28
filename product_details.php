<?php
// Session start here
session_start();
$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("Error: Product not found.");
}

// This is to select from the products(Men.php) for us to read the information later on
$product_id = intval($_GET['id']);
$query = $conn->prepare("SELECT * FROM Products WHERE product_ID = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Error: Product not found.");
}

$quantity_available = intval($product['quantity_available']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

   
    <link rel="stylesheet" href="css/product_details.css" type="text/css" />
    
    <title><?= htmlspecialchars($product['product_name']); ?> - Product Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
</head>
<body>
    <fieldset class="titles" style="border: none; margin-top: -1em;">
        <h2>Product Details</h2>
        <a href="Mens.php" class="back-btn">Back to Products</a>
    </fieldset>
    <div class="product-container">
        <div class="product-image">
            <img src="<?= !empty($product['image']) ? $product['image'] : 'images/default.png'; ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['product_name']); ?></h1>
            <p class="desc"><?= htmlspecialchars($product['description']); ?></p>
            <p class="price">$<?= number_format($product['price'], 2); ?></p>

            <!-- This is for the product info for Men-->
            <div class="product-info">
                <p><strong>Origin:</strong> <?= htmlspecialchars($product['origin']); ?></p>
                <p><strong>Date of Creation:</strong> <?= htmlspecialchars($product['date_of_creation']); ?></p>
                <p><strong>Quantity Available:</strong> <span id="availableQuantity"><?= $quantity_available; ?></span></p>
                <p><strong>Material Used for Case:</strong> <?= htmlspecialchars($product['material_used']); ?></p>
            </div>

            <!-- This is the function where the user can change quantity and add the item to the cart -->
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_ID']; ?>">
                <div class="quantity-container">
                    <button type="button" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" id="productQuantity" value="1" min="1" max="<?= $quantity_available; ?>">
                    <button type="button" onclick="changeQuantity(1)">+</button>
                </div>
                <div class="cart-buttons">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // This is the script for changing the quantity, we didn't add it to a javascript file since this is the only one here
        function changeQuantity(change) {
            let qty = document.getElementById('productQuantity');
            let maxQty = parseInt(document.getElementById('availableQuantity').innerText);
            let newQty = parseInt(qty.value) + change;

            if (newQty > 0 && newQty <= maxQty) {
                qty.value = newQty;
            }
        }
    </script>

</body>
</html>
