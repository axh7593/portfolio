<?php
include('DB.class.php');
$con = mysqli_connect('localhost','root','root','php_shoeStore');

if(isset($_GET['ProductID']) && is_numeric($_GET['ProductID'])){
    $ProductID = $_GET['ProductID'];
    $result = mysqli_query($con, "DELETE FROM shoes WHERE ProductID='$ProductID'") or die(mysqli_error());
    header("Location:admin.php");
} else{
    header("Location:admin.php");
}
?>
