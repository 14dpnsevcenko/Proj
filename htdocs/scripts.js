// Get references to search form elements
const searchForm = document.getElementById('searchForm');
const searchResults = document.getElementById('searchResults');

// Function to display search results
function displaySearchResults(products) {
    // Clear previous results
    searchResults.innerHTML = '';

    // Display each product
    products.forEach(product => {
        const productItem = document.createElement('div');
        productItem.classList.add('product-item');
        productItem.innerHTML = `
            <h3>${product.name}</h3>
            <p><strong>Date:</strong> ${product.date}</p>
            <p><strong>Price:</strong> ${product.price} $</p>
            <button onclick="buyTicket('product_detail.php?id=${product.id}')">Buy Ticket</button>
        `;
        searchResults.appendChild(productItem);
    });
}

// Function to handle form submission
searchForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const searchQuery = document.getElementById('searchQuery').value;
    const sortCriteria = document.getElementById('sortCriteria').value;

    // Fetch search results
    fetch(`search.php?searchQuery=${encodeURIComponent(searchQuery)}&sortCriteria=${encodeURIComponent(sortCriteria)}`)
        .then(response => response.json())
        .then(data => {
            displaySearchResults(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

// Function to handle the buy ticket action
function buyTicket(link) {
    window.location.href = link;
}


// Get the pop-up and close button elements
const popup = document.getElementById('popup');
const closeBtn = document.querySelector('.close');
const chooseTimeLink = document.getElementById('chooseTimeLink');
const timeSelection = document.getElementById('timeSelection');

// Function to show the pop-up
function showPopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "block";
}

function closePopup() {
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

// Close the pop-up when the user clicks anywhere outside of the pop-up
window.addEventListener('click', function(event) {
    if (event.target == popup) {
        hidePopup();
    }
});

// Handle form submission (you can add your own logic here)
const callbackForm = document.getElementById('callbackForm');
if (callbackForm) {
    callbackForm.addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Form submitted!'); // Replace this with your form submission logic
        hidePopup();
    });
}

// Handle the display of the time selection
if (chooseTimeLink) {
    chooseTimeLink.addEventListener('click', function(event) {
        event.preventDefault();
        timeSelection.style.display = 'block';
    });
}

document.querySelector(".close").addEventListener("click", closePopup);
document.getElementById("chooseTimeLink").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("timeSelection").style.display = "block";
});