<?php 
include("nav.php");
$user_id = $_SESSION['user_id'];
$select = "SELECT * FROM `wishlist` JOIN `products` ON `products`.`product_id` = `wishlist`.`product_id` WHERE `wishlist`.`user_id` = $user_id";
$run_sel = mysqli_query($connect, $select);

if (isset($_POST['wishlist'])) {
    $pid = $_POST['product_id'];
    $delete = "DELETE FROM `wishlist` WHERE `product_id` = '$pid' AND `user_id` = '$user_id'";
    $run_delete = mysqli_query($connect, $delete);
    header("location:wishlist2.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/wishlist.css">
    <title>Wishlist</title>
</head>

<body>

    <div class="container">
        <h1>Your Wishlist <i class="fa-solid fa-heart" style="color: #db180a;"></i></h1>
        <div class="cards">
            <?php foreach ($run_sel as $data){ ?>
                <div class="card">
                    <a href="#">
                        <div class="imgg">
                            <img src="images/<?php echo $data['product_photo']; ?>" alt="">
                        </div>
                        <div class="cont">
                            <h3><?php echo htmlspecialchars($data['product_name']); ?></h3>
                            <h4><?php echo htmlspecialchars($data['product_price']); ?></h4>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                                <button type="submit" name="wishlist" style="background: none; border: none; padding: 0; cursor: pointer;">
                                    <span id="like-icon-1" class="like-icon" onclick="toggleLike(this); event.stopPropagation();">
                                        <i class="fa-solid fa-heart" style="color: #db180a;"></i>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div> 
    </div>
    
    <script>
        function toggleLike(icon) {
            const isLiked = icon.classList.toggle('liked'); // Toggle the 'liked' class
    
            if (isLiked) {
                icon.innerHTML = '<i class="fa-solid fa-heart" style="color: #db180a;"></i>'; // Change to liked state
            } else {
                icon.innerHTML = '<i class="fa-regular fa-heart" style="color: #555;"></i>'; // Change to unliked state
            }
        }
    </script>
</body>

</html>
