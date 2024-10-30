<?php
include("nav.php");

$user_id = $_SESSION['user_id'];

// Function to render product cards
function renderProductCard($data, $user_id, $connect) {
    // Check if the product is already in the wishlist
    $check_wishlist = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $connect->prepare($check_wishlist);
    $stmt->bind_param("ii", $user_id, $data['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $is_wishlisted = mysqli_num_rows($result) > 0;

    echo '<div class="product-card">';
    echo '<div class="image-container">';
    echo '<a href=""><img src="images/' . $data['product_photo'] . '" alt="" class="product-image"></a>';
    echo '<form method="POST">';
    echo '<input type="hidden" value="' . $data['product_id'] . '" name="id">';
    if (!$is_wishlisted) {
        echo '<button type="submit" name="wishlist"><i class="fa-regular fa-heart"></i></button>';
    } else {
        echo '<span class="like-icon"><i class="fa-solid fa-heart" style="color: #db180a;"></i></span>';
    }
    echo '</form>';
    echo '<div class="middle"><div class="text"><a href="product_details.php?pro=' . $data['product_id'] . '"><button>View More</button></a></div></div>';
    echo '</div>';
    echo '<div class="product-info"><h3>' . $data['product_name'] . '</h3>';
    echo '<p class="price"><span class="current-price">' . $data['product_price'] . '</span></p></div>';
    echo '</div>';
}

if (isset($_POST['wishlist'])) {
    $pro_id = $_POST['id'];
    $stmt = $connect->prepare("INSERT INTO `wishlist` (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $pro_id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['men'])) {
    $select_men = "SELECT * FROM `products` 
    JOIN `sub_category` ON `sub_category`.`sub_id`=`products`.`sub_id`
    JOIN `category` ON `category`.`cat_id`=`sub_category`.`cat_id`
    WHERE `category`.`cat_name`='men'";
    $RunSelect_men = mysqli_query($connect, $select_men);
} elseif (isset($_POST['women'])) {
    $select_women = "SELECT * FROM `products` 
    JOIN `sub_category` ON `sub_category`.`sub_id`=`products`.`sub_id`
    JOIN `category` ON `category`.`cat_id`=`sub_category`.`cat_id`
    WHERE `category`.`cat_name`='women'";
    $RunSelect_women = mysqli_query($connect, $select_women);
} elseif (isset($_POST['kids'])) {
    $select_kids = "SELECT * FROM `products` 
    JOIN `sub_category` ON `sub_category`.`sub_id`=`products`.`sub_id`
    JOIN `category` ON `category`.`cat_id`=`sub_category`.`cat_id`
    WHERE `category`.`cat_name`='kids'";
    $RunSelect_kids = mysqli_query($connect, $select_kids);

    

} elseif (isset($_POST['sale'])) {
    $select_offer = "SELECT * FROM `products` WHERE `on_sale` = 1";
    $RunSelect_offer = mysqli_query($connect, $select_offer);
} else {
    $select = "SELECT * FROM `products`";
    $RunSelect = mysqli_query($connect, $select);
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
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- link font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- link css file -->
    <link rel="stylesheet" href="css/all-products.css">
</head>

<body>

    <header>
        <form method="POST">
            <button type="submit" name="men">Men</button>
            <button type="submit" name="women">Women</button>
            <button type="submit" name="kids">Kids</button>
            <button type="submit" name="sale">Sale</button>
            
        </form>
    </header>

    <div class="title">
        <h1>All Products</h1>
    </div>

    <div class="container">
        <!-- Sale products -->
        <?php if (isset($RunSelect_offer) && mysqli_num_rows($RunSelect_offer) > 0) { ?>
        <div class="product-card">
            <?php foreach($RunSelect_offer as $dataa) { 
                $originalPrice = floatval(preg_replace('/[^0-9.]/', '', $dataa['product_price']));
                $discountedPrice = $originalPrice * 0.85;
            ?>
            <div class="image-container">
                <a href="product_details.php?pro=<?php echo $dataa['product_id']; ?>">
                    <img src="./images/<?php echo $dataa['product_photo']; ?>" alt="" class="product-image">
                </a>
                <span class="discount-badge">-15%</span>
                <form method="POST">
                    <input type="hidden" value="<?php echo $dataa['product_id']; ?>" name="id">
                    <?php 
                    $check_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = '$user_id' AND `product_id` = '".$dataa['product_id']."'";
                    $result = mysqli_query($connect, $check_wishlist);
                    if (mysqli_num_rows($result) == 0) { ?>
                        <button class="wishlist-icon"><i class="fa-regular fa-heart"></i></button>
                    <?php } else { ?>
                        <button class="wishlist-icon"><i class="fa-solid fa-heart" style="color: #db180a;"></i></button>
                    <?php } ?>
                </form>
                <div class="middle">
                    <div class="text">
                        <a href="product_details.php?pro=<?php echo $dataa['product_id']; ?>">
                            <button type="button">View More</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <h3><?php echo $dataa['product_name']; ?></h3>
                <p class="price">
                    <span class="current-price">EGP <?php echo number_format($discountedPrice, 2); ?></span>
                    <span class="original-price">EGP <?php echo $dataa['product_price'];?></span>
                </p>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php
        if (isset($RunSelect_men)) {
            foreach ($RunSelect_men as $data) {
                renderProductCard($data, $user_id, $connect);
            }
        } elseif (isset($RunSelect_women)) {
            foreach ($RunSelect_women as $data) {
                renderProductCard($data, $user_id, $connect);
            }
        } elseif (isset($RunSelect_kids)) {
            foreach ($RunSelect_kids as $data) {
                renderProductCard($data, $user_id, $connect);
            }
        } elseif (!isset($RunSelect_offer)) {
            foreach ($RunSelect as $data) {
                renderProductCard($data, $user_id, $connect);
            }
        }
        ?>
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
                <h2>Follow Us</h2>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>
