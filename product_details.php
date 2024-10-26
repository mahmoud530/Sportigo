<?php
include("nav.php");
$user_id = $_SESSION['user_id'];

$s = $m = $l = $xl = 0;
if (isset($_GET['pro'])) {
    $product_id = $_GET['pro'];
}
$select_product = "SELECT * FROM `products` WHERE `product_id` = $product_id";
$run_pro = mysqli_query($connect, $select_product);

if (isset($_POST['small'])) {
    $select_size_s = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 1";
    $run_size1 = mysqli_query($connect, $select_size_s);
    $fetsh1 = mysqli_fetch_assoc($run_size1);
    $s = isset($fetsh1['quantaty']) ? $fetsh1['quantaty'] : 0;
}

if (isset($_POST['mid'])) {
    $select_size_m = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 2";
    $run_size2 = mysqli_query($connect, $select_size_m);
    $fetsh2 = mysqli_fetch_assoc($run_size2);
    $m = isset($fetsh2['quantaty']) ? $fetsh2['quantaty'] : 0;
}

if (isset($_POST['large'])) {
    $select_size_l = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 3";
    $run_size3 = mysqli_query($connect, $select_size_l);
    $fetsh3 = mysqli_fetch_assoc($run_size3);
    $l = isset($fetsh3['quantaty']) ? $fetsh3['quantaty'] : 0;
}

if (isset($_POST['xlarge'])) {
    $select_size_xl = "SELECT * FROM `product_size` WHERE `product_id` = $product_id AND `size_id` = 4";
    $run_size4 = mysqli_query($connect, $select_size_xl);
    $fetsh4 = mysqli_fetch_assoc($run_size4);
    $xl = isset($fetsh4['quantaty']) ? $fetsh4['quantaty'] : 0;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    $quantity_small = isset($_POST['quantity_small']) ? $_POST['quantity_small'] : 0;
    $quantity_mid = isset($_POST['quantity_mid']) ? $_POST['quantity_mid'] : 0;
    $quantity_large = isset($_POST['quantity_large']) ? $_POST['quantity_large'] : 0;
    $quantity_xlarge = isset($_POST['quantity_xlarge']) ? $_POST['quantity_xlarge'] : 0;

    if ($quantity_small > 0) {
        $insert_cart = "INSERT INTO `cart` (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity_small') ON DUPLICATE KEY UPDATE quantity = quantity + $quantity_small";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_mid > 0) {
        $insert_cart = "INSERT INTO `cart` (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity_mid') ON DUPLICATE KEY UPDATE quantity = quantity + $quantity_mid";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_large > 0) {
        $insert_cart = "INSERT INTO `cart` (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity_large') ON DUPLICATE KEY UPDATE quantity = quantity + $quantity_large";
        mysqli_query($connect, $insert_cart);
    }
    if ($quantity_xlarge > 0) {
        $insert_cart = "INSERT INTO `cart` (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity_xlarge') ON DUPLICATE KEY UPDATE quantity = quantity + $quantity_xlarge";
        mysqli_query($connect, $insert_cart);
    }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/product-details.css">
    <title>Sportigo</title>
</head>

<body>
    <div class="main">
        <div class="container">
            <?php foreach ($run_pro as $row) { ?>
                <div class="prod-img">
                    <img src="images/<?php echo $row['product_photo'] ?>" height="500px" width="500px">
                </div>
                <div class="content">
                    <h1><?php echo $row['product_name'] ?></h1>
                    <h2>L.E <?php echo $row['product_price'] ?></h2>

                    <h2 class="title">Size:</h2>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?>">
                        <input type="hidden" name="quantity_small" value="0">
                        <input type="hidden" name="quantity_mid" value="0">
                        <input type="hidden" name="quantity_large" value="0">
                        <input type="hidden" name="quantity_xlarge" value="0">

                        <div class="sizes">
                            <div class="size" id="size-s">
                                <button type="submit" name="small">S</button>
                                <div class="btnssss">
                                    <button class="minus" type="button"> - </button>
                                    <span class="counter">0</span>
                                    <button class="plus" type="button"> + </button>
                                </div>
                            </div>
                            <div class="size" id="size-m">
                                <button type="submit" name="mid">M</button>
                                <div class="btnssss">
                                    <button class="minus" type="button"> - </button>
                                    <span class="counter">0</span>
                                    <button class="plus" type="button"> + </button>
                                </div>
                            </div>
                            <div class="size" id="size-l">
                                <button type="submit" name="large">L</button>
                                <div class="btnssss">
                                    <button class="minus" type="button"> - </button>
                                    <span class="counter">0</span>
                                    <button class="plus" type="button"> + </button>
                                </div>
                            </div>
                            <div class="size" id="size-xl">
                                <button type="submit" name="xlarge">XL</button>
                                <div class="btnssss">
                                    <button class="minus" type="button"> - </button>
                                    <span class="counter">0</span>
                                    <button class="plus" type="button"> + </button>
                                </div>
                            </div>
                        </div>

                        <p>Pieces left:
                            <?php
                            if (isset($_POST['small'])) {
                                echo $s > 0 ? $s : "Out of stock";
                            } elseif (isset($_POST['mid'])) {
                                echo $m > 0 ? $m : "Out of stock";
                            } elseif (isset($_POST['large'])) {
                                echo $l > 0 ? $l : "Out of stock";
                            } elseif (isset($_POST['xlarge'])) {
                                echo $xl > 0 ? $xl : "Out of stock";
                            }
                            ?>
                        </p>

                        <div class="btns">
                            <button type="submit" name="add_to_cart">Add To Cart <i class="fa-solid fa-cart-shopping"></i></button>
                            <button><i class="fa-solid fa-heart"></i></button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        // Get all the plus and minus buttons and counters
        const plusButtons = document.querySelectorAll('.plus');
        const minusButtons = document.querySelectorAll('.minus');
        const counters = document.querySelectorAll('.counter');

        // Initialize an array to hold counts for each size
        let counts = Array.from(counters).map(() => 0);

        // Function to update all counters and save them to hidden inputs
        function updateCounters() {
            counters.forEach((counter, index) => {
                counter.textContent = counts[index];
                document.querySelector(`input[name="quantity_${index === 0 ? 'small' : index === 1 ? 'mid' : index === 2 ? 'large' : 'xlarge'}"]`).value = counts[index];
            });
        }

        // Update counters on page load
        updateCounters();

        // Increment the counter for the specific size when plus is clicked
        plusButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                counts[index]++;
                updateCounters();
            });
        });

        // Decrement the counter for the specific size when minus is clicked
        minusButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                if (counts[index] > 0) {
                    counts[index]--;
                    updateCounters();
                }
            });
        });
    </script>
</body>

</html>
