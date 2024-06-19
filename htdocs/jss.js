document.getElementById('searchButton').addEventListener('click', function() {
    const search = document.getElementById('search').value;
    const sort = document.getElementById('sort').value;
    const order = document.getElementById('order').value;

    fetch(`search.php?search=${search}&sort=${sort}&order=${order}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Для отладки

            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';

            data.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.className = 'product';

                const name = document.createElement('h2');
                name.textContent = product.name;

                const date = document.createElement('p');
                date.textContent = `Date: ${product.date}`;

                const price = document.createElement('p');
                price.textContent = `Price: $${product.price}`;

                const place = document.createElement('p');
                place.textContent = `Place: ${product.place}`;

                productDiv.appendChild(name);
                productDiv.appendChild(date);
                productDiv.appendChild(price);
                productDiv.appendChild(place);

                resultsDiv.appendChild(productDiv);
            });
        })
        .catch(error => console.error('Error:', error));
});
