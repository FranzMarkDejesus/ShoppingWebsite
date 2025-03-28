<?php
// Session start here

session_start();

$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This is to read from the products2(women) table and read it from that
$debug_result = $conn->query("SELECT * FROM Products2 WHERE product_name = 'MFK Baccarat Rouge 540'");
if ($debug_result->num_rows === 0) {
    error_log("Error: MFK Baccarat Rouge 540 not found in Products2 table.");
}

// This is to read from the products2(women) table and read it from that
$result = $conn->query("SELECT * FROM Products2");


if (isset($_GET['id'])) {
    $product_ID = intval($_GET['id']);
    error_log("Debug: Product ID received from URL = " . $product_ID);
}

// To ensure logout is properly done
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
    <title>Women's Perfume Collection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="css/Womens.css" type="text/css" />
</head>
<body>
    <!-- This is where all the contens of the header is held -->
    <header class="head">
        <a href="index.php"><h1>S É D U I R E</h1></a>
        <div class="hamburger" onclick="toggleMenu()">
            <i class="ri-menu-line"></i>
        </div>
        <nav id="mobile-menu" class="hidden">
            <a href="index.php" id="nav1">HOME</a>
            <a href="About Us.php" id="nav2">ABOUT</a>
            <a href="Contact.php" id="nav3">CONTACT</a>
            <a href="cart.php" id="nav4">CART</a>
        </nav>
        <!-- This is the search container -->
        <div class="search-container" style="border: none;">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for perfumes..."/>
                <button type="submit"><i class="ri-search-line"></i></button>
            </div>
            <a href="cart.php">
                <i class="ri-shopping-bag-line cart-icon"></i>
            </a>
        </div>
        <!-- THis is the logout button -->
        <form method="post" class="logout-btn" onsubmit="return confirmLogout();">
            <button type="submit" name="logout" style="display: flex; align-items: center; background: none; border: none; cursor: pointer; font-size: 16px;">
                <i class="ri-logout-box-r-line"></i>
                <span id="Logout" style="margin-left: 5px;">Logout</span>
            </button>
        </form>
    </header>

    
    <!-- Introduction for the page -->
    <main>
        <fieldset id="text">
            <p>BEST SELLING PRODUCTS FOR WOMEN</p>
        </fieldset>

        <!-- THis is for the search engine where if the product is not available, it would show this -->
        <div id="noResultsMessage" style="display: none; text-align: center; color: white; font-size: 1.5em; margin-top: 20px;">
            Product Not Available
        </div>

        
        <!-- This the product grid where the information will be shown -->
        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="product-card">
                    <img src="<?= !empty($row['image']) ? $row['image'] : 'images/default.png'; ?>" 
                         alt="<?= htmlspecialchars($row['product_name']); ?>">
                    <h3><?= htmlspecialchars($row['product_name']); ?></h3>
                    <p class="product-price">$<?= number_format($row['price'], 2); ?></p>
                    <p>100ml</p>
                    <a href="product_details2.php?id=<?= $row['product_ID']; ?>" class="view-btn">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- This is the ad section -->
        <div class="ad-section">
            <fieldset id="text">
                <p>Enthrall with the Allure of Azure and Gold</p>
            </fieldset>

            <fieldset id="ad1">
                <fieldset id="ad11">
                    <img src="images/perfume5.png" id="pic1"></img>
                </fieldset>
                <fieldset id="ad12">
                    <fieldset id="ad121">
                        <h1 style="font-size:1.5em;margin-top:1.5em;margin-bottom: -1em;">Limited Time Offer: 20% OFF on Xerjoff Blue Hope</h1>
                    </fieldset>
                    <fieldset id="ad122">
                        <h1>Blue Hope</h1>
                    </fieldset>
                    <fieldset id="ad123">    
                        <p>Immerse in the Boundless Serenity of Blue Hope</p>
                    </fieldset>
                    <fieldset id="ad124">
                        <p>Surrender to the peaceful charm of Xerjoff Blue Hope, where quiet strength and timeless elegance converge</p>
                    </fieldset>    
                </fieldset>
            </fieldset>

            <fieldset id="ad2">
                <fieldset id="ad11">
                    <img src="images/perfume6.png" id="pic2"></img>
                </fieldset>
                <fieldset id="ad12">
                    <fieldset id="ad121">
                        <h1 style="font-size:1.5em;margin-top:1.5em;margin-bottom: -1em;">Limited Time Offer: 25% OFF on Paco Rabanne Lady Million</h1>
                    </fieldset>
                    <fieldset id="ad122">
                        <h1>Lady Million</h1>
                    </fieldset>
                    <fieldset id="ad123">    
                        <p>Where luxury meets irresistible charm</p>
                    </fieldset>
                    <fieldset id="ad124">
                        <p>Discover Lady Million, where dazzling luxury and captivating confidence create a stunning presence.</p>
                    </fieldset>    
                </fieldset>
            </fieldset>
        </div>
    </main>

    <script src="javascript/scriptWomen.js"></script>


    
    <footer>
        <p>© 2025 SÉDUIRE. All rights reserved. Created by DJGG</p>
    </footer>
</body>
</html>
