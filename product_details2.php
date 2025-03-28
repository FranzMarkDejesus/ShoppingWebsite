<?php
// Session start here
session_start();
$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_GET['id'])) {
    die("Error: Product ID not provided.");
}

$product_id = intval($_GET['id']);


// This is to select the items from the products2(Women) to get their information
$query = $conn->prepare("SELECT * FROM Products2 WHERE product_ID = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();
$query->close();

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
    <!-- This is for the link to get back to the products -->
    <fieldset class="titles" style="border: none; margin-top: -1em;">
        <h2>Product Details</h2>
        <a href="Womens.php" class="back-btn">Back to Products</a>
    </fieldset>
    <!-- This is for the products container for the products in women -->
    <div class="product-container">
        <div class="product-image">
            <img src="<?= !empty($product['image']) ? $product['image'] : 'images/default.png'; ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['product_name']); ?></h1>
            <p class="desc"><?= htmlspecialchars($product['description']); ?></p>
            <p class="price">$<?= number_format($product['price'], 2); ?></p>
            <!-- This is to display information from the table in the database -->
            <div class="product-info">
                <p><strong>Origin:</strong> <?= htmlspecialchars($product['origin']); ?></p>
                <p><strong>Date of Creation:</strong> <?= htmlspecialchars($product['date_of_creation']); ?></p>
                <p><strong>Quantity Available:</strong> <span id="availableQuantity"><?= $quantity_available; ?></span></p>
                <p><strong>Material Used for Case:</strong> <?= htmlspecialchars($product['material_used']); ?></p>
            </div>
            <!-- This is the add to cart function where the user can add to cart and increase or decrease the quantity -->
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['product_ID']; ?>">
                <div class="quantity-container">
                    <button type="button" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" id="productQuantity" value="1" min="1" max="<?= $quantity_available; ?>">
                    <button type="button" onclick="changeQuantity(1)">+</button>
                </div>
                <div class="cart-buttons">
                    <button type="submit" class="add-to-cart" id="addToCartBtn" <?= $quantity_available == 0 ? 'disabled' : ''; ?>>Add to Cart</button>
                </div>
            </form>
        </div>
    </div>
<!-- This is the script for increasing and decreasing the quantity, we didn't add it to a separate javascript file since this code is too small -->
    <script>
        function changeQuantity(change) {
            let qty = document.getElementById('productQuantity');
            let availableQty = parseInt(document.getElementById('availableQuantity').textContent);
            let newQty = parseInt(qty.value) + change;

            if (newQty >= 1 && newQty <= availableQty) {
                qty.value = newQty;
            }
        }

        
        if (parseInt(document.getElementById('availableQuantity').textContent) === 0) {
            document.getElementById('addToCartBtn').disabled = true;
        }
    </script>

</body>
</html>
