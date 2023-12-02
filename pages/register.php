<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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

$username = $email = $password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the registration data (you need to implement your own validation logic)
    $validRegistration = validateRegistration($username, $email, $password);

    if ($validRegistration) {
        // Store user information in the session
        $_SESSION['username'] = $username;

        // Redirect to a dashboard or home page after successful registration
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid registration data";
    }
}
?>

<!-- The rest of your HTML code remains unchanged -->

    <div class="flex-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 class='text-center'>Create a New Account</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>

</body>

</html>
