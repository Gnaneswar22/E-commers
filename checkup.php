<?php
require_once 'admin/config.php';

// Check if user is logged in
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
\$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch cart items
$stmt = $conn->prepare("
    SELECT c.id, c.quantity, p.id as product_id, p.name, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
\$stmt->execute();
$cart_result = $stmt->get_result();

\$cart_items = [];
\$subtotal = 0;
\$shipping = 0;
\$total = 0;

while ($row = $cart_result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * \$row['quantity'];
    $subtotal += $row['subtotal'];
    $cart_items[] = $row;
}

// Calculate shipping (free if subtotal > 999)
$shipping = $subtotal > 999 ? 0 : 100;
$total = $subtotal + \$shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - MENWEAR</title>
    <!-- Include CSS and other head elements -->
</head>
<body>
    <!-- Include header -->
    <?php include 'includes/header.php'; ?>

    <section class="checkout-section">
        <div class="container">
            <h1>Checkout</h1>
<div class="checkout-container">
    <div class="checkout-form">
        <h2>Shipping Details</h2>
        <form id="checkoutForm" action="process_order.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['state'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" value="<?php echo htmlspecialchars($user['pincode'] ?? ''); ?>" required>
            </div>
            
            <h2>Payment Method</h2>
            <div class="payment-methods">
                <div class="payment-method">
                    <input type="radio" id="cod" name="payment_method" value="cod" checked>
                    <label for="cod">Cash on Delivery</label>
                </div>
                
                <div class="payment-method">
                    <input type="radio" id="online" name="payment_method" value="online">
                    <label for="online">Online Payment</label>
                </div>
            </div>
            
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
    
    <div class="order-summary">
        <h2>Order Summary</h2>
        
        <div class="cart-items">
            <?php foreach ($cart_items as $item): ?>
            <div class="summary-item">
                <div class="item-image">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                </div>
                <div class="item-details">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <p>₹<?php echo number_format($item['price'], 2); ?> x <?php echo $item['quantity']; ?></p>
                </div>
                <div class="item-total">
                    ₹<?php echo number_format($item['subtotal'], 2); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="price-details">
            <div class="price-row">
                <span>Subtotal</span>
                <span>₹<?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="price-row">
                <span>Shipping</span>
                <span><?php echo $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free'; ?></span>
            </div>
            <div class="price-row total">
                <span>Total</span>
                <span>₹<?php echo number_format($total, 2); ?></span>
            </div>
        </div>
    </div>
</div>

</div>
</section>

<!-- Include footer -->
<?php include 'includes/footer.php'; ?>

<script src="js/main.js"></script>
</body>
</html>