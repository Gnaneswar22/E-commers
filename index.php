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
    <title>MENWEAR - Premium Men's Clothing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base Styles */
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
                    <a href="#">MENWEAR</a>
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
                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="profile-header">
                                <div class="profile-image">   
                                    <img id="profile-img" src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="User">
                                    <div class="edit-profile-image">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" id="profile-image-input" accept="image/*">
                                    </div>
                                </div>
                                <h3 id="profile-name">Anne Cho <span class="edit-name-btn" id="edit-name-btn"><i class="fas fa-pencil-alt"></i></span></h3>
                                <p id="profile-email">ancho@example.com</p>
                            </div>
                            <div class="profile-menu">
                                <h4>My Account</h4>
                                <ul>
                                    <li><a href="#" id="my-profile-link"><i class="fas fa-user"></i> My Profile <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="orders-link"><i class="fas fa-box"></i> Orders <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="wishlist-link"><i class="fas fa-heart"></i> Wishlist <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="addresses-link"><i class="fas fa-map-marker-alt"></i> Addresses <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="payment-link"><i class="fas fa-credit-card"></i> Payment Methods <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="coupons-link"><i class="fas fa-gift"></i> Coupons <i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="#" id="notifications-link"><i class="fas fa-bell"></i> Notifications <i class="fas fa-chevron-right"></i></a></li>
                                </ul>
                                <div class="logout-btn"><a href="#" id="logoutBtn">Logout</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nav-container">
            <div class="container">
                <ul class="main-nav">
                    <li class="nav-item"><a href="newarraivals.php">New Arrivals</a></li>
                    <li class="nav-item">
                        <a href="#">Shirts</a>
                        <div class="dropdown-content">
                            <a href="#">Formal Shirts</a>
                            <a href="#">Casual Shirts</a>
                            <a href="#">Linen Shirts</a>
                            <a href="#">Oxford Shirts</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#">T-Shirts</a>
                        <div class="dropdown-content">
                            <a href="#">Polo T-Shirts</a>
                            <a href="#">Crew Neck</a>
                            <a href="#">Henley</a>
                            <a href="#">Graphic Tees</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#">Trousers</a>
                        <div class="dropdown-content">
                            <a href="#">Chinos</a>
                            <a href="#">Formal Trousers</a>
                            <a href="#">Shorts</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="#">Jeans</a></li>
                    <li class="nav-item">
                        <a href="#">Collections</a>
                        <div class="dropdown-content">
                            <a href="#">Summer Layering</a>
                            <a href="#">Resort Wear</a>
                            <a href="#">Workwear</a>
                            <a href="#">Travel & Fashion</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="#">Sale</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-content">
            <h1>ELEVATED ESSENTIALS</h1>
            <p>Timeless pieces crafted with precision. Premium fabrics that feel as good as they look. Experience clothing that becomes an extension of your personality.</p>
            <div class="buttons">
                <a href="#" class="btn">Shop Now</a>
                <a href="#" class="btn btn-outline">Our Story</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <div class="section-title">
                <h2>Shop By Category</h2>
            </div>
            <div class="category-grid">
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1603252109303-2751441dd157?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Summer Layering">
                    <div class="category-content">
                        <h3>Summer Layering</h3>
                        <a href="#" class="shop-link">Shop Now</a>
                    </div>
                </div>
                
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1543322748-33df6d3db806?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Resort Wear">
                    <div class="category-content">
                        <h3>Resort Wear</h3>
                        <a href="#" class="shop-link">Shop Now</a>
                    </div>
                </div>
                
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Workwear">
                    <div class="category-content">
                        <h3>Workwear</h3>
                        <a href="#" class="shop-link">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>
            
            <div class="product-grid">
                <div class="product-card" data-product-id="1">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Linen Shirt">
                        <span class="product-badge">New</span>
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(1)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(1)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(1)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Pure Linen Shirt</h3>
                        <p class="product-price">₹2,499</p>
                    </div>
                </div>
                
                <div class="product-card" data-product-id="2">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Polo T-shirt">
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(2)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(2)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(2)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Vibrant Polo T-shirt</h3>
                        <p class="product-price">₹1,699</p>
                    </div>
                </div>
                
                <div class="product-card" data-product-id="3">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1514222788835-3a1a1d5b32f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Formal Shirt">
                        <span class="product-badge">Sale</span>
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(3)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(3)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(3)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Classic Oxford Shirt</h3>
                        <p class="product-price">₹1,999</p>
                    </div>
                </div>
                
                <div class="product-card" data-product-id="4">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Casual Trousers">
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(4)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(4)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(4)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">Cotton Chino Trousers</h3>
                        <p class="product-price">₹2,299</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Collection Banner -->
    <section class="collection-banner">
        <div class="collection-content">
            <h2>Travel & Fashion Collection</h2>
            <p>Discover our curated collection designed for the modern traveler. Comfortable, wrinkle-resistant fabrics that look great from plane to meeting.</p>
            <a href="#" class="btn">Explore Collection</a>
        </div>
    </section>

    <!-- USP Section -->
    <section class="usp-section">
        <div class="container">
            <div class="usp-grid">
                <div class="usp-card">
                    <div class="usp-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="usp-title">Free Shipping</h3>
                    <p class="usp-text">On all orders above ₹999</p>
                </div>
                
                <div class="usp-card">
                    <div class="usp-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h3 class="usp-title">Easy Returns</h3>
                    <p class="usp-text">30-day return policy</p>
                </div>
                
                <div class="usp-card">
                    <div class="usp-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="usp-title">Secure Payments</h3>
                    <p class="usp-text">Protected by industry leaders</p>
                </div>
                
                <div class="usp-card">
                    <div class="usp-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="usp-title">24/7 Support</h3>
                    <p class="usp-text">Dedicated customer service</p>
                </div>
                
                <div class="usp-card">
                    <div class="usp-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3 class="usp-title">Premium Quality</h3>
                    <p class="usp-text">Finest fabrics and craftsmanship</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h3>Subscribe to Our Newsletter</h3>
                <p>Stay updated with our latest collections, exclusive offers, and style tips.</p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Your email address">
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
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
                        <li><a href="newarraivals.php">New Arrivals</a></li>
                        <li><a href="#">Shirts</a></li>
                        <li><a href="#">T-Shirts</a></li>
                        <li><a href="#">Trousers</a></li>
                        <li><a href="#">Jeans</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Collections</h4>
                    <ul class="footer-links">
                        <li><a href="#">Summer Layering</a></li>
                        <li><a href="#">Resort Wear</a></li>
                        <li><a href="#">Workwear</a></li>
                        <li><a href="#">Travel & Fashion</a></li>
                        <li><a href="#">Classic Oxfords</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Information</h4>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Size Guide</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
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

            <!-- Profile Creation Form -->
            <div id="profile-creation-section" class="profile-creation-section">
                <h2>Complete Your Profile</h2>
                <p>Please provide the following details</p>
                <div class="form-group">
                    <input type="text" id="firstName" placeholder="First Name*" required>
                </div>
                <div class="form-group">
                    <input type="text" id="lastName" placeholder="Last Name*" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" placeholder="Email Address (Optional)">
                </div>
                <div class="form-group gender-selection">
                    <p>Gender</p>
                    <label>
                        <input type="radio" name="gender" value="male" checked> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female"> Female
                    </label>
                    <label>
                        <input type="radio" name="gender" value="other"> Other
                    </label>
                </div>
                <div class="form-group">
                    <p>Date of Birth (Optional)</p>
                    <div class="dob-inputs">
                        <select id="dobDay">
                            <option value="">Day</option>
                        </select>
                        <select id="dobMonth">
                            <option value="">Month</option>
                        </select>
                        <select id="dobYear">
                            <option value="">Year</option>
                        </select>
                    </div>
                </div>
                <button id="createProfileBtn" class="btn">Create Profile</button>
            </div>
        </div>
    </div>

    <!-- Profile Details Modal -->
    <div id="profileDetailsModal" class="profile-details-modal">
        <div class="profile-details-container">
            <span class="close" id="close-profile-details">&times;</span>
            <div class="profile-details-header">
                <h2>My Profile</h2>
                <p>Manage your profile details</p>
            </div>
            <div class="profile-details-content">
                <div class="profile-info-group">
                    <h4>Full Name</h4>
                    <p id="detail-fullname">Anne Cho</p>
                </div>
                <div class="profile-info-group">
                    <h4>Mobile Number</h4>
                    <p id="detail-mobile">+91 9876543210</p>
                </div>
                <div class="profile-info-group">
                    <h4>Email Address</h4>
                    <p id="detail-email">ancho@example.com</p>
                </div>
                <div class="profile-info-group">
                    <h4>Gender</h4>
                    <p id="detail-gender">Female</p>
                </div>
                <div class="profile-info-group">
                    <h4>Date of Birth</h4>
                    <p id="detail-dob">15 Aug 1992</p>
                </div>
                <div class="profile-info-group">
                    <h4>Location</h4>
                    <p id="detail-location">Mumbai, India</p>
                </div>
                <div class="profile-info-actions">
                    <button class="btn" id="edit-profile-btn">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="edit-profile-modal">
        <div class="edit-profile-container">
            <span class="close" id="close-edit-profile">&times;</span>
            <div class="edit-profile-header">
                <h2>Edit Profile</h2>
            </div>
            <form class="edit-profile-form" id="edit-profile-form">
                <div class="form-group">
                    <label for="edit-fullname">Full Name</label>
                    <input type="text" id="edit-fullname" placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="edit-email">Email Address</label>
                    <input type="email" id="edit-email" placeholder="Enter your email">
                </div>
             
                <div class="form-group">
                    <label>Gender</label>
                    <div style="display: flex; gap: 20px;">
                        <label style="display: flex; align-items: center;">
                            <input type="radio" name="gender" value="male" style="width: auto; margin-right: 5px;">
                            Male
                        </label>
                        <label style="display: flex; align-items: center;">
                            <input type="radio" name="gender" value="female" style="width: auto; margin-right: 5px;">
                            Female
                        </label>
                        <label style="display: flex; align-items: center;">
                            <input type="radio" name="gender" value="other" style="width: auto; margin-right: 5px;">
                            Other
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <div style="display: flex; gap: 10px;">
                        <select id="edit-dob-day" style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Day</option>
                        </select>
                        <select id="edit-dob-month" style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Month</option>
                        </select>
                        <select id="edit-dob-year" style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Year</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-location">Location</label>
                    <input type="text" id="edit-location" placeholder="Enter your location">
                </div>
                <div class="edit-profile-actions">
                    <button type="button" class="btn cancel-btn" id="cancel-edit-profile">Cancel</button>
                    <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Name Edit Modal -->
    <div id="nameEditModal" class="name-edit-modal">
        <div class="name-edit-container">
            <span class="close" id="close-name-edit">&times;</span>
            <div class="name-edit-header">
                <h3>Edit Name</h3>
            </div>
            <form class="name-edit-form" id="name-edit-form">
                <div class="form-group">
                    <label for="edit-name-input">Full Name</label>
                    <input type="text" id="edit-name-input" placeholder="Enter your full name">
                </div>
                <div class="name-edit-actions">
                    <button type="button" class="btn cancel-btn" id="cancel-name-edit">Cancel</button>
                    <button type="submit" class="btn">Save</button>
                </div>
            </form>
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

    <script>
       // Wait for the DOM to be fully loaded before running any code
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    
    // Demo products data
    const demoProducts = [
        { id: 1, name: 'Pure Linen Shirt', price: 2499, image: 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', category: 'Shirts', subcategory: 'Linen Shirts' },
        { id: 2, name: 'Vibrant Polo T-shirt', price: 1699, image: 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', category: 'T-Shirts', subcategory: 'Polo T-Shirts' },
        { id: 3, name: 'Classic Oxford Shirt', price: 1999, image: 'https://images.unsplash.com/photo-1514222788835-3a1a1d5b32f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', category: 'Shirts', subcategory: 'Oxford Shirts' },
        { id: 4, name: 'Cotton Chino Trousers', price: 2299, image: 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', category: 'Trousers', subcategory: 'Chinos' }
    ];

    // Test localStorage functionality
    try {
        localStorage.setItem('test', 'test');
        console.log('LocalStorage write test:', localStorage.getItem('test') === 'test');
        localStorage.removeItem('test');
    } catch (e) {
        console.error('LocalStorage not available:', e);
        alert('This website requires local storage to be enabled in your browser.');
    }

    // Get DOM elements with error handling
    function getElement(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.error(`Element with ID "${id}" not found!`);
        }
        return element;
    }

    // DOM Elements with error handling
    const loginModal = getElement('loginModal');
    const cartSidebar = getElement('cartSidebar');
    const searchModal = getElement('searchModal');
    const overlay = getElement('overlay');
    const phoneInput = getElement('phone');
    const otpInput = getElement('otp');
    const sendOtpBtn = getElement('sendOtpBtn');
    const verifyOtpBtn = getElement('verifyOtpBtn');
    const resendOtpBtn = getElement('resendOtpBtn');
    const phoneSection = getElement('phone-input-section');
    const otpSection = getElement('otp-input-section');
    const profileCreationSection = getElement('profile-creation-section');
    const createProfileBtn = getElement('createProfileBtn');
    const timerElement = getElement('timer');
    const cartIcon = getElement('cart-icon');
    const searchIcon = getElement('search-icon');
    const userIcon = getElement('user-icon');
    const profileDropdown = getElement('profileDropdown');
    const logoutBtn = getElement('logoutBtn');
    const closeCartButton = document.querySelector('.close-cart');
    const checkoutBtn = getElement('checkoutBtn');
    const cartItems = getElement('cartItems');
    const cartTotal = getElement('cartTotal');
    const searchInput = getElement('searchInput');
    const searchBtn = getElement('searchBtn');
    const searchResults = getElement('searchResults');
    const cartCountElement = document.querySelector('.cart-count');
    
    // Profile elements
    const profileImg = getElement('profile-img');
    const profileName = getElement('profile-name');
    const profileEmail = getElement('profile-email');
    const profileImageInput = getElement('profile-image-input');
    const editNameBtn = getElement('edit-name-btn');
    const nameEditModal = getElement('nameEditModal');
    const nameEditForm = getElement('name-edit-form');
    const editNameInput = getElement('edit-name-input');
    const closeNameEdit = getElement('close-name-edit');
    const cancelNameEdit = getElement('cancel-name-edit');
    const myProfileLink = getElement('my-profile-link');
    const profileDetailsModal = getElement('profileDetailsModal');
    const closeProfileDetails = getElement('close-profile-details');
    const editProfileBtn = getElement('edit-profile-btn');
    const editProfileModal = getElement('editProfileModal');
    const closeEditProfile = getElement('close-edit-profile');
    const cancelEditProfile = getElement('cancel-edit-profile');
    const editProfileForm = getElement('edit-profile-form');
    
    // Close modal buttons
    const closeModalButtons = document.querySelectorAll('.close');
    
    // Global variables
    let otpTimer;
    let isLoggedIn = false;
    let isNewUser = true;
    let cartCount = 0;
    let userCart = [];
    let demoOtp = '123456'; // Demo OTP for testing
    
    // Default user profile
    let userProfile = {
        name: 'Anne Cho',
        firstName: 'Anne',
        lastName: 'Cho',
        email: 'ancho@example.com',
        phone: '+91 9876543210',
        gender: 'Female',
        dob: '15 Aug 1992',
        location: 'Mumbai, India',
        image: 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
    };

    // Check if user is logged in
    function checkLoginStatus() {
        console.log('Checking login status...');
        isLoggedIn = localStorage.getItem('user_id') !== null;
        console.log('Is user logged in?', isLoggedIn);
        
        if (isLoggedIn) {
            try {
                // Load user profile from localStorage if available
                const storedProfile = localStorage.getItem('user_profile');
                if (storedProfile) {
                    userProfile = JSON.parse(storedProfile);
                    console.log('Loaded user profile:', userProfile);
                }
                
                // Update UI with user profile
                updateUserInterface(userProfile);
                
                // Load cart
                loadCart();
            } catch (error) {
                console.error('Error loading user profile:', error);
            }
        } else {
            if (userIcon) {
                userIcon.innerHTML = '<i class="fas fa-user"></i>';
            }
        }
    }

    // Update user interface with profile data
    function updateUserInterface(profile) {
        console.log('Updating user interface with profile:', profile);
        
        try {
            if (profileName) {
                const displayName = profile.name || `${profile.firstName || ''} ${profile.lastName || ''}`.trim();
                profileName.innerHTML = displayName + ' <span class="edit-name-btn" id="edit-name-btn"><i class="fas fa-pencil-alt"></i></span>';
                
                // Reattach event listener for edit name button
                const newEditNameBtn = document.getElementById('edit-name-btn');
                if (newEditNameBtn) {
                    newEditNameBtn.addEventListener('click', openNameEditModal);
                }
            }
            
            if (profileEmail) {
                profileEmail.textContent = profile.email || '';
            }
            
            if (profileImg && profile.image) {
                profileImg.src = profile.image;
            }
            
            if (userIcon && profile.image) {
                userIcon.innerHTML = `<div style="width: 24px; height: 24px; border-radius: 50%; overflow: hidden; display: inline-block; vertical-align: middle;"><img src="${profile.image}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;"></div>`;
            }
        } catch (error) {
            console.error('Error updating user interface:', error);
        }
    }

    // Handle user icon click
    function handleUserIconClick(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        console.log('User icon clicked');
        
        if (isLoggedIn) {
            // Toggle profile dropdown
            if (profileDropdown) {
                if (profileDropdown.style.display === 'block') {
                    profileDropdown.style.display = 'none';
                    console.log('Profile dropdown hidden');
                } else {
                    profileDropdown.style.display = 'block';
                    console.log('Profile dropdown shown');
                }
            }
        } else {
            openModal(loginModal);
        }
    }

    // Handle profile image change
    function handleProfileImageChange(e) {
        console.log('Profile image change triggered');
        
        const file = e.target.files[0];
        if (!file) {
            console.log('No file selected');
            return;
        }
        
        console.log('File selected:', file.name, file.type);
        
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
            const imageUrl = event.target.result;
            console.log('Image loaded successfully');
            
            // Update profile image
            if (profileImg) {
                profileImg.src = imageUrl;
            }
            
            if (userIcon) {
                userIcon.innerHTML = `<div style="width: 24px; height: 24px; border-radius: 50%; overflow: hidden; display: inline-block; vertical-align: middle;"><img src="${imageUrl}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;"></div>`;
            }
            
            // Update user profile
            userProfile.image = imageUrl;
            localStorage.setItem('user_profile', JSON.stringify(userProfile));
            console.log('Profile image updated in localStorage');
        };
        
        reader.onerror = function(error) {
            console.error('Error reading file:', error);
            alert('Error reading the image file. Please try again.');
        };
        
        reader.readAsDataURL(file);
    }

    // Open name edit modal
    function openNameEditModal(e) {
        console.log('Opening name edit modal');
        if (e) e.preventDefault();
        
        if (editNameInput && nameEditModal && overlay) {
            editNameInput.value = userProfile.name || `${userProfile.firstName || ''} ${userProfile.lastName || ''}`.trim();
            nameEditModal.style.display = 'block';
            overlay.style.display = 'block';
            console.log('Name edit modal opened');
        } else {
            console.error('Required elements for name editing not found');
        }
    }

    // Close name edit modal
    function closeNameEditModal() {
        console.log('Closing name edit modal');
        if (nameEditModal && overlay) {
            nameEditModal.style.display = 'none';
            overlay.style.display = 'none';
            console.log('Name edit modal closed');
        }
    }

    // Save name edit
    function saveNameEdit(e) {
        console.log('Saving name edit');
        if (e) e.preventDefault();
        
        if (!editNameInput) {
            console.error('Edit name input not found');
            return;
        }
        
        const newName = editNameInput.value.trim();
        console.log('New name:', newName);
        
        if (newName) {
            userProfile.name = newName;
            
            // Split name into first and last name
            const nameParts = newName.split(' ');
            if (nameParts.length > 0) {
                userProfile.firstName = nameParts[0];
                userProfile.lastName = nameParts.slice(1).join(' ');
            }
            
            if (profileName) {
                profileName.innerHTML = newName + ' <span class="edit-name-btn" id="edit-name-btn"><i class="fas fa-pencil-alt"></i></span>';
                
                // Reattach event listener
                const newEditNameBtn = document.getElementById('edit-name-btn');
                if (newEditNameBtn) {
                    newEditNameBtn.addEventListener('click', openNameEditModal);
                }
            }
            
            // Save to localStorage
            localStorage.setItem('user_profile', JSON.stringify(userProfile));
            console.log('Name updated in localStorage');
            
            closeNameEditModal();
        } else {
            alert('Please enter a valid name');
        }
    }

    // Open profile details modal
    function openProfileDetailsModal() {
        console.log('Opening profile details modal');
        
        try {
            // Populate profile details
            const detailFullname = getElement('detail-fullname');
            const detailMobile = getElement('detail-mobile');
            const detailEmail = getElement('detail-email');
            const detailGender = getElement('detail-gender');
            const detailDob = getElement('detail-dob');
            const detailLocation = getElement('detail-location');
            
            if (detailFullname) detailFullname.textContent = userProfile.name || `${userProfile.firstName || ''} ${userProfile.lastName || ''}`.trim();
            if (detailMobile) detailMobile.textContent = userProfile.phone || '';
            if (detailEmail) detailEmail.textContent = userProfile.email || '';
            if (detailGender) detailGender.textContent = userProfile.gender || '';
            if (detailDob) detailDob.textContent = userProfile.dob || '';
            if (detailLocation) detailLocation.textContent = userProfile.location || '';
            
            if (profileDetailsModal && overlay) {
                profileDetailsModal.style.display = 'block';
                overlay.style.display = 'block';
                
                if (profileDropdown) {
                    profileDropdown.style.display = 'none';
                }
                
                console.log('Profile details modal opened');
            }
        } catch (error) {
            console.error('Error opening profile details modal:', error);
        }
    }

    // Close profile details modal
    function closeProfileDetailsModal() {
        console.log('Closing profile details modal');
        if (profileDetailsModal && overlay) {
            profileDetailsModal.style.display = 'none';
            overlay.style.display = 'none';
            console.log('Profile details modal closed');
        }
    }

    // Open edit profile modal
    function openEditProfileModal() {
        console.log('Opening edit profile modal');
        
        try {
            // Get form elements
            const editFullname = getElement('edit-fullname');
            const editEmail = getElement('edit-email');
            const editLocation = getElement('edit-location');
            const editDobDay = getElement('edit-dob-day');
            const editDobMonth = getElement('edit-dob-month');
            const editDobYear = getElement('edit-dob-year');
            
            // Populate form with current profile data
            if (editFullname) editFullname.value = userProfile.name || `${userProfile.firstName || ''} ${userProfile.lastName || ''}`.trim();
            if (editEmail) editEmail.value = userProfile.email || '';
            if (editLocation) editLocation.value = userProfile.location || '';
            
            // Set gender
            const genderInputs = document.getElementsByName('gender');
            for (let input of genderInputs) {
                if (input.value.toLowerCase() === (userProfile.gender || '').toLowerCase()) {
                    input.checked = true;
                    break;
                }
            }
            
            // Parse and set DOB if available
            if (userProfile.dob && editDobDay && editDobMonth && editDobYear) {
                const dobParts = userProfile.dob.split(' ');
                if (dobParts.length === 3) {
                    const day = dobParts[0];
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const month = (monthNames.indexOf(dobParts[1]) + 1).toString().padStart(2, '0');
                    const year = dobParts[2];
                    
                    editDobDay.value = day;
                    editDobMonth.value = month;
                    editDobYear.value = year;
                }
            }
            
            if (editProfileModal && overlay) {
                editProfileModal.style.display = 'block';
                overlay.style.display = 'block';
                
                if (profileDetailsModal) {
                    profileDetailsModal.style.display = 'none';
                }
                
                console.log('Edit profile modal opened');
            }
        } catch (error) {
            console.error('Error opening edit profile modal:', error);
        }
    }

    // Close edit profile modal
    function closeEditProfileModal() {
        console.log('Closing edit profile modal');
        if (editProfileModal && overlay) {
            editProfileModal.style.display = 'none';
            overlay.style.display = 'none';
            console.log('Edit profile modal closed');
        }
    }

    // Save profile edit
    function saveProfileEdit(e) {
        console.log('Saving profile edit');
        if (e) e.preventDefault();
        
        try {
            // Get form elements
            const editFullname = getElement('edit-fullname');
            const editEmail = getElement('edit-email');
            const editLocation = getElement('edit-location');
            const editDobDay = getElement('edit-dob-day');
            const editDobMonth = getElement('edit-dob-month');
            const editDobYear = getElement('edit-dob-year');
            
            if (!editFullname) {
                console.error('Edit fullname input not found');
                return;
            }
            
            // Get form values
            const fullName = editFullname.value.trim();
            const email = editEmail ? editEmail.value.trim() : '';
            const location = editLocation ? editLocation.value.trim() : '';
            
            // Get selected gender
            let gender = '';
            const genderInputs = document.getElementsByName('gender');
            for (let input of genderInputs) {
                if (input.checked) {
                    gender = input.value;
                    break;
                }
            }
            
            // Get DOB
            let dob = '';
            if (editDobDay && editDobMonth && editDobYear) {
                const day = editDobDay.value;
                const monthValue = editDobMonth.value;
                const year = editDobYear.value;
                
                if (day && monthValue && year) {
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const monthIndex = parseInt(monthValue) - 1;
                    dob = `${day} ${monthNames[monthIndex]} ${year}`;
                }
            }
            
            if (!fullName) {
                alert('Please enter your full name');
                return;
            }
            
            // Update user profile
            userProfile.name = fullName;
            
            // Split name into first and last name
            const nameParts = fullName.split(' ');
            if (nameParts.length > 0) {
                userProfile.firstName = nameParts[0];
                userProfile.lastName = nameParts.slice(1).join(' ');
            }
            
            userProfile.email = email;
            userProfile.gender = gender;
            if (dob) userProfile.dob = dob;
            userProfile.location = location;
            
            // Update UI
            updateUserInterface(userProfile);
            
            // Save to localStorage
            localStorage.setItem('user_profile', JSON.stringify(userProfile));
            console.log('Profile updated in localStorage');
            
            // Close modal and open profile details with updated info
            closeEditProfileModal();
            openProfileDetailsModal();
        } catch (error) {
            console.error('Error saving profile edit:', error);
        }
    }

    // Send OTP
    function sendOTP() {
        console.log('Send OTP function called');
        
        if (!phoneInput) {
            console.error('Phone input not found');
            return;
        }
        
        const phone = phoneInput.value.trim();
        console.log('Phone number entered:', phone);
        
        if (!phone || phone.length !== 10 || !/^\d+$/.test(phone)) {
            alert('Please enter a valid 10-digit phone number');
            return;
        }
        
        // Disable buttons during request
        if (sendOtpBtn) sendOtpBtn.disabled = true;
        if (resendOtpBtn) resendOtpBtn.disabled = true;
        
        // Check if user exists (in a real app, this would be a server call)
        const existingUser = localStorage.getItem('user_' + phone);
        isNewUser = !existingUser;
        console.log('Is new user?', isNewUser);
        
        // For demo purposes, simulate OTP sending
        setTimeout(() => {
            // Show OTP input section
            if (phoneSection) phoneSection.style.display = 'none';
            if (otpSection) otpSection.style.display = 'block';
            
            // Start timer
            startOtpTimer();
            
            // Alert user (in a real app, this would be sent via SMS)
            alert('For demo purposes, your OTP is: ' + demoOtp);
            
            if (resendOtpBtn) resendOtpBtn.disabled = false;
            
            console.log('OTP sent and OTP input section displayed');
        }, 1000);
    }

    // Verify OTP
    function verifyOTP() {
        console.log('Verify OTP function called');
        
        if (!phoneInput || !otpInput) {
            console.error('Phone or OTP input not found');
            return;
        }
        
        const phone = phoneInput.value.trim();
        const otp = otpInput.value.trim();
        console.log('Verifying OTP for phone:', phone);
        
        if (!otp || otp.length !== 6 || !/^\d+$/.test(otp)) {
            alert('Please enter a valid 6-digit OTP');
            return;
        }
        
        // Disable button during request
        if (verifyOtpBtn) verifyOtpBtn.disabled = true;
        
        // For demo purposes, accept the demo OTP
        setTimeout(() => {
            if (otp === demoOtp) {
                console.log('OTP verified successfully');
                
                if (isNewUser) {
                    // Show profile creation for new users
                    console.log('New user - showing profile creation form');
                    if (otpSection) otpSection.style.display = 'none';
                    if (profileCreationSection) profileCreationSection.style.display = 'block';
                    
                    // Store temporary phone number
                    localStorage.setItem('temp_phone', phone);
                } else {
                    // For existing users, log them in directly
                    console.log('Existing user - logging in directly');
                    try {
                        const storedUser = localStorage.getItem('user_' + phone);
                        const userProfile = storedUser ? JSON.parse(storedUser) : {};
                        
                        // Store user info
                        localStorage.setItem('user_id', userProfile.id || '1');
                        localStorage.setItem('user_profile', JSON.stringify(userProfile));
                        
                        // Update UI
                        isLoggedIn = true;
                        updateUserInterface(userProfile);
                        
                        // Close modal
                        closeModal(loginModal);
                        
                        // Reset form
                        resetLoginForm();
                        
                        // Load cart
                        loadCart();
                        
                        alert('Login successful!');
                    } catch (error) {
                        console.error('Error during login:', error);
                        alert('An error occurred during login. Please try again.');
                    }
                }
            } else {
                alert('Invalid OTP. Please try again.');
                if (verifyOtpBtn) verifyOtpBtn.disabled = false;
            }
        }, 1000);
    }

    // Create new user profile
    function createProfile(e) {
        console.log('Create profile function called');
        if (e) e.preventDefault();
        
        try {
            const firstName = getElement('firstName').value.trim();
            const lastName = getElement('lastName').value.trim();
            const email = getElement('email').value.trim();
            const phone = localStorage.getItem('temp_phone');
            
            console.log('Creating profile for phone:', phone);
            
            // Get selected gender
            let gender = '';
            const genderInputs = document.getElementsByName('gender');
            for (const input of genderInputs) {
                if (input.checked) {
                    gender = input.value;
                    break;
                }
            }
            
            // Get date of birth
            const dobDay = getElement('dobDay');
            const dobMonth = getElement('dobMonth');
            const dobYear = getElement('dobYear');
            
            let dob = '';
            if (dobDay && dobMonth && dobYear) {
                const day = dobDay.value;
                const month = dobMonth.value;
                const year = dobYear.value;
                
                if (day && month && year) {
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const monthIndex = parseInt(month) - 1;
                    dob = `${day} ${monthNames[monthIndex]} ${year}`;
                }
            }
            
            // Validate required fields
            if (!firstName) {
                alert('Please enter your first name');
                return;
            }
            
            if (!phone) {
                console.error('No phone number found in temporary storage');
                alert('An error occurred. Please try again.');
                return;
            }
            
            // Generate user ID
            const userId = 'user_' + Date.now();
            
            // Create user profile
            const newUserProfile = {
                id: userId,
                firstName: firstName,
                lastName: lastName,
                name: `${firstName} ${lastName}`.trim(),
                email: email,
                phone: `+91 ${phone}`,
                gender: gender,
                dob: dob,
                location: 'India',
                image: 'https://constant.myntassets.com/myx/images/header_default_user.png',
                createdAt: new Date().toISOString()
            };
            
            // Store in localStorage (in a real app, this would be sent to a server)
            localStorage.setItem('user_' + phone, JSON.stringify(newUserProfile));
            localStorage.setItem('user_id', userId);
            localStorage.setItem('user_profile', JSON.stringify(newUserProfile));
            
            // Remove temporary phone
            localStorage.removeItem('temp_phone');
            
            // Update UI
            isLoggedIn = true;
            userProfile = newUserProfile;
            updateUserInterface(newUserProfile);
            
            // Close modal
            closeModal(loginModal);
            
            // Reset form
            resetLoginForm();
            
            alert('Profile created successfully!');
            console.log('Profile created successfully');
        } catch (error) {
            console.error('Error creating profile:', error);
            alert('An error occurred while creating your profile. Please try again.');
        }
    }

    // Logout
    function logout(e) {
        console.log('Logout function called');
        if (e) e.preventDefault();
        
        try {
            localStorage.removeItem('user_id');
            localStorage.removeItem('user_profile');
            localStorage.removeItem('cart');
            
            isLoggedIn = false;
            if (userIcon) userIcon.innerHTML = '<i class="fas fa-user"></i>';
            userCart = [];
            if (profileDropdown) profileDropdown.style.display = 'none';
            
            updateCartCount(0);
            
            alert('Logged out successfully!');
            console.log('Logout successful');
        } catch (error) {
            console.error('Error during logout:', error);
            alert('An error occurred during logout. Please try again.');
        }
    }

    // Start OTP timer
    function startOtpTimer() {
        let minutes = 5;
        let seconds = 0;
        
        clearInterval(otpTimer);
        
        if (!timerElement) {
            console.error('Timer element not found');
            return;
        }
        
        console.log('Starting OTP timer');
        
        otpTimer = setInterval(() => {
            if (seconds === 0) {
                if (minutes === 0) {
                    clearInterval(otpTimer);
                    if (resendOtpBtn) resendOtpBtn.disabled = false;
                    console.log('OTP timer expired');
                    return;
                }
                minutes--;
                seconds = 59;
            } else {
                seconds--;
            }
            
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }

    // Reset login form
    function resetLoginForm() {
        console.log('Resetting login form');
        
        try {
            if (phoneInput) phoneInput.value = '';
            if (otpInput) otpInput.value = '';
            
            const firstName = getElement('firstName');
            const lastName = getElement('lastName');
            const email = getElement('email');
            
            if (firstName) firstName.value = '';
            if (lastName) lastName.value = '';
            if (email) email.value = '';
            
            // Reset gender selection
            const maleRadio = document.querySelector('input[name="gender"][value="male"]');
            if (maleRadio) maleRadio.checked = true;
            
            // Reset date of birth
            const dobDay = getElement('dobDay');
            const dobMonth = getElement('dobMonth');
            const dobYear = getElement('dobYear');
            
            if (dobDay) dobDay.value = '';
            if (dobMonth) dobMonth.value = '';
            if (dobYear) dobYear.value = '';
            
            // Reset sections visibility
            if (phoneSection) phoneSection.style.display = 'block';
            if (otpSection) otpSection.style.display = 'none';
            if (profileCreationSection) profileCreationSection.style.display = 'none';
            
            // Reset buttons
            if (sendOtpBtn) sendOtpBtn.disabled = false;
            if (verifyOtpBtn) verifyOtpBtn.disabled = false;
            if (resendOtpBtn) resendOtpBtn.disabled = true;
            
            // Clear timer
            clearInterval(otpTimer);
            
            console.log('Login form reset complete');
        } catch (error) {
            console.error('Error resetting login form:', error);
        }
    }

    // Open modal
    function openModal(modal) {
        console.log('Opening modal');
        
        if (!modal) {
            console.error('Modal not found');
            return;
        }
        
        modal.style.display = 'block';
        
        if (overlay) {
            overlay.style.display = 'block';
        }
        
        document.body.style.overflow = 'hidden';
        console.log('Modal opened');
    }

    // Close modal
    function closeModal(modal) {
        console.log('Closing modal');
        
        if (!modal) {
            console.error('Modal not found');
            return;
        }
        
        modal.style.display = 'none';
        
        if (overlay) {
            overlay.style.display = 'none';
        }
        
        document.body.style.overflow = '';
        
        if (modal === loginModal) {
            resetLoginForm();
        }
        
        console.log('Modal closed');
    }

    // Close all modals
    function closeAllModals() {
        console.log('Closing all modals');
        
        try {
            if (loginModal) loginModal.style.display = 'none';
            if (searchModal) searchModal.style.display = 'none';
            if (cartSidebar) cartSidebar.classList.remove('open');
            if (profileDropdown) profileDropdown.style.display = 'none';
            if (nameEditModal) nameEditModal.style.display = 'none';
            if (profileDetailsModal) profileDetailsModal.style.display = 'none';
            if (editProfileModal) editProfileModal.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
            
            document.body.style.overflow = '';
            resetLoginForm();
            
            console.log('All modals closed');
        } catch (error) {
            console.error('Error closing all modals:', error);
        }
    }

    // Toggle cart sidebar
    function toggleCart() {
        console.log('Toggling cart sidebar');
        
        if (!cartSidebar) {
            console.error('Cart sidebar not found');
            return;
        }
        
        cartSidebar.classList.toggle('open');
        
        if (cartSidebar.classList.contains('open')) {
            if (overlay) overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
            loadCart();
            console.log('Cart sidebar opened');
        } else {
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = '';
            console.log('Cart sidebar closed');
        }
    }

    // Open search modal
    function openSearchModal() {
        console.log('Opening search modal');
        openModal(searchModal);
        if (searchInput) searchInput.focus();
    }

    // Load cart items
    function loadCart() {
        console.log('Loading cart items');
        
        if (!cartItems || !cartTotal || !cartCountElement) {
            console.error('Cart elements not found');
            return;
        }
        
        if (!isLoggedIn) {
            cartItems.innerHTML = '<div class="empty-message">Please login to view your cart</div>';
            cartTotal.textContent = '₹0.00';
            updateCartCount(0);
            console.log('User not logged in, showing login message');
            return;
        }
        
        try {
            // Get cart from localStorage
            let storedCart = localStorage.getItem('cart');
            userCart = storedCart ? JSON.parse(storedCart) : [];
            
            if (userCart.length === 0) {
                cartItems.innerHTML = '<div class="empty-message">Your cart is empty</div>';
                cartTotal.textContent = '₹0.00';
                updateCartCount(0);
                console.log('Cart is empty');
                return;
            }
            
            let html = '';
            let total = 0;
            
            userCart.forEach(item => {
                // Find product details
                const product = demoProducts.find(p => p.id === item.productId);
                if (product) {
                    const subtotal = product.price * item.quantity;
                    total += subtotal;
                    
                    html += `
                        <div class="cart-item" data-id="${item.id}">
                            <div class="cart-item-image">
                                <img src="${product.image}" alt="${product.name}">
                            </div>
                            <div class="cart-item-details">
                                <h4 class="cart-item-name">${product.name}</h4>
                                <p class="cart-item-price">₹${product.price.toLocaleString()}</p>
                                <div class="cart-item-quantity">
                                    <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                                    <input type="number" class="quantity-input" value="${item.quantity}" min="1" onchange="updateQuantity(${item.id}, this.value)">
                                    <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                                    <button class="cart-item-remove" onclick="removeFromCart(${item.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            
            cartItems.innerHTML = html;
            cartTotal.textContent = '₹' + total.toLocaleString();
            updateCartCount(userCart.length);
            console.log('Cart loaded successfully with', userCart.length, 'items');
        } catch (error) {
            console.error('Error loading cart:', error);
            cartItems.innerHTML = '<div class="empty-message">Error loading cart items</div>';
        }
    }

    // Add to cart
    function addToCart(productId, quantity = 1) {
        console.log('Adding to cart:', productId, 'quantity:', quantity);
        
        if (!isLoggedIn) {
            console.log('User not logged in, showing login modal');
            openModal(loginModal);
            return;
        }
        
        try {
            // Get cart from localStorage
            let storedCart = localStorage.getItem('cart');
            userCart = storedCart ? JSON.parse(storedCart) : [];
            
            // Check if product is already in cart
            const existingItemIndex = userCart.findIndex(item => item.productId === productId);
            
            if (existingItemIndex !== -1) {
                // Update quantity if product already in cart
                userCart[existingItemIndex].quantity += quantity;
                console.log('Updated quantity for existing item in cart');
            } else {
                // Add new item
                const newItem = {
                    id: Date.now(), // Generate unique ID
                    productId: productId,
                    quantity: quantity
                };
                userCart.push(newItem);
                console.log('Added new item to cart');
            }
            
            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(userCart));
            
            // Update UI
            updateCartCount(userCart.length);
            
            alert('Product added to cart');
            
            // Show cart
            toggleCart();
        } catch (error) {
            console.error('Error adding to cart:', error);
            alert('Error adding product to cart. Please try again.');
        }
    }

    // Update cart quantity
    function updateQuantity(itemId, quantity) {
        console.log('Updating quantity for item:', itemId, 'to:', quantity);
        
        quantity = parseInt(quantity);
        
        if (quantity <= 0) {
            removeFromCart(itemId);
            return;
        }
        
        try {
            // Get cart from localStorage
            let storedCart = localStorage.getItem('cart');
            userCart = storedCart ? JSON.parse(storedCart) : [];
            
            // Find and update item
            const itemIndex = userCart.findIndex(item => item.id === itemId);
            if (itemIndex !== -1) {
                userCart[itemIndex].quantity = quantity;
                
                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(userCart));
                
                // Update UI
                loadCart();
                console.log('Quantity updated successfully');
            } else {
                console.error('Item not found in cart');
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    // Remove from cart
    function removeFromCart(itemId) {
        console.log('Removing item from cart:', itemId);
        
        try {
            // Get cart from localStorage
            let storedCart = localStorage.getItem('cart');
            userCart = storedCart ? JSON.parse(storedCart) : [];
            
            // Filter out the item
            userCart = userCart.filter(item => item.id !== itemId);
            
            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(userCart));
            
            // Update UI
            loadCart();
            console.log('Item removed from cart');
        } catch (error) {
            console.error('Error removing from cart:', error);
        }
    }

    // Update cart count
    function updateCartCount(count) {
        cartCount = count;
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }

    // Handle checkout
    function handleCheckout() {
        console.log('Handling checkout');
        
        if (!isLoggedIn) {
            console.log('User not logged in, showing login modal');
            openModal(loginModal);
            return;
        }
        
        if (cartCount === 0) {
            alert('Your cart is empty');
            return;
        }
        
        alert('Proceeding to checkout...');
        // In a real app, redirect to checkout page
    }

    // Add to wishlist
    function addToWishlist(productId) {
        console.log('Adding to wishlist:', productId);
        
        if (!isLoggedIn) {
            console.log('User not logged in, showing login modal');
            openModal(loginModal);
            return;
        }
        
        alert('Product added to wishlist');
        // In a real app, save to database
    }

    // Quick view
    function quickView(productId) {
        console.log('Quick view for product:', productId);
        
        const product = demoProducts.find(p => p.id === productId);
        if (product) {
            alert(`Quick view for ${product.name}\nPrice: ₹${product.price}\nCategory: ${product.category}`);
        } else {
            console.error('Product not found');
        }
    }

    // Perform search
    function performSearch() {
        console.log('Performing search');
        
        if (!searchInput || !searchResults) {
            console.error('Search elements not found');
            return;
        }
        
        const query = searchInput.value.trim().toLowerCase();
        
        if (!query) {
            alert('Please enter a search term');
            return;
        }
        
        searchResults.innerHTML = '<div class="empty-message">Searching...</div>';
        
        try {
            // Filter products based on query
            const results = demoProducts.filter(product => 
                product.name.toLowerCase().includes(query) || 
                product.category.toLowerCase().includes(query) || 
                product.subcategory.toLowerCase().includes(query)
            );
            
            setTimeout(() => {
                if (results.length === 0) {
                    searchResults.innerHTML = '<div class="empty-message">No products found</div>';
                    console.log('No search results found');
                } else {
                    let html = '';
                    results.forEach(product => {
                        html += `
                            <div class="search-item" data-id="${product.id}">
                                <div class="search-item-image">
                                    <img src="${product.image}" alt="${product.name}">
                                </div>
                                <div class="search-item-details">
                                    <h4 class="search-item-name">${product.name}</h4>
                                    <p class="search-item-price">₹${product.price.toLocaleString()}</p>
                                    <button class="btn" onclick="addToCart(${product.id})">Add to Cart</button>
                                </div>
                            </div>
                        `;
                    });
                    searchResults.innerHTML = html;
                    console.log('Found', results.length, 'search results');
                }
            }, 500);
        } catch (error) {
            console.error('Error performing search:', error);
            searchResults.innerHTML = '<div class="empty-message">Error performing search</div>';
        }
    }

    // Populate date dropdowns
    function populateDateDropdowns() {
        console.log('Populating date dropdowns');
        
        try {
            populateDays('dobDay');
            populateMonths('dobMonth');
            populateYears('dobYear');
            
            populateDays('edit-dob-day');
            populateMonths('edit-dob-month');
            populateYears('edit-dob-year');
            
            console.log('Date dropdowns populated successfully');
        } catch (error) {
            console.error('Error populating date dropdowns:', error);
        }
    }
    
    // Populate days dropdown
    function populateDays(elementId) {
        const select = document.getElementById(elementId);
        if (!select) {
            console.error(`Day select element with ID "${elementId}" not found`);
            return;
        }
        
        // Clear existing options except the first one
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add days
        for (let i = 1; i <= 31; i++) {
            const option = document.createElement('option');
            option.value = i.toString().padStart(2, '0');
            option.textContent = i;
            select.appendChild(option);
        }
    }
    
    // Populate months dropdown
    function populateMonths(elementId) {
        const select = document.getElementById(elementId);
        if (!select) {
            console.error(`Month select element with ID "${elementId}" not found`);
            return;
        }
        
        // Clear existing options except the first one
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add months
        const months = [
            { value: '01', name: 'January' },
            { value: '02', name: 'February' },
            { value: '03', name: 'March' },
            { value: '04', name: 'April' },
            { value: '05', name: 'May' },
            { value: '06', name: 'June' },
            { value: '07', name: 'July' },
            { value: '08', name: 'August' },
            { value: '09', name: 'September' },
            { value: '10', name: 'October' },
            { value: '11', name: 'November' },
            { value: '12', name: 'December' }
        ];
        
        months.forEach(month => {
            const option = document.createElement('option');
            option.value = month.value;
            option.textContent = month.name;
            select.appendChild(option);
        });
    }
    
    // Populate years dropdown
    function populateYears(elementId) {
        const select = document.getElementById(elementId);
        if (!select) {
            console.error(`Year select element with ID "${elementId}" not found`);
            return;
        }
        
        // Clear existing options except the first one
        while (select.options.length > 1) {
            select.remove(1);
        }
        
        // Add years (current year - 80 to current year - 18)
        const currentYear = new Date().getFullYear();
        for (let i = currentYear - 18; i >= currentYear - 80; i--) {
            const option = document.createElement('option');
            option.value = i.toString();
            option.textContent = i;
            select.appendChild(option);
        }
    }

    // Initialize the application
    function init() {
        console.log('Initializing application...');
        
        try {
            // Check login status
            checkLoginStatus();
            
            // Populate date dropdowns
            populateDateDropdowns();
            
            // Add event listeners if elements exist
            if (sendOtpBtn) sendOtpBtn.addEventListener('click', sendOTP);
            if (verifyOtpBtn) verifyOtpBtn.addEventListener('click', verifyOTP);
            if (resendOtpBtn) resendOtpBtn.addEventListener('click', sendOTP);
            if (createProfileBtn) createProfileBtn.addEventListener('click', createProfile);
            if (userIcon) userIcon.addEventListener('click', handleUserIconClick);
            if (logoutBtn) logoutBtn.addEventListener('click', logout);
            if (cartIcon) cartIcon.addEventListener('click', toggleCart);
            if (searchIcon) searchIcon.addEventListener('click', openSearchModal);
            if (closeCartButton) closeCartButton.addEventListener('click', toggleCart);
            if (overlay) overlay.addEventListener('click', closeAllModals);
            if (checkoutBtn) checkoutBtn.addEventListener('click', handleCheckout);
            if (searchBtn) searchBtn.addEventListener('click', performSearch);
            
            // Profile image upload handler
            if (profileImageInput) {
                profileImageInput.addEventListener('change', handleProfileImageChange);
            }
            
            // Edit name functionality
            if (editNameBtn) {
                editNameBtn.addEventListener('click', openNameEditModal);
            }
            if (closeNameEdit) closeNameEdit.addEventListener('click', closeNameEditModal);
            if (cancelNameEdit) cancelNameEdit.addEventListener('click', closeNameEditModal);
            if (nameEditForm) nameEditForm.addEventListener('submit', saveNameEdit);
            
            // Profile details modal
            if (myProfileLink) {
                myProfileLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openProfileDetailsModal();
                });
            }
            if (closeProfileDetails) closeProfileDetails.addEventListener('click', closeProfileDetailsModal);
            
            // Edit profile modal
            if (editProfileBtn) editProfileBtn.addEventListener('click', openEditProfileModal);
            if (closeEditProfile) closeEditProfile.addEventListener('click', closeEditProfileModal);
            if (cancelEditProfile) cancelEditProfile.addEventListener('click', closeEditProfileModal);
            if (editProfileForm) editProfileForm.addEventListener('submit', saveProfileEdit);
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (profileDropdown && 
                    profileDropdown.style.display === 'block' && 
                    !e.target.closest('.profile-container')) {
                    profileDropdown.style.display = 'none';
                }
            });
            
            // Close modal buttons
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    closeModal(modal);
                });
            });
            
            // Search on Enter key
            if (searchInput) {
                searchInput.addEventListener('keyup', function(event) {
                    if (event.key === 'Enter') {
                        performSearch();
                    }
                });
            }
            
            console.log('Application initialized successfully');
        } catch (error) {
            console.error('Error initializing application:', error);
        }
    }

    // Initialize mobile menu functionality
    function initMobileMenu() {
        console.log('Initializing mobile menu');
        
        const menuToggle = document.querySelector('.menu-toggle');
        const navContainer = document.querySelector('.nav-container');
        
        if (menuToggle && navContainer) {
            menuToggle.addEventListener('click', () => {
                if (navContainer.style.display === 'block') {
                    navContainer.style.display = 'none';
                    console.log('Mobile menu closed');
                } else {
                    navContainer.style.display = 'block';
                    console.log('Mobile menu opened');
                }
            });
            
            // Handle dropdown on mobile
            const navItems = document.querySelectorAll('.nav-item');
            
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        const hasDropdown = this.querySelector('.dropdown-content');
                        if (hasDropdown) {
                            e.preventDefault();
                            this.classList.toggle('active');
                            console.log('Mobile dropdown toggled');
                        }
                    }
                });
            });
            
            // Responsive adjustments
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    navContainer.style.display = '';
                }
            });
            
            console.log('Mobile menu initialized');
        } else {
            console.error('Mobile menu elements not found');
        }
    }

    // Make functions globally available
    window.addToCart = addToCart;
    window.updateQuantity = updateQuantity;
    window.removeFromCart = removeFromCart;
    window.addToWishlist = addToWishlist;
    window.quickView = quickView;

    // Initialize the application
    init();
    
    // Initialize mobile menu
    initMobileMenu();
});

    </script>
</body>