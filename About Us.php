<?php
// session start here
session_start();
$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

// To logout here
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/about.css" type="text/css" />
    <title>Home Page</title>
</head>
<body>
    <!-- for every header here -->
    <section id="desktop">
        <header class="head">
            <a href="index.php" ><h1>S É D U I R E</h1></a>
            <div class="hamburger" onclick="toggleMenu()">
                <i class="ri-menu-line"></i> 
            </div>
            <nav id="mobile-menu" class="hidden">
                <a href="index.php" id="nav1">HOME</a>
                <a href="About Us.php" id="nav2">ABOUT</a>
                <a href="Contact.php" id="nav3">CONTACT</a>
                <a href="cart.php" id="nav4">CART</a>
            </nav>
            <!-- FOr search engine here -->
            <div class="search-container">
                <div class="search-bar">
                    <input type="text" placeholder="Search..." />
                    <button type="submit"><i class="ri-search-line"></i></button>
                </div>
                
                <a href="cart.php">
                    <i class="ri-shopping-bag-line cart-icon"></i>
                </a>
            </div>
        <!-- For the logout button here -->
            <form method="post" class="logout-btn" onsubmit="return confirmLogout();">
                <button type="submit" name="logout" style="display: flex; align-items: center; background: none; border: none; cursor: pointer; font-size: 16px;">
                    <i class="ri-logout-box-r-line" style="color: white;"></i>
                    <span id="Logout" style="margin-left: 5px;">Logout</span>
                </button>
            </form>
        </header>

    <!-- For the contents here -->
        <h2>About Us</h2>
        <section class="about-us">
        <p class="para">
            At SÉDUIRE, we believe that fragrance is an art form and an expression of personal style. We curate a collection of rare and luxurious niche and designer scents, offering discerning individuals access to the world’s finest aromas. For many years, the most coveted designer and niche brands have chosen to partner with SÉDUIRE, solidifying our position as the go-to destination for fragrance enthusiasts.
            Our handpicked selection includes both timeless classics and avant-garde creations, each chosen for its quality and exclusivity. Whether you're searching for a signature scent or a unique gift, SÉDUIRE delivers an unparalleled fragrance experience.
            Discover elegance and sophistication with SÉDUIRE—where luxury meets scent.
        </p>
    </section>

    
        <h2>Our Story</h2>
        <section class="our-story">
        <p class="para">
            SÉDUIRE meaning "to seduce" in French was founded with a passion for exceptional fragrances and a vision to offer the world’s most exclusive scents. Our curated collection features rare and luxurious niche and designer aromas, each selected for its unique charm and superior quality.
            Driven by a love for fine perfume, we aim to provide a sensory experience that reflects elegance and sophistication. At SÉDUIRE, every fragrance tells a story, and every client enjoys a touch of luxury. Discover the art of scent with us.
        </p>
    </section>
<!-- Links here -->
    <section class="contact-us">
        <h2>Contact Us</h2>
            <div class="social">
                <a href="https://www.facebook.com/seduire.2025" target="_blank" style="text-decoration: none;">
                    <img src="images/facebook-logo.png" alt="black and white Facebook logo" />
                </a>
                <a href="https://www.instagram.com/seduireofficial2025/" target="_blank" style="text-decoration: none;">
                    <img src="images/instagram-logo.png" alt="black and white Instagram logo" />
                </a>
                <a href="https://www.tiktok.com/@seduireofficial?is_from_webapp=1&sender_device=pc" target="_blank" style="text-decoration: none;">
                    <img src="images/tiktok-logo.png" alt="black and white Tiktok logo" />
                </a>
            </div>
    </section>
<footer>
    <p>© 2025 SÉDUIRE. All rights reserved. Created by DJGG</p>
</footer>
<script src="javascript/scriptAbout.js"></script>
</body>
</html>
