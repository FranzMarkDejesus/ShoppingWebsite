// For showing the hamburger menu in mobile
function toggleMenu() {
    let menu = document.getElementById("mobile-menu");
    menu.classList.toggle("show"); 
}

// For sending an email using SMTP
function emailSend() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var message = document.getElementById('message').value;

    var messageBody = "Name: " + name +
    "<br/> Email: " + email +
    "<br/> Message: " + message;
    Email.send({
        Host : "smtp.elasticemail.com",
        Username : "karlguiao17@gmail.com",
        Password : "90F3AC7A85581BAE57BE911091306DC36829",
        To : "karlguiao17@gmail.com",
        From : "karlguiao17@gmail.com",
        Subject : "S É D U I R E",
        Body : messageBody
    }).then(    // For checking and displaying if the message is sent successfully or not
        message => {
        if(message == 'OK') {
            swal("Sent", "Message sent successfully!", "success");
        }
        else {
            swal("Error", "Please try again.", "error");
        }
    }    
);
}

// For showing confirmation to log out
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}

// For the search bar input functionality to search a specific item
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".search-bar input");
    const searchButton = document.querySelector(".search-bar button");

    // For keywords used to search a specific item
    const pages = {
        "home": "index.php",
        "about us": "About Us.php",
        "background": "About Us.php",
        "story": "About Us.php",
        "contacts": "Contact.php",
        "location": "Contact.php",
        "map": "Contact.php",
        "comment": "Contact.php",
        "message": "Contact.php",
        "email": "Contact.php",
        "address": "Contact.php",
        "social media": "Contact.php",
        "cart": "Cart.php",
        "men perfume": "Mens.php",
        "aventus creed": "Mens.php",
        "dior sauvage": "Mens.php",
        "stronger with you": "Mens.php",
        "bleu de chanel": "Mens.php",
        "afnan 9pm": "Mens.php",
        "orto parisi megamare": "Mens.php",
        "initio side effect": "Mens.php",
        "versace eros flame": "Mens.php",
        "le male elixir": "Mens.php",
        "women perfume": "Womens.php",
        "miss dior": "Womens.php",
        "ariana grande cloud": "Womens.php",
        "chanel no. 5": "Womens.php",
        "tiffany & co": "Womens.php",
        "dolce & gabbana light blue": "Womens.php",
        "lanvin eclat": "Womens.php",
        "coco and chanel": "Womens.php",
        "mfk baccarat rouge 540": "Womens.php",
        "blue hope": "Womens.php",
        "lady million": "Womens.php",
        "orders": "Cart.php",
        "basket": "Cart.php",
    };

    // For adding suggestions box below the search bar
    let suggestionBox = document.createElement("div");
    suggestionBox.className = "suggestions";
    searchInput.parentNode.appendChild(suggestionBox);

    // For navigating the result of the searched item
    const searchPage = () => {
        const query = searchInput.value.toLowerCase().trim();
        if (pages[query]) {
            window.location.href = pages[query];
        } else {
            alert("No matching page found!");
        }
    };

    // For showing suggested searches
    searchInput.addEventListener("input", () => {
        let query = searchInput.value.toLowerCase().trim();
        suggestionBox.innerHTML = "";
        if (!query) return (suggestionBox.style.display = "none");

        let matches = Object.keys(pages).filter(page => page.includes(query));
        if (matches.length) {
            suggestionBox.style.display = "block";
            matches.forEach(match => {
                let item = document.createElement("div");
                item.className = "suggestion-item";
                item.textContent = match;
                item.onclick = () => { 
                    searchInput.value = match; 
                    searchPage(); 
                };
                suggestionBox.appendChild(item);
            });
        } else {
            suggestionBox.style.display = "none";
        }
    });

    // For clicking search button
    searchButton.addEventListener("click", searchPage);

    // For pressing "Enter" key to search
    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") searchPage();
    });

    // For hiding suggestions when clicking outside the search bar
    document.addEventListener("click", (e) => {
        if (!searchInput.parentNode.contains(e.target)) suggestionBox.style.display = "none";
    });
});

