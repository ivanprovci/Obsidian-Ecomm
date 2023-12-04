<!DOCTYPE html>
<html lang="en">

<head>
    <title>Favourites</title>

    <?php
    require_once('../components/head.php');
    require_once('../components/nav.php');
    require_once('../php/favourites_update.php');

    ?>

    <style>
        td,
        th {
            padding-bottom: 25px;
            font-size: 17px;
        }

        th:first-child {
            padding-right: 200px;
        }

        th {
            padding-right: 75px;
        }

        th:last-child {
            padding-right: 0;
        }

        p {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <h1 class='text-center'>Your Favourites</h1><br><br>
    <div class='flex-center'>

        <?php

        $sql = "SELECT product_name, product_price, product_image FROM products WHERE product_sku = :product_sku";
        $stmt = $db->prepare($sql);

        // Check if the favourites is not empty
        if (!empty($_SESSION['favourites']))
        {
            echo "<form method='post'>";
            echo "<table>";
            echo "<tr><th>Product</th><th>Price</th><th>Add to Cart</th><th>Remove</th></tr>";

            //loop through favourites array
            foreach ($_SESSION['favourites'] as $product_sku => $quantity)
            {
                $stmt->execute(array(":product_sku" => $product_sku));

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Display the product name, price, and image
                echo "<tr>";
                echo "<td>" . $row["product_name"] . "<br><img src='" . $row["product_image"] . "' alt='Product image' width='200'></td>";
                echo "<td>$" . number_format($row["product_price"], 2) . "</td>";
                echo "<td><button type='submit' name='add_to_cart' value='$product_sku' class='btn btn-primary'>Add to Cart</button></td>";
                echo "<td><button type='submit' name='remove' value='$product_sku' class='btn btn-danger'>Remove</button></td>";
                echo "</tr>";
            }

            echo "</table><hr>";
            echo "<button type='submit' name='clear' value='clear' class='btn btn-danger'>Clear Favourites</button>";
            echo "</form>";
        }
        
        else
        {
            echo "<p>You have no favourites</p>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['add_to_cart']))
            {
                $product_sku = $_POST['add_to_cart'];
                // Check if the product SKU is already in the cart array
                if (array_key_exists($product_sku, $_SESSION['cart']))
                {
                    // If yes, increment the quantity by one
                    $_SESSION['cart'][$product_sku]++;
                }
                else
                {
                    // If no, add the product SKU and set the quantity to one
                    $_SESSION['cart'][$product_sku] = 1;
                }
            }
        }
        ?>
</body>

</html>