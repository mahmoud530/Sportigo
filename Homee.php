<?php
include("nav.php");
$user_id=$_SESSION['user_id'];
// SELECT Categories
$select_cat="SELECT * FROM `category`";
$run_select_cat=mysqli_query($connect , $select_cat);
//SELECT new arrival 
$select_product="SELECT * FROM `products` order by 'product_id' desc limit 4";
$run_select_product=mysqli_query($connect , $select_product);
// SEARCH


//top selling
$select_top = "SELECT *, COUNT(`order_details`.`product_id`) as total_orders FROM `order_details`
    JOIN `products`  ON `order_details`.`product_id` = `products`.`product_id`
    GROUP BY `order_details`.`product_id` ORDER BY total_orders DESC LIMIT 5";
    
    $run_select_top=mysqli_query($connect, $select_top);

// wishlist
if(isset($_POST['wishlist'])){
    $id=$_POST['id'];
    $insert_wishlist="INSERT INTO `wishlist` values(NULL,'$user_id',$id)";
    $run_insert_wishlist=mysqli_query($connect, $insert_wishlist);
$add_msg="added to wish list ";
}
//add to cart
//offers
$select_offer="SELECT * FROM products WHERE on_sale = 1";
$run_select_offer=mysqli_query($connect, $select_offer);


?>
        
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportigo</title>


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
    <link rel="stylesheet" href="css/home.css">

</head>

<body>

    
    <div id="searchResults"></div>

    <div class="header">
        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>
    </div>

<!-- slider -->
    <div class="slider-section">

        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/ahly team.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/hijab adidas.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/ahly team.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- promo code -->
    <div class="sign-up-section">
        <h1>
            Sign Up now and get 10% Offer
        </h1>
        <p>
            Create your account today to access exclusive features and stay connected!
        </p>
        <button>
            Sign Up Now
        </button>
    </div>

    <!-- categories -->
    <div class="category-section" id="category">

        <div class="category-title">
            <h1>
                Our Categories
            </h1>
        </div>
        <div class="category-cards">
            <?php foreach($run_select_cat as $row)  { ?>
            <div class="cardd">
                <a href="sub_cat.php?cat=<?php echo $row['cat_id']?>">
                    <img src="images/<?php echo $row['cat_photo'] ?>" alt="">
                </a>
                <a href="sub_cat.php?cat=<?php echo $row['cat_id']?>">
                    <button type="button" class="cta">
                        <span><?php echo $row['cat_name'] ?></span>
                        <svg width="15px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                </a>
                
            </div>

            <?php } ?> 
        </div>
    </div>
                <!-- enddddddddd -->
                <!-- arrivallllllllllll -->
<div class="new-products-section">
    <div class="new-products-title">
        <h1>New Arrivals</h1>
    </div>
    <div class="new-products-cards">
        <?php foreach ($run_select_product as $dow) { ?>
            <div class="myCard">
                <div class="innerCard">
                    <div class="frontSide">
                        <img src="./images/<?php echo $dow['product_photo']; ?>" alt="">
                    </div>
                    <div class="backSide">
                        <p class="title"><?php echo $dow['product_name']; ?></p>
                        <p>Product Price:<br> <span><?php echo $dow['product_price']; ?></span></p>
                        <div class="buttons">
                            <a href="product_details.php?pro=<?php echo $dow['product_id']; ?>" class="buy-btn">
                                <button type="button">SHOW MORE</button>
                            </a>
                            <form method="POST">
                                <input type="hidden" value="<?php echo $dow['product_id']; ?>" name="id">

                                <?php if (!empty($_SESSION) && isset($_SESSION['user_id'])) { 
                                    $user_id = $_SESSION['user_id'];

                                    // Check if the product is already in the wishlist
                                    $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dow['product_id']."'";
                                    $result = mysqli_query($connect, $check_wishlist);

                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <button type="submit" name="wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    <?php } else { ?>
                                        <span class="like-icon">
                                            <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                                        </span>
                                    <?php } 
                                } else { ?>
                                    <p><a href="login.php">Log in to add to wishlist</a></p>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- responsive cards -->
    <?php foreach ($run_select_product as $dow) { ?>
        <div class="card" style="width: 18rem;">
            <?php
            // Check if the product is already in the wishlist
            $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dow['product_id']."'";
            $result = mysqli_query($connect, $check_wishlist);

            if (mysqli_num_rows($result) == 0) { ?>
                <button type="submit" name="wishlist">
                    <i class="fa-regular fa-heart"></i>
                </button>
            <?php } else { ?>
                <span class="like-icon">
                    <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                </span>
            <?php } ?>

            <img height="200px" width="100px" src="./images/<?php echo $dow['product_photo']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $dow['product_name']; ?></h5>
                <p class="card-text"><?php echo $dow['product_price']; ?></p>
                <div class="btnss">
                    <a href="product_details.php?pro=<?php echo $dow['product_id']; ?>">
                        <button class="buy-btn">Show More</button>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div> 
<!-- best selling -->
<div class="new-products-section">
    <div class="new-products-title">
        <h1>Best Selling</h1>
    </div>
     <?php if (mysqli_num_rows($run_select_top) > 0) { ?>
        <div class="new-products-cards">

            <?php foreach($run_select_top as $data){ ?>
            <div class="myCard">
                <div class="innerCard">
                    <div class="frontSide">
                        <img src="./images/<?php echo $data['product_photo']; ?>" alt="">
                    </div>
                    <div class="backSide">
                        <p class="title"><?php echo $data['product_name']; ?></p>
                        <p>Product Price:<br> <span><?php echo $data['product_price']; ?></span></p>
                        <div class="buttons">
                            <a href="product_details.php?pro=<?php echo $data['product_id']; ?>" class="buy-btn">
                                <button type="button">SHOW MORE</button>
                            </a>
                            <form method="POST">
                                <input type="hidden" value="<?php echo $data['product_id']; ?>" name="id">

                                <?php if (!empty($_SESSION) && isset($_SESSION['user_id'])) { 
                                    $user_id = $_SESSION['user_id'];

                                    // Check if the product is already in the wishlist
                                    $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dow['product_id']."'";
                                    $result = mysqli_query($connect, $check_wishlist);

                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <button type="submit" name="wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    <?php } else { ?>
                                        <span class="like-icon">
                                            <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                                        </span>
                                    <?php } 
                                } else { ?>
                                    <p><a href="login.php">Log in to add to wishlist</a></p>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>

    <!-- responsive cards -->
    <?php if (mysqli_num_rows($run_select_top) > 0) { ?>
            <?php foreach($run_select_top as $data){ ?>
        <div class="card" style="width: 18rem;">
            <?php
            // Check if the product is already in the wishlist
            $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dow['product_id']."'";
            $result = mysqli_query($connect, $check_wishlist);

            if (mysqli_num_rows($result) == 0) { ?>
                <button type="submit" name="wishlist">
                    <i class="fa-regular fa-heart"></i>
                </button>
            <?php } else { ?>
                <span class="like-icon">
                    <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                </span>
            <?php } ?>

            <img height="200px" width="100px" src="./images/<?php echo $data['product_photo']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $data['product_name']; ?></h5>
                <p class="card-text"><?php echo $data['product_price']; ?></p>
                <div class="btnss">
                    <a href="product_details.php?pro=<?php echo $data['product_id']; ?>">
                        <button class="buy-btn">Show More</button>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php } ?>
</div>


  
    <!-- offers card -->
    <?php if (mysqli_num_rows($run_select_offer) > 0) { ?>
    <div class="new-products-section" id="offer">
        <div class="new-products-title">
            <h1>Offers</h1>
        </div>
        
        <div class="new-products-cards">
            <?php foreach($run_select_offer as $dataa) { 
                $originalPrice = floatval(preg_replace('/[^0-9.]/', '', $dataa['product_price']));
                $discountedPrice = $originalPrice * 0.85;
            ?>
                <div class="myCard">
                    <div class="innerCard">
                        <div class="frontSide">
                            <img src="./images/<?php echo $dataa['product_photo']; ?>" alt="">
                            <span>-15%</span>
                        </div>
                        <div class="backSide">
                            <p class="title"><?php echo $dataa['product_name']; ?></p>

                                                      
                         <p>Product Price: <span><?php echo "L.E" . number_format($discountedPrice, 2); ?>
                            <br> <del><?php echo $dataa ['product_price'];?></del></span>
                            <p>
                            <div class="buttons">
                            <a href="product_details.php?pro=<?php echo $dataa['product_id']; ?>" class="buy-btn">
                                <button type="button">SHOW MORE</button>
                            </a>
                            <form method="POST">
                                <input type="hidden" value="<?php echo $dataa['product_id']; ?>" name="id">

                                <?php if (!empty($_SESSION) && isset($_SESSION['user_id'])) { 
                                    $user_id = $_SESSION['user_id'];

                                    // Check if the product is already in the wishlist
                                    $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dow['product_id']."'";
                                    $result = mysqli_query($connect, $check_wishlist);

                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <button type="submit" name="wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    <?php } else { ?>
                                        <span class="like-icon">
                                            <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                                        </span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php }  ?> 
  
            <!-- responsive cards -->
            <?php if (mysqli_num_rows($run_select_offer) > 0) { ?>
                <?php foreach($run_select_offer as $data3) { ?>

            <div class="card" style="width: 18rem;">
                <span>-15%</span>
                <?php
            // Check if the product is already in the wishlist
            $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$data3['product_id']."'";
            $result = mysqli_query($connect, $check_wishlist);

            if (mysqli_num_rows($result) == 0) { ?>
                <button type="submit" name="wishlist">
                    <i class="fa-regular fa-heart"></i>
                </button>
            <?php } else { ?>
                <span class="like-icon">
                    <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                </span>
            <?php } ?>
                <img height="200px" width="100px" src="./images/<?php echo $data3['product_photo']; ?>" 
                class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $data3['product_name']; ?></h5>
                    
                    <div class="btnss">
                    <a href="product_details.php?pro=<?php echo $data3['product_id']; ?>">
                        <button class="buy-btn">Show More</button>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>

    <div class="sign-up-section">
        <h1>
            Become a Member & get 15% off
        </h1>
        <p>
            Create your account today to access exclusive features and stay connected!
        </p>
        <button>
            Sign Up Now
        </button>
    </div>



    <!-- footer -->

    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h2>Products</h2>
                <ul>
                    <li><a href="#">Shoes</a></li>
                    <li><a href="#">Clothing</a></li>
                    <li><a href="#">Accessories</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>Sports</h2>
                <ul>
                    <li><a href="#">Running</a></li>
                    <li><a href="#">Basketball</a></li>
                    <li><a href="#">Football</a></li>
                    <li><a href="#">Yoga</a></li>
                    <li><a href="#">Outdoor</a></li>
                    <li><a href="#">Tennis</a></li>
                    <li><a href="#">Training</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>Category</h2>
                <ul>
                    <li><a href="#">Men</a></li>
                    <li><a href="#">Women</a></li>
                    <li><a href="#">Kids</a></li>

                </ul>
            </div>
            <div class="footer-column">
                <h2>Company Info</h2>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Carbon Footprint</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">SportiClub</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>Support</h2>
                <ul>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">SportiClub & Newsletter</a></li>
                    <li><a href="#">Vouchers</a></li>
                    <li><a href="#">Size Charts</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Accessibility</a></li>
                    <li><a href="#">Storefinder</a></li>
                </ul>
            </div>
            <div class="footer-column follow-us">
                <h2>Follow Us</h2>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </footer>




    <!-- link bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


    <script>
        window.onscroll = function () { myFunction() };

        function myFunction() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("myBar").style.width = scrolled + "%";
        }

       // Get the input element
var searchInput = document.getElementById("searchInput");

// Add an event listener for the 'input' event to make it dynamic
searchInput.addEventListener("input", function () {
    let query = searchInput.value; // Get the search query from the input

    if (query.length > 0) {
        search(query); // Call the search function if there's a query
    } else {
        // If the search query is empty, restore the original "New Arrivals" content
        document.querySelector('.new-products-cards').innerHTML = originalNewArrivals;
    }
});

function search(query) {
    // Send an AJAX POST request for non-empty queries
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "search.php", true); // Create a new PHP file to handle search
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.querySelector('.new-products-cards').innerHTML = this.responseText;
        }
    };

    xhr.send("text=" + query); // Send search query to the server
}

function search() {
    let query = document.getElementById("searchInput").value; // Get search query

    // If the input is empty, clear the search results
    if (query === "") {
        document.getElementById("searchResults").innerHTML = ""; // Clear search results
        return; // Exit the function, no need to make an AJAX request
    }

    // Send an AJAX POST request for non-empty queries
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "search.php", true); // Create a new PHP file to handle search
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("searchResults").innerHTML = this.responseText;
        }
    };

    xhr.send("text=" + query); // Send search query to the server
}





    </script>
</body>

</html>
