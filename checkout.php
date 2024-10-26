<?php
include "nav.php";
$user_id = $_SESSION['user_id'];

$select_cart = "SELECT * FROM `cart`
    JOIN `products` ON `cart`.`product_id` = `products`.`product_id`
    JOIN `users` ON `cart`.`user_id` = `users`.`user_id`
    WHERE `users`.`user_id` = $user_id";
$run_select_cart = mysqli_query($connect, $select_cart);

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
    <h2>Your Cart</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total_amount = 0; 
        foreach ($run_select_cart as $data) { 
            $product_name = $data['product_name'];
            $quantity = $data['quantity'];
            $price = floatval(preg_replace('/[^0-9.]/', '', $data['product_price'])); // Strip non-numeric characters //chatgptt
            $total_price = $price * $quantity; 
            $total_amount += $total_price;
        ?>
            <tr>
                <td><?php echo $product_name; ?></td>
                <td><?php echo $quantity; ?></td>
                <td>$<?php echo number_format($price, 2); ?></td>
                <td>$<?php echo number_format($total_price, 2); ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right;"><strong>Total Amount:</strong></td>
                <td><strong>$<?php echo number_format($total_amount, 2); ?></strong></td>
            </tr>
            <tr>
                <td colspan="4">
                    
                      <a href="payment.php"> <button type="button" name="confirm_order">Confirm Order</button> </a>
                    
                </td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
