<?php
require_once 'admin/config.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
// Remove in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get the search query from POST data
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['query'])) {
            echo json_encode(['success' => false, 'message' => 'Search query is required']);
            exit;
        }
        
        $query = $data['query'];
        
        // Get optional filters
        $category = isset($data['category']) ? $data['category'] : null;
        $subcategory = isset($data['subcategory']) ? $data['subcategory'] : null;
        $color = isset($data['color']) ? $data['color'] : null;
        $min_price = isset($data['min_price']) ? floatval($data['min_price']) : null;
        $max_price = isset($data['max_price']) ? floatval($data['max_price']) : null;
        $sort = isset($data['sort']) ? $data['sort'] : 'relevance';
        
        // Build the base query
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";
        
        // Add search conditions
        if (!empty($query)) {
            $search_term = "%" . $query . "%";
            $sql .= " AND (name LIKE ? OR description LIKE ? OR category LIKE ? OR subcategory LIKE ?)";
            $params = array_merge($params, [$search_term, $search_term, $search_term, $search_term]);
            $types .= "ssss";
        }
        
        // Add filters
        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }
        
        if (!empty($subcategory)) {
            $sql .= " AND subcategory = ?";
            $params[] = $subcategory;
            $types .= "s";
        }
        
        if (!empty($color)) {
            $sql .= " AND color = ?";
            $params[] = $color;
            $types .= "s";
        }
        
        if (!empty($min_price)) {
            $sql .= " AND price >= ?";
            $params[] = $min_price;
            $types .= "d";
        }
        
        if (!empty($max_price)) {
            $sql .= " AND price <= ?";
            $params[] = $max_price;
            $types .= "d";
        }
        
        // Add sorting
        switch ($sort) {
            case 'price_low':
                $sql .= " ORDER BY price ASC";
                break;
            case 'price_high':
                $sql .= " ORDER BY price DESC";
                break;
            case 'newest':
                $sql .= " ORDER BY id DESC";
                break;
            case 'featured':
                $sql .= " ORDER BY is_featured DESC, name ASC";
                break;
            default:
                // Default sort by relevance (featured first, then alphabetically)
                $sql .= " ORDER BY is_featured DESC, name ASC";
        }
        
        // Add limit
        $sql .= " LIMIT 24";
        
        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch products
        $products = [];
        while ($row = $result->fetch_assoc()) {
            // Format price for display
            $row['formatted_price'] = number_format($row['price'], 2);
            $products[] = $row;
        }
        
        // Get available filters
        $filters = [
            'categories' => [],
            'subcategories' => [],
            'colors' => [],
            'price_range' => [
                'min' => 0,
                'max' => 0
            ]
        ];
        
        // If we found products, get available filters
        if (!empty($products)) {
            // Get categories
            $cat_sql = "SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category";
            $cat_result = $conn->query($cat_sql);
            while ($row = $cat_result->fetch_assoc()) {
                $filters['categories'][] = $row['category'];
            }
            
            // Get subcategories
            $subcat_sql = "SELECT DISTINCT subcategory FROM products WHERE subcategory IS NOT NULL AND subcategory != '' ORDER BY subcategory";
            $subcat_result = $conn->query($subcat_sql);
            while ($row = $subcat_result->fetch_assoc()) {
                $filters['subcategories'][] = $row['subcategory'];
            }
            
            // Get colors
            $color_sql = "SELECT DISTINCT color FROM products WHERE color IS NOT NULL AND color != '' ORDER BY color";
            $color_result = $conn->query($color_sql);
            while ($row = $color_result->fetch_assoc()) {
                $filters['colors'][] = $row['color'];
            }
            
            // Get price range
            $price_sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM products";
            $price_result = $conn->query($price_sql);
            $price_row = $price_result->fetch_assoc();
            $filters['price_range']['min'] = floatval($price_row['min_price']);
            $filters['price_range']['max'] = floatval($price_row['max_price']);
        }
        
        // Get related products if the search is specific enough
        $related_products = [];
        if (!empty($products) && count($products) < 10 && !empty($query)) {
            // Get categories and subcategories from search results
            $result_categories = array_unique(array_column($products, 'category'));
            $result_subcategories = array_unique(array_column($products, 'subcategory'));
            
            if (!empty($result_categories) || !empty($result_subcategories)) {
                $related_sql = "SELECT * FROM products WHERE 1=0";
                
                if (!empty($result_categories)) {
                    $placeholders = str_repeat('?,', count($result_categories) - 1) . '?';
                    $related_sql .= " OR category IN ($placeholders)";
                }
                
                if (!empty($result_subcategories)) {
                    $placeholders = str_repeat('?,', count($result_subcategories) - 1) . '?';
                    $related_sql .= " OR subcategory IN ($placeholders)";
                }
                
                // Exclude products already in main results
                $product_ids = array_column($products, 'id');
                if (!empty($product_ids)) {
                    $placeholders = str_repeat('?,', count($product_ids) - 1) . '?';
                    $related_sql .= " AND id NOT IN ($placeholders)";
                }
                
                $related_sql .= " ORDER BY is_featured DESC, RAND() LIMIT 8";
                
                $related_params = array_merge($result_categories, $result_subcategories, $product_ids);
                $related_types = str_repeat('s', count($result_categories)) . 
                                str_repeat('s', count($result_subcategories)) .
                                str_repeat('i', count($product_ids));
                
                $related_stmt = $conn->prepare($related_sql);
                if (!empty($related_params)) {
                    $related_stmt->bind_param($related_types, ...$related_params);
                }
                
                $related_stmt->execute();
                $related_result = $related_stmt->get_result();
                
                while ($row = $related_result->fetch_assoc()) {
                    // Format price for display
                    $row['formatted_price'] = number_format($row['price'], 2);
                    $related_products[] = $row;
                }
            }
        }
        
        // Return results
        echo json_encode([
            'success' => true,
            'query' => $query,
            'products' => $products,
            'related_products' => $related_products,
            'filters' => $filters,
            'count' => count($products),
            'related_count' => count($related_products)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Use POST.'
    ]);
}
?>