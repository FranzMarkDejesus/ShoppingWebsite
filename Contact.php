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
    <link rel="stylesheet" href="css/Contact.css" type="text/css" />
    <title>Contact Us</title>
</head>
<body>
    <section id="desktop">
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
                    <input type="text" id="searchInput" placeholder="Search..."/>
                    <button type="submit"><i class="ri-search-line"></i></button>
                </div>
                <a href="cart.php">
                    <i class="ri-shopping-bag-line cart-icon"></i>
                </a>
            </div>
            <form method="post" class="logout-btn" onsubmit="return confirmLogout();">
                <button type="submit" name="logout" style="display: flex; align-items: center; background: none; border: none; cursor: pointer; font-size: 16px;">
                    <i class="ri-logout-box-r-line" class="logout" style="color: white;"></i>
                    <span id="Logout" style="margin-left: 5px;">Logout</span>
                </button>
            </form>
        </header>
        
        <body>
            <div class="container">
                <h2>Contact Us</h2>
                <form id="contact_form" onsubmit="emailSend(); reset(); return false;">
                    <label for="name">Name</label>
                    <input type="text" id="name" placeholder="e.g. Karl Guiao" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="e.g. seduireperfume@gmail.com" name="email" required>

                    <label for="message">Message</label>
                    <textarea id="message" placeholder="Message..." rows="5" name="message" required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>

            <div class="map-container">
                <h4>Contact us: <a href="tel:+639071752436">+639071752436</a></h4>
                <h4>Email us: <a href="mailto:seduireperfume@gmail.com" class="contact-email-link">seduireperfume@gmail.com</a></h4>
                <h4>Visit us at: 4HMR+XGR, Flora Ave, Angeles, Pampanga</h4>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3851.4249946476607!2d120.58868827335095!3d15.134987063773682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396f39cd482ad57%3A0x95cef8be5ee535ca!2sGame%20City%20HAU%20branch!5e0!3m2!1sen!2sph!4v1728712390626!5m2!1sen!2sph" width="600" height="450" allowfullscreen="" class="map"></iframe>
            </div>

            <div class="social">
                <a href="https://www.facebook.com/christructure" target="_blank">
                    <img src="images/facebook-logo.png" alt="black and white Facebook logo" />
                </a>
                <a href="https://www.instagram.com/christructure" target="_blank">
                    <img src="images/instagram-logo.png" alt="black and white Instagram logo" />
                </a>
                <a href="https://www.tiktok.com/@skaarlzky" target="_blank">
                    <img src="images/tiktok-logo.png" alt="black and white Tiktok logo" />
                </a>
            </div>
        </body>
<footer>
    <p>© 2025 SÉDUIRE. All rights reserved. Created by DJGG</p>
</footer>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://smtpjs.com/v3/smtp.js"></script>
<script src="javascript/scriptContact.js"></script>
</body>
</html>
