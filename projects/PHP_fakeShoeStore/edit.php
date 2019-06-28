<?php
include('DB.class.php');
// include santization and validation page
include('LIB_project1.php');
function makeForm(){
$db = new DB();
// key that password needs to match to submit form
$key = 12345;

global $password;
global $error;



$id = $_GET['ProductID'];
$data = $db -> getThisItem($id);

$ProductID = $data['ProductID'];
$ProductName = $data['ProductName'];
$Description = $data['Description'];
$Price = $data['Price'];
$Quantity = $data['Quantity'];
$SalePrice = $data['SalePrice'];


// add a connection to the database
$con = mysqli_connect('localhost','root','root','php_shoeStore');
// make form data
$string = "";
$string .="<form action='edit.php?ProductID=$ProductID' method='post'><input type='hidden' name='ProductID' value='$ProductID'/><div><p><strong>Product ID:</strong>$ProductID</p>
<strong>Password: *</strong><input type='password' name='Password' /><br>
<strong>Product name: *</strong><input type='text' name='ProductName' value='$ProductName'/><br/>
<strong>Description: *</strong> <input type='text' name='Description' value='$Description'/><br/>
<strong>Price: *</strong> <input type='number' name='Price' value='$Price'/><br/>";

$string .="<strong>Quantity: *</strong> <input type='number' name='Quantity' value='$Quantity'/><br/><strong>Sale Price: *</strong> <input type='number' name='SalePrice' value='$SalePrice'/><br/><p>* Required</p><input type='submit' name='submit' value='Submit'><a href='admin.php'>Cancel</a></div></form>";
// display form
echo $string;

// check to see if password is set
if(isset($_POST[$password])){

  // get password posted from form
  $password = $_POST['Password'];

}

// if password is equal to the key submit query and update table, if not echo error
if($password == $key)
{
if(isset($_POST['submit'])){
      if(is_numeric($_POST['ProductID'])){
        $ProductID = $_POST['ProductID'];
        // post corresponding table colums
        $ProductName = mysqli_real_escape_string($con, htmlspecialchars($_POST['ProductName']));
        $Description = mysqli_real_escape_string($con, htmlspecialchars($_POST['Description']));
        $Price = mysqli_real_escape_string($con, htmlspecialchars($_POST['Price']));
        $Quantity = mysqli_real_escape_string($con, htmlspecialchars($_POST['Quantity']));
        $SalePrice = mysqli_real_escape_string($con, htmlspecialchars($_POST['SalePrice']));
     if ($valid == false){
            $result = mysqli_query($con, "UPDATE shoes SET ProductName='$ProductName', Description='$Description', Price='$Price', Quantity='$Quantity', SalePrice='$SalePrice' WHERE ProductID='$ProductID'") or die(mysqli_error);
         echo $password;
            header("Location:admin.php");

        } else{
            $error = "An error occured";
            echo $error;

        }
} else {
          echo "not a number";
      }
}
}else{
    $error = "passwords do not match!";
    echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}


function validate($ProductName, $Description, $Price, $Quantity, $SalePrice){
    $error = false;
    if ($ProductName == ""){
        $error = true;
    }
    else {

    }
      if ($Description == ""){
        $error = true;
    }
      if ($Price == ""){
        $error = true;
    }
      if ($Quantity == ""){
        $error = true;
    }
      if ($SalePrice == ""){
        $error = true;
    }
    return $error;
}
}



?>

<!DOCTYPE HTML>

<html>

<head>

<title>Edit Products</title>

</head>

<body>
<?php makeForm();?>
<?php
    if($error != ''){
        echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

    }
?>


</body>

</html>
