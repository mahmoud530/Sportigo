<?php
include("nav.php");
$user_id=$_SESSION['user_id'];

$s = "";
$m = "";
$l = "";
$xl = "";
if(isset($_GET['pro'])){
    $product_id=$_GET['pro'];
}
$select_product = "SELECT * FROM `products` WHERE `product_id` = $product_id";
$run_pro = mysqli_query($connect, $select_product);

if(isset($_POST['small'])) { 
    $select_size_s = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 1";
    $run_size1 = mysqli_query($connect, $select_size_s);
    $fetsh1 = mysqli_fetch_assoc($run_size1);
    $s = $fetsh1['quantaty'];
} 

if(isset($_POST['mid'])) { 
    $select_size_m = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 2";
    $run_size2 = mysqli_query($connect, $select_size_m);
    $fetsh2 = mysqli_fetch_assoc($run_size2);
    $m = $fetsh2['quantaty'];
} 

if(isset($_POST['large'])) { 
    $select_size_l = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 3";
    $run_size3 = mysqli_query($connect, $select_size_l);
    $fetsh3 = mysqli_fetch_assoc($run_size3);
    $l = $fetsh3['quantaty'];
} 

if(isset($_POST['xlarge'])) { 
    $select_size_xl = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 4";
    $run_size4 = mysqli_query($connect, $select_size_xl);
    $fetsh4 = mysqli_fetch_assoc($run_size4);
    $xl = $fetsh4['quantaty'];
} 

if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];

    $quantity_small = isset($_POST['quantity_small']) ? $_POST['quantity_small'] : 0;
    $quantity_mid = isset($_POST['quantity_mid']) ? $_POST['quantity_mid'] : 0;
    $quantity_large = isset($_POST['quantity_large']) ? $_POST['quantity_large'] : 0;
    $quantity_xlarge = isset($_POST['quantity_xlarge']) ? $_POST['quantity_xlarge'] : 0;

    if ($quantity_small > 0) {
        $product_quantity = $quantity_small;
        $insert_cart = "INSERT INTO `cart` VALUES(NULL, '$user_id', '$product_id', '$product_quantity')";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_mid > 0) {
        $product_quantity = $quantity_mid;
        $insert_cart = "INSERT INTO `cart` VALUES(NULL, '$user_id', '$product_id', '$product_quantity')";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_large > 0) {
        $product_quantity = $quantity_large;
        $insert_cart = "INSERT INTO `cart` VALUES(NULL, '$user_id', '$product_id', '$product_quantity')";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_xlarge > 0) {
        $product_quantity = $quantity_xlarge;
        $insert_cart = "INSERT INTO `cart` VALUES(NULL, '$user_id', '$product_id', '$product_quantity')";
        mysqli_query($connect, $insert_cart);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">

<?php foreach($run_pro as $row)  { ?>
    <form method="POST">
    <div class="card">
        <img src="" alt="">
        
        <div class="overlay">
            <div class="text"><?php echo $row['product_name']?></div>
            <div class="text"><?php echo $row['product_price']?></div>
            
        </div>
        <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
        
        <label for="quantity_small">Small Quantity</label>
        <input type="number" name="quantity_small" min="0" value="0">
        <input type="submit" name="small">
        <?php echo $s ?>
        <br>
        
        <label for="quantity_mid">Medium Quantity</label>
        <input type="number" name="quantity_mid" min="0" value="0">
        <input type="submit" name="mid">
        <?php echo $m ?>
        <br>
        
        <label for="quantity_large">Large Quantity</label>
        <input type="number" name="quantity_large" min="0" value="0">
        <input type="submit" name="large">
        <?php echo $l ?>
        <br>
        
        <label for="quantity_xlarge">X-Large Quantity</label>
        <input type="number" name="quantity_xlarge" min="0" value="0">
        <input type="submit" name="xlarge">
        <?php echo $xl ?>
        <br>

        <button type="submit" name="add_to_cart">Add to cart</button>
    </form>
    </div>

<?php } ?> 

</div> 
</body>
</html>
