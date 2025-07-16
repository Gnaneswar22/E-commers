<?php
// Include database connection
require_once 'admin/config.php';

// Get category from URL parameter
$category = isset($_GET['category']) ? $_GET['category'] : 'new-arrivals';
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';

// Get category information
$category_query = "SELECT * FROM categories WHERE slug = '$category'";
$category_result = $conn->query($category_query);
$category_data = $category_result->fetch_assoc();

// Get products
if ($subcategory) {
    $products_query = "SELECT * FROM products WHERE category_slug = '$category' AND subcategory_slug = '$subcategory' LIMIT 50";
} else {
    $products_query = "SELECT * FROM products WHERE category_slug = '$category' LIMIT 50";
}
$products_result = $conn->query($products_query);

// Get navigation structure
$nav_query = "SELECT * FROM categories ORDER BY display_order";
$nav_result = $conn->query($nav_query);

// Get subcategories
$subnav_query = "SELECT * FROM subcategories ORDER BY category_id, display_order";
$subnav_result = $conn->query($subnav_query);

// Build navigation array
$navigation = array();
while ($category = $nav_result->fetch_assoc()) {
    $category_id = $category['id'];
    $navigation[$category_id] = $category;
    $navigation[$category_id]['subcategories'] = array();
}

// Add subcategories to navigation array
while ($subcategory = $subnav_result->fetch_assoc()) {
    $category_id = $subcategory['category_id'];
    if (isset($navigation[$category_id])) {
        $navigation[$category_id]['subcategories'][] = $subcategory;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_data['name']; ?> | MENWEAR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
        }

        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Top Bar */
        .top-bar {
            background-color: #f5f5f5;
            padding: 8px 0;
            font-size: 12px;
            text-align: center;
        }

        .top-bar p {
            margin: 0;
        }

        .top-bar span {
            font-weight: 600;
        }

        /* Header Styles */
        header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .logo a {
            color: #000;
        }

        /* Navigation */
        .nav-container {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .main-nav {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 15px 0;
        }

        .main-nav li {
            position: relative;
            margin: 0 20px;
        }

        .main-nav li a {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }

        .main-nav li a:hover {
            color: #b18b5f;
        }

        /* Dropdown */
        .dropdown-content {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1;
            padding: 15px 0;
        }

        .nav-item:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-content a {
            padding: 10px 20px;
            display: block;
            color: #333;
            font-size: 13px;
            text-transform: none;
        }

        .dropdown-content a:hover {
            background-color: #f9f9f9;
        }

        /* Header Icons */
        .header-icons {
            display: flex;
            align-items: center;
        }

        .header-icons a {
            margin-left: 20px;
            color: #333;
            font-size: 18px;
            cursor: pointer;
        }

        .header-icons a:hover {
            color: #b18b5f;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #b18b5f;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Profile Dropdown */
        .profile-container {
            position: relative;
            margin-left: 20px;
        }

        .profile-dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            width: 280px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }

        .profile-header {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            background-color: #f9f9f9;
            position: relative;
        }

        .profile-image {
            position: relative;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 10px;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .edit-profile-image {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(0,0,0,0.5);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }

        .edit-profile-image input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .profile-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-header p {
            color: #777;
            font-size: 14px;
            margin-top: 5px;
        }

        .edit-name-btn {
            margin-left: 8px;
            font-size: 14px;
            color: #b18b5f;
            cursor: pointer;
        }

        .profile-menu {
            padding: 15px 0;
        }

        .profile-menu h4 {
            padding: 0 20px;
            margin: 0 0 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .profile-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .profile-menu li {
            margin-bottom: 5px;
        }

        .profile-menu li a {
            display: flex;
            padding: 12px 20px;
            color: #333;
            font-size: 14px;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.3s ease;
        }

        .profile-menu li a:hover {
            background-color: #f9f9f9;
        }

        .profile-menu li a i:first-child {
            margin-right: 10px;
            width: 20px;
            color: #666;
        }

        .profile-menu li a:hover i {
            color: #b18b5f;
        }

        .profile-menu li a i:last-child {
            color: #b18b5f;
        }

        .logout-btn {
            padding: 15px 20px;
            margin-top: 10px;
            border-top: 1px solid #eee;
        }

        .logout-btn a {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #f5f5f5;
            color: #333;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .logout-btn a:hover {
            background-color: #e0e0e0;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 400px;
            background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.3);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            font-weight: 300;
        }

        .btn {
            display: inline-block;
            background-color: #b18b5f;
            color: white;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #9a7445;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid white;
        }

        .btn-outline:hover {
            background-color: white;
            color: #333;
        }

        /* Categories Section */
        .categories {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
            display: inline-block;
        }

        .section-title h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background-color: #b18b5f;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .category-card {
            position: relative;
            overflow: hidden;
            height: 400px;
            border-radius: 4px;
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover img {
            transform: scale(1.05);
        }

        .category-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
            text-align: center;
        }

        .category-content h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .shop-link {
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: white;
            position: relative;
            padding-bottom: 5px;
            display: inline-block;
        }

        .shop-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: white;
            transition: width 0.3s ease;
        }

        .shop-link:hover:after {
            width: 0;
        }

        /* Featured Products */
        .featured-products {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .product-image {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #b18b5f;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .product-actions {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            transition: bottom 0.3s ease;
        }

        .product-card:hover .product-actions {
            bottom: 20px;
        }

        .product-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-action-btn:hover {
            background-color: #b18b5f;
            color: white;
        }

        .product-info {
            padding: 20px;
            text-align: center;
        }

        .product-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 18px;
            color: #b18b5f;
            font-weight: 600;
        }

        /* Collection Banner */
        .collection-banner {
            padding: 100px 0;
            background-color: #f0f0f0;
            text-align: center;
            background-image: url('https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
        }

        .collection-banner:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .collection-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .collection-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .collection-content p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* USP Section */
        .usp-section {
            padding: 60px 0;
            background-color: #fff;
        }

        .usp-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }

        .usp-card {
            text-align: center;
            padding: 10px;
        }

        .usp-icon {
            font-size: 2.5rem;
            color: #b18b5f;
            margin-bottom: 20px;
        }

        .usp-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .usp-text {
            font-size: 14px;
            color: #777;
        }

        /* Newsletter */
        .newsletter {
            padding: 80px 0;
            background-color: #f9f9f9;
            text-align: center;
        }

        .newsletter-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .newsletter h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .newsletter p {
            margin-bottom: 30px;
            color: #777;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-right: none;
            font-size: 14px;
            outline: none;
        }

        .newsletter-btn {
            padding: 15px 30px;
            background-color: #b18b5f;
            color: white;
            border: none;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter-btn:hover {
            background-color: #9a7445;
        }

        /* Footer */
        footer {
            background-color: #222;
            color: #fff;
            padding: 80px 0 0;
        }

        .footer-top {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }

        .footer-column h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-column h4:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: #b18b5f;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #aaa;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #b18b5f;
        }

        .footer-contact p {
            color: #aaa;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .social-links {
            display: flex;
            margin-top: 20px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #333;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .social-links a:hover {
            background-color: #b18b5f;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
            color: #aaa;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 4px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .search-modal-content {
            max-width: 800px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        #otp-timer {
            margin-bottom: 15px;
            color: #666;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 100%;
            max-width: 400px;
            height: 100%;
            background-color: #fff;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 1001;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-cart {
            font-size: 24px;
            cursor: pointer;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: #b18b5f;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            background-color: #f5f5f5;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }

        .cart-item-remove {
            color: #ff6b6b;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .cart-footer {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 18px;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        /* Search Results */
        .search-results {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .search-item {
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-item-image {
            height: 200px;
            overflow: hidden;
        }

        .search-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .search-item-details {
            padding: 15px;
        }

        .search-item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .search-item-price {
            color: #b18b5f;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        /* Search Form Header */
        .search-form-header {
            display: flex;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-right: none;
            font-size: 16px;
            outline: none;
        }

        .search-btn {
            padding: 12px 20px;
            background-color: #b18b5f;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #9a7445;
        }

        /* Edit Profile Modal */
        .edit-profile-modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .edit-profile-container {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 4px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .edit-profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-profile-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .edit-profile-form .form-group {
            margin-bottom: 20px;
        }

        .edit-profile-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .edit-profile-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .edit-profile-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .cancel-btn {
            background-color: #f5f5f5;
            color: #333;
        }

        /* Name Edit Modal */
        .name-edit-modal {
            display: none;
            position: fixed;
            z-index: 1002;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .name-edit-container {
            background-color: #fff;
            margin: 15% auto;
            padding: 30px;
            border-radius: 4px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .name-edit-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .name-edit-header h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .name-edit-form .form-group {
            margin-bottom: 20px;
        }

        .name-edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .name-edit-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .name-edit-actions {
            display: flex;
            justify-content: space-between;
        }

        /* Profile Details Modal */
        .profile-details-modal {
            display: none;
            position: fixed;
            z-index: 1002;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .profile-details-container {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 4px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .profile-details-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-details-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .profile-details-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .profile-info-group {
            margin-bottom: 20px;
        }

        .profile-info-group h4 {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }

        .profile-info-group p {
            font-size: 16px;
            font-weight: 500;
        }

        .profile-info-actions {
            grid-column: 1 / -1;
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        /* Profile Creation Modal */
        .profile-creation-section {
            display: none;
            padding: 20px 0;
        }

        .profile-creation-section h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .gender-selection {
            margin: 15px 0;
        }
        
        .gender-selection label {
            margin-right: 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .gender-selection label input {
            margin-right: 5px;
            width: auto;
        }
        
        .dob-inputs {
            display: flex;
            gap: 10px;
        }
        
        .dob-inputs select {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .usp-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-top {
                grid-template-columns: repeat(2, 1fr);
            }

            .search-results {
                grid-template-columns: repeat(2, 1fr);
            }

            .profile-details-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .nav-container {
                display: none;
            }
            
            .main-nav {
                flex-direction: column;
                align-items: center;
            }
            
            .main-nav li {
                margin: 10px 0;
            }
            
            .dropdown-content {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            
            .nav-item.active .dropdown-content {
                max-height: 500px;
                padding: 10px 0;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .product-grid {
                grid-template-columns: repeat(1, 1fr);
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-input {
                border-right: 1px solid #ddd;
                border-bottom: none;
                margin-bottom: 10px;
            }

            .search-results {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .category-grid {
                grid-template-columns: 1fr;
            }
            
            .usp-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-top {
                grid-template-columns: 1fr;
            }

            .dob-inputs {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <p>Sale is Live. <span>Welcome!</span></p>
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
                        <span class="cart-count">0</span>
                    </a>
                    <div class="profile-container">
                        <a href="#" id="user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                        <!-- Profile dropdown content would go here -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nav-container">
            <div class="container">
                <ul class="main-nav">
                    <?php foreach ($navigation as $nav_item): ?>
                    <li class="nav-item">
                        <a href="category.php?category=<?php echo $nav_item['slug']; ?>"><?php echo $nav_item['name']; ?></a>
                        
                        <?php if (!empty($nav_item['subcategories'])): ?>
                        <div class="dropdown-content">
                            <?php foreach ($nav_item['subcategories'] as $subnav_item): ?>
                            <a href="category.php?category=<?php echo $nav_item['slug']; ?>&subcategory=<?php echo $subnav_item['slug']; ?>"><?php echo $subnav_item['name']; ?></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </header>

    <!-- Category Header -->
    <section class="category-header">
        <div class="container">
            <h1><?php echo $category_data['name']; ?></h1>
            <p><?php echo $category_data['description']; ?></p>
        </div>
    </section>

    <!-- Product Listing -->
    <section class="product-listing">
        <div class="container">
            <div class="product-grid">
                <?php while ($product = $products_result->fetch_assoc()): ?>
                <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                    <div class="product-image">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        
                        <?php if ($product['is_new']): ?>
                        <span class="product-badge">New</span>
                        <?php elseif ($product['is_sale']): ?>
                        <span class="product-badge">Sale</span>
                        <?php endif; ?>
                        
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(<?php echo $product['id']; ?>)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(<?php echo $product['id']; ?>)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(<?php echo $product['id']; ?>)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo $product['name']; ?></h3>
                        <p class="product-price">₹<?php echo number_format($product['price']); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-column">
                    <h4>Shop</h4>
                    <ul class="footer-links">
                        <li><a href="category.php?category=new-arrivals">New Arrivals</a></li>
                        <li><a href="category.php?category=shirts">Shirts</a></li>
                        <li><a href="category.php?category=t-shirts">T-Shirts</a></li>
                        <li><a href="category.php?category=trousers">Trousers</a></li>
                        <li><a href="category.php?category=jeans">Jeans</a></li>
                        <li><a href="category.php?category=sale">Sale</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Collections</h4>
                    <ul class="footer-links">
                        <li><a href="category.php?category=collections&subcategory=summer-layering">Summer Layering</a></li>
                        <li><a href="category.php?category=collections&subcategory=resort-wear">Resort Wear</a></li>
                        <li><a href="category.php?category=collections&subcategory=workwear">Workwear</a></li>
                        <li><a href="category.php?category=collections&subcategory=travel-fashion">Travel & Fashion</a></li>
                        <li><a href="category.php?category=collections&subcategory=oxford-classics">Classic Oxfords</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Information</h4>
                    <ul class="footer-links">
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="sustainability.php">Sustainability</a></li>
                        <li><a href="size-guide.php">Size Guide</a></li>
                        <li><a href="careers.php">Careers</a></li>
                        <li><a href="terms.php">Terms & Conditions</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Contact Us</h4>
                    <div class="footer-contact">
                        <p><i class="fas fa-map-marker-alt"></i> 123 Fashion Street, Mumbai, India</p>
                        <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                        <p><i class="fas fa-envelope"></i> support@menwear.com</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 MENWEAR. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Include all the modals, cart sidebar, etc. from your original HTML -->

    <script src="script.js"></script>
</body>
</html>