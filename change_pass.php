<?php 
include 'connection.php';
$error="";
$err=FALSE;
if(isset($_POST['submit'])){
    $email=$_SESSION['email'];
    $password=$_POST['pass'];
    $confirm=$_POST['cpass'];
    $hashed=password_hash($password , PASSWORD_DEFAULT);
    $lowercase=preg_match('@[a-z]@',$password);
    $uppercase=preg_match('@[A-Z]@',$password);
    $numbers=preg_match('@[0-9]@',$password);

    if (strlen($password) < 6) {
     $error = "The password should have at least 6 characters.";
     $err=TRUE;
   }elseif ($password !=$confirm){
          $error="password doesn't match confirm password";
          $err=TRUE;
       } elseif ($uppercase<1 ||$lowercase<1 ||$numbers<1 ||$character<1 ){
          $error= "password must contain upeercase, lowercase, number and character ";
          $err=TRUE;
       }
       else{

    $update="UPDATE `users` set `user_password` = '$hashed' where `user_email` ='$email' ";
    $run_update=mysqli_query($connect,$update);
     echo "Password changed successfully";
     unset($_SESSION['otp']);
     unset($_SESSION['email']);
     header("Location:login.php");
}
     }
       

?>




<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Change password</title>
</head>
<body>
     <form method="POST">
          <label for="password">password</label>
          <input type="password" name="pass" id="password"><br>
          <br><br>
          <label for="">confirm password</label>
          <input type="password" name="cpass" id=""><br><br>


          <?php if ($err){ ?>
                            <p>error</p><br>
                            <?php echo $error; } ?>
                    </div>





          <button type="submit" name="submit">submit</button>
     </form>
</body>
</html>