<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700&display=swap" rel="stylesheet">
</head>
<body>
  <form action="display_test.php" method="post">
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-3 col-12">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter name...">
          </div>
        </div>
        <div class="col-md-6 col-12">
          <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" class="form-control" placeholder="Enter description...">
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" min="0" placeholder="Enter price...">
          </div>
        </div>
        <div class="col-md-1 col-12">
          <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" class="form-control" placeholder="Enter SKU...">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-12">
          <div class="form-group">
            <label for="gender">Gender:</label>
            <div class="form-check">
              <input type="radio" id="men" name="gender" value="men">
              <label for="male">Men</label>
            </div>
            <div class="form-check">
              <input type="radio" id="women" name="gender" value="women">
              <label for="female">Women</label>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-12">
          <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" class="form-select">
              <option value="">Select category...</option>
              <option value="pants">Pants</option>
              <option value="shirts">Shirts</option>
              <option value="hoodies">Hoodies</option>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-12">
          <div class="form-group">
            <label for="brand">Brand:</label>
            <select id="brand" name="brand" class="form-select">
              <option value="">Select brand...</option>
              <option value="nike">Nike</option>
              <option value="adidas">Adidas</option>
              <option value="puma">Puma</option>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-12">
          <div class="form-group">
            <button type="submit" name="submit" value="Search" class="btn btn-primary mt-4">Search</button>
			<small class="form-text align-middle mt-3 d-inline-block">Leave fields blank to search all</small>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>
<?php
require_once('../php/products.php');


if (isset($_POST["submit"])) 
{

  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = $_POST["price"];
  $sku = $_POST["sku"];
  $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
  $category = $_POST["category"];
  $brand = $_POST["brand"];


  $querry = "SELECT product_name, product_description, product_price, product_inventory, product_sku, product_gender, product_category, product_brand, product_image FROM products WHERE 1";
  $params = [];
  
  // Add name condition
  if ($name != "") 
  {
    $querry .= " AND product_name LIKE :name";
    $params[":name"] = "%$name%";
  }
  // Add description condition
  if ($description != "") 
  {
    $querry .= " AND product_description LIKE :description";
    $params[":description"] = "%$description%";
  }
  // Add price condition
  if ($price != "") 
  {
    $querry .= " AND product_price <= :price";
    $params[":price"] = $price;
  }
 // Add sku condition
    if ($sku != "") 
  {
    $querry .= " AND product_sku = :sku";
    $params[":sku"] = $sku;
  }
  // Add gender condition
  if ($gender != "") 
  {
    $querry .= " AND product_gender = :gender";
    $params[":gender"] = $gender;
  }
  // Add category condition
  if ($category != "") 
  {
    $querry .= " AND product_category = :category";
    $params[":category"] = $category;
  }
  // Add brand condition
  if ($brand != "") 
  {
    $querry .= " AND product_brand = :brand";
    $params[":brand"] = $brand;
  }

  $stmt = $db->prepare($querry);
  $stmt->execute($params);

  //  display results
  if ($stmt->rowCount() > 0) 
  {
    echo "<h1>Search Results</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Inventory</th><th>SKU</th><th>Gender</th><th>Category</th><th>Brand</th><th>Image</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
      echo "<tr>";
      echo "<td>" . $row["product_name"] . "</td>";
      echo "<td>" . $row["product_description"] . "</td>";
      echo "<td>" . $row["product_price"] . "</td>";
      echo "<td>" . $row["product_inventory"] . "</td>";
      echo "<td>" . $row["product_sku"] . "</td>";
      echo "<td>" . $row["product_gender"] . "</td>";
      echo "<td>" . $row["product_category"] . "</td>";
      echo "<td>" . $row["product_brand"] . "</td>";
      echo "<td><img src='" . $row["product_image"] . "' alt='Product image' width='300' height='400'></td>";
      echo "</tr>";
    }
    echo "</table>";
  } 
  else 
  {
    echo "<h1>No results found</h1>";
  }
}
?>
