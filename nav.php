<?php 
include("connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">


    <!-- link font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- link css file -->
    <link rel="stylesheet" href="css/nav.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light"> 

        <div class="container-fluid">
            <a class="navbar-brand" href="Homee.php">Sportigo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="Homee.php">Home</a>
                    <a class="nav-link" href="all-products.php">Products</a>
                    <a class="nav-link" href="#category">Categories</a>
                    <a class="nav-link" href="#offer">Offers</a>
                </div>
            </div>

            <!-- SEARCH -->
                
            <form method="POST" class="d-flex" id="searchForm" onsubmit="search(); return false;">
                <input class="form-control me-2" onkeyup="search()" type="search" placeholder="Search" name="text" aria-label="Search"
                    id="searchInput"> 
            </form>
            <form method="POST">

            <?php if (empty($_SESSION) || !isset($_SESSION['user_id'])) { ?>
                <a href="login and sign up.php">
                    <button type="button" class="btn-login">
            Login
        </button>
                    </a>
  
<?php } else { ?>
    <button class="btn-login "name="logout">
        Logout
    </button>
<?php } ?>
</from>
            
            <div class="icons collapse navbar-collapse" id="navbarNavAltMarkup">
                <a href="cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <a href="wishlist.php">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <a href="profile.php">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>

        </div>
    </nav>
    
</body>
</html>

    
