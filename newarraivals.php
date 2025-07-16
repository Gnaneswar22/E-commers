<?php
// Include database connection
require_once 'admin/config.php';

// Set category for this page
$category = 'new-arrivals';
$category_title = 'New Arrivals';
$category_description = 'Discover our latest collection of premium menswear';

// Create products array directly - no database connection needed
$products = array();

// Create 50+ product entries with images from Unsplash and other free stock sites
$products[] = array('id' => 1, 'name' => 'Premium Linen Shirt', 'price' => 2499, 'image_url' => 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 2, 'name' => 'Classic Oxford Shirt', 'price' => 1999, 'image_url' => 'https://images.unsplash.com/photo-1514222788835-3a1a1d5b32f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 3, 'name' => 'Slim Fit Chinos', 'price' => 2299, 'image_url' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 4, 'name' => 'Casual Denim Jacket', 'price' => 3499, 'image_url' => 'https://images.unsplash.com/photo-1590883359549-b56ef835b3ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 5, 'name' => 'Modern Fit Blazer', 'price' => 4999, 'image_url' => 'https://images.unsplash.com/photo-1570363556581-d5cca5858115?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 6, 'name' => 'Vibrant Polo T-shirt', 'price' => 1699, 'image_url' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 7, 'name' => 'Designer Wool Coat', 'price' => 5999, 'image_url' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 8, 'name' => 'Tailored Suit Jacket', 'price' => 6499, 'image_url' => 'https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 9, 'name' => 'Slim Fit Jeans', 'price' => 2799, 'image_url' => 'https://images.unsplash.com/photo-1527010154944-f2241763d806?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 10, 'name' => 'Premium Cotton Tee', 'price' => 1299, 'image_url' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 11, 'name' => 'Casual Bomber Jacket', 'price' => 3999, 'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 12, 'name' => 'Designer Cardigan', 'price' => 2899, 'image_url' => 'https://images.unsplash.com/photo-1516826957135-700dedea698c?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 13, 'name' => 'Linen Summer Shorts', 'price' => 1899, 'image_url' => 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 14, 'name' => 'Lightweight Sweater', 'price' => 2399, 'image_url' => 'https://images.unsplash.com/photo-1608063615781-e2ef8c73d114?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 15, 'name' => 'Casual Hoodie', 'price' => 2199, 'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 16, 'name' => 'Designer Sunglasses', 'price' => 1599, 'image_url' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 17, 'name' => 'Premium Leather Belt', 'price' => 1799, 'image_url' => 'https://images.unsplash.com/photo-1603252109360-909baaf261c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 18, 'name' => 'Formal Dress Shoes', 'price' => 4299, 'image_url' => 'https://images.unsplash.com/photo-1533867617858-e7b97cee4eb7?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 19, 'name' => 'Casual Sneakers', 'price' => 3299, 'image_url' => 'https://images.unsplash.com/photo-1527010673457-b5e6e8a85b1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 20, 'name' => 'Designer Watch', 'price' => 8999, 'image_url' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 21, 'name' => 'Leather Wallet', 'price' => 1499, 'image_url' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 22, 'name' => 'Slim Fit Trousers', 'price' => 2599, 'image_url' => 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 23, 'name' => 'Patterned Socks', 'price' => 699, 'image_url' => 'https://images.unsplash.com/photo-1586350977771-2a1dc0c3451d?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 24, 'name' => 'Leather Brogues', 'price' => 4599, 'image_url' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 25, 'name' => 'Vintage Denim Shirt', 'price' => 2199, 'image_url' => 'https://images.unsplash.com/photo-1589992896844-9b720813d1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 26, 'name' => 'Casual Checkered Shirt', 'price' => 1899, 'image_url' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 27, 'name' => 'Tailored Waistcoat', 'price' => 3299, 'image_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 28, 'name' => 'Casual Loafers', 'price' => 3599, 'image_url' => 'https://images.unsplash.com/photo-1573100925118-870b8efc799d?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 29, 'name' => 'Lightweight Jacket', 'price' => 2999, 'image_url' => 'https://images.unsplash.com/photo-1551028719-8f2b1fdf5d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 30, 'name' => 'Designer Cufflinks', 'price' => 1299, 'image_url' => 'https://images.unsplash.com/photo-1591076682663-f868b0ecb4e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 31, 'name' => 'Casual Beanie', 'price' => 899, 'image_url' => 'https://images.unsplash.com/photo-1520903074185-9f5e24990142?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 32, 'name' => 'Premium Scarf', 'price' => 1499, 'image_url' => 'https://images.unsplash.com/photo-1520975954732-35dd22299614?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 33, 'name' => 'Leather Gloves', 'price' => 1899, 'image_url' => 'https://images.unsplash.com/photo-1548883354-94bcfe321cbb?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 34, 'name' => 'Slim Fit Polo', 'price' => 1599, 'image_url' => 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 35, 'name' => 'Designer Tie', 'price' => 1299, 'image_url' => 'https://images.unsplash.com/photo-1591696205602-2f950c417cb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 36, 'name' => 'Casual Cap', 'price' => 999, 'image_url' => 'https://images.unsplash.com/photo-1556306535-0f09a537f0a3?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 37, 'name' => 'Slim Fit Henley', 'price' => 1799, 'image_url' => 'https://images.unsplash.com/photo-1617196701537-7329482cc9fe?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 38, 'name' => 'Designer Backpack', 'price' => 3499, 'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 39, 'name' => 'Formal Bow Tie', 'price' => 999, 'image_url' => 'https://images.unsplash.com/photo-1589903308904-1010c2294adc?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 40, 'name' => 'Casual Messenger Bag', 'price' => 2999, 'image_url' => 'https://images.unsplash.com/photo-1623113562225-694f6a2ee75e?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 41, 'name' => 'Premium Leather Boots', 'price' => 5499, 'image_url' => 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 42, 'name' => 'Graphic T-Shirt', 'price' => 1399, 'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 43, 'name' => 'Casual Slip-ons', 'price' => 2499, 'image_url' => 'https://images.unsplash.com/photo-1560243563-062bfc001d68?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 44, 'name' => 'Slim Fit Blazer', 'price' => 4999, 'image_url' => 'https://images.unsplash.com/photo-1617196034183-421b4917c92d?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 45, 'name' => 'Casual Button-Up', 'price' => 1999, 'image_url' => 'https://images.unsplash.com/photo-1593757147298-e064ed1419e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 46, 'name' => 'Premium Joggers', 'price' => 2299, 'image_url' => 'https://images.unsplash.com/photo-1552331872-0f9b8c0c3518?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 47, 'name' => 'Designer Bracelet', 'price' => 1199, 'image_url' => 'https://images.unsplash.com/photo-1618018352910-72bdafdc82a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 48, 'name' => 'Casual Sweatshirt', 'price' => 1999, 'image_url' => 'https://images.unsplash.com/photo-1611010344444-5f9e4d86a6e1?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 49, 'name' => 'Premium Swim Shorts', 'price' => 1599, 'image_url' => 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
$products[] = array('id' => 50, 'name' => 'Designer Glasses', 'price' => 2499, 'image_url' => 'https://images.unsplash.com/photo-1599837565318-25315069a19c?ixlib=rb-4.0.3&auto=format&fit=crop&w=634&q=80', 'is_new' => true, 'is_sale' => false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo \$category_title; ?> | MENWEAR</title>
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

        .main-nav li a:hover,
        .main-nav li a.active {
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

        .dropdown-content a:hover,
        .dropdown-content a.active {
            background-color: #f9f9f9;
            color: #b18b5f;
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
            color: #666

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

        /* Product Grid Styles */
        .featured-products {
            padding: 80px 0;
            background-color: #f9f9f9;
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
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
            border-radius: 3px;
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
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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
            color: #333;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            font-size: 18px;
            color: #b18b5f;
            font-weight: 600;
        }

        /* Filter Section */
        .filter-section {
            background-color: #fff;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 30px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-options {
            display: flex;
            align-items: center;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 500;
            margin-right: 15px;
        }

        .filter-select {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 15px;
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: #b18b5f;
        }

        .product-count {
            font-size: 14px;
            color: #777;
        }

        /* Breadcrumb */
        .breadcrumb {
            margin-bottom: 30px;
            font-size: 14px;
            color: #777;
        }

        .breadcrumb a {
            color: #333;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #b18b5f;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .pagination-item {
            margin: 0 5px;
        }

        .pagination-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .pagination-link:hover,
        .pagination-link.active {
            background-color: #b18b5f;
            color: white;
            border-color: #b18b5f;
        }

        /* Newsletter */
        .newsletter {
            padding: 80px 0;
            background-color: #f9f9f9;
            text-align: center;
            border-top: 1px solid #eee;
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
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
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
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
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

        /* Empty Message */
        .empty-message {
            text-align: center;
            padding: 50px 0;
            color: #777;
            font-size: 16px;
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

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-top {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .product-count {
                margin-top: 15px;
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
            
            .filter-options {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-select {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-input {
                border-right: 1px solid #ddd;
                border-bottom: none;
                margin-bottom: 10px;
                border-radius: 4px;
            }
            
            .newsletter-btn {
                border-radius: 4px;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-top {
                grid-template-columns: 1fr;
            }
            
            .pagination-link {
                width: 35px;
                height: 35px;
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
                    <li class="nav-item"><a href="new-arrivals.php" class="active">New Arrivals</a></li>
                    <li class="nav-item">
                        <a href="shirts.php">Shirts</a>
                        <div class="dropdown-content">
                            <a href="shirts.php?subcategory=formal-shirts">Formal Shirts</a>
                            <a href="shirts.php?subcategory=casual-shirts">Casual Shirts</a>
                            <a href="shirts.php?subcategory=linen-shirts">Linen Shirts</a>
                            <a href="shirts.php?subcategory=oxford-shirts">Oxford Shirts</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="t-shirts.php">T-Shirts</a>
                        <div class="dropdown-content">
                            <a href="t-shirts.php?subcategory=polo-t-shirts">Polo T-Shirts</a>
                            <a href="t-shirts.php?subcategory=crew-neck">Crew Neck</a>
                            <a href="t-shirts.php?subcategory=henley">Henley</a>
                            <a href="t-shirts.php?subcategory=graphic-tees">Graphic Tees</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="trousers.php">Trousers</a>
                        <div class="dropdown-content">
                            <a href="trousers.php?subcategory=chinos">Chinos</a>
                            <a href="trousers.php?subcategory=formal-trousers">Formal Trousers</a>
                            <a href="trousers.php?subcategory=shorts">Shorts</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="jeans.php">Jeans</a></li>
                    <li class="nav-item">
                        <a href="collections.php">Collections</a>
                        <div class="dropdown-content">
                            <a href="collections.php?subcategory=summer-layering">Summer Layering</a>
                            <a href="collections.php?subcategory=resort-wear">Resort Wear</a>
                            <a href="collections.php?subcategory=workwear">Workwear</a>
                            <a href="collections.php?subcategory=travel-fashion">Travel & Fashion</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="sale.php">Sale</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-content">
            <h1><?php echo \$category_title; ?></h1>
            <p><?php echo \$category_description; ?></p>
            <div class="buttons">
                <a href="#products" class="btn">Shop Now</a>
                <a href="about.php" class="btn btn-outline">Our Story</a>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-container">
                <div class="filter-options">
                    <span class="filter-label">Sort By:</span>
                    <select class="filter-select">
                        <option value="newest">Newest First</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="popularity">Popularity</option>
                    </select>
                    
                    <span class="filter-label">Filter:</span>
                    <select class="filter-select">
                        <option value="all">All Products</option>
                        <option value="shirts">Shirts</option>
                        <option value="t-shirts">T-Shirts</option>
                        <option value="trousers">Trousers</option>
                        <option value="jeans">Jeans</option>
                        <option value="accessories">Accessories</option>
                    </select>
                </div>
                
                <div class="product-count">
                    Showing <?php echo count(\$products); ?> products
                </div>
            </div>
        </div>
    </section>

    <!-- Product Listing -->
    <section id="products" class="featured-products">
        <div class="container">
            <div class="section-title">
                <h2>Latest Arrivals</h2>
            </div>
            
            <div class="product-grid">
                <?php foreach($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo \$product['id']; ?>">
                    <div class="product-image">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        <?php if(\$product['is_new']): ?>
                            <span class="product-badge">New</span>
                        <?php elseif(\$product['is_sale']): ?>
                            <span class="product-badge">Sale</span>
                        <?php endif; ?>
                        <div class="product-actions">
                            <div class="product-action-btn" onclick="addToWishlist(<?php echo \$product['id']; ?>)">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="product-action-btn" onclick="addToCart(<?php echo \$product['id']; ?>)">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="product-action-btn" onclick="quickView(<?php echo \$product['id']; ?>)">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo \$product['name']; ?></h3>
                        <p class="product-price">₹<?php echo number_format(\$product['price']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-item">
                    <a href="#" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
                </div>
                <div class="pagination-item">
                    <a href="#" class="pagination-link active">1</a>
                </div>
                <div class="pagination-item">
                    <a href="#" class="pagination-link">2</a>
                </div>
                <div class="pagination-item">
                    <a href="#" class="pagination-link">3</a>
                </div>
                <div class="pagination-item">
                    <a href="#" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
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
                        <li><a href="new-arrivals.php">New Arrivals</a></li>
                        <li><a href="shirts.php">Shirts</a></li>
                        <li><a href="t-shirts.php">T-Shirts</a></li>
                        <li><a href="trousers.php">Trousers</a></li>
                        <li><a href="jeans.php">Jeans</a></li>
                        <li><a href="sale.php">Sale</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>Collections</h4>
                    <ul class="footer-links">
                        <li><a href="collections.php?subcategory=summer-layering">Summer Layering</a></li>
                        <li><a href="collections.php?subcategory=resort-wear">Resort Wear</a></li>
                        <li><a href="collections.php?subcategory=workwear">Workwear</a></li>
                        <li><a href="collections.php?subcategory=travel-fashion">Travel & Fashion</a></li>
                        <li><a href="collections.php?subcategory=oxford-classics">Classic Oxfords</a></li>
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

    <!-- JavaScript for basic functionality -->
    <script>
        // Wait for the DOM to be fully loaded before running any code
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed');
            
            // Get DOM elements
            const userIcon = document.getElementById('user-icon');
            const profileDropdown = document.getElementById('profileDropdown');
            const searchIcon = document.getElementById('search-icon');
            const cartIcon = document.getElementById('cart-icon');
            const menuToggle = document.querySelector('.menu-toggle');
            const navContainer = document.querySelector('.nav-container');
            const cartCount = document.querySelector('.cart-count');
            
            // Demo products data - this would normally come from your database
            const demoProducts = <?php echo json_encode($products); ?>;

            // Toggle mobile menu
            if (menuToggle && navContainer) {
                menuToggle.addEventListener('click', function() {
                    if (navContainer.style.display === 'block') {
                        navContainer.style.display = 'none';
                    } else {
                        navContainer.style.display = 'block';
                    }
                });
            }
            
            // Toggle profile dropdown
            if (userIcon && profileDropdown) {
                userIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (profileDropdown.style.display === 'block') {
                        profileDropdown.style.display = 'none';
                    } else {
                        profileDropdown.style.display = 'block';
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.profile-container') && profileDropdown.style.display === 'block') {
                        profileDropdown.style.display = 'none';
                    }
                });
            }
            
            // Handle cart icon click
            if (cartIcon) {
                cartIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Cart functionality will be implemented here');
                });
            }
            
            // Handle search icon click
            if (searchIcon) {
                searchIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Search functionality will be implemented here');
                });
            }
            
            // Add to cart functionality
            window.addToCart = function(productId) {
                console.log('Adding product to cart:', productId);
                
                // Simulate adding to cart
                const product = demoProducts.find(p => p.id === productId);
                if (product) {
                    // Update cart count
                    const currentCount = parseInt(cartCount.textContent || '0');
                    cartCount.textContent = currentCount + 1;
                    
                    // Show confirmation
                    alert(`Added ${product.name} to your cart!`);
                }
            };
            
            // Add to wishlist functionality
            window.addToWishlist = function(productId) {
                console.log('Adding product to wishlist:', productId);
                
                // Simulate adding to wishlist
                const product = demoProducts.find(p => p.id === productId);
                if (product) {
                    // Show confirmation
                    alert(`Added ${product.name} to your wishlist!`);
                }
            };
            
            // Quick view functionality
            window.quickView = function(productId) {
                console.log('Quick view for product:', productId);
                
                // Simulate quick view
                const product = demoProducts.find(p => p.id === productId);
                if (product) {
                    // Show product details
                    alert(`Quick View: ${product.name}\nPrice: ₹${product.price}\nNew Arrival: ${product.is_new ? 'Yes' : 'No'}`);
                }
            };
            
            // Filter functionality
            const filterSelects = document.querySelectorAll('.filter-select');
            if (filterSelects.length > 0) {
                filterSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        alert(`Filter changed to: ${this.value}\nThis would normally filter the products`);
                    });
                });
            }
            
            // Pagination functionality
            const paginationLinks = document.querySelectorAll('.pagination-link');
            if (paginationLinks.length > 0) {
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Remove active class from all links
                        paginationLinks.forEach(l => l.classList.remove('active'));
                        
                        // Add active class to clicked link
                        this.classList.add('active');
                        
                        // This would normally load the next page of products
                        if (!this.querySelector('i')) {
                            alert(`Navigating to page ${this.textContent}`);
                        }
                    });
                });
            }
            
            // Newsletter form submission
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const emailInput = this.querySelector('.newsletter-input');
                    const email = emailInput.value.trim();
                    
                    if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        alert(`Thank you for subscribing with: ${email}`);
                        emailInput.value = '';
                    } else {
                        alert('Please enter a valid email address');
                    }
                });
            }
            
            // Responsive handling for window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && navContainer) {
                    navContainer.style.display = '';
                }
            });
            
            console.log('JavaScript initialization complete');
        });
    </script>
</body>
</html>