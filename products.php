<?php 
include("connection.php");
// include("nav.php");
$user_id=$_SESSION['user_id'];

if(isset($_GET['sub'])){
    // $cat_id=$_GET['cat_id'];
    $sub_id=$_GET['sub'];
    $select_product="SELECT * FROM `products` WHERE `sub_id`=$sub_id";
    $run_select_product=mysqli_query($connect , $select_product);

   
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
    <?php foreach($run_select_product as $data) { ?>
        <?php echo $data['product_name']?>
        <?php echo $data['product_price']?>
        <a href="product_details.php?pro=<?php echo $data['product_id']?>" class="">
                <button>Details</button>
            </a>
        <?php } ?>
       
</body>
</html>