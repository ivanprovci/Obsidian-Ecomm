<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="p-3 border-bottom bg-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-3 rounded link-body-emphasis">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="nav-link px-3 rounded link-body-emphasis dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Men</a>
                        <ul class="dropdown-menu text-small" style="">
                            <li><a class="dropdown-item" href="">T-Shirts</a></li>
                            <li><a class="dropdown-item" href="">Shorts</a></li>
                            <li><a class="dropdown-item" href="">Pants</a></li>
                            <li><a class="dropdown-item" href="">Hoodies</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link px-3 rounded link-body-emphasis dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Women</a>
                        <ul class="dropdown-menu text-small" style="">
                            <li><a class="dropdown-item" href="">T-Shirts</a></li>
                            <li><a class="dropdown-item" href="">Shorts</a></li>
                            <li><a class="dropdown-item" href="">Leggings</a></li>
                            <li><a class="dropdown-item" href="">Hoodies</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link px-3 rounded link-body-emphasis dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Accessories</a>
                        <ul class="dropdown-menu text-small" style="">
                            <li><a class="dropdown-item" href="">Hats</a></li>
                            <li><a class="dropdown-item" href="">Shoes</a></li>
                            <li><a class="dropdown-item" href="">Backpacks</a></li>
                            <li><a class="dropdown-item" href="">Socks</a></li>
                        </ul>
                    </li>
					<li>
                        <a href="sites/display_test.php" class="nav-link px-3 rounded link-body-emphasis dropdown-toggle" aria-expanded="false">Display Test</a>
                    </li>
                </ul>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                </form>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle" style="font-size:2em; color: var(--bs-gray-700);"></i>
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                        <li><a class="dropdown-item" href="sites/user-profile.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="sites/favourites.php">Favourites</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="flex-center">
        <h1>OBSIDIAN</h1>
    </div>
</body>
</html>