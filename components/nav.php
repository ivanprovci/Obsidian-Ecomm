<header class="p-3 border-bottom bg-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/INFO3135_Project/index.php" class="nav-link px-3 rounded link-body-emphasis">Home</a></li>
                <li><a href="/INFO3135_Project/pages/catalog.php"
                        class="nav-link px-3 rounded link-body-emphasis">Catalog</a></li>
            </ul>

            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle" style="font-size:2em; color: var(--bs-gray-700);"></i>
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="/INFO3135_Project/pages/user-profile.php">View Profile</a></li>
                    <li><a class="dropdown-item" href="/INFO3135_Project/pages/favourites.php">Favourites</a></li>
                    <li><a class="dropdown-item" href="/INFO3135_Project/pages/cart.php">View Cart</a></li>
                    <li>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="post">
                            <button type="submit" name="logout" class="btn btn-dark logout-btn w-100 text-start">Log
                                Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php
    session_start();
    require_once(realpath(__DIR__ . '/../php/sql_connect.php'));

    function saveSessionData($username)
    {
        global $db;
    
        // Encode the entire $_SESSION array as a JSON string
        $sessionData = json_encode($_SESSION);

        // Prepare a SQL statement to update the user's session data
        $query = "UPDATE users SET sessiondata = :sessionData WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':sessionData', $sessionData, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    }

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
    {
        header('Location: /INFO3135_Project/pages/login.php');
        exit;
    }
    else
    {
        //echo "logged in";
    }

    if (isset($_POST['logout']))
    {
        $username = $_SESSION['username'];

        // Save the current session data to the database before logging out
        saveSessionData($username);

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('Location: /INFO3135_Project/pages/login.php');
        exit;
    }
    ?>

</header>