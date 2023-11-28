<?php
    $dsn = 'mysql:host=localhost;dbname=clothing_ecommerce';
    $username = 'mgs_user';
    $password = 'pa$$word';
    
    try 
    {
        $db = new PDO($dsn, $username, $password); 
    } 
    
    catch (PDOException $e) 
    {
        $error_message = $e->getMessage();
        echo "<p>Error: $error_message</p>";
        exit();
    }
?>
