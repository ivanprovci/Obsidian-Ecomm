<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../components/head.php');
    require_once('../php/sql_connect.php');
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <?php
    session_start();
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

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate the login credentials
        $validLogin = validateLogin($username, $password);

        if ($validLogin)
        {
            // Prepare a SQL statement to select the user data by username
            $query = "SELECT * FROM `users` WHERE `username` = :username";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the user data as an associative array
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user exists and the password matches the hash
            if ($user && password_verify($password, $user['password']))
            {

                // Set the username and logged-in status
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;

                // Load the session data from the database into the current session
                loadSessionData($username);

                // Redirect to a dashboard or home page after successful login
                header('Location: ../index.php');
                exit();
            }
            else
            {
                $error = "- Invalid login credentials";
            }
        }
        else
        {
            $error = "- Invalid registration data: <br> - Username must have 3-20 characters <br> - Password must have 8 characters and 1 number";
        }
    }

    // Define a function to validate the login data
    function validateLogin($username, $password)
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

    // Function to load session data from the database
    function loadSessionData($username)
    {
        global $db;

        // Prepare a SQL statement to select the user's session data
        $query = "SELECT sessiondata FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the session data as a JSON string
        $sessionData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Decode the JSON string and store it back into the $_SESSION array
        if ($sessionData && $sessionData['sessiondata'])
        {
            $_SESSION = json_decode($sessionData['sessiondata'], true);
        }
    }
    ?>

    <div class="flex-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 class='text-center'>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p class='text-center'> —— or ——<br><br><a href="register.php">Create a new account</a></p>

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