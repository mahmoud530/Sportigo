<?php
include "nav.php";
$user_id = $_SESSION['user_id'];

$total_amount = 0; 
$select_cart = "SELECT * FROM `cart`
    JOIN `products` ON `cart`.`product_id` = `products`.`product_id`
    JOIN `users` ON `cart`.`user_id` = `users`.`user_id`
    WHERE `cart`.`user_id` = $user_id" ;
$run_select_cart = mysqli_query($connect, $select_cart);

if (mysqli_num_rows($run_select_cart) > 0) {
    foreach ($run_select_cart as $data) {
        $product_price = $data['product_price'];
        // Remove any non-numeric characters (such as 'L.E', '$')
        $numeric_price = floatval(preg_replace('/[^0-9.]/', '', $product_price));

        $quantity = $data['quantity'];
        $total_amount = $numeric_price * $quantity;
    }
}

if (isset($_POST['confirm_order'])) {
    $date = date('Y-m-d');
    $total_amount = 0; 
    
    foreach ($run_select_cart as $data) {
        $product_price = $data['product_price'];
        $numeric_price = floatval(preg_replace('/[^0-9.]/', '', $product_price));
        $quantity = $data['quantity'];
        $total_amount = $numeric_price * $quantity;

        // $cart_id = $data['cart_id'];  
    }

    $insert_order = "INSERT INTO `order` VALUES (NULL, '$user_id', '$total_amount', '$date', 'pending')";
    $run_insert_order = mysqli_query($connect, $insert_order);

    $select_order = "SELECT * FROM `order` WHERE `user_id` = $user_id ORDER BY `order_id` DESC LIMIT 1";
    $run_select_order = mysqli_query($connect, $select_order);
    $fetch = mysqli_fetch_assoc($run_select_order);
    $order_id = $fetch['order_id'];

    if (mysqli_num_rows($run_select_cart) > 0) {
        foreach ($run_select_cart as $data) {
            $product_id = $data['product_id'];
            $quantity = $data['quantity'];
            $numeric_price = floatval(preg_replace('/[^0-9.]/', '', $data['product_price']));
            $item_total_price = $numeric_price * $quantity;

            $insert_order_details = "INSERT INTO `order_details`  
                VALUES ('$order_id', '$product_id', '$quantity', '$item_total_price')";
            $run_details = mysqli_query($connect, $insert_order_details);
        }
    }

    $insert_payment = "INSERT INTO `payment` VALUES (NULL, '$total_amount', '$date', '$order_id')";
    $run_insert_payment = mysqli_query($connect, $insert_payment);

    $delete_cart = "DELETE FROM `cart` WHERE `user_id` = $user_id";
    $run_delete_cart = mysqli_query($connect, $delete_cart);

    echo "<script>alert('Order and payment completed successfully!');</script>";
}
?>

<html>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Confirm Your Order</h3>
        </div>
        <div class="card-body">
            <p>Order Total: <strong><?php echo number_format($total_amount, 2); ?> L.E</strong></p>
            <form method="POST">
                <h5>Select Payment Method</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="credit_card" id="credit_card" checked>
                    <label class="form-check-label" for="credit_card">
                        Credit Card
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal">
                    <label class="form-check-label" for="paypal">
                        PayPal
                    </label>
                </div>

                <div class="form-group mt-3">
                    <label for="card_number">Card Number</label>
                    <input type="text" class="form-control" id="card_number" placeholder="Enter your card number">
                </div>
                <div class="form-group">
                    <label for="card_expiry">Expiry Date</label>
                    <input type="text" class="form-control" id="card_expiry" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="card_cvc">CVC</label>
                    <input type="text" class="form-control" id="card_cvc" placeholder="CVC">
                </div>

                <div class="form-group mt-3">
                    <button type="submit" name="confirm_order" class="btn btn-primary btn-block">Confirm Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
</html>
