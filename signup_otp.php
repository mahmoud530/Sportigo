<?php
include 'mail.php'; 
$time=$_SESSION['time'];
$rand2=$_SESSION['otp'];
$email=$_SESSION['user_email'];

$passwordhashing= $_SESSION['user_password'];
$name= $_SESSION['user_name'];
$phone=$_SESSION['user_phone'];

$error="";
$time+=100;

if (isset($_POST['submit'])){
    $otp=$_POST['1'].$_POST['2'].$_POST['3'].$_POST['4'].$_POST['5'];
    if($rand2==$otp){
        $new_time=time();
        
        if($new_time <=$time){
            $insert="INSERT INTO `users` VALUES(NULL,'$name','default.png','$email','$passwordhashing','$phone')";
            $run_insert=mysqli_query($connect,$insert);
                    header("location:login.php");
        }        else{
            $error= "expired otp";
        }}
        else{
            $error= "incorrect otp";
        }}


        if (isset($_POST['resend'])){
            $rand3=rand(10000,99999);
            $_SESSION['otp']=$rand3;
            $msg="hello your otp is $rand3";

            $mail->setFrom('maloka.elhalawany@gmail.com', 'sportigo');          //sender mail address , website name
$mail->addAddress($email);      //reciever mail address
$mail->isHTML(true);                               
$mail->Subject = 'Activation code';             //mail subject
$mail->Body=($msg);                  //mail content
$mail->send(); 
            
    }


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rubik:ital,wght@0,300..900;1,300..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- bootstrab -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="./css/otp.css">
</head>

<body>
    
    <section class=" container-fluid bg-body-tertiary d-flex">
        <div class="row">
            <div class=" big d-flex col-12 col-md-6 col-lg-4">
                <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                    <div class="card-body p-5 text-center">
                        <i class="fa-solid fa-lock"></i>
                        <h2>Verify</h2>
                        <p class="pp">Your code was sent to you via email</p>
                        <form method ="POST">
                        <div class="otp-field mb-4">
                            <input type="number" name="1" />
                            <input type="number" name="2"  />
                            <input type="number" name="3"  />
                            <input type="number" name="4" />
                            <input type="number" name="5" />
                        </div>
                        <!-- ----------------------error------------------ -->
                        <div class="error">
                            <p><?php echo $error ?></p>
                        </div>
                           <!-- ----------------------error------------------ -->
                        <button class="btn btn-primary mb-3" name="submit">
                            Verify
                        </button>
                    </form>
                        <form method ="POST">
                        <button class="btn btn-primary mb-3" name ="resend">
                        resend
                        </button>
                        </form>
                        <!-- <p class="resend text-muted mb-0">
                            Didn't receive code? <a href="user_signup.php">Request again</a>
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- bootstrap js link -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <!-- js -->
    <script src="./js/otp.js"></script>
</body>

</html>