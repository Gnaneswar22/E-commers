// Perform search with database results
function performSearch() {
    const query = searchInput.value.trim();
    
    if (!query) {
        alert('Please enter a search term');
        return;
    }
    
    searchResults.innerHTML = '<div class="empty-message">Searching...</div>';
    
    // Make AJAX request to search products
    fetch('admin/search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            query: query
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.count === 0) {
                searchResults.innerHTML = '<div class="empty-message">No products found</div>';
            } else {
                let html = '';
                data.products.forEach(product => {
                    html += `
                        <div class="search-item" data-id="\${product.id}">
                            <div class="search-item-image">
                                <img src="${product.image || 'images/placeholder.jpg'}" alt="${product.name}">
                            </div>
                            <div class="search-item-details">
                                <h4 class="search-item-name">\${product.name}</h4>
                                <p class="search-item-price">₹\${parseInt(product.price).toLocaleString()}</p>
                                <button class="btn" onclick="addToCart(\${product.id})">Add to Cart</button>
                            </div>
                        </div>
                    `;
                });
                searchResults.innerHTML = html;
            }
        } else {
            searchResults.innerHTML = '<div class="empty-message">Error: ' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        searchResults.innerHTML = '<div class="empty-message">Error performing search. Check console for details.</div>';
    });
}