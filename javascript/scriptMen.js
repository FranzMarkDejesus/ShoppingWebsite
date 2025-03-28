// For the visibility of the naviagation menu
function toggleMenu() {
    const menu = document.querySelector(".head nav");
    
    if (menu.classList.contains("show")) {
        menu.style.height = "0";
        menu.style.opacity = "0";
        
        setTimeout(() => menu.classList.remove("show"), 500);
    } else {
        menu.classList.add("show");
        menu.style.height = "200px"; 
        menu.style.opacity = "1";
    }
}

// For filtering displayed products based on the customer search
function filterProducts() {
    const filterText = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    let found = false;

    productCards.forEach(card => {
        const productName = card.querySelector('h3').innerText.toLowerCase();

        if (productName.includes(filterText)) {
            card.style.display = 'block';
            found = true;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('noResultsMessage').style.display = found ? 'none' : 'block';
}

// For closing the product popup
function closePopup() {
    document.getElementById('productPopup').style.display = 'none';
}

// For visibility of navigation menu
function toggleMenu() {
    let menu = document.querySelector(".head nav");
    menu.classList.toggle("show");
}

// For the visibility of the search bar
function toggleSearchBar() {
    let searchBar = document.getElementById("searchBar");
    searchBar.classList.toggle("active");
}

// For showing confirmation to log out
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
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