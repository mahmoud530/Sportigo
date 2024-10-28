<?php
include("nav.php");
$user_id=$_SESSION['user_id'];
$select_user="SELECT * FROM`users`WHERE `user_id`='$user_id'";
$run_select_user=mysqli_query($connect , $select_user);
$old="";
$select_order_ids = "SELECT DISTINCT `order_id` FROM `order` WHERE `user_id` = $user_id";
$run_select_order_ids = mysqli_query($connect, $select_order_ids);
$order_ids = [];
while ($row = mysqli_fetch_assoc($run_select_order_ids)) {
    $order_ids[] = $row['order_id'];
}

// Prepare to store all orders
$orders = [];

// Loop through unique order IDs to gather order details
foreach ($order_ids as $order_id) {
    $select_order_details = "
        SELECT `order`.*, `order_details`.*, `products`.*
        FROM `order`
        JOIN `order_details` ON `order_details`.`order_id` = `order`.`order_id`
        JOIN `products` ON `products`.`product_id` = `order_details`.`product_id`
        WHERE `order`.`user_id` = $user_id AND `order`.`order_id` = $order_id
    ";
    $run_select_order_details = mysqli_query($connect, $select_order_details);
    
    while ($data = mysqli_fetch_assoc($run_select_order_details)) {
        $orders[$order_id]['details'][] = $data;
        $orders[$order_id]['total_amount'] = $data['total_amount'];
        $orders[$order_id]['status'] = $data['status'];
    }
}
$select="SELECT * FROM `wishlist`join `products`on `products`.`product_id`=`wishlist`.`product_id` WHERE `wishlist`.`user_id`=$user_id";
$run_sel=mysqli_query($connect , $select);
if(isset($_POST['edit-info'])){
$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$update_user="UPDATE `users` SET `user_name`='$name',`user_email`='$email',`user_address`='$address',`user_phone`='$phone' WHERE `user_id`='$user_id'";
$run_update_user=mysqli_query($connect,$update_user);
header("location:user-profile.php");

}
if(isset($_POST['edit-info'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $update_user="UPDATE `users` SET `user_name`='$name',`user_email`='$email',`user_address`='$address',`user_phone`='$phone' WHERE `user_id`='$user_id'";
    $run_update_user=mysqli_query($connect,$update_user);
    header("location:user-profile.php");
    
    }
    
    if(isset($_POST['change_pass'])){
        $fetch=mysqli_fetch_assoc($run_select_user);
        $fetch_old_pass=$fetch['user_password'];
        $old_pass=$_POST['old_password'];
        $new_pass=$_POST['new_password'];
        $confirm_pass=$_POST['confirm_password'];
        if(password_verify($old_pass,$fetch_old_pass)){
            if($new_pass==$confirm_pass){
                $new_hashing= password_hash($new_pass, PASSWORD_DEFAULT);
                $update="UPDATE `users` set `user_password`='$new_hashing' WHERE `user_id`='$user_id'";
                $run_update=mysqli_query($connect,$update);
                echo "Password is changed successfully!";
                header("location:user-profile.php");
            }else{
                $dm="The new password doesn't match the confirmed one";
                $err=TRUE;
            }
        }else{
            $old="Old password is incorrect";
            $err=TRUE;
        }
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
    <link rel="stylesheet" href="css/user-profile.css">
</head>

<body>

    <!-- The Main content -->

    <div class="container">

        <!-- the headers -->
        <header onclick="openProfile()">
            <h1> <i class="fa-solid fa-user"></i>My Account</h1>
        </header>
        <header class="header-of-media-query">
            <ul>
                <li>
                    <a href="#" onclick="openOrder()">
                        <i class="fa-solid fa-cart-shopping"></i>My Orders
                    </a>
                </li>
                <li>
                    <a href="#" onclick="openReview()">
                        <i class="fa-regular fa-star"></i>My Reviews
                    </a>
                </li>
                <li>
                    <a href="#" onclick="openWishlist()">
                        <i class="fa-regular fa-heart"></i>My Wishlist
                    </a>
                </li>
             
                <li>
                    <a href="#">
                        <i class="fa-solid fa-right-from-bracket"></i>Sign Out
                    </a>
                </li>
            </ul>
        </header>
        <!-- The headers -->

        <div class="profile">


            <div class="sidebar">
            <?php foreach($run_select_user as $data){?>
                <div class="greeting">
                    Hi <?php echo$data['user_name']?>
                </div>
                <?php } ?>
                <div class="account-review">
                    <a href="#" class="active" onclick="openProfile()" id="profile">
                        <i class="fa-solid fa-user"></i>Account Review
                    </a>
                </div>
                <nav class="menu">
                    <ul>
                        <li>
                            <a href="#" onclick="openOrder()" id="order">
                                <i class="fa-solid fa-cart-shopping"></i>My Orders
                            </a>
                        </li>



                        <li>
                            <a href="#" onclick="openReview()" id="review">
                                <i class="fa-regular fa-star"></i>My Reviews
                            </a>
                        </li>


                        <li>
                            <a href="#" onclick="openWishlist()" id="wishlist">
                                <i class="fa-regular fa-heart"></i>My Wishlist
                            </a>
                        </li>


                       


                    
                    </ul>
                </nav>
            </div>

            <div class="profile-info" id="profile-info-section">
                <h1>
                    Personal Information
                </h1>
<?php foreach($run_select_user as $data){?>
                <div class="info">

                    <!-- username section -->

                    <div class="labels">

                        <div class="heading">
                            <h4>
                                User Name
                            </h4>
                        </div>

                        <div class="editing">
                            <a href="#" onclick="openEdit()">
                                Edit Info.
                            </a>
                        </div>
                    </div>

                    <input type="text" value="<?php echo$data['user_name']?>">

                    <!-- end username section -->

                    <!-- email section -->
                    <div class="labels">

                        <div class="heading">
                            <h4>
                                User E-mail
                            </h4>
                        </div>


                    </div>

                    <input type="email" value="<?php echo$data['user_email']?>" readonly >
                    <!-- end email section -->


                    <!-- address section -->
                    <div class="labels">

                        <div class="heading">
                            <h4>
                                User Address
                            </h4>
                        </div>


                    </div>
                    
                    <input type="text" value="<?php echo$data['user_address']?>">
                    <!-- end email section -->


                    <!-- password section -->
                    <div class="labels">

                        <div class="heading">
                            <h4>
                                User Pass.
                            </h4>
                        </div>

                        <div class="editing">
                            <a href="#" onclick="openPass()">
                                Edit Pass.
                            </a>
                        </div>
                    </div>

                    <input type="password" value="<?php echo$data['user_password']?>">
                    <!-- end password section -->



                    <!-- phone number section -->
                    <div class="labels">

                        <div class="heading">
                            <h4>
                                User Phone Number
                            </h4>
                        </div>

                    </div>

                    <input type="number" value="<?php echo$data['user_phone']?>">
                    <!-- end phone number section -->



                </div>
                <?php } ?>
            </div>




            <div class="profile-info d-none" id="my-orders-section">
    <h1>
        My Orders
    </h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Order No.</th>
            </tr>
        </thead>
        <tbody>
            <?php $nom = 1; ?>
            <?php foreach ($orders as $order_id => $order) { ?>
                <?php foreach ($order['details'] as $detail) { ?>
                <tr>
                    <th scope="row"><?php echo $nom++; ?></th>
                        <td><?php echo $detail['product_name']; ?></td>
                        <td><?php echo $detail['order_date']; ?></td>
                        <td><?php echo $order['status']; ?></td>
                        <td><?php echo $order_id; ?></td>
                    </tr>
                    <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>





            <div class="profile-info d-none" id="my-wishlist-section">
                <h1>
                    My Wishlist
                </h1>

                <div class="wishlist-cards">

                    <!-- loooooop mn hnaaaaaaaa -->
            <?php   foreach($run_sel as $data){ ?>

                    <div class="product-card">

                        <!-- el sooooraaaaaa -->
                        <div class="image-container">
                            <a href="product_details.php?pro=<?php echo $data['product_id']?>">
                                
                        <img src="images/<?php echo $data['product_photo']?>" alt="" class="product-image">

                            </a>

                        </div>



                        <div class="product-info">
                            <h3><?php echo $data['product_name']?></h3>
                            <p class="price">
                                <span class="current-price"><?php echo $data['product_price']?></span>
                            </p>
                           
                        </div>
                    </div>
                    <?php } ?>
                    <!-- a5r el loooooop -->

                </div>



            </div>


            <div class="profile-info d-none" id="my-review-section">
                <h1>
                    My Reviews
                </h1>

                <div class="wishlist-cards">

                    <!-- loooooop mn hnaaaaaaaa -->
                    <div class="product-card">

                        <!-- el sooooraaaaaa -->
                        <div class="image-container">
                            <a href="#">
                                <img src="" alt="" class="product-image">
                            </a>

                        </div>



                        <div class="product-info">
                            <h3>SOLARGLIDE 6 SHOES</h3>
                            <p class="price">
                                <span class="current-price">EGP 5,849.35</span>
                            </p>
                            <p style="color: #163a54;">
                                My Review Is 5/5
                            </p>
                        </div>
                    </div>
                    <!-- a5r el loooooop -->

                </div>



            </div>



        </div>
    </div>

    <!-- -------------------------------------popups mn 2wl henaaaaaaa------------------- -->

    <!-- edit info popup -->
    <div class="edit-info d-none" id="edit-info-popup">

        <div class="edit-info-popup">


            <div class="header-popup">
                <h2>
                    Edit Info.
                </h2>
                <a href="#" onclick="closeEdit()">
                    <i class="fa-solid fa-x"></i>
                </a>
            </div>

            <form class="edit-form">
            <?php foreach($run_select_user as $data){?>
                <div class="group">
                    <input required type="text" name="name" class="input" value="<?php echo$data['user_name']?>">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter New Username</label>
                </div>
                <div class="group">
                    <input required type="email" name="email" class="input" value="<?php echo$data['user_email']?>">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter New E-Mail</label>
                </div>
                <div class="group">
                    <input required type="text"  name="address" class="input" value="<?php echo$data['user_address']?>">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter New Address</label>
                </div>
                <div class="group">
                    <input required type="number" name="phone" class="input" value="<?php echo$data['user_phone']?>">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter New Phone Number</label>
                </div>
                <button type="submit" name="edit-info">
                    Edit
                </button>
                <?php } ?>
            </form>
        </div>
    </div>




    <!-- edit pass popup -->
    <div class="edit-info d-none" id="edit-pass-popup">

        <div class="edit-info-popup">


            <div class="header-popup">
                <h2>
                    Edit Password
                </h2>
                <a href="#" onclick="closePass()">
                    <i class="fa-solid fa-x"></i>
                </a>
            </div>

            <form method="POST" class="edit-form">
            <?php foreach($run_select_user as $data){?>

                <div class="group">
                    <input required type="password" class="input"id="old" name="old_password">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter Old Password</label>
                </div>
                <div class="group">
                    <input required type="password" class="input"id="new" name="new_password">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Enter New Password</label>
                </div>
                <div class="group">
                    <input required type="password" class="input"name="confirm_password" id="cnew">
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label>Confirm New Password</label>
                </div>
                <button type="submit" name="change_pass">
                    Edit
                </button>
                <?php } ?>
            </form>
        </div>
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


    <!-- link js file -->
    <script src="js/user-profile.js"></script>
</body>

</html>
