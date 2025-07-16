<?php
require_once 'admin/config.php';

// Array of sample products with more variety and colors
\$products = [
    // SHIRTS - Multiple colors and styles
    [
        'name' => 'Pure Linen Shirt - Blue',
        'description' => 'Premium quality linen shirt perfect for summer days. Breathable fabric with a comfortable fit.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Linen Shirts',
        'color' => 'Blue',
        'stock' => 50,
        'is_featured' => 1
    ],
    [
        'name' => 'Pure Linen Shirt - White',
        'description' => 'Premium quality linen shirt perfect for summer days. Breathable fabric with a comfortable fit.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1598961942613-ba897716405b?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Linen Shirts',
        'color' => 'White',
        'stock' => 45,
        'is_featured' => 0
    ],
    [
        'name' => 'Pure Linen Shirt - Beige',
        'description' => 'Premium quality linen shirt perfect for summer days. Breathable fabric with a comfortable fit.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Linen Shirts',
        'color' => 'Beige',
        'stock' => 30,
        'is_featured' => 0
    ],
    [
        'name' => 'Classic Oxford Shirt - White',
        'description' => 'Timeless oxford shirt perfect for formal occasions. Tailored fit with premium cotton fabric.',
        'price' => 1999,
        'image' => 'https://images.unsplash.com/photo-1514222788835-3a1a1d5b32f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Oxford Shirts',
        'color' => 'White',
        'stock' => 40,
        'is_featured' => 1
    ],
    [
        'name' => 'Classic Oxford Shirt - Blue',
        'description' => 'Timeless oxford shirt perfect for formal occasions. Tailored fit with premium cotton fabric.',
        'price' => 1999,
        'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Oxford Shirts',
        'color' => 'Blue',
        'stock' => 35,
        'is_featured' => 0
    ],
    [
        'name' => 'Formal Shirt - Light Blue',
        'description' => 'Classic formal shirt for professional settings. Made from premium cotton fabric.',
        'price' => 1899,
        'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Formal Shirts',
        'color' => 'Light Blue',
        'stock' => 40,
        'is_featured' => 0
    ],
    [
        'name' => 'Formal Shirt - White',
        'description' => 'Classic formal shirt for professional settings. Made from premium cotton fabric.',
        'price' => 1899,
        'image' => 'https://images.unsplash.com/photo-1603252109612-24fa03d145c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Formal Shirts',
        'color' => 'White',
        'stock' => 50,
        'is_featured' => 0
    ],
    [
        'name' => 'Casual Checkered Shirt - Red',
        'description' => 'Comfortable casual shirt with checkered pattern. Perfect for weekend outings.',
        'price' => 1799,
        'image' => 'https://images.unsplash.com/photo-1608744882201-52a7f7f3dd60?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Casual Shirts',
        'color' => 'Red',
        'stock' => 30,
        'is_featured' => 0
    ],
    [
        'name' => 'Casual Checkered Shirt - Blue',
        'description' => 'Comfortable casual shirt with checkered pattern. Perfect for weekend outings.',
        'price' => 1799,
        'image' => 'https://images.unsplash.com/photo-1605216663980-b7ca6e9f2451?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Shirts',
        'subcategory' => 'Casual Shirts',
        'color' => 'Blue',
        'stock' => 25,
        'is_featured' => 0
    ],
    
    // T-SHIRTS - Multiple colors and styles
    [
        'name' => 'Vibrant Polo T-shirt - Red',
        'description' => 'Classic polo t-shirt with vibrant colors. Made from premium cotton for everyday comfort.',
        'price' => 1699,
        'image' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Polo T-Shirts',
        'color' => 'Red',
        'stock' => 75,
        'is_featured' => 1
    ],
    [
        'name' => 'Vibrant Polo T-shirt - Blue',
        'description' => 'Classic polo t-shirt with vibrant colors. Made from premium cotton for everyday comfort.',
        'price' => 1699,
        'image' => 'https://images.unsplash.com/photo-1577133913228-cb37daa5500a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Polo T-Shirts',
        'color' => 'Blue',
        'stock' => 60,
        'is_featured' => 0
    ],
    [
        'name' => 'Vibrant Polo T-shirt - Black',
        'description' => 'Classic polo t-shirt with vibrant colors. Made from premium cotton for everyday comfort.',
        'price' => 1699,
        'image' => 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Polo T-Shirts',
        'color' => 'Black',
        'stock' => 80,
        'is_featured' => 0
    ],
    [
        'name' => 'Crew Neck T-shirt - Black',
        'description' => 'Essential crew neck t-shirt made from soft cotton fabric. Perfect for everyday wear.',
        'price' => 999,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Crew Neck',
        'color' => 'Black',
        'stock' => 100,
        'is_featured' => 0
    ],
    [
        'name' => 'Crew Neck T-shirt - White',
        'description' => 'Essential crew neck t-shirt made from soft cotton fabric. Perfect for everyday wear.',
        'price' => 999,
        'image' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Crew Neck',
        'color' => 'White',
        'stock' => 120,
        'is_featured' => 0
    ],
    [
        'name' => 'Crew Neck T-shirt - Grey',
        'description' => 'Essential crew neck t-shirt made from soft cotton fabric. Perfect for everyday wear.',
        'price' => 999,
        'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Crew Neck',
        'color' => 'Grey',
        'stock' => 90,
        'is_featured' => 0
    ],
    [
        'name' => 'Henley T-shirt - Navy',
        'description' => 'Stylish henley t-shirt with button placket. Comfortable fit for casual occasions.',
        'price' => 1299,
        'image' => 'https://images.unsplash.com/photo-1617113930975-f9c7243ae527?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Henley',
        'color' => 'Navy',
        'stock' => 45,
        'is_featured' => 0
    ],
    [
        'name' => 'Henley T-shirt - Olive',
        'description' => 'Stylish henley t-shirt with button placket. Comfortable fit for casual occasions.',
        'price' => 1299,
        'image' => 'https://images.unsplash.com/photo-1608744882027-92595d803c14?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Henley',
        'color' => 'Olive',
        'stock' => 40,
        'is_featured' => 0
    ],
    [
        'name' => 'Graphic T-shirt - Urban Art',
        'description' => 'Express your style with this unique graphic t-shirt featuring urban art design.',
        'price' => 1199,
        'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'T-Shirts',
        'subcategory' => 'Graphic Tees',
        'color' => 'Black',
        'stock' => 30,
        'is_featured' => 0
    ],
    
    // TROUSERS - Multiple styles and colors
    [
        'name' => 'Cotton Chino Trousers - Beige',
        'description' => 'Classic chino trousers made from premium cotton. Perfect for both casual and semi-formal occasions.',
        'price' => 2299,
        'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Chinos',
        'color' => 'Beige',
        'stock' => 60,
        'is_featured' => 1
    ],
    [
        'name' => 'Cotton Chino Trousers - Navy',
        'description' => 'Classic chino trousers made from premium cotton. Perfect for both casual and semi-formal occasions.',
        'price' => 2299,
        'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Chinos',
        'color' => 'Navy',
        'stock' => 55,
        'is_featured' => 0
    ],
    [
        'name' => 'Cotton Chino Trousers - Olive',
        'description' => 'Classic chino trousers made from premium cotton. Perfect for both casual and semi-formal occasions.',
        'price' => 2299,
        'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Chinos',
        'color' => 'Olive',
        'stock' => 40,
        'is_featured' => 0
    ],
    [
        'name' => 'Formal Trousers - Black',
        'description' => 'Classic formal trousers for professional settings. Tailored fit with premium fabric.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Formal Trousers',
        'color' => 'Black',
        'stock' => 35,
        'is_featured' => 0
    ],
    [
        'name' => 'Formal Trousers - Navy',
        'description' => 'Classic formal trousers for professional settings. Tailored fit with premium fabric.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Formal Trousers',
        'color' => 'Navy',
        'stock' => 30,
        'is_featured' => 0
    ],
    [
        'name' => 'Formal Trousers - Grey',
        'description' => 'Classic formal trousers for professional settings. Tailored fit with premium fabric.',
        'price' => 2499,
        'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Formal Trousers',
        'color' => 'Grey',
        'stock' => 25,
        'is_featured' => 0
    ],
    [
        'name' => 'Casual Shorts - Navy',
        'description' => 'Comfortable casual shorts perfect for summer days. Made from lightweight cotton.',
        'price' => 1499,
        'image' => 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Shorts',
        'color' => 'Navy',
        'stock' => 55,
        'is_featured' => 0
    ],
    [
        'name' => 'Casual Shorts - Beige',
        'description' => 'Comfortable casual shorts perfect for summer days. Made from lightweight cotton.',
        'price' => 1499,
        'image' => 'https://images.unsplash.com/photo-1590400516695-36708d3f964a?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Trousers',
        'subcategory' => 'Shorts',
        'color' => 'Beige',
        'stock' => 50,
        'is_featured' => 0
    ],
    
    // JEANS - Multiple styles and washes
    [
        'name' => 'Denim Jeans - Dark Blue',
        'description' => 'Classic denim jeans with a modern fit. Made from premium denim fabric for durability and comfort.',
        'price' => 2599,
        'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Jeans',
        'subcategory' => 'Slim Fit',
        'color' => 'Dark Blue',
        'stock' => 45,
        'is_featured' => 0
    ],
    [
        'name' => 'Denim Jeans - Light Blue',
        'description' => 'Classic denim jeans with a modern fit. Made from premium denim fabric for durability and comfort.',
        'price' => 2599,
        'image' => 'https://images.unsplash.com/photo-1604176424472-9d69a5b14788?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Jeans',
        'subcategory' => 'Slim Fit',
        'color' => 'Light Blue',
        'stock' => 40,
        'is_featured' => 0
    ],
    [
        'name' => 'Denim Jeans - Black',
        'description' => 'Classic denim jeans with a modern fit. Made from premium denim fabric for durability and comfort.',
        'price' => 2599,
        'image' => 'https://images.unsplash.com/photo-1582552938357-32b906df40cb?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Jeans',
        'subcategory' => 'Slim Fit',
        'color' => 'Black',
        'stock' => 35,
        'is_featured' => 0
    ],
    [
        'name' => 'Straight Fit Jeans - Blue',
        'description' => 'Comfortable straight fit jeans for a classic look. Durable denim with perfect stretch.',
        'price' => 2399,
        'image' => 'https://images.unsplash.com/photo-1555689502-c4b22d76c56f?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Jeans',
        'subcategory' => 'Straight Fit',
        'color' => 'Blue',
        'stock' => 30,
        'is_featured' => 0
    ],
    [
        'name' => 'Relaxed Fit Jeans - Medium Wash',
        'description' => 'Relaxed fit jeans for maximum comfort. Perfect for casual everyday wear.',
        'price' => 2299,
        'image' => 'https://images.unsplash.com/photo-1602293589930-45aad59ba3ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
        'category' => 'Jeans',
        'subcategory' => 'Relaxed Fit',
        'color' => 'Medium Blue',
        'stock' => 25,
        'is_featured' => 0
    ]
];

// First, modify the products table to add color column if it doesn't exist
try {
    \$conn->query("ALTER TABLE products ADD COLUMN IF NOT EXISTS color VARCHAR(50) AFTER subcategory");
    echo "Table modified successfully to include color column.<br>";
} catch (Exception \$e) {
    echo "Error modifying table: " . \$e->getMessage() . "<br>";
}

// Insert products into database
$stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category, subcategory, color, stock, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsssiii", $name, $description, $price, $image, $category, $subcategory, $color, $stock, $is_featured);

\$count = 0;
foreach ($products as $product) {
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $image = $product['image'];
    $category = $product['category'];
    $subcategory = $product['subcategory'];
    $color = $product['color'];
    $stock = $product['stock'];
    $is_featured = $product['is_featured'];
    
    if (\$stmt->execute()) {
        \$count++;
    } else {
        echo "Error adding product: " . \$stmt->error . "<br>";
    }
}

echo "Successfully added \$count products to database.";
\$stmt->close();
\$conn->