<?php
require_once ('API.php');

$products = Commerce\Product::all();

//print_r($products);

echo "<br> <br> <br>";

//$query = file_get_contents('db/clothing_ecommerce.sql');
//$stmt = $db->prepare($query);
//$stmt->execute();

// Prepare the SQL statement
$query = "INSERT INTO products 
(product_name, product_description, product_price, product_inventory, product_sku, product_gender, product_category, product_brand, product_image) 
VALUES (:product_name, :product_description, :product_price, :product_inventory, :product_sku, :product_gender, :product_category, :product_brand, :product_image)
ON DUPLICATE KEY UPDATE product_name = :product_name, product_description = :product_description, product_price = :product_price, 
product_inventory = :product_inventory, product_sku = :product_sku, product_gender = :product_gender, product_category = :product_category, 
product_brand = :product_brand, product_image = :product_image";

$stmt = $db->prepare($query);

foreach ($products['data'] as $product) 
{	
	// Get the product name, id, price, and image from the array
	$name = $product['name'];
	$description = $product['description'];
	$price = $product['price']['raw'];
	$inventory = $product['inventory']['available'];
	$sku = $product['sku'];
	$gender = $product['categories'][0]['name'];
	$category = $product['categories'][1]['name'];
	$brand = $product['categories'][2]['name'];
	$image = $product['image']['url'];
	

	// Bind the values to the placeholders
	$stmt->bindParam(':product_name', $name);
	$stmt->bindParam(':product_description', $description);
	$stmt->bindParam(':product_price', $price);
	$stmt->bindParam(':product_inventory', $inventory);
	$stmt->bindParam(':product_sku', $sku);
	$stmt->bindParam(':product_gender', $gender);
	$stmt->bindParam(':product_category', $category);
	$stmt->bindParam(':product_brand', $brand);
	$stmt->bindParam(':product_image', $image);
	
	// Execute the prepared statement
	$stmt->execute();

	// Print confirmation message
	//echo "Inserted $name into the Products table.<br>";
}
?>