    <?php 
    include 'mail.php';

    if(isset($_POST['submit'])){
        $email=$_POST['email'];
        $_SESSION['email']=$email;

        $select="SELECT * FROM `users` where `user_email` = '$email' ";
        $run_select=mysqli_query($connect,$select);
        $rows=mysqli_num_rows($run_select);
        if($rows>0){

            $rand=rand(10000,100000);
            $msg="Hello your otp is $rand";
            
         // php mail start->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$mail->setFrom('malllam146@gmail.com', 'malksh da3wa');          //sender mail address , website name
$mail->addAddress($email);      //reciever mail address
$mail->isHTML(true);                               
$mail->Subject = 'Activation code';             //mail subject
$mail->Body=($msg);                  //mail content
$mail->send(); 
       //php mail end ->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
            $_SESSION['otp']=$rand;
            header("location:otp.php");
        }else{
            $error_msg="email not found";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>forget_pass</title>
    </head>
    <body>
        





 
        
        <div class="main">

            <div class="verification">
                <form  method="POST" action="">
                    <div class="img-div">
                    <img src="./images/Forgot.PNG" class="img">
                    </div>
                    <h1>Change Password</h1>
                    <p class="p">Please type the Your Email</p>
                    <br><br>
                    <div class="inputs">
                    <input name="email" type="email" placeholder="info@example.com" required class="input">
                      
                    </div>
                    <?php if(isset($error_msg)) { ?>
                <p>
                 <?php error: echo"$error_msg"; ?>
                </p>
                <?php } ?>
                    <button type="submit" name="submit" class="btn">Send</button>

                </form>
            </div>

        </div>
    </div>




























    </body>
    </html>