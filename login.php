<?php
include("connection.php");
$error_msg = "";
$email = ""; // Initialize variables to avoid undefined index errors
$password = "";
$remember = "";

if (isset($_POST['login'])) {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    
    // Check if 'Remember Me' is checked
    if (isset($_POST['remember'])) {
        $remember = $_POST['remember'];
    }

    // Query to check if the email exists in the database
    $select = "SELECT * FROM `users` WHERE `user_email` = '$email'";
    $run_select = mysqli_query($connect, $select);
    $rows = mysqli_num_rows($run_select);

    if ($rows > 0) {
        $fetch = mysqli_fetch_assoc($run_select);
        $hashed_password = $fetch['user_password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $user_id = $fetch['user_id'];
            $_SESSION['user_id'] = $user_id; 

            // If 'Remember Me' is checked, set cookies for 1 year
            if (isset($_POST['remember'])) {
                setcookie("remember_email", $email, time() + 3600 * 24 * 365); 
                setcookie("remember_password", $password, time() + 3600 * 24 * 365);   
  
                setcookie("remember", $remember, time() + 3600 * 24 * 365);
            } else {
                // If 'Remember Me' is not checked, delete cookies
                setcookie("remember_email", "", time() - 3600); 
                setcookie("remember_password", "", time() - 3600); 


                setcookie("remember", "", time() - 3600);

            }

            // Redirect to Home page after successful login
            header("Location: Home.php");
            exit;

        } else {
            $error_msg = "Password incorrect";
        }
    } else {
        $error_msg = "Incorrect email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<div class="main-cont">
    <div class="photo_main">
        <img class="photo" src="./images/login-amico.png" alt="">
    </div>

    <div class="main">
        <h2>Login</h2>
        <form class="form" method="POST">
            <!-- email -->
            <label for="Email">Email:</label>
            <input type="email" name="user_email" id="Email" 
                value="<?php echo !empty($email) ? $email : (isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : ''); ?>" 
                placeholder="Enter Your E-mail" required>
            
            <!-- pass -->
            <label for="pass">Password:</label>
            <div class="icon">
                <i class="fa-solid fa-eye" id="eye-icon"></i>
            </div>
            <input type="password" name="user_password" id="pass" class="pass"
            value="<?php echo !empty($password) ? $password : (isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''); ?>" 

             placeholder="Enter Your Password" required>

            <!-- Forget password link -->
            <a href="forget_pass.php" class="forget"> Forget Password ?</a>

            <!-- Error message -->
            <?php if (!empty($error_msg)) { ?>
                <p style="color: red;"><?php echo $error_msg; ?></p>
            <?php } ?>

            <!-- 'Remember Me' checkbox -->
            <label>
                <input type="checkbox" name="remember" value="1"
                    <?php echo (!empty($remember) || isset($_COOKIE['remember'])) ? 'checked' : ''; ?>>
                Remember me
            </label>

            <!-- Submit button -->
            <button class="zorar" type="submit" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
