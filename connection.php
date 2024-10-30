<?php

$localhost = "localhost";
$username = "root";
$password = "";
$database ="sportigo";

$connect = mysqli_connect($localhost, $username ,$password , $database); 
if($connect){
    // echo"connected" ;
}

session_start();
ob_start();
if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    header("location:login and sign up.php");
}
    // if(!empty($_SESSION['freelancer_id'])){
    //     $id=$_SESSION['freelancer_id'];
    //     $select="SELECT * FROM `freelancer` where `freelancer_id`=$id";
    //     $run=mysqli_query($connect,$select);
    //     $fetch=mysqli_fetch_assoc($run);
    //     $ban=$fetch['ban'];
    //     $date=$fetch['time'];
    //     $old_date=strtotime("$date");
    //     $current_date=strtotime("today");
    //     if(($ban==1) && ($old_date <=$current_date)){
    //         session_unset();
    //         session_destroy();
    //         header("location:login.php");
    //     }
    // }

    // error_reporting(0);

?>
