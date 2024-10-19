<?php
include("connection.php");

if(isset($_POST['text'])){
    $text = mysqli_real_escape_string($connect, $_POST['text']);

    // Only proceed if $text is not empty
    if(strlen($text) > 0) {
        $select_search = "SELECT * FROM `products` WHERE `product_name` LIKE '%$text%'";
        $run_select_search = mysqli_query($connect, $select_search);
        
        if(mysqli_num_rows($run_select_search) > 0){
            while($row = mysqli_fetch_assoc($run_select_search)){
                echo '<div class="search-item">';
                echo '<p>' . $row['product_name'] . '</p>';
                echo '<img src="./images/' . $row['product_photo'] . '" alt="' . $row['product_name'] . '">';
                echo '</div>';
            }
        } else {
            echo '<p>No products found</p>';
        }
    } else {
        echo '<p>Please enter a search term</p>';
    }
}

?>
