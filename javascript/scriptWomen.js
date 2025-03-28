// For the visibility of the naviagation menu
function toggleMenu() {
    let menu = document.querySelector("nav");

    if (menu.classList.contains("show")) {
        menu.style.maxHeight = "0"; 
        setTimeout(() => menu.classList.remove("show"), 500); 
    } else {
        menu.classList.add("show"); 
        menu.style.maxHeight = "300px"; 
    }
}

// For filtering displayed products based on the customer search
function filterProducts() {
    const filterText = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    let found = false;

    productCards.forEach(card => {
        const productName = card.querySelector('h3').innerText.toLowerCase();

        if (filterText === "") {
            card.style.display = "block"; 
            found = true;
        } else if (productName.includes(filterText)) {
            card.style.display = "block"; 
            found = true;
        } else {
            card.style.display = "none"; 
        }
    });

    // For showing a message when the searched product is not found
    document.getElementById('noResultsMessage').style.display = found ? "none" : "block";
}

// For running an Event Listener when the DOM is full
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const ads = document.querySelectorAll('.ad-section');

    searchInput.addEventListener('keyup', () => {
        filterProducts();

        // For showing/hiding the ads when searching
        ads.forEach(ad => {
            ad.style.display = searchInput.value ? 'none' : 'block';
        });
    });
});

// For showing confirmation to log out
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}

// For displaying the product details popup
function openPopup(productName) {
    let popup = document.getElementById("productPopup");
    let product = productDetails[productName];

    if (product) {
        document.getElementById("popupProductName").innerText = productName;
        document.getElementById("popupDescription").innerText = product.description;
        document.getElementById("popupOrigin").innerText = product.origin;
        document.getElementById("popupDate").innerText = product.date;
        document.getElementById("popupQuantity").innerText = product.quantity;
        document.getElementById("popupMaterial").innerText = product.material;
        document.getElementById("popupPrice").innerText = product.price;
        document.getElementById("popupProductImage").src = product.image;

        // For setting the initial quantity of the product to 1
        document.getElementById("productQuantity").value = 1;
    }
    
    // For showing the popup
    popup.style.display = "flex";
}

// For opening the popup with details when clicking the product itself
document.querySelectorAll(".perfume-box").forEach(box => {
    box.addEventListener("click", function() {
        let productName = this.querySelector(".perfume-name").innerText;
        openPopup(productName);
    });
});

// For closing the product popup
function closePopup() {
    document.getElementById("productPopup").style.display = "none";
}

// For closing the product popup when clicking outside
document.getElementById("productPopup").addEventListener("click", function(event) {
    let popupContent = document.querySelector(".popup-content");
    if (!popupContent.contains(event.target)) {
        closePopup();
    }
});

// For manipulating the quantity of the product in popup
function changeQuantity(amount) {
    let quantityInput = document.getElementById("productQuantity");
    let productName = document.getElementById("popupProductName").innerText;
    let maxQuantity = parseInt(productDetails[productName].quantity); 

    let newQuantity = parseInt(quantityInput.value) + amount;

    if (newQuantity >= 1 && newQuantity <= maxQuantity) {
        quantityInput.value = newQuantity;
    }
}


// For adding the product to the customer's cart
function addToCart() {
    alert("Added to cart!");
}

// For opening the product popup when the product is clicked
document.querySelectorAll(".perfume-box").forEach(box => {
    box.addEventListener("click", function() {
        let productName = this.querySelector(".perfume-name").innerText;
        openPopup(productName);
    });
});

// For the visibility of the naviagation menu
function toggleMenu() {
    let menu = document.querySelector(".head nav");
    menu.classList.toggle("show");
}

// For the visibility of the search bar
function toggleSearchBar() {
    let searchBar = document.getElementById("searchBar");
    searchBar.classList.toggle("active");
}

// For filtering products and hiding ads based on search input
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const productCards = document.querySelectorAll('.product-card');
    const ads = document.querySelectorAll('.ad-section');
    const noResultsMessage = document.getElementById('noResultsMessage');

    searchInput.addEventListener('keyup', () => {
        const filterText = searchInput.value.toLowerCase();
        let found = false;

        // For looping within all the products and display when matches the search input
        productCards.forEach(card => {
            const productName = card.querySelector('h3').innerText.toLowerCase();

            if (productName.includes(filterText)) {
                card.style.display = 'block';
                found = true;
            } else {
                card.style.display = 'none';
            }
        });

        // For showing/hiding the ads when searching
        ads.forEach(ad => {
            ad.style.display = filterText ? 'none' : 'block';
        });

        // For showing a message when the searched product is not found
        noResultsMessage.style.display = found ? 'none' : 'block';
    });
});

