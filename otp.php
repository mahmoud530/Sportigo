<?php 
include 'connection.php';
$rand=$_SESSION['otp'];

if(isset($_POST['submit'])){
    $otp=$_POST['otp'];
    if($rand==$otp){
        header("location:change_pass.php");
    }else{
        echo"incorrect otp";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>otp</title>
</head>
<body>
    <form method="POST">
        <input type="number" name="otp">
        <button type="submit" name="submit">send</button>
</body>
</html>