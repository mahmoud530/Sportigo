<?php
include("nav.php");
$user_id=$_SESSION['user_id'];
// SELECT Categories
$select_cat="SELECT * FROM `category`";
$run_select_cat=mysqli_query($connect , $select_cat);
//SELECT new arrival 
$select_product="SELECT * FROM `products` order by 'product_id' desc limit 2";
$run_select_product=mysqli_query($connect , $select_product);
// SEARCH
$search_result = [];
if(isset($_POST['text'])){
    $text = mysqli_real_escape_string($connect, $_POST['text']);
    $select_search = "SELECT * FROM `products` WHERE `product_name` LIKE '%$text%'";
    $run_select_search = mysqli_query($connect, $select_search);
    if(mysqli_num_rows($run_select_search) > 0){
        $search_result = mysqli_fetch_all($run_select_search, MYSQLI_ASSOC);
    }
}

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

}


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

    <!-- Navbar -->
    

    <!-- end Navbar -->
     
    
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
                    <button class="cta">
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
            <h1>
                New Arrivels
            </h1>
            <!-- <a href="#">
                View More<i class="fa-solid fa-chevron-right"></i>
            </a> -->
        </div>
        <div class="new-products-cards ">
        <?php foreach($run_select_product as $row)  { ?>

            <div class="myCard">
                
                <div class="innerCard">
                    
                    <div class="frontSide">
                        <img src="./images/<?php echo $row['product_photo']?>" alt="">
                    </div>
                    <div class="backSide">
                        <p class="title"><?php echo $row['product_name']?></p>
                        <a href="#">
                          
                        </a>
                        <p>Product Price:<br> <span><?php echo $row['product_price']?></span>
                        </p>
                        <div class="buttons">
                            <a href="product_details.php?pro=<?php echo$row['product_id']?>" class="buy-btn">
                                <button>
                                    SHOW MORE
                                </button>
                            </a>
                            <a href="#" class="add-btn">
                                <button>
                                    Add To Cart
                                </button>
                            </a>
                            <form method="POST">
                                <input type="hidden" value="<?php echo $row['product_id']?>" name="id">
                            <button type="submit" name="wishlist">
                                <i class="fa-regular fa-heart"></i>
                            
                            </button>
                            </form>

<!--                            
                            <a href="#">
                                <i class="fa-solid fa-heart"></i>
                            </a> -->

                        </div>                        
                    </div>
      
                </div>
                
                
            </div>
            <?php } ?> 
            
            <!-- responsive cards -->
            <div class="card" style="width: 18rem;">
                <a href="#">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <img height="200px" width="100px" src="./images/Arsenal_FC.svg.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Product Name</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <div class="btnss">
                        <a href="#">
                            <button class="buy-btn">
                                Buy Now
                            </button>
                        </a>
                        <a href="#">
                            <button class="add-btn">
                                 Add To Cart
                            </button>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- best selling section -->

    <div class="new-products-section">

        <div class="new-products-title">
            <h1>
                Best Selling
            </h1>
            <a href="#">
                View More<i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

<?php
        if (mysqli_num_rows($run_select_top) > 0) { ?>
        <div class="new-products-cards ">

            <?php foreach($run_select_top as $data){ ?>

            <div class="myCard">
                <div class="innerCard">
                    <div class="frontSide">
                        <img src="..." alt="">
                    </div>
                    <div class="frontSide">
                        <img src="./images/<?php echo $data['product_photo']?>" alt="">
                    </div>
                    <div class="backSide">
                        <p class="title"><?php echo $data['product_name']?></p>
                        <a href="#">
                            Product Details:
                        </a>
                        <p>Product Price: <span><?php echo $data['product_price']?></span>
                        </p>
                        <div class="buttons">
                            <a href="#" class="buy-btn">
                                <button>
                                    Buy Now
                                </button>
                            </a>
                            <a href="#" class="add-btn">
                                <button>
                                    Add To Cart
                                </button>
                            </a>
                            <a href="#">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <a href="#">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>

            <!-- responsive cards -->
            <div class="card" style="width: 18rem;">
                <a href="#">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <img height="200px" width="100px" src="./images/Arsenal_FC.svg.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Product Name</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <div class="btnss">
                        <a href="#">
                            <button class="buy-btn">
                                Buy Now
                            </button>
                        </a>
                        <a href="#">
                            <button class="add-btn">
                                Add To Cart
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <!-- offers card -->

    <div class="new-products-section" id="offer">

        <div class="new-products-title">
            <h1>
                Offers
            </h1>
        </div>

        <div class="new-products-cards ">


            <div class="myCard">
                <div class="innerCard">
                    <div class="frontSide">
                        <img src="..." alt="">
                        <span>-15%</span>
                    </div>
                    <div class="backSide">
                        <p class="title">Product Name</p>
                        <a href="#">
                            Product Details:
                        </a>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem, aliquid.</p>
                        <p>Product Price: <span>999</span>
                        </p>
                        <div class="buttons">
                            <a href="#" class="buy-btn">
                                <button>
                                    Buy Now
                                </button>
                            </a>
                            <a href="#" class="add-btn">
                                <button>
                                    Add To Cart
                                </button>
                            </a>
                            <a href="#">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <a href="#">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>






            <!-- responsive cards -->

            <div class="card" style="width: 18rem;">
                <span>-15%</span>
                <a href="#">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <img height="200px" width="100px" src="./images/Arsenal_FC.svg.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Product Name</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <div class="btnss">
                        <a href="#">
                            <button class="buy-btn">
                                Buy Now
                            </button>
                        </a>
                        <a href="#">
                            <button class="add-btn">
                                Add To Cart
                            </button>
                        </a>
                    </div>
                </div>
            </div>






        </div>




    </div>




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

    if (query.length > 0) { // Minimum 3 characters to search
        search(query); // Call the search function
    } else {
        // Clear search results if query is too short
        document.querySelector('.new-products-cards').innerHTML = '';
    }
});

function search() {
    let query = document.getElementById("searchInput").value; // Get search query
    
    if (query !== '') {
        // Send an AJAX POST request
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
