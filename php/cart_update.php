<?php
if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = array();
}

// Check if the update button was pressed
if (isset($_POST['update'])) {
    // Loop through the product SKU array
    foreach ($_POST['product_sku'] as $product_sku) {
        // Get the corresponding quantity for each product SKU
        $quantity = current($_POST['quantity']);
        // Move the array pointer of the quantity array to the next element
        next($_POST['quantity']);
        // Check if the quantity is 0, and if so, remove the product SKU from the cart array
        if ($quantity == 0) {
            unset($_SESSION['cart'][$product_sku]);
        } else {
            // Otherwise, update the quantity in the cart array
            $_SESSION['cart'][$product_sku] = $quantity;
        }
    }
}


// Check if the clear button was pressed
if (isset($_POST['clear']))
{
    // Destroy the session and reload the page
    session_destroy();
    header("Location: cart.php");
    exit;
}

?>