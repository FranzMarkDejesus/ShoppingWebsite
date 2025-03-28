<?php
// Start session here 
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "shoppingdb1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This is to get the information based from the order_id
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["order_id"])) {
    $order_id = intval($_POST["order_id"]);

    // This is to process the order
    $query = "SELECT order_id, customer_name, email, address, product_name, quantity, price, (price * quantity) AS total_price, order_date, customer_ID FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        
        $total_price = $row['total_price'] ?? ($row['price'] * $row['quantity']);

        // This is to insert in the received_orders table
        $insertReceived = "
            INSERT INTO received_orders (order_id, customer_name, email, address, product_name, quantity, price, total_price, order_date, customer_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmtReceived = $conn->prepare($insertReceived);
        $stmtReceived->bind_param(
            "issssiddsi",
            $row['order_id'], $row['customer_name'], $row['email'], $row['address'],
            $row['product_name'], $row['quantity'], $row['price'],
            $total_price, $row['order_date'], $row['customer_ID']
        );

        
        // This is the insert in the permanent orders table where the records will be permanently written without removing it from the database by us
        $insertPermanent = "
            INSERT INTO permanent_orders (order_id, customer_name, email, address, product_name, quantity, price, total_price, order_date, customer_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmtPermanent = $conn->prepare($insertPermanent);
        $stmtPermanent->bind_param(
            "issssiddsi",
            $row['order_id'], $row['customer_name'], $row['email'], $row['address'],
            $row['product_name'], $row['quantity'], $row['price'],
            $total_price, $row['order_date'], $row['customer_ID']
        );

        
        if ($stmtReceived->execute() && $stmtPermanent->execute()) {
            // This is used for the delete from orders
            $deleteQuery = "DELETE FROM orders WHERE order_id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $order_id);
            $deleteStmt->execute();

            
            header("Location: order_list.php");
            exit;
            // This are all for the error handling
        } else {
            echo "Error moving order: " . $conn->error;
        }
    } else {
        echo "Order not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
