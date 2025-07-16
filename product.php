<?php
require_once 'admin/config.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Product not found, redirect to homepage
    header('Location: index.php');
    exit;
}

$product = $result->fetch_assoc();

// Get related products
$category = $product['category'];
$stmt = $conn->prepare("
    SELECT id, name, price, image 
    FROM products 
    WHERE category = ? AND id != ? 
    LIMIT 4
");
$stmt->bind_param("si", $category, $product_id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_products = [];
while ($row = $related_result->fetch_assoc()) {
    $related_products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - MENWEAR</title>
    <!-- Include CSS and other head elements from your main file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'includes/header.php'; ?>

    <!-- Product Details Section -->
    <section class="product-details">
        <div class="container">
            <div class="product-container">
                <div class="product-images">
                    <div class="main-image">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                </div>
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="product-price">₹<?php echo number_format($product['price'], 2); ?></p>
                    <div class="product-description">
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>
                    <div class="product-meta">
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                        <p><strong>Subcategory:</strong> <?php echo htmlspecialchars($product['subcategory']); ?></p>
                        <p><strong>Availability:</strong> <?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?></p>
                    </div>
                    <div class="product-actions">
                        <div class="quantity-selector">
                            <button class="quantity-btn minus">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                            <button class="quantity-btn plus">+</button>
                        </div>
                        <button class="btn add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>, document.getElementById('quantity').value)">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <?php if (count($related_products) > 0): ?>
            <div class="related-products">
                <h2>You May Also Like</h2>
                <div class="product-grid">
                    <?php foreach ($related_products as $related): ?>
                    <div class="product-card" data-product-id="<?php echo $related['id']; ?>">
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($related['image']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>">
                            <div class="product-actions">
                                <div class="product-action-btn" onclick="addToWishlist(<?php echo $related['id']; ?>)">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="product-action-btn" onclick="addToCart(<?php echo $related['id']; ?>)">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="product-action-btn" onclick="location.href='product.php?id=<?php echo $related['id']; ?>'">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo htmlspecialchars($related['name']); ?></h3>
                            <p class="product-price">₹<?php echo number_format($related['price'], 2); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Include footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Include all JS scripts -->
    <script src="js/main.js"></script>
    <script>
        // Quantity selector functionality
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const quantityInput = document.getElementById('quantity');
            const maxStock = <?php echo $product['stock']; ?>;

            minusBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            plusBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value < maxStock) {
                    quantityInput.value = value + 1;
                }
            });

            quantityInput.addEventListener('change', function() {
                let value = parseInt(this.value);
                if (isNaN(value) || value < 1) {
                    this.value = 1;
                } else if (value > maxStock) {
                    this.value = maxStock;
                }
            });
        });
    </script>
</body>
</html>