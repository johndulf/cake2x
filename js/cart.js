    function toggleNavbar() {
              var navbar = document.getElementById('navbar');
              var accountDropdown = document.getElementById('accountDropdown');

              if (navbar.classList.contains('active')) {
                navbar.style.display = 'none';
                navbar.classList.remove('active');
                if (accountDropdown) {
                  accountDropdown.style.display = 'none';
                }
              } else {
                navbar.style.display = 'block';
                navbar.classList.add('active');
                if (accountDropdown) {
                  accountDropdown.style.display = 'block';
                }
              }
            }

            function toggleSearchInput() {
              var searchInput = document.getElementById('searchInput');
              var searchInputStyle = window.getComputedStyle(searchInput);

              if (searchInputStyle.display === 'none') {
                searchInput.style.display = 'block';
              } else {
                searchInput.style.display = 'none';
              }
            }
// var cartItems = [
//   { name: 'Item 1', price: { small: 10.99, medium: 12.99, large: 14.99 }, quantity: 2, size: 'medium', image: 'images/b1.jpg' },
//   { name: 'Item 2', price: { small: 5.99, medium: 7.99, large: 9.99 }, quantity: 1, size: 'small', image: 'images/b2.jpg' },
//   { name: 'Item 3', price: { small: 8.99, medium: 10.99, large: 12.99 }, quantity: 3, size: 'large', image: 'images/b3.jpg' }
// ];

function showCart() {
  var cartPanel = document.getElementById('cartPanel');
  cartPanel.style.display = 'block';

  var cartItemsList = document.getElementById('cartItemsList');
  cartItemsList.innerHTML = '';

  cartItems.forEach(function(item) {
    var cartItem = document.createElement('li');

    var itemImage = document.createElement('img');
    itemImage.src = item.image;
    itemImage.style.height = '75px';
    itemImage.style.width = '75px';

    var itemName = document.createElement('span');
    itemName.textContent = item.name;
    itemName.style.fontWeight = 'bold';
    itemName.style.fontSize = '16px';

    var itemQuantity = document.createElement('span');
    itemQuantity.textContent = item.quantity;
    itemQuantity.style.fontWeight = 'bold';
    itemQuantity.style.fontSize = '16px';

    var itemSize = document.createElement('span');
    itemSize.textContent = item.size;
    itemSize.style.fontSize = '14px';

    var itemPrice = document.createElement('span');
    itemPrice.textContent = '₱' + item.price[item.size].toFixed(2);
    itemPrice.style.fontSize = '14px';

    var itemTotalPrice = document.createElement('span');
    var totalPrice = item.price[item.size] * item.quantity;
    itemTotalPrice.textContent = '₱' + totalPrice.toFixed(2);
    itemTotalPrice.style.fontSize = '14px';

    var sizeSelect = document.createElement('select');
    sizeSelect.className = 'size-select';
    sizeSelect.addEventListener('change', function(event) {
      var selectedSize = event.target.value;
      changeItemSize(item, selectedSize);
    });

    var sizes = Object.keys(item.price);
    sizes.forEach(function(size) {
      var option = document.createElement('option');
      option.value = size;
      option.textContent = size.charAt(0).toUpperCase() + size.slice(1); // Capitalize the first letter
      sizeSelect.appendChild(option);
    });

    sizeSelect.value = item.size;

    var decrementButton = document.createElement('button');
    decrementButton.textContent = '-';
    decrementButton.className = 'quantity-button';
    decrementButton.addEventListener('click', function() {
      decrementItem(item);
    });

    var incrementButton = document.createElement('button');
    incrementButton.textContent = '+';
    incrementButton.className = 'quantity-button';
    incrementButton.addEventListener('click', function() {
      incrementItem(item);
    });

    cartItem.appendChild(itemImage);
    cartItem.appendChild(itemName);
    cartItem.appendChild(sizeSelect);
    cartItem.appendChild(itemPrice);
    cartItem.appendChild(decrementButton);
    cartItem.appendChild(itemQuantity);
    cartItem.appendChild(incrementButton);
    cartItem.appendChild(itemTotalPrice);

    cartItemsList.appendChild(cartItem);
  });

  updateCartTotal(); // Update the cart total when displaying the cart
}

function changeItemSize(item, newSize) {
  item.size = newSize.toLowerCase();
  showCart(); // Re-render the cart to reflect the updated size
}

function hideCart() {
  var cartPanel = document.getElementById('cartPanel');
  cartPanel.style.display = 'none';
}

function addToCart(itemName, itemPrice, itemSize) {
  var existingItem = cartItems.find(function(item) {
    return item.name === itemName && item.size === itemSize.toLowerCase();
  });

  if (existingItem) {
    existingItem.quantity++;
  } else {
    var newItem = {
      name: itemName,
      price: itemPrice,
      size: itemSize.toLowerCase(),
      quantity: 1
    };
    cartItems.push(newItem);
  }

  updateCartTotal(); // Update the cart total when adding an item
}

function decrementItem(item) {
  if (item.quantity > 1) {
    item.quantity--;
    updateCartTotal(); // Update the cart total when decrementing an item
    showCart(); // Re-render the cart to reflect the updated quantity
  }
}

function incrementItem(item) {
  item.quantity++;
  updateCartTotal(); // Update the cart total when incrementing an item
  showCart(); // Re-render the cart to reflect the updated quantity
}

function updateCartTotal() {
  var cartTotalElement = document.getElementById('cartTotal');

  var cartTotal = cartItems.reduce(function(total, item) {
    return total + item.price[item.size] * item.quantity;
  }, 0);

  cartTotalElement.textContent = '$' + cartTotal.toFixed(2);
}

function checkout() {
  // Perform checkout actions here
  console.log('Checkout clicked!');
}
