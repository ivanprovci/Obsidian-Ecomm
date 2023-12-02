<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            margin-top: 15%;
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
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the login credentials (you need to implement your own validation logic)
    $validLogin = validateLogin($username, $password);

    if ($validLogin) {
        // Store user information in the session
        $_SESSION['username'] = $username;

        // Redirect to a dashboard or home page after successful login
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid login credentials";
    }
}
?>

<!-- The rest of your HTML code remains unchanged -->

    <div class="flex-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 class='text-center'>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p class='text-center'> &mdash;&mdash; or &mdash;&mdash;<br><br><a href="register.php">Create a new account</a></p>
        </form>
    </div>

</body>

</html>
