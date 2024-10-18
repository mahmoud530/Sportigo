<?php 
include("mail.php");
$name="";
$email="";
$password="";
$match="";
$phone="";
$error_msg="";
$form = isset($_POST['form_action']) ? $_POST['form_action'] : 'sign_up';

if($form=='sign_up' && isset($_POST['submit'])){    $form=$_POST['form_action'];

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
      
      }if($rows>0){
          $error_msg="this email is already taken";
      }elseif($lowercase<1 || $uppercase <1||$numbers<1){
           $error_msg="password must contain at least 1 uppercase , 1 lowercase and number";
      }elseif($password !=$match){
          $error_msg= "password doesn't match confirmed password";
      }elseif(strlen($phone)!=11){
           $error_msg="please enter a valid phone number";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
<form action="" method="POST">
                <!-- -------------------user signup----------------- -->
                <h1>Create Account</h1>
                <span>Create A user Account</span><BR>

                <?php if (!empty($error_msg)): ?>
        <p style="color: red;"><?php echo $error_msg; ?></p>
    <?php endif; ?>
                <!-- <input type="hidden" placeholder="form_action" name="form_action" value="sign_upF"> -->
                <input type="hidden" placeholder="form_action" name="form_action" value="sign_up">


                <input type="text" placeholder="Name" name="user_name"value="<?php echo $name?>"><BR>
                
 
                <input type="email" placeholder="Email" name="user_email"value="<?php echo $email?>"><br>
              

                <input type="password" placeholder="Password" name="user_password" required><br>
                <!-- <div class=error2><?php echo $password ?> </div> -->

                <input type="password" placeholder="Confirm Password" name="confirm_pass" required><br>
                 <!-- <div class=error2> <?php echo $match ?></div> -->

                 <input type="number" value="<?php echo $phone?>" name="user_phone" id="user_phone" placeholder="+02" required><br>

                <button type="submit" name="submit">submit</button>
                <a href="login.php" class="login-btn">Have An Account ?</a>



                
</body>
</html>