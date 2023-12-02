<?php

if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = array();
}

// Check if the update button was pressed
if (isset($_POST['update']))
{
    // Loop through the product SKU and quantity arrays
    for ($i = 0; $i < count($_POST['product_sku']); $i++)
    {
        // Get the product SKU and quantity for each pair
        $product_sku = $_POST['product_sku'][$i];
        $quantity = $_POST['quantity'][$i];

        // Check if the quantity is 0, and if so, remove the product SKU from the cart array
        if ($quantity == 0)
        {
            unset($_SESSION['cart'][$product_sku]);
        }
        else
        {
            // Otherwise, update the quantity in the cart array
            $_SESSION['cart'][$product_sku] = $quantity;
        }
    }
}

// Check if the clear button was pressed
if (isset($_POST['clear']))
{
    // unset the session and reload the page
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Check if the checkout button was pressed
if (isset($_POST['checkout']))
{
    // unset the session and reload the page
    unset($_SESSION['cart']);
    header("Location: checkout.php");
    exit;
}

?>