// For adding quantity of the product
function increaseQuantity(id) {
    var input = document.getElementById('quantity_' + id);
    input.value = parseInt(input.value) + 1;
}

// For reducing the number of quantity
function decreaseQuantity(id) {
    var input = document.getElementById('quantity_' + id);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// For selecting all check boxes
function toggleSelectAll(source) { 
    checkboxes = document.getElementsByName('selected_items[]'); 
    for (var i = 0; i < checkboxes.length; i++) { 
        checkboxes[i].checked = source.checked; 
    } 
} 

// For the select/unselect all check box
document.getElementById('select_all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// For showing confirmation to log out
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}

// For showing the hamburger menu in mobile
function toggleMenu() {
    var menu = document.getElementById("mobile-menu");
    menu.classList.toggle("show");
}

// For hiding the hamburger menu when clicking outside 
document.addEventListener("click", function(event) {
    var menu = document.getElementById("mobile-menu");
    var hamburger = document.querySelector(".hamburger");

    if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
        menu.classList.remove("show");
    }
});

// For hiding the hamburger menu
function toggleMenu() {
    var menu = document.getElementById("mobile-menu");
    menu.classList.toggle("hidden");
}

