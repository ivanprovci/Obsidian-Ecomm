<html>

<head>
    <?php 
    
    require_once('../components/head.php');
    require_once('../components/nav.php');
    require_once('../php/cart_update.php');

    //echo print_r($_SESSION['cart']);
    ?>

    <title>Cart</title>
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
    <h1 class="text-center">Your Cart</h1><br><br>
    <div class="flex-center">
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
                echo "<td>" . $row["product_name"] . "<br><img src='" . $row["product_image"] . "' alt='Product image' width='200'></td>";
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
                echo "</tr>";
            }
            echo "</table><hr>";

            // Display the total amount
            echo "<p>Subotal: $" . number_format($total, 2) . "</p>";
            echo "<p>Taxes (12%): $" . number_format($total * 0.12, 2) . "</p>";
            echo "<strong>Total: $" . number_format($total * 1.12, 2) . "</strong>";
            echo "<br><br><br><div class='flex-space-between'><button type='submit' name='clear' value='clear' class='btn btn-danger'>Clear Cart</button>";
            echo "<button type='submit' name='update' value='update' class='btn btn-primary'>Update Cart</button>";
            echo "<button type='submit' name='checkout' value='checkout' class='btn btn-success'>Checkout</button></div>";
            echo "</form></div>";
        }
        else
        {
            echo "<p>Your cart is empty.</p>";
        }

        ?>

</body>

</html>