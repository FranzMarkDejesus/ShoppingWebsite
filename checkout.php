<?php
// Session start here
session_start();
if (empty($_SESSION['checkout_items'])) {
    header("Location: cart.php");
    exit();
}

// To ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    die("Error: You must be logged in to place an order.");
}


$customer_id = $_SESSION['customer_id'];

// The request method for the information to be passed later on
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $payment_method = $_POST['payment_method'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $distance = $_POST['distance']; 

    $card_number = $expiry_date = $cvv = NULL;
    if (strtolower($payment_method) === "card") {
        if (empty($_POST['card_number']) || empty($_POST['expiry_date']) || empty($_POST['cvv'])) {
            die("Error: Please enter all card details.");
        }
        $card_number = htmlspecialchars($_POST['card_number']);
        $expiry_date = htmlspecialchars($_POST['expiry_date']);
        $cvv = htmlspecialchars($_POST['cvv']);
    }

    $conn = new mysqli("localhost", "root", "", "shoppingdb1");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // THis is to insert in the orders table
    $conn->begin_transaction();
    try {
        foreach ($_SESSION['checkout_items'] as $item) {
            $stmt = $conn->prepare("INSERT INTO orders (customer_ID, customer_name, email, address, phone, latitude, longitude, distance, product_ID, product_name, quantity, price, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssdddissds", $customer_id, $name, $email, $address, $phone, $latitude, $longitude, $distance, $item['product_ID'], $item['name'], $item['quantity'], $item['price'], $item['category']);

            if (!$stmt->execute()) {
                die("Insert Error: " . $stmt->error);
            }
            $order_id = $conn->insert_id;
        }
        // This is to insert in the payments tables
        $stmt = $conn->prepare("INSERT INTO payments (order_id, customer_id, payment_method, card_number, card_expiry, card_cvv, payment_status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iissss", $order_id, $customer_id, $payment_method, $card_number, $expiry_date, $cvv);
        $stmt->execute();
    
        $conn->commit();
        unset($_SESSION['checkout_items']);
    
        header("Location: order_list.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/checkout.css" type="text/css" />
    <title>Checkout</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-geosearch/dist/geosearch.umd.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />
    <style>
        #map { height: 400px; width: 100%; margin-top: 20px; }
    </style>
</head>
<body>
<fieldset class="titles">
    <h2>Checkout</h2>
    <a href="cart.php" style="text-decoration: none;">Back to Cart</a>
</fieldset>
<!-- This is for the input sections for the informations -->
<form method="POST" action="">
    <label>Name:</label>
    <input type="text" name="name" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Address:</label>
    <textarea name="address" required></textarea>
    <label>Phone Number:</label>
    <input type="text" name="phone" required>
    <label>Country:</label>
    <select name="country" id="country" required>
        <option value="">Select Country</option>
        <?php
            $conn = new mysqli("localhost", "root", "", "shoppingdb1");
            $sql = "SELECT id, name FROM countries";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
        ?>
    </select>
    <label>City:</label>
    <select name="city" id="city" required>
        <option value="">Select City</option>
            <?php
            $conn = new mysqli("localhost", "root", "", "shoppingdb1");
            $sql = "SELECT id, name FROM cities";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
    </select>

    <h3 class="info" style="color: black;">Order Summary</h3>
    <ul class="info">
        <?php foreach ($_SESSION['checkout_items'] as $item) : ?>
            <li style="color: black;"><?= htmlspecialchars($item['name']); ?> - <?= intval($item['quantity']); ?> x $<?= number_format($item['price'], 2); ?></li>
        <?php endforeach; ?>
    </ul>
    <strong class="info" style="color: black;">Total: $<?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['checkout_items'])), 2); ?></strong>
    
    <h3 style="color: black;">Select Your Location:</h3>
    <!-- This is for the map to appear -->
    <div id="map" required></div>
    <p><strong style="color: black;">Distance to Store:</strong> <span id="distance" style="color: black;">Search or click on the map</span></p>
    <!-- This is for the estimate distance of our location to the location the user wants to select -->
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <input type="hidden" name="distance" id="distance_input">
    <label>Payment Method:</label>
    <select name="payment_method" id="payment_method" required>
        <option value="Null">Select option...</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
    </select>

    <div id="card_details" style="display: none;">
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="card_expiry">Expiry Date:</label>   
        <input type="text" id="card_expiry" name="card_expiry" required>

        <label for="card_cvv">CVV:</label>
        <input type="text" id="card_cvv" name="card_cvv" required>
    </div>

    <button type="submit" class="submit-btn">Place Order</button>
</form>
<script src="javascript/scriptCheckout.js"></script>

</body>
</html>