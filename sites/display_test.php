<?php

require_once('../php/products.php');

$query = 'SELECT * FROM products';
$stmt = $db->prepare($query);
$stmt->execute();
$fetchedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<br> <br> <br>";

print_r($fetchedProducts);

echo "<br> <br> <br>";

foreach ($fetchedProducts as $fetchedProduct)
{
	echo "name: " . $fetchedProduct['product_name'] . "<br>";
	echo "description: " . $fetchedProduct['product_description'] . "<br>";
	echo "price " . $fetchedProduct['product_price'] . "<br>";
	echo "inventory " . $fetchedProduct['product_inventory'] . "<br>";
	echo "sku: " . $fetchedProduct['product_sku'] . "<br>";
	echo "gender: " . $fetchedProduct['product_gender'] . "<br>";
	echo "category: " . $fetchedProduct['product_category'] . "<br>";
	echo "brand: " . $fetchedProduct['product_brand'] . "<br>";
	echo 'image: ' . "<img src='" . $fetchedProduct['product_image'] . "' width='300' height='300'>" . "<br>";

}
?>