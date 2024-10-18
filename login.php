<?php
include("connection.php");
$error_msg="";
if(isset($_POST['login'])){
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $select="SELECT * FROM `users` WHERE `user_email`='$email'";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);

    
    if($rows>0){
        $fetch=mysqli_fetch_assoc($run_select);
        $hashed_password=$fetch['user_password'];
            
         if(password_verify($password,$hashed_password)){
            $user_id=$fetch['user_id'];
            $_SESSION['user_id']=$user_id; 
         

            header("location:landing.php");



        } 
            else {
            $error_msg = "Password incorrect";
        }
        }
         else {
        $error_msg = "Incorrect email";
    }
}
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>login</title>
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
        <input type="email" name="user_email" id="Email" placeholder="Enter Your E-mail" required>
        <!-- pass -->

        <label for="pass">Password:</label>

        <div class="icon">
            <i class="fa-solid fa-eye" id="eye-icon"></i>


        </div>

        <input type="password" name="user_password" id="pass" class="pass" placeholder="Enter Your Password" required>
        <!-- pass icon -->

         <a href="forget_pass.php" class="forget"> Forget Password ?</a>
         <?php if(isset($error_msg)) { ?>
        <p>
         <?php error: echo"$error_msg" ?>
        </p>
        <?php } ?>
        <!-- button -->
        <button class="zorar" type="submit" name="login">Login</button>

    </form>
</div>
</div>
















        </body>
        </html>