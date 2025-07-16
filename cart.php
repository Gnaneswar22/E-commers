<?php
require_once 'config.php';

// Check if user is authenticated
function isAuthenticated() {
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = isset($data['action']) ? $data['action'] : '';
    
    // Add to cart
    if ($action == 'add_to_cart') {
        if (!isAuthenticated()) {
            echo json_encode(['success' => false, 'message' => 'Please login to add items to cart', 'require_login' => true]);
            exit;
        }
        
        $product_id = $data['product_id'];
        $quantity = isset($data['quantity']) ? $data['quantity'] : 1;
        $user_id = $_SESSION['user_id'];
        
        // Check if product exists and has stock
        $stmt = $conn->prepare("SELECT id, stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }
        
        $product = $result->fetch_assoc();
        if ($product['stock'] < $quantity) {
            echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
            exit;
        }
        
        // Check if product is already in cart
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update quantity
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            
            if ($new_quantity > $product['stock']) {
                echo json_encode(['success' => false, 'message' => 'Cannot add more items than available in stock']);
                exit;
            }
            
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_quantity, $row['id']);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
            }
        } else {
            // Add new item to cart
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Product added to cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add product to cart']);
            }
        }
    }
    
    // Get cart items with detailed product info
    elseif ($action == 'get_cart') {
        if (!isAuthenticated()) {
            echo json_encode(['success' => false, 'message' => 'Please login to view cart', 'require_login' => true]);
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("
            SELECT c.id, c.quantity, p.id as product_id, p.name, p.price, p.image, p.stock
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $cart_items = [];
        $total = 0;
        
        while ($row = $result->fetch_assoc()) {
            $row['subtotal'] = $row['price'] * $row['quantity'];
            $total += $row['subtotal'];
            $cart_items[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'cart_items' => $cart_items,
            'total' => $total,
            'count' => count($cart_items)
        ]);
    }
    
    // Remove from cart
    elseif ($action == 'remove_from_cart') {
        if (!isAuthenticated()) {
            echo json_encode(['success' => false, 'message' => 'Please login', 'require_login' => true]);
            exit;
        }
        
        $cart_id = $data['cart_id'];
        $user_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart']);
        }
    }
    
    // Update cart quantity with stock check
    elseif ($action == 'update_quantity') {
        if (!isAuthenticated()) {
            echo json_encode(['success' => false, 'message' => 'Please login', 'require_login' => true]);
            exit;
        }
        
        $cart_id = $data['cart_id'];
        $quantity = $data['quantity'];
        $user_id = $_SESSION['user_id'];
        
        if ($quantity <= 0) {
            // Remove item if quantity is 0 or less
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cart_id, $user_id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart']);
            }
        } else {
            // Check stock before updating
            $stmt = $conn->prepare("
                SELECT p.stock, c.product_id
                FROM cart c
                JOIN products p ON c.product_id = p.id
                WHERE c.id = ? AND c.user_id = ?
            ");
            $stmt->bind_param("ii", $cart_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 0) {
                echo json_encode(['success' => false, 'message' => 'Cart item not found']);
                exit;
            }
            
            $product = $result->fetch_assoc();
            if ($product['stock'] < $quantity) {
                echo json_encode(['success' => false, 'message' => 'Not enough stock available. Maximum available: ' . $product['stock']]);
                exit;
            }
            
            // Update quantity
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
            }
        }
    }
}
?>