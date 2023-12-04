<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>

    <?php
    require_once('../components/head.php');
    ?>
    <style>
        input {
            margin-bottom: 16px;
        }
    </style>

</head>

<body>
    <?php

    require_once('../components/nav.php');
    // Get the user's username from the session
    $username = $_SESSION['username'];

    // Get the user's details from the database
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the user's id, email, firstname, lastname, and profileimage
    $id = $user['id'];
    $email = $user['email'];
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $profileimage = $user['profileimage'];

    if (isset($_POST['update']))
    {
        // Get the new username, password, firstname, lastname, and profileimage from the form
        $new_username = $_POST['username'];
        $new_password = $_POST['password'];
        $new_firstname = $_POST['firstname'];
        $new_lastname = $_POST['lastname'];
        $new_profileimage = $_FILES['profileimage'];

        // Validate the new username and password
        if (validateRegistration($new_username, $new_password))
        {
            // Check if the new username already exists in the database
            $query = "SELECT username from `users` WHERE `username` = :username AND `id` != :id";

            $pdo = $db->prepare($query);
            $pdo->bindParam(':username', $new_username, PDO::PARAM_STR);
            $pdo->bindParam(':id', $id, PDO::PARAM_INT);
            $pdo->execute();
            $rowExists = $pdo->fetchColumn();

            if ($rowExists)
            {
                // New username already exists, display an error message
                echo "<p>This username already exists.</p>";
            }
            else
            {
                // Hash the new password
                $hashPassword = password_hash($new_password, PASSWORD_DEFAULT);

                // Prepare the update query
                $sql = "UPDATE users SET username = :username, password = :password, firstname = :firstname, lastname = :lastname";

                // Check if the user uploaded a new profileimage
                if ($new_profileimage['error'] == 0)
                {
                    // Validate the new profile_image
                    if (validateImage($new_profileimage))
                    {
                        // Generate a unique name for the new profile_image
                        $new_profileimage_name = uniqid() . '-' . $new_profileimage['name'];

                        // Define the uploads directory path
                        $uploads_dir = '../uploads/';

                        // Check if the uploads directory exists, if not create it
                        if (!is_dir($uploads_dir))
                        {
                            mkdir($uploads_dir, 0755, true);
                        }

                        // Move the new profile_image to the uploads folder
                        $new_profileimage_path = $uploads_dir . $new_profileimage_name;
                        move_uploaded_file($new_profileimage['tmp_name'], $new_profileimage_path);

                        // Add the profile_image to the update query
                        $sql .= ", profileimage = :profileimage";
                    }
                    else
                    {
                        // New profile_image is not valid, display an error message
                        echo "<p>Please upload a valid image file.</p>";
                    }
                }


                // Add the where clause to the update query
                $sql .= " WHERE id = :id";

                // Execute the update query
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $new_username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashPassword, PDO::PARAM_STR);
                $stmt->bindParam(':firstname', $new_firstname, PDO::PARAM_STR);
                $stmt->bindParam(':lastname', $new_lastname, PDO::PARAM_STR);

                if (isset($new_profileimage_name))
                {
                    $stmt->bindParam(':profileimage', $new_profileimage_name, PDO::PARAM_STR);
                }

                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                // Update curent session
                $_SESSION['username'] = $new_username;

                // Display a success message
                echo "<p class='success'>Your profile has been updated.</p>";

                // Refresh the page to show the updated details
                header("Refresh: 2");
            }
        }
        else
        {
            // New username or password is not valid, display an error message
            echo "<p> - Invalid registration data: <br> - Username must have 3-20 characters <br> - Password must have 8 characters and 1 number.</p>";
        }
    }

    // Define a function to validate the username and password
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

    // Define a function to validate the image
    function validateImage($image)
    {
        // Image must be jpg, jpeg, png, or gif
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        // Get the image extension
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);

        if (in_array($imageExtension, $allowedExtensions))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>User Profile Page</title>
    </head>

    <body>
        <div class="container">
            <h1>User Profile Page</h1>
            <div class="profile">
                <?php
                if ($profileimage)
                {
                    echo '<img src="../uploads/' . $profileimage . '" width="100px" height="100px" alt="Profile Picture">';
                }
                else
                {
                    echo '<p>No profile picture uploaded</p>';
                }
                ?>
                <div class="profile-info">
                    <p><span>Email:</span>
                        <?php echo $email; ?>
                    </p>
                </div>
            </div>
            <div class="form">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="username">Update your username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br>
                    <label for="firstname">Update your first name:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>"><br>
                    <label for="lastname">Update your last name:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"><br>
                    <label for="profile_image">Upload your profile picture:</label><br>
                    <input type="file" id="profileimage" name="profileimage"><br>
                    <label for="password">Enter your current/new password to confirm changes:</label>
                    <input type="password" id="password" name="password" value="" required><br>
                    <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </body>

    </html>