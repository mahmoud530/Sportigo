<?php 
include("nav.php");
$user_id=$_SESSION['user_id'];
$select="SELECT * FROM `wishlist`join `products`on `products`.`product_id`=`wishlist`.`product_id` WHERE `wishlist`.`user_id`=$user_id";
$run_sel=mysqli_query($connect , $select);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php   foreach($run_sel as $data){ ?>
        <!-- card 3adyyyy -->
        <div class="product-card">

            <!-- el sooooraaaaaa -->
            <div class="image-container">
                <a href="">
                    <img src="<?php echo $data['product_photo']?>" alt="" class="product-image">
                </a>

                <button class="wishlist-icon"name="wishlist"type="submit">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <!-- <button class="wishlist-icon">
                    <i class="fa-solid fa-heart"></i>

                </button> -->
            
                <div class="middle">
                    <div class="text">
                        <a href="product_details.php?pro=<?php echo $data['product_id']?>">
                            <button>
                                View More
                            </button>
                        </a>
                    </div>
                </div>
            </div>



            <div class="product-info">
                <h3><?php echo $data['product_name']?></h3>
                <p class="price">
                    <span class="current-price"><?php echo $data['product_price']?></span>
                </p>
            </div>
        </div>

   <?php } ?>
    </div>

</body>
</html> 