<?php
// Session start here
session_start();
$conn = new mysqli("localhost", "root", "", "ShoppingDB1");

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Index.css" type="text/css" />
    <title>Home Page</title>

</head>
<body>
<!-- For our header where all the navs and search engine are located -->
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
        <div class="search-container">
            <div class="search-bar">
                <input type="text" placeholder="Search..." />
                <button type="submit"><i class="ri-search-line"></i></button>
            </div>
            <a href="cart.php">
                <i class="ri-shopping-bag-line cart-icon"></i>
            </a>
            
        </div>

    </header>

    <!-- This is to confirm logout -->
    <form method="post" class="logout-btn" onsubmit="return confirmLogout();">
        <button type="submit" name="logout" style="display: flex; align-items: center; background: none; border: none; cursor: pointer; font-size: 16px;">
            <i class="ri-logout-box-r-line" style="margin-right: 5px;" id="Logout"> Logout</i>
        </button>
    </form>


    <main>

    <!-- This is for the Men and Women link in the index or homepage -->
        <fieldset class="contents">
            <a href="Mens.php" class="men" style="text-decoration: none; font-weight: bold;">MEN</a>
            <img class="photo1" src="images/perfume1.png" alt="Perfume Image">
            <a href="Womens.php" style="text-decoration: none; font-weight: bold;" class="women">WOMEN</a>
        </fieldset>
    </main>

    <script src="javascript/scriptIndex.js"></script>
</body>
</html>
