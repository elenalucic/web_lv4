// Get elements
const cartButton = document.querySelector('.cart-button');
const cartBadge = document.querySelector('.cart-badge');
const modal = document.querySelector('.modal');
const modalClose = document.querySelector('.close');
const buyButton = document.querySelector('.buy-btn');
const cartItemsList = document.querySelector('.cart-items');
const cartTotal = document.querySelector('.cart-total');
const itemsGrid = document.querySelector('.items-grid');
const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

let items = [
    {
        id: 1,
        name: 'Ozweego',
        price: 109,
        imageUrl: 'images/1.jpg',
    },
    {
        id: 2,
        name: 'Forum',
        price: 144,
        imageUrl: 'images/2.jpg',
    },
    {
        id: 3,
        name: 'SUPERSTAR XLG',
        price: 249,
        imageUrl: 'images/3.jpg',
    },
    {
        id: 4,
        name: 'X_PLR Phase',
        price: 149,
        imageUrl: 'images/4.jpg',
    },
    {
        id: 5,
        name: 'Forum Bold',
        price: 209,
        imageUrl: 'images/5.jpg',
    },
    {
        id: 6,
        name: 'Stan Smith Bonega',
        price: 229,
        imageUrl: 'images/6.jpg',
    },
   
];

let cart = [];

let walletAmount = 1000; 

function fillItemsGrid() {
    itemsGrid.innerHTML = '';

    for (const item of items) {
        let itemElement = document.createElement('div');
        itemElement.classList.add('item');
        itemElement.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.name}">
            <h2>${item.name}</h2>
            <p>$${item.price}</p>
            <button class="add-to-cart-btn" data-id="${item.id}">Add to cart (0)</button>
            <div class="quantity-controls">
                <button class="decrement-btn">-</button>
                <span class="quantity">0</span>
                <button class="increment-btn">+</button>
            </div>
        `;
        itemsGrid.appendChild(itemElement);
    }
    addListenersToCartButtons(); 
}

function addListenersToCartButtons() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const itemElement = button.closest('.item');
            const quantityElement = itemElement.querySelector('.quantity');
            const currentQuantity = parseInt(quantityElement.textContent);
            const itemId = parseInt(button.getAttribute('data-id'));
            addToCart(itemId, currentQuantity);
            quantityElement.textContent = 0;
            updateAddToCartButton(itemElement);
        });
    });
}

function addToCart(itemId, quantity = 1) {
    const selectedItem = items.find(item => item.id === itemId);
    for (let i = 0; i < quantity; i++) {
        cart.push(selectedItem); 
    }
    updateCart();
}

function updateCart() {
    cartItemsList.innerHTML = '';
    let totalPrice = 0;
    const itemQuantities = {};

    cart.forEach(item => {
        if (item.id in itemQuantities) {
            itemQuantities[item.id]++;
        } else {
            itemQuantities[item.id] = 1;
        }
    });

    for (const itemId in itemQuantities) {
        const itemQuantity = itemQuantities[itemId];
        const item = items.find(item => item.id === parseInt(itemId));
        const cartItemElement = document.createElement('li');
        const itemTotalPrice = item.price * itemQuantity;
        cartItemElement.innerHTML = `
            <span>• ${item.name} (${itemQuantity}) - $${itemTotalPrice.toFixed(2)}</span>
           <button class="remove-from-cart-btn" data-id="${itemId}">-</button>
        `;
        cartItemsList.appendChild(cartItemElement);
        totalPrice += itemTotalPrice;
    }

    cartTotal.textContent = `$${totalPrice.toFixed(2)}`;
    cartBadge.textContent = Object.values(itemQuantities).reduce((a, b) => a + b, 0); 
    const removeFromCartButtons = document.querySelectorAll('.remove-from-cart-btn');
    removeFromCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const itemId = parseInt(button.getAttribute('data-id'));
            removeFromCart(itemId);
        });
    });
}

function updateAddToCartButton(itemElement) {
    const quantity = parseInt(itemElement.querySelector('.quantity').textContent);
    const addToCartButton = itemElement.querySelector('.add-to-cart-btn');
    addToCartButton.textContent = `Add to cart (${quantity})`;
}


function updateWalletAmount() {
    const walletAmountElement = document.querySelector('.wallet-amount');
    walletAmountElement.textContent = `$${walletAmount.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const itemElement = button.closest('.item');
            const quantityElement = itemElement.querySelector('.quantity');
            const currentQuantity = parseInt(quantityElement.textContent);
            const itemId = parseInt(button.getAttribute('data-id'));
            addToCart(itemId, currentQuantity);
            quantityElement.textContent = 0;
            updateAddToCartButton(itemElement);
        });
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('increment-btn')) {
            const itemElement = event.target.closest('.item');
            const quantityElement = itemElement.querySelector('.quantity');
            const currentQuantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = currentQuantity + 1;
            updateAddToCartButton(itemElement);
        } else if (event.target.classList.contains('decrement-btn')) {
            const itemElement = event.target.closest('.item');
            const quantityElement = itemElement.querySelector('.quantity');
            const currentQuantity = parseInt(quantityElement.textContent);
            if (currentQuantity > 0) {
                quantityElement.textContent = currentQuantity - 1;
                updateAddToCartButton(itemElement);
            } else {
                quantityElement.textContent = 0;
                updateAddToCartButton(itemElement, 0);
            }
        }
    });
    document.getElementById('sort-select').addEventListener('change', function() {
        const sortBy = this.value;
        if (sortBy === 'lowest') {
            items.sort((a, b) => a.price - b.price);
        } else if (sortBy === 'highest') {
            items.sort((a, b) => b.price - a.price);
        }
        fillItemsGrid();
    });
});

function removeFromCart(itemId) {
    const index = cart.findIndex(item => item.id === itemId);
    if (index !== -1) {
        cart.splice(index, 1);
        updateCart();
    }
}

buyButton.addEventListener('click', () => {
    const totalItemsPrice = parseFloat(cartTotal.textContent.slice(1));
    const purchaseMessage = document.querySelector('.purchase-message');
    const emptyCartMessage = document.querySelector('.empty-cart-message');
    const insufficientFundsMessage = document.querySelector('.insufficient-funds-message');
    
    if (totalItemsPrice === 0) {
        emptyCartMessage.style.display = 'block';
        purchaseMessage.style.display = 'none';
        insufficientFundsMessage.style.display = 'none';
        return;
    }
    
    if (walletAmount >= totalItemsPrice) {
        walletAmount -= totalItemsPrice;
        cart = [];
        updateCart();
        updateWalletAmount();
        
        purchaseMessage.style.display = 'block';
        insufficientFundsMessage.style.display = 'none';
        emptyCartMessage.style.display = 'none';
    } else {
        insufficientFundsMessage.style.display = 'block';
        purchaseMessage.style.display = 'none';
        emptyCartMessage.style.display = 'none';
    }
});


const searchInput = document.getElementById('search-input');
searchInput.addEventListener('input', () => {
    const searchText = searchInput.value.trim().toLowerCase();
    const filteredItems = items.filter(item => item.name.toLowerCase().startsWith(searchText));
    renderFilteredItems(filteredItems);
});



function renderFilteredItems(filteredItems) {
    itemsGrid.innerHTML = '';
    for (const item of filteredItems) {
        let itemElement = document.createElement('div');
        itemElement.classList.add('item');
        itemElement.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.name}">
            <h2>${item.name}</h2>
            <p>$${item.price}</p>
            <button class="add-to-cart-btn" data-id="${item.id}">Add to cart (0)</button>
            <div class="quantity-controls">
                <button class="decrement-btn">-</button>
                <span class="quantity">0</span>
                <button class="increment-btn">+</button>
            </div>
        `;
        itemsGrid.appendChild(itemElement);
    }
    addListenersToCartButtons(); 
}


// Adding the .show-modal class to an element will make it visible
// because it has the CSS property display: block; (which overrides display: none;)
// See the CSS file for more details.
function toggleModal() {
  modal.classList.toggle('show-modal');
}

// Call fillItemsGrid function when page loads
fillItemsGrid();

// Example of DOM methods for adding event handling
cartButton.addEventListener('click', toggleModal);
modalClose.addEventListener('click', toggleModal);