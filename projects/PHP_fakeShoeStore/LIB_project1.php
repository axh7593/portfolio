<?php
function sanitize($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
}

function alphaNumericSpace($value) {
	$reg = "/^[A-Za-z0-9 ]+$/";
	return preg_match($reg,$value);
}

function numbers($value) {
	$reg = "/^[0-9]+$/";
	return preg_match($reg,$value);
}

function validateInput(){
 
  if (empty($_POST["ProductName"])) {
    $error .= "\nProduct Name is required!";
  } else {
    $productName = sanitize($_POST["ProductName"]);
    if(!alphaNumericSpace($productName))
    $error .= "\nInvalid Product Name!";
  }

  if (empty($_POST["Description"])) {
    $error .= "\nDescription is required!";
  } else {
    $description = sanitize($_POST["Description"]);
    if(!alphaNumericSpace($description))
    $error .= "\nInvalid description!";
  }

  if (empty($_POST["Quantity"])) {
    $error .= "\nQuantity is required!";
  } else {
    $quantity = sanitize($_POST["Quantity"]);
    if(!numbers($quantity))
    $error .= "\nInvalid Quantity!";
  }

  if (empty($_POST["ImageName"])) {
    $error .= "\nImage needs to be uploaded first!";
  } else {
    $image_name = sanitize($_POST["ImageName"]);
  }
  
  if (empty($_POST["Price"])) {
    $error .= "\nPrice is required!";
  } else {
    $price = sanitize($_POST["Price"]);
    if(!numbers($price))
    $error .= "\nInvalid Price!";
  }
  
  if(!empty($_POST["SalePrice"])){
  	$salesPrice = sanitize($_POST["SalePrice"]);
  	if(!numbers($sales_price))
    $error .= "\nInvalid Sale Price!";
  	if($salesPrice>$price){
  		$error .= "\nSale Price should be less than Original price!";
  	}
   
  }
  return $error;

}

?>