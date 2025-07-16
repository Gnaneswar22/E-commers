<?php
require_once 'admin/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $query = isset($data['query']) ? $data['query'] : '';
    
    if (empty($query)) {
        echo json_encode(['success' => false, 'message' => 'Search query is required']);
        exit;
    }
    
    // Search in products
    $search_term = "%" . $query . "%";
    
    // Get primary search results
    $stmt = $conn->prepare("
        SELECT id, name, description, price, image, category, subcategory, color, stock 
        FROM products 
        WHERE name LIKE ? OR description LIKE ? OR category LIKE ? OR subcategory LIKE ? OR color LIKE ?
        ORDER BY is_featured DESC, name ASC
        LIMIT 20
    ");
    $stmt->bind_param("sssss", $search_term, $search_term, $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $primary_products = [];
    $categories = [];
    $subcategories = [];
    $colors = [];
    
    while ($row = $result->fetch_assoc()) {
        $primary_products[] = $row;
        
        // Collect unique categories, subcategories, and colors
        if (!in_array($row['category'], $categories)) {
            $categories[] = $row['category'];
        }
        if (!in_array($row['subcategory'], $subcategories)) {
            $subcategories[] = $row['subcategory'];
        }
        if (!in_array($row['color'], $colors)) {
            $colors[] = $row['color'];
        }
    }
    
    // Get related products based on categories, subcategories, and colors found
    $related_products = [];
    
    if (!empty($categories) || !empty($subcategories) || !empty($colors)) {
        $sql = "SELECT id, name, description, price, image, category, subcategory, color, stock 
                FROM products WHERE ";
        
        $conditions = [];
        $params = [];
        $types = "";
        
        if (!empty($categories)) {
            $placeholders = str_repeat('?,', count($categories) - 1) . '?';
            $conditions[] = "category IN ($placeholders)";
            $params = array_merge($params, $categories);
            $types .= str_repeat('s', count($categories));
        }
        
        if (!empty($subcategories)) {
            $placeholders = str_repeat('?,', count($subcategories) - 1) . '?';
            $conditions[] = "subcategory IN ($placeholders)";
            $params = array_merge($params, $subcategories);
            $types .= str_repeat('s', count($subcategories));
        }
        
        if (!empty($colors)) {
            $placeholders = str_repeat('?,', count($colors) - 1) . '?';
            $conditions[] = "color IN ($placeholders)";
            $params = array_merge($params, $colors);
            $types .= str_repeat('s', count($colors));
        }
        
        $sql .= implode(' OR ', $conditions);
        $sql .= " ORDER BY is_featured DESC, name ASC LIMIT 40"; // Get more related products
        
        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Collect related products that are not in primary results
        $primary_ids = array_column($primary_products, 'id');
        while ($row = $result->fetch_assoc()) {
            if (!in_array($row['id'], $primary_ids)) {
                $related_products[] = $row;
            }
        }
    }
    
    // Group products by category for better organization
    $grouped_results = [
        'primary' => $primary_products,
        'related' => $related_products
    ];
    
    echo json_encode([
        'success' => true,
        'results' => $grouped_results,
        'count' => [
            'primary' => count($primary_products),
            'related' => count($related_products),
            'total' => count($primary_products) + count($related_products)
        ]
    ]);
}
?>