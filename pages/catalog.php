<html>
<?php
?>

<head>
    <?php require_once('../components/head.php'); ?>
    <title>Catalog</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        img {
            box-sizing: border-box;
            object-fit: contain;
            width: 434px;
            height: 434px;
        }

        p {
            margin-bottom: 3px;
        }

        .width-100 {
            width: 100%;
        }

        .body {
            display: flex;
        }

        .sidebar {
            width: 310px;
            flex-shrink: 0;
            padding: 16px;
            border-right: 1px solid gray;
        }

        .card {
            padding: 16px;
            margin: 16px;
            width: 450px;
        }

        .form-group {
            margin-top: 10px;
        }

        .flex-space-between {
            display: flex;
            justify-content: space-between;
        }

        .product-display {
            padding: 32px;
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <?php require_once('../components/nav.php'); ?>
    <div class="body">
        <form class='sidebar' action="catalog.php" method="get">
            <div class="container mt-2">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter name...">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" class="form-control" placeholder="Enter description...">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" class="form-control" min="0" placeholder="Enter price...">
                </div>
                <div class="form-group">
                    <label for="sku">SKU:</label>
                    <input type="text" id="sku" name="sku" class="form-control" placeholder="Enter SKU...">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <div class="form-check">
                        <input type="radio" id="men" name="gender" value="men">
                        <label for="male">Men's</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="women" name="gender" value="women">
                        <label for="female">Women's</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">Select category...</option>
                        <option value="pants">Pants</option>
                        <option value="shirts">Shirts</option>
                        <option value="hoodies">Hoodies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <select id="brand" name="brand" class="form-select">
                        <option value="">Select brand...</option>
                        <option value="nike">Nike</option>
                        <option value="adidas">Adidas</option>
                        <option value="puma">Puma</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" value="Search" class="btn btn-primary mt-4">Search</button> <br>
                    <small class="form-text align-middle mt-3 d-inline-block">Leave fields blank to search all</small>
                </div>
            </div>
        </form>
        <div class="product-display">
            <?php
            require_once('../php/products.php');

            // Sanitize user input
            function sanitizeInput($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (isset($_GET["submit"])) {

                // Sanitize each input variable using the function
                $name = sanitizeInput($_GET["name"]);
                $description = sanitizeInput($_GET["description"]);
                $price = sanitizeInput($_GET["price"]);
                $sku = sanitizeInput($_GET["sku"]);
                $gender = isset($_GET["gender"]) ? sanitizeInput($_GET["gender"]) : "";
                $category = sanitizeInput($_GET["category"]);
                $brand = sanitizeInput($_GET["brand"]);

                $querry = "SELECT product_name, product_description, product_price, product_inventory, product_sku, product_gender, product_category, product_brand, product_image FROM products WHERE 1";
                $params = [];

                // Add name condition
                if ($name != "") {
                    $querry .= " AND product_name LIKE :name";
                    $params[":name"] = "%$name%";
                }
                // Add description condition
                if ($description != "") {
                    $querry .= " AND product_description LIKE :description";
                    $params[":description"] = "%$description%";
                }
                // Add price condition
                if ($price != "") {
                    $querry .= " AND product_price <= :price";
                    $params[":price"] = $price;
                }
                // Add sku condition
                if ($sku != "") {
                    $querry .= " AND product_sku = :sku";
                    $params[":sku"] = $sku;
                }
                // Add gender condition
                if ($gender != "") {
                    $querry .= " AND product_gender = :gender";
                    $params[":gender"] = $gender;
                }
                // Add category condition
                if ($category != "") {
                    $querry .= " AND product_category = :category";
                    $params[":category"] = $category;
                }
                // Add brand condition
                if ($brand != "") {
                    $querry .= " AND product_brand = :brand";
                    $params[":brand"] = $brand;
                }

                $stmt = $db->prepare($querry);
                $stmt->execute($params);

                // display results
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                        <div class="card">
                            <div class="card-image">
                                <img class="width-100" src="' . $row["product_image"] . 'alt="Product Image">
                            </div>
                            <div class="card-text">
                                <hr>
                                <h3>' . $row["product_name"] . '</h3>
                                <p>' . $row["product_category"] . '/' . $row["product_gender"] . '</p>
                                <p>' . $row["product_brand"] . '</p>
                                <div class="flex-space-between">
                                    <h3>$' . $row["product_price"] . '</h3>
                                    <form method="get">
                                        <input type="hidden" name="product_sku" value="' . $row["product_sku"] . '">
                                        <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<h1>No results found</h1>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>