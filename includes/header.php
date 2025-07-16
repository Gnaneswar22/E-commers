<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

// Get cart count if logged in
$cartCount = 0;
if ($isLoggedIn && isset($_SESSION['user_id'])) {
    // Connect to database if not already connected
    if (!isset($conn)) {
        require_once 'admin/config.php';
    }
    
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cartCount = $row['count'];
}
?>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <p>Sale is Live. <span>Up to 40% off</span></p>
    </div>
</div>

<!-- Header -->
<header>
    <div class="container">
        <div class="header-main">
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            
            <div class="logo">
                <a href="index.php">MENWEAR</a>
            </div>
            
            <div class="header-icons">
                <a href="#" id="search-icon"><i class="fas fa-search"></i></a>
                <a href="#" class="cart-icon" id="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo $cartCount; ?></span>
                </a>
                <a href="#" id="user-icon">
                    <i class="fas <?php echo $isLoggedIn ? 'fa-user-check' : 'fa-user'; ?>"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="nav-container">
        <div class="container">
            <ul class="main-nav">
                <li class="nav-item"><a href="index.php">Home</a></li>
                <li class="nav-item"><a href="new_arrivals.php">New Arrivals</a></li>
                <li class="nav-item">
                    <a href="category.php?cat=Shirts">Shirts</a>
                    <div class="dropdown-content">
                        <a href="category.php?cat=Shirts&subcat=Formal%20Shirts">Formal Shirts</a>
                        <a href="category.php?cat=Shirts&subcat=Casual%20Shirts">Casual Shirts</a>
                        <a href="category.php?cat=Shirts&subcat=Linen%20Shirts">Linen Shirts</a>
                        <a href="category.php?cat=Shirts&subcat=Oxford%20Shirts">Oxford Shirts</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="category.php?cat=T-Shirts">T-Shirts</a>
                    <div class="dropdown-content">
                        <a href="category.php?cat=T-Shirts&subcat=Polo%20T-Shirts">Polo T-Shirts</a>
                        <a href="category.php?cat=T-Shirts&subcat=Crew%20Neck">Crew Neck</a>
                        <a href="category.php?cat=T-Shirts&subcat=Henley">Henley</a>
                        <a href="category.php?cat=T-Shirts&subcat=Graphic%20Tees">Graphic Tees</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="category.php?cat=Trousers">Trousers</a>
                    <div class="dropdown-content">
                        <a href="category.php?cat=Trousers&subcat=Chinos">Chinos</a>
                        <a href="category.php?cat=Trousers&subcat=Formal%20Trousers">Formal Trousers</a>
                        <a href="category.php?cat=Trousers&subcat=Shorts">Shorts</a>
                    </div>
                </li>
                <li class="nav-item"><a href="category.php?cat=Jeans">Jeans</a></li>
                <li class="nav-item"><a href="sale.php">Sale</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login / Register</h2>
        <div id="phone-input-section">
            <p>Enter your phone number to continue</p>
            <div class="form-group">
                <input type="tel" id="phone" placeholder="Phone Number (10 digits)" maxlength="10">
                <button id="sendOtpBtn" class="btn">Send OTP</button>
            </div>
        </div>
        
        <div id="otp-input-section" style="display:none;">
            <p>Enter the OTP sent to your phone</p>
            <div class="form-group">
                <input type="text" id="otp" placeholder="Enter OTP" maxlength="6">
                <div id="otp-timer">OTP expires in <span id="timer">05:00</span></div>
                <button id="verifyOtpBtn" class="btn">Verify OTP</button>
                <button id="resendOtpBtn" class="btn btn-outline" disabled>Resend OTP</button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h3>Your Cart</h3>
        <span class="close-cart">&times;</span>
    </div>
    <div id="cartItems" class="cart-items">
        <!-- Cart items will be loaded here -->
        <div class="empty-message">Your cart is empty</div>
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total:</span>
            <span id="cartTotal">₹0.00</span>
        </div>
        <button id="checkoutBtn" class="btn">Checkout</button>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="modal">
    <div class="modal-content search-modal-content">
        <span class="close">&times;</span>
        <h2>Search Products</h2>
        <div class="search-form-header">
            <input type="text" id="searchInput" class="search-input" placeholder="Search for products...">
            <button id="searchBtn" class="search-btn">Search</button>
        </div>
        <div id="searchResults" class="search-results">
            <!-- Search results will be loaded here -->
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="overlay" class="overlay"></div>