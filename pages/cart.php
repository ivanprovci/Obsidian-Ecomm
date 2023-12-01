<html>
<?php
session_start();
require_once('../php/sql_connect.php');
require_once('../php/cart_update.php');

//echo print_r($_SESSION['cart']);
?>

<head>
    <?php require_once('../components/head.php'); ?>
    <?php require_once('../components/nav.php'); ?>
    <title>Cart</title>
</head>

<body>
    <h1>Your Cart</h1>
    <?php

    $sql = "SELECT product_name, product_price, product_image FROM products WHERE product_sku = :product_sku";
    $stmt = $db->prepare($sql);

    // Check if the cart is not empty
    if (!empty($_SESSION['cart']))
    {

        echo "<form method='post'>";
        echo "<table>";
        echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";


        $total = 0;

        // Loop through the cart array
        foreach ($_SESSION['cart'] as $product_sku => $quantity)
        {
            $stmt->execute(array(":product_sku" => $product_sku));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display the product name, price, and image
            echo "<tr>";
            echo "<td>" . $row["product_name"] . "<br><img src='" . $row["product_image"] . "' alt='Product image' width='100'></td>";
            echo "<td>$" . number_format($row["product_price"], 2) . "</td>";

            // Display the quantity in an input field
            echo "<td><input type='number' name='quantity[]' value='" . $quantity . "' min='0' max='99'></td>";

            // Add a hidden input field for the product SKU
            echo "<input type='hidden' name='product_sku[]' value='" . $product_sku . "'>";

            // Calculate and display the subtotal
            $subtotal = floatval($row["product_price"]) * floatval($quantity);
            echo "<td>$" . number_format($subtotal, 2) . "</td>";

            // Add the subtotal to the total amount
            $total += $subtotal;
        }
        echo "</table>";

        // Display the total amount
        echo "<p>Total: $" . number_format($total, 2) . "</p>";
        echo "<button type='submit' name='checkout' value='checkout' class='btn btn-success'>Checkout</button>";
        echo "<button type='submit' name='update' value='update' class='btn btn-primary'>Update Cart</button>";
        echo "<button type='submit' name='clear' value='clear' class='btn btn-danger'>Clear Cart</button>";
        echo "</form>";
    }
    else
    {
        echo "<p>Your cart is empty.</p>";
    }

    ?>
</body>

</html>