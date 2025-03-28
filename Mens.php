<?php
// Session start here
session_start();

$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This is to set up the connection from the products table
$result = $conn->query("SELECT * FROM Products");


// Logout function here
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
    <title>Men's Perfume Collection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="css/Mens.css" type="text/css" />
</head>
<body>
    
<!-- This is for the header which contains the contents, nav, and the search engine -->
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
        <div class="search-container" style="border: none;">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for perfumes..."/>
                <button type="submit"><i class="ri-search-line"></i></button>
            </div>
            <a href="cart.php">
                <i class="ri-shopping-bag-line cart-icon"></i>
            </a>
        </div>
        <form method="post" class="logout-btn" onsubmit="return confirmLogout();">
            <button type="submit" name="logout" style="display: flex; align-items: center; background: none; border: none; cursor: pointer; font-size: 16px;">
                <i class="ri-logout-box-r-line"></i>
                <span id="Logout" style="margin-left: 5px;">Logout</span>
            </button>
        </form>
    </header>

    
    <main>
        <!-- Text for introduction to the website -->
        <fieldset id="text">
            <p>BEST SELLING PRODUCTS FOR MEN</p>
        </fieldset>

        <div id="noResultsMessage" style="display: none; text-align: center; color: white; font-size: 1.5em; margin-top: 20px;">
            Product Not Available
        </div>

        
        <!-- This is the product grid where the contents of the product will be shown -->
        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="product-card">
                    <img src="<?= !empty($row['image']) ? $row['image'] : 'images/default.png'; ?>" alt="<?= htmlspecialchars($row['product_name']); ?>">
                    <h3><?= htmlspecialchars($row['product_name']); ?></h3>
                    <p class="product-price">$<?= number_format($row['price'], 2); ?></p>
                    <p>100ml</p>
                    <a href="product_details.php?id=<?= $row['product_ID']; ?>" class="view-btn">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>

        
        <!-- This is the ad section where the most famous perfumes are located -->
        <div class="ad-section">
            <fieldset id="text">
                <p>Enthrall with the Allure of Azure and Gold</p>
            </fieldset>

            <fieldset id="ad1">
                <fieldset id="ad11">
                    <img src="images/perfume3.png" id="pic1"></img>
                </fieldset>
                <fieldset id="ad12">
                    <fieldset id="ad121">
                        <h1 style="font-size:1.5em;margin-top:1.5em;margin-bottom: -1em;">Limited Time Offer: 20% OFF on Versace Eros</h1>
                    </fieldset>
                    <fieldset id="ad122">
                        <h1>Versace Eros</h1>
                    </fieldset>
                    <fieldset id="ad123">    
                        <p>Embrace the Allure of Desire</p>
                    </fieldset>
                    <fieldset id="ad124">
                        <p>Step into the embrace of timeless seduction with Versace Eros, where bold masculinity meets irresistible charm. This iconic fragrance fuses fresh mint, crisp green apple, and zesty lemon with a sensual heart of tonka bean, amber, and geranium.</p>
                    </fieldset>    
                </fieldset>
            </fieldset>

            <fieldset id="ad2">
                <fieldset id="ad11">
                    <img src="images/perfume4.png" id="pic2"></img>
                </fieldset>
                <fieldset id="ad12">
                    <fieldset id="ad121">
                        <h1 style="font-size:1.5em;margin-top:1.5em;margin-bottom: -1em;">Limited Time Offer: 25% OFF on Jean Paul Gaultier Le Male Elixir!</h1>
                    </fieldset>
                    <fieldset id="ad122">
                        <h1>Le Male Elixir</h1>
                    </fieldset>
                    <fieldset id="ad123">    
                        <p>Reveal Your Bold, Sensual Spirit</p>
                    </fieldset>
                    <fieldset id="ad124">
                        <p>Indulge in the divine allure of Being Golden, a fragrance that embodies celestial elegance and radiance. This luxurious scent opens with a burst of sparkling citrus, blending seamlessly with soft floral notes that exude grace and sophistication.</p>
                    </fieldset>    
                </fieldset>
            </fieldset>
        </div>
    </main>

    <script src="javascript/scriptMen.js"></script>


    
    <footer>
        <p>© 2025 SÉDUIRE. All rights reserved. Created by DJGG</p>
    </footer>
</body>
</html>
