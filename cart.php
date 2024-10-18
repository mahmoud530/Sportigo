<?php
include "nav.php";
$user_id=$_SESSION['user_id'];

$select_cart = "SELECT cart.*, `products`.`product_name`, `products`.`product_price` 
    FROM `cart` 
    JOIN `products` ON `cart`.`product_id` = `products`.`product_id` 
    WHERE `cart`.`user_id` = $user_id";

$run_select = mysqli_query($connect, $select_cart);
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $delete = "DELETE FROM `cart` WHERE `product_id` = $id AND `user_id` = $user_id";
    $run_delete = mysqli_query($connect, $delete);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css"> 
</head>
<body>
<div class="container">
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($run_select as $data) { ?>
            <tr>
                <td><?php echo $data['product_name'] ?></td>
                <td><?php echo $data['product_price'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $data['product_id']; ?>">
                        <button type="submit" name="delete">DELETE</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <a href="checkout.php?user_id=<?php echo $user_id; ?>">Checkout</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>