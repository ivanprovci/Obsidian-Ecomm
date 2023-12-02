<?php

if (!isset($_SESSION['favourites']))
{
    $_SESSION['favourites'] = array();
}

// Check if the clear button was pressed
if (isset($_POST['clear']))
{
    // unset the session and reload the page
    unset($_SESSION['favourites']);
    header("Location: favourites.php");
    exit;
}

// Check if the remove button was pressed
if (isset($_POST['remove']))
{
    // Get the product SKU from the button value
    $product_sku = $_POST['remove'];
    // Remove the product SKU from the favourites array
    unset($_SESSION['favourites'][$product_sku]);
    // Reload the page
    header("Location: favourites.php");
    exit;
}

?>