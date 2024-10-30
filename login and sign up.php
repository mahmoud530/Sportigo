<?php 
include("mail.php");
$name="";
$email="";
$password="";
$match="";
$phone="";
$error_msg="";
$form = isset($_POST['form_action']) ? $_POST['form_action'] : 'sign_up';
$isSignUpError = false; // Track if there’s an error in the sign-up form


if($form=='sign_up' && isset($_POST['submit'])){  ;
    $form = $_POST['form_action'];

    $name=$_POST['user_name'];
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $match=$_POST['confirm_pass'];
    $phone=$_POST['user_phone'];

    $passwordhashing=password_hash($password , PASSWORD_DEFAULT);
    $lowercase=preg_match('@[a-z]@',$password);
    $uppercase=preg_match('@[A-Z]@',$password);
    $numbers=preg_match('@[0-9]@',$password);

    $select="SELECT * FROM `users` WHERE `user_email` ='$email' ";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);

    if(empty($name)||empty($email)||empty($password)||empty($match)||empty($phone)){
        $error_msg= " please fill all required data ";
        $isSignUpError = true;

      }if($rows>0){
          $error_msg="this email is already taken";
          $isSignUpError = true;

      }elseif($lowercase<1 || $uppercase <1||$numbers<1){
           $error_msg="password must contain at least 1 uppercase , 1 lowercase and number";
           $isSignUpError = true;

      }elseif($password !=$match){
          $error_msg= "password doesn't match confirmed password";
          $isSignUpError = true;

      }elseif(strlen($phone)!=11){
           $error_msg="please enter a valid phone number";
           $isSignUpError = true;

      }else{
          $_SESSION['user_name']=$name;
          $_SESSION['user_email']=$email;
          $_SESSION['user_password']=$passwordhashing;
          $_SESSION['user_phone']=$phone;

        //   $insert="INSERT INTO `users` VALUES(NULL,'$name','default.png','$email','$passwordhashing','$phone')";
        //     $run_insert=mysqli_query($connect,$insert);
        
    //otttttttttttttttpppppppp


    $rand=rand(10000,99999);
    $msg="hello,your otp is $rand";
  // php mail start->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  $mail->setFrom('maloka.elhalawany@gmail.com', 'sportigo');          //sender mail address , website name
  $mail->addAddress($email);      //reciever mail address
  $mail->isHTML(true);                               
  $mail->Subject = 'Activation code';             //mail subject
  $mail->Body=($msg);                  //mail content
  $mail->send(); 
         //php mail end ->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 


         $_SESSION['otp']=$rand;
         $_SESSION['time']=time();
         header("location:signup_otp.php");



}}
// <!-- login -->
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
            header("Location: Homee.php");
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/test.css">
    <title>Document</title>
</head>

<body>


    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
                <input type="checkbox" class="toggle" id="toggleSwitch">
                <span class="slider"></span>
                <span class="card-side"></span>
                <div class="flip-card__inner" id="flipCard">
                    <div class="flip-card__front" >
                        <div class="img">
                        </div>
                        <div class="main-form">
                            <!-- --------------------login form---------------------- -->
                            <div class="title">Log in</div>

                            <form class="flip-card__form" action=""method="POST">
                                <!-- email -->
                                <label for="email">Emali</label>
                                <input class="flip-card__input" type="email" name="user_email" id="Email"value="<?php echo !empty($email) ? $email : (isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : ''); ?>" 
                                placeholder="Enter Your E-mail" required>
                                <!-- pass -->
                                <label for="pass">Password</label>
                                <input class="flip-card__input" type="password" name="user_password" id="pass" value="<?php echo !empty($password) ? $password : (isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''); ?>" 
    
                                placeholder="Enter Your Password" required>

                                <div class="forget-rem">
                                    
                                <!-- 'Remember Me' checkbox -->
            <label>
                <input type="checkbox" name="remember" value="1"
                    <?php echo (!empty($remember) || isset($_COOKIE['remember'])) ? 'checked' : ''; ?>>
                Remember me
            </label>

            <!-- Forget password link -->
            <a href="forget_pass.php" class="forget"> Forget Password ?</a>
                                </div>
                        <!-- Error message -->
 <?php if (!empty($error_msg) && !$isSignUpError) { ?>
                <p style="color: red;"><?php echo $error_msg; ?></p>
            <?php } ?>
                                <button class="flip-card__btn"type="submit" name="login">Login</button>
                            </form>
                        </div>

                    </div>


                    
                <div class="flip-card__back">
                    <div class="mainn-form">
                        <!-- ---------------------sign up------------------- -->
                        <div class="title">Sign up</div>
                        <form class="flip-card__form" action=""method="POST">
                        <input type="hidden" placeholder="form_action" name="form_action" value="sign_up">

                            <label for="name">Name</label>
                            <input class="flip-card__input"type="text" placeholder="Name" name="user_name"value="<?php echo $name?>"> 

                            <label for="emaill">Email</label>
                            <input class="flip-card__input"type="email" placeholder="Email" name="user_email"value="<?php echo $email?>" >

                            <label for="password">Password</label>
                            <input class="flip-card__input"type="password" placeholder="Password" name="user_password" minlength="8" required >
                            <!-- <div class=error2><?php echo $password ?> </div> -->

                            <label for="cpass">Confirm Password</label>
                            <input class="flip-card__input" type="password" placeholder="Confirm Password" name="confirm_pass" required>
                            <!-- <div class=error2> <?php echo $match ?></div> -->

                            <label for="pnum">Phone Number</label>
                            <input class="flip-card__input" type="number" value="<?php echo $phone?>" name="user_phone" id="user_phone" placeholder="+02" minlength="11" required>
                            
                                  <!-- Error message -->
 <?php if (!empty($error_msg) && $isSignUpError) { ?>
                <p style="color: red;"><?php echo $error_msg; ?></p>
            <?php } ?>
                            <button class="flip-card__btn"type="submit" name="submit">Confirm!</button>
                            <a href="login and sign up.php" class="login-btn">Have An Account ?</a>
                        </form>
                    </div>
                    <div class="imgg">

                    </div>
                </div>

                </div>

        </div>
        </label>
    </div>
    </div>
    <script>
        // Check if there is an error on the Sign-Up slide and toggle accordingly
        document.addEventListener('DOMContentLoaded', function() {
            let isSignUpError = <?php echo json_encode($isSignUpError); ?>;
            let toggleSwitch = document.getElementById('toggleSwitch');

            if (isSignUpError) {
                // Check the toggle to stay on Sign-Up slide if there's an error
                toggleSwitch.checked = true;
            }
        });
    </script>
</body>

</html>