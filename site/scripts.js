// Get references to search form elements
const searchForm = document.getElementById('searchForm');
const searchResults = document.getElementById('searchResults');

// Array simulating ticket data (for demonstration purposes)
const ticketData = [
    { name: 'AC/DC Concert', date: '2024-05-15', price: 50, link: 'acdc.html' },
    { name: 'Queen Concert', date: '2024-05-15', price: 200, link: 'concert-event.html' },
    { name: 'Football Match "El Classico"', date: '2024-06-30', price: 800, link: 'sports-event.html' },
    { name: 'FIFA World Cup Final', date: '2026-06-30', price: 200, link: 'fifa.html' },
];

// Function to display search results and sorting
function displaySearchResults(searchQuery, sortCriteria) {
    // Clear searchResults content before updating
    searchResults.innerHTML = '';

    // Filter and sort tickets
    const filteredTickets = ticketData.filter(ticket => {
        // Example filter by search query (customize as needed)
        return ticket.name.toLowerCase().includes(searchQuery.toLowerCase());
    });

    // Sort tickets based on criteria
    filteredTickets.sort((a, b) => {
        if (sortCriteria === 'date') {
            return new Date(a.date) - new Date(b.date); // Sort by date
        } else if (sortCriteria === 'price') {
            return a.price - b.price; // Sort by price
        } else {
            return 0; // Default: no sorting
        }
    });

    // Display sorted tickets
    filteredTickets.forEach(ticket => {
        const ticketItem = document.createElement('div');
        ticketItem.classList.add('ticket-item');
        ticketItem.innerHTML = `
            <h3>${ticket.name}</h3>
            <p><strong>Date:</strong> ${ticket.date}</p>
            <p><strong>Price:</strong> ${ticket.price} $</p>
            <button onclick="buyTicket('${ticket.link}')">Buy Ticket</button>
        `;
        searchResults.appendChild(ticketItem);
    });
}

// Function to handle the buy ticket action
function buyTicket(link) {
    window.location.href = link;
}

// Event handler for search form submission
if (searchForm) {
    searchForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        const searchQuery = document.getElementById('searchQuery').value;
        const sortCriteria = document.getElementById('sortCriteria').value;

        // Call function to display search results and sorting
        displaySearchResults(searchQuery, sortCriteria);
    });
}

// Get the pop-up and close button elements
const popup = document.getElementById('popup');
const closeBtn = document.querySelector('.close');
const chooseTimeLink = document.getElementById('chooseTimeLink');
const timeSelection = document.getElementById('timeSelection');

// Function to show the pop-up
function showPopup() {
    popup.style.display = 'block';
}

// Function to hide the pop-up
function hidePopup() {
    popup.style.display = 'none';
}

// Close the pop-up when the user clicks on the close button
if (closeBtn) {
    closeBtn.addEventListener('click', hidePopup);
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
