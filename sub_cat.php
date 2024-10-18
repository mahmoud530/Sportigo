<?php 
include("connection.php");
// include("nav.php");

if(isset($_GET['cat'])){
    $cat_id=$_GET['cat'];

    // $select_cat="SELECT * FROM `products` WHERE `cat_id`=$cat_id";
    // $run_select_cat=mysqli_query($connect , $select_cat);

    $select_sub_cat="SELECT * FROM `sub_category`  WHERE `cat_id`=$cat_id";
    $run_select_sub=mysqli_query($connect , $select_sub_cat);
}
// $_SESSION['cat']=$cat_id;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <?php foreach($run_select_sub as $data){?>
        <a href="products.php?sub=<?php echo $data['sub_id'] ?>">
            <button><?php echo $data['sub_name']?>
            </button> 
        </a>
        <?php } ?>
</body>
</html>