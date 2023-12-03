<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../components/head.php'); ?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <?php
    require_once('../php/sql_connect.php');
    ?>

    <style>
        html {
            min-height: 100vh;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        form {
            width: 300px;
        }

        input {
            box-sizing: border-box;
            font-size: 17px;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }

        button {
            background-color: rgb(35, 28, 103);
            color: white;
            padding: 10px 15px;
            margin-top: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        a {
            color: black;
        }

        .flex-center {
            border: 1px solid gray;
            padding: 60px;
            margin-top: 10%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <?php

    $username = $email = $password = '';
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate the registration data
        $validRegistration = validateRegistration($username, $password);

        if ($validRegistration)
        {
            // Check if the email or username already exists in the database
            $query = "SELECT email from `users` WHERE `email` = :email OR `username` = :username";

            $pdo = $db->prepare($query);
            $pdo->bindParam(':email', $email, PDO::PARAM_STR);
            $pdo->bindParam(':username', $username, PDO::PARAM_STR);
            $pdo->execute();
            $rowExists = $pdo->fetchColumn();

            if ($rowExists)
            {
                $error = "- This email or username already exists";
            }
            else
            {
                // Hash the password
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user data into the database
                $query = "INSERT INTO `users` (username, email, password) VALUES (:username, :email, :password)";

                $stmt = $db->prepare($query);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashPassword, PDO::PARAM_STR);
                $stmt->execute();

                // Redirect to login after successful registration
                header('Location: login.php');
                exit();
            }
        }
        else
        {
            $error = "- Invalid registration data: <br> - Username must have 3-20 characters <br> - Password must have 8 characters and 1 number";
        }
    }

    // Define a function to validate the registration data
    function validateRegistration($username, $password)
    {

        // Username must be 3-20 characters
        $usernamePattern = "/^[a-zA-Z0-9_]{3,20}$/";
        // Password must be 8 characters and contain 1 number
        $passwordPattern = "/^(?=.*\d)[a-zA-Z\d]{8,}$/";

        // Check if the username matches the pattern
        if (preg_match($usernamePattern, $username))
        {
            // Check if the password matches the pattern
            if (preg_match($passwordPattern, $password))
            {
                // All the registration data are valid, return true
                return true;
            }
            else
            {
                // Password does not match the pattern, return false
                return false;
            }
        }
        else
        {
            // Username does not match the pattern, return false
            return false;
        }
    }
    ?>

    <div class="flex-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 class='text-center'>Create a New Account</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"
                required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" minlength="8" required>

            <button type="submit">Register</button>
            <p class='text-center'> —— or ——<br><br><a href="login.php">Login to an existing account</a></p>

            <!-- Display the error message if it is not empty -->
            <?php
            if ($error != '')
            {
                echo "<p class='error'> <br>";
                echo $error;
                echo "</p>";
            }
            ?>
        </form>
    </div>

</body>

</html>