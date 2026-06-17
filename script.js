// ==========================================================================
//   SAFFRON & SPICE — Interactive JavaScript controller
// ==========================================================================

/* ---- MENU DATASET ---- */
const menuData = [
  {
    id: 1,
    name: "Vegetable Samosa",
    price: 6.50,
    category: "appetizers",
    spicy: 1,
    desc: "Crispy golden pastry pockets filled with spiced potato and green peas, served with sweet tamarind chutney.",
    image: "assets/saffron_specialties_hero.png",
    badge: "Traditional"
  },
  {
    id: 2,
    name: "Saffron Paneer Tikka",
    price: 9.95,
    category: "appetizers",
    spicy: 1,
    desc: "Cottage cheese cubes marinated in rich saffron yoghurt and charred in the hot clay tandoor oven.",
    image: "assets/indian_restaurant_interior.png",
    badge: "Popular"
  },
  {
    id: 3,
    name: "Tandoori Murgh Platter",
    price: 18.95,
    category: "tandoor",
    spicy: 2,
    desc: "A sizzling combination of clay oven grilled chicken tikka, seekh kebab, and king prawns with lemon juice.",
    image: "assets/tandoori_platter.png",
    badge: "Signature"
  },
  {
    id: 4,
    name: "Classic Butter Chicken",
    price: 16.50,
    category: "tandoor",
    spicy: 1,
    desc: "Tandoori chicken tikka simmered in a velvety tomato, cream, and butter sauce infused with dry fenugreek.",
    image: "assets/saffron_specialties_hero.png"
  },
  {
    id: 5,
    name: "Awadhi Lamb Biryani",
    price: 19.95,
    category: "specials",
    spicy: 2,
    desc: "Fragrant aged basmati rice layered with tender lamb, saffron, and aromatic spices cooked under slow dum.",
    image: "assets/saffron_specialties_hero.png",
    badge: "Chef Special"
  },
  {
    id: 6,
    name: "Royal Saffron Korma",
    price: 17.50,
    category: "specials",
    spicy: 1,
    desc: "Tender chunks of beef cooked in a rich, mild almond, cashew nut, and saffron cream sauce.",
    image: "assets/indian_restaurant_interior.png"
  },
  {
    id: 7,
    name: "Garlic & Coriander Naan",
    price: 3.50,
    category: "breads",
    spicy: 0,
    desc: "Fresh leavened flatbread baked on the clay tandoor wall, brushed generously with garlic butter.",
    image: "assets/tandoori_platter.png"
  },
  {
    id: 8,
    name: "Peshwari Naan",
    price: 4.25,
    category: "breads",
    spicy: 0,
    desc: "Sweet tandoori naan stuffed with crushed coconut, almonds, sultanas, and glazed with pure ghee.",
    image: "assets/saffron_specialties_hero.png"
  },
  {
    id: 9,
    name: "Mango Lassi",
    price: 4.50,
    category: "drinks",
    spicy: 0,
    desc: "Traditional sweet yoghurt smoothie blended with fresh Alphonso mango pulp and green cardamom.",
    image: "assets/indian_restaurant_interior.png"
  },
  {
    id: 10,
    name: "Royal Saffron Tea",
    price: 3.95,
    category: "drinks",
    spicy: 0,
    desc: "Fragrant spiced masala chai infused with authentic saffron threads and hot sweetened milk.",
    image: "assets/saffron_specialties_hero.png"
  }
];

/* ---- DOM STATE ---- */
let cart = [];

/* ---- NAV SCROLL & HAMBURGER ---- */
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 60) navbar.classList.add('scrolled');
  else navbar.classList.remove('scrolled');
});

const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');
hamburger.addEventListener('click', () => navLinks.classList.toggle('open'));
navLinks.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => navLinks.classList.remove('open'));
});

/* ---- INTERACTIVE MENU RENDER ---- */
const menuGrid = document.getElementById('menuGrid');
const tabButtons = document.querySelectorAll('.menu-tab');

function renderMenu(category = 'all') {
  if (!menuGrid) return;
  menuGrid.innerHTML = '';
  
  const filteredDishes = category === 'all' 
    ? menuData 
    : menuData.filter(item => item.category === category);
    
  filteredDishes.forEach(dish => {
    // Generate spicy level
    let spicyIndicator = '';
    if (dish.spicy > 0) {
      spicyIndicator = `<span class="menu-item-spicy" title="Spice level: ${dish.spicy}">${'🌶️'.repeat(dish.spicy)}</span>`;
    }
    
    // Check badge
    const badgeHTML = dish.badge ? `<div class="menu-item-badge">${dish.badge}</div>` : '';
    
    const card = document.createElement('div');
    card.className = 'menu-item-card fade-in-up';
    card.innerHTML = `
      <div class="menu-item-img-container">
        <img src="${dish.image}" alt="${dish.name}" class="menu-item-img" loading="lazy" />
        ${badgeHTML}
      </div>
      <div class="menu-item-body">
        <div class="menu-item-meta">
          <h4 class="menu-item-title">${dish.name} ${spicyIndicator}</h4>
          <span class="menu-item-price">€${dish.price.toFixed(2)}</span>
        </div>
        <p class="menu-item-desc">${dish.desc}</p>
        <div class="menu-item-footer">
          <button class="btn btn-outline btn-full" onclick="addToCart(${dish.id})">Add to Order</button>
        </div>
      </div>
    `;
    menuGrid.appendChild(card);
    
    // Instantly apply observer
    setTimeout(() => card.classList.add('visible'), 50);
  });
}

// Attach filter listeners
tabButtons.forEach(btn => {
  btn.addEventListener('click', (e) => {
    tabButtons.forEach(b => b.classList.remove('active'));
    e.target.classList.add('active');
    const category = e.target.getAttribute('data-category');
    renderMenu(category);
  });
});

// Initial Menu load
renderMenu('all');

/* ---- SHOPPING CART STATE MANAGEMENT ---- */
const cartDrawer = document.getElementById('cartDrawer');
const cartOverlay = document.getElementById('cartOverlay');
const cartItemsContainer = document.getElementById('cartItems');
const cartTotalElement = document.getElementById('cartTotal');
const cartCountElement = document.getElementById('cartCount');
const checkoutBtn = document.getElementById('checkoutBtn');
const navCartBtn = document.getElementById('navCartBtn');
const cartCloseBtn = document.getElementById('cartCloseBtn');

function openCart() {
  cartDrawer.classList.add('open');
  cartOverlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeCart() {
  cartDrawer.classList.remove('open');
  cartOverlay.classList.remove('open');
  document.body.style.overflow = '';
}

if (navCartBtn) navCartBtn.addEventListener('click', openCart);
if (cartCloseBtn) cartCloseBtn.addEventListener('click', closeCart);
if (cartOverlay) cartOverlay.addEventListener('click', closeCart);

window.openCart = openCart;
window.closeCart = closeCart;

window.addToCart = function(id) {
  const product = menuData.find(item => item.id === id);
  if (!product) return;
  
  const existingItem = cart.find(item => item.product.id === id);
  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push({ product, quantity: 1 });
  }
  
  // Bounce animation on nav cart badge
  if (cartCountElement) {
    cartCountElement.classList.add('bounce');
    setTimeout(() => cartCountElement.classList.remove('bounce'), 300);
  }
  
  updateCart();
  openCart();
};

window.changeQty = function(id, amount) {
  const item = cart.find(item => item.product.id === id);
  if (!item) return;
  
  item.quantity += amount;
  if (item.quantity <= 0) {
    cart = cart.filter(item => item.product.id !== id);
  }
  updateCart();
};

window.deleteCartItem = function(id) {
  cart = cart.filter(item => item.product.id !== id);
  updateCart();
};

function updateCart() {
  if (!cartItemsContainer || !cartTotalElement || !cartCountElement || !checkoutBtn) return;
  
  cartItemsContainer.innerHTML = '';
  
  if (cart.length === 0) {
    cartItemsContainer.innerHTML = `
      <div class="cart-empty-state">
        <div class="cart-empty-icon">🍲</div>
        <h4>Your basket is empty</h4>
        <p>Browse our menu and select delicacies to start order.</p>
      </div>
    `;
    cartTotalElement.textContent = "€0.00";
    cartCountElement.textContent = "0";
    checkoutBtn.disabled = true;
    return;
  }
  
  let total = 0;
  let itemsCount = 0;
  
  cart.forEach(item => {
    const itemTotal = item.product.price * item.quantity;
    total += itemTotal;
    itemsCount += item.quantity;
    
    const itemRow = document.createElement('div');
    itemRow.className = 'cart-item';
    itemRow.innerHTML = `
      <div class="cart-item-info">
        <div class="cart-item-title">${item.product.name}</div>
        <div class="cart-item-price">€${item.product.price.toFixed(2)}</div>
      </div>
      <div class="cart-qty-control">
        <button class="cart-qty-btn" onclick="changeQty(${item.product.id}, -1)">-</button>
        <span class="cart-qty-num">${item.quantity}</span>
        <button class="cart-qty-btn" onclick="changeQty(${item.product.id}, 1)">+</button>
      </div>
      <button class="cart-item-delete" onclick="deleteCartItem(${item.product.id})" aria-label="Remove item">✕</button>
    `;
    cartItemsContainer.appendChild(itemRow);
  });
  
  cartTotalElement.textContent = `€${total.toFixed(2)}`;
  cartCountElement.textContent = itemsCount;
  checkoutBtn.disabled = false;
}

/* ---- SIMULATED CHECKOUT ---- */
const checkoutSuccessDialog = document.getElementById('checkoutSuccessDialog');

if (checkoutBtn) {
  checkoutBtn.addEventListener('click', () => {
    closeCart();
    cart = [];
    updateCart();
    if (checkoutSuccessDialog) {
      checkoutSuccessDialog.showModal();
    }
  });
}

window.closeCheckoutSuccess = function() {
  if (checkoutSuccessDialog) {
    checkoutSuccessDialog.close();
  }
};

/* ---- RESERVATIONS (BOOKING) DIALOG ---- */
const bookingDialog = document.getElementById('bookingDialog');
const bookingForm = document.getElementById('bookingForm');
const bookingSuccessPanel = document.getElementById('bookingSuccess');
const dateInput = document.getElementById('date');

if (dateInput) {
  // Prevent selecting past dates
  dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
}

window.openBooking = function() {
  if (bookingDialog) {
    // Reset form display
    if (bookingForm) bookingForm.style.display = 'flex';
    if (bookingSuccessPanel) bookingSuccessPanel.style.display = 'none';
    bookingDialog.showModal();
  }
};

window.closeBooking = function() {
  if (bookingDialog) {
    bookingDialog.close();
  }
};

// Handle Click-Outside (Light Dismiss) for native dialogs
const dialogs = [bookingDialog, checkoutSuccessDialog];
dialogs.forEach(dialog => {
  if (!dialog) return;
  dialog.addEventListener('click', (e) => {
    const rect = dialog.getBoundingClientRect();
    const isOutside = (
      e.clientX < rect.left ||
      e.clientX > rect.right ||
      e.clientY < rect.top ||
      e.clientY > rect.bottom
    );
    if (isOutside) {
      dialog.close();
    }
  });
});

if (bookingForm) {
  bookingForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const submitBtn = bookingForm.querySelector('button[type="submit"]');
    const oldText = submitBtn.textContent;
    submitBtn.textContent = 'Processing...';
    submitBtn.disabled = true;
    
    // Simulate API request delay
    setTimeout(() => {
      submitBtn.textContent = oldText;
      submitBtn.disabled = false;
      bookingForm.reset();
      bookingForm.style.display = 'none';
      if (bookingSuccessPanel) {
        bookingSuccessPanel.style.display = 'flex';
      }
    }, 1000);
  });
}

/* ---- SCROLL-REVEAL OBSERVER ---- */
const fadeElements = document.querySelectorAll('.about-feature-card, .cd-item, .map-container');
fadeElements.forEach(el => el.classList.add('fade-in-up'));

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry, idx) => {
    if (entry.isIntersecting) {
      setTimeout(() => {
        entry.target.classList.add('visible');
      }, idx * 80);
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

fadeElements.forEach(el => revealObserver.observe(el));

/* ---- SMOOTH SCROLLING FOR LINKS ---- */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function(e) {
    const targetId = this.getAttribute('href');
    if (targetId === "#") return;
    const target = document.querySelector(targetId);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
