<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "php_shoeStore";

$dbc = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Error connecting to your MySQL Server");

// delete table by truncating
if(isset($_POST['delete'])){
    $query = "TRUNCATE TABLE cart";
    $result = mysqli_query($dbc,$query) or die("Error deleting table");
    header("Location: cart.php");

} else{
    echo "Sorry";
}

?>
