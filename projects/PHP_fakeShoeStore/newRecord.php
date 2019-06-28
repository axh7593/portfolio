<?php
include('DB.class.php');
$con = mysqli_connect('localhost','root','root','php_shoeStore');
// key that password needs to match to submit form
$key = 12345;
global $password;
global $ProductName;
global $Description;
global $Price;
global $Quantity;
global $SalePrice;
global $ImageName;


function renderForm($ProductName, $Description, $Price, $Quantity, $SalePrice, $ImageName,$error){
?>
<!DOCTYPE HTML>

<html>

<head>

<title>New Record</title>

</head>

<body>
<?php


    if($error != ''){
        echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
    }
?>

<form action="newRecord.php" method="post" enctype="multipart/form-data">
<strong>Password: *</strong><input type='password' name='Password' /><br>

<strong>Product Name: *</strong> <input type="text" name="ProductName" value="<?php echo $ProductName; ?>" /><br/>

<strong>Description: *</strong> <input type="text" name="Description" value="<?php echo $Description; ?>" /><br/>

<strong>Price: *</strong> <input type="number" name="Price" placeholder="$" value="<?php echo $Price; ?>" /><br/>

<strong>Quantity: *</strong> <input type="number" name="Quantity" value="<?php echo $Quantity; ?>" /><br/>

<strong>Sale Price: *</strong> <input type="number" name="SalePrice" placeholder="$" value="<?php echo $SalePrice; ?>" /><br/>
<input type="hidden" class='hidden' name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="3500000" />

<label for="uploaded_file">Choose a file to upload:</label>
    <input name="uploaded_file" id="uploaded_file" type="file" />


<p>* required</p>

<input type="submit" name="submit" value="Submit">
<a href="admin.php"> Cancel </>



</form>

</body>

</html>
<?php
}



  // get password posted from form
  $password = $_POST['Password'];



//allow user to upload file doesnt check file extesnion for image though
if(!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == 0 ){
    //check file size and type
    $filename = basename($_FILES['uploaded_file']['name']);
    // get extension
    $ext = substr($filename, strrpos($filename, '.' ) + 1);

       if($_FILES['uploaded_file']['size'] < 350000)
       {

        $newname = "./img/$filename";
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname)){
                             chmod($newname,0644);
                             $msg  ="It's done! the file has been saved.";
                             $json['msg'] = $msg;
                             $json['error'] = "";
                             echo json_encode($json);

    } else{
    $msg = "Error: an error occured during upload";
    $json = array();
    $json['msg'] = $msg;
    $json['error'] = 'No file was uploaded or an error occured';
    echo json_encode($json);
    }
    }


    else{
    $msg = "Error: Only Excel files < 350k allowed";
    $json = array();
    $json['error'] = 'No file was uploaded or an error occured';
    echo json_encode($json);

    }
}

 else {
    $msg = "Error: No file uploaded";
    $json = array();
    $json['error'] = 'No file was uploaded or an error occured';
    echo json_encode($json);
}
//$sanProductName = filter_var($ProductName,FILTER_SANITIZE_STRING);
// if password is equal to the key submit query and update table, if not echo error
if($password == $key)
{
if(isset($_POST['submit'])){

    $ProductName = mysqli_real_escape_string($con, htmlspecialchars($_POST['ProductName']));
    $Description = mysqli_real_escape_string($con, htmlspecialchars($_POST['Description']));
    $Price = mysqli_real_escape_string($con, htmlspecialchars($_POST['Price']));
    $Quantity = mysqli_real_escape_string($con, htmlspecialchars($_POST['Quantity']));
    $SalePrice = mysqli_real_escape_string($con, htmlspecialchars($_POST['SalePrice']));
    $ImageName = mysqli_real_escape_string($con, htmlspecialchars($_POST['ImageName']));
}
} else {
    $error = "Password does not match";
    echo $error;
}


    // check if any fields are empty
    if ($ProductName == '' || $Description == '' || $Price == '' || $Quantity == '' || $SalePrice == '' || $ImageName = ''){
        $error = 'ERROR: Please fill in all required fields!';
        renderForm($ProductName, $Description, $Price, $Quantity, $SalePrice, $ImageName,$error);

    } else {
        mysqli_query($con, "INSERT shoes SET ProductName='$ProductName', Description='$Description',Price='$Price',Quantity='$Quantity',SalePrice='$SalePrice', ImageName='$filename'")
            or die(mysqli_error($con));

        header("Location:admin.php");
    }
?>
