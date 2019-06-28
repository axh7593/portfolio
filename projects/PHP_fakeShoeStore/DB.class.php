<?php
include "Product.class.php";
class DB {
    private $connection;


    //constructor
    function __construct(){
        require_once("dbinfo.php");
        $this -> connection = new mysqli($host, $user, $pass, $dbname);
        if ($this -> connection -> connect_error){
            // if cant connect print out reason and kill script otherwise connect
            echo "connect failed: " . mysqli_connect_error();
            die();
        }
    }


// get all sale item data from the table
    function getSaleItems(){
         $data = array();
        if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE SalePrice > 0")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       return $data;
    }

    // get all sale items as a formatted html area
    function getSaleItemsFormatted(){
         $data = $this -> getSaleItems();
        if(count($data) > 0){
            $bigString = "<div class='row'>
                        <div class='row'>
                        <h2> On Sale </h3>";
            // display sale items as intended by the bootstrap template used
            foreach($data as $row){
                $bigString .= "<form action='index.php' method='POST'>
                        <div class='col-sm-4 col-lg-4 col-md-4'>
                        <div class='thumbnail'>
                         <img src='img/{$row["ImageName"]}'>
                        <div class='caption'>
                        <input type='hidden' name='id' value='{$row['ProductID']}'>
                        <input type='submit' name='saleSubmit' id='{$row['ProductID']}'class='btn' value='Add To Cart'>";

                $bigString .= "<h4 class='pull-right'>Sale Price:$"."{$row['SalePrice']}</h4>
                                <p class='pull-right' style='float:right;margin-left:40px;text-decoration:line-through;'>Original Price:$"."{$row['Price']}</p>
                                <h4>{$row['ProductName']} </h4>
                                <h4> Quantity Left: {$row['Quantity']} </h4>
                                <p> {$row['Description']} </p>
                                </div></form></div></div>";
            }

            $bigString .= "</div></div>";
        } else {
            $bigString = "<h2> No Sales exist </h2>";
        }
        return $bigString;


    }

    // attempt at paging function
    function populatePage($limit,$offset){
            $data =  array();
            if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE SalePrice = 0 LIMIT $limit OFFSET $offset")){
            $stmt -> execute();
            $stmt -> store_result();

            $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

            if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       // var_dump($data);
       return $data;

    }

    // get all non sale item data from the table
    function getAllItems(){
        $data = array();
        if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE SalePrice=0")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       return $data;


    }
    function selectAllItems(){
        $data = array();
        if($stmt = $this -> connection -> prepare("SELECT * FROM shoes")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       return $data;
    }


    function getThisItem($id){
        $data = array();
        if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE ProductID = $id")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       return $data[0];


    }


    // get all non sale items as a formatted html area
    function getAllItemsFormatted(){
        $data = $this -> getAllItems();
        if(count($data) > 0){
            $bigString = "<div class='row'>
                        <div class='row'>
                        <h2> Catalog</h2>";


            // parse all data into HTML
            // display sale items as intended by the bootstrap template used
            foreach($data as $row){
                $bigString .= "<form action='index.php' method='POST'>
                        <div class='col-sm-4 col-lg-4 col-md-4'>
                        <div class='thumbnail'>
                         <img src='img/{$row["ImageName"]}'>
                        <div class='caption'>
                        <input type='hidden' name='id' value='{$row['ProductID']}'>
                        <input type='submit' name='submit' id='{$row['ProductID']}'class='btn' value='Add To Cart'>";

                $bigString .= "<h4 class='pull-right'>Price:$"."{$row['Price']}</h4>
                                <h4>{$row['ProductName']} </h4>
                                <h4> Quantity Left: {$row['Quantity']} </h4>
                                <p> {$row['Description']} </p>
                                </div></form></div></div>";
            }

            $bigString .= "</div></div>";
        } else {
            $bigString = "<h2> No Products exist </h2>";
        }
        return $bigString;


    }

    function ifExists($id){
        $data = array();
        if($stmt = $this -> connection -> prepare("SELECT * FROM cart WHERE ProductID = $id")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity);
                } // end while
            } //end if num rows > 0

        }
         //echo "DATA: ";var_dump($data);
       return $data;
    }

    function updateQuantity($id,$Quantity){
        $data = array();
        if($stmt = $this -> connection -> prepare("UPDATE cart SET Quantity=$Quantity WHERE ProductID = $id")){
          $stmt -> execute();

          $stmt -> store_result();

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                   "ImageName" => $ImageName,
                                   "SalePrice" => $SalePrice);
                } // end while
            } //end if num rows > 0
      }
       return $data;
    }

    // add normal non sale items to cart as seperate
    function addToCart(){
        $data = $this -> getCart();

        if(isset($_POST['id'])){
            $id = $_POST['id'];


                $ray = array();
                if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE ProductID = $id")){
                    $stmt -> execute();

                    $stmt -> store_result();
                    $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

                    if ($stmt -> num_rows > 0){
                    while($stmt -> fetch()){
                    $ray[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                  "ImageName" => $ImageName,
                                  "SalePrice" => $SalePrice);
                    } // end while
                    }
                }


            $Quantity = 1;
            $sql = "INSERT INTO cart (ProductID,ProductName,Quantity,Description,Price) VALUES (?,?,?,?,?)";
            $stmt = $this ->connection ->prepare($sql);

// check to make sure the statement was prepared without error
if ($stmt) {
   // the statement is good - proceed
   $stmt->bind_param("sssss",$ProductID, $ProductName, $Quantity, $Description,$Price);
   $stmt->execute();
} else {
    $success = false;
}

if ($success === true) {
     echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
        echo "<script type='text/javascript'>alert('You added a product to the cart');</script>";}
    }
    // add sales section of index.php to cart as seperate
    function addSalesToCart(){

          function addToCart(){
        $data = $this -> getCart();

        if(isset($_POST['id'])){
            $id = $_POST['id'];

                $ray = array();
                if($stmt = $this -> connection -> prepare("SELECT * FROM shoes WHERE ProductID = $id")){
                    $stmt -> execute();

                    $stmt -> store_result();
                    $stmt -> bind_result($ProductID, $ProductName, $Description, $Price, $Quantity, $ImageName, $SalePrice);

                    if ($stmt -> num_rows > 0){
                    while($stmt -> fetch()){
                    $ray[] = array("ProductID" => $ProductID,
                                    "ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity,
                                  "ImageName" => $ImageName,
                                  "SalePrice" => $SalePrice);
                    } // end while
                    }
                }


            $Quantity = 1;
            $sql = "INSERT INTO cart (ProductID,ProductName,Quantity,Description,Price) VALUES (?,?,?,?,?)";
            $stmt = $this ->connection ->prepare($sql);

// check to make sure the statement was prepared without error
if ($stmt) {
   // the statement is good - proceed
   $stmt->bind_param("sssss",$ProductID, $ProductName, $Quantity, $Description,$SalePrice);
   $stmt->execute();
} else {
    $success = false;
}

if ($success === true) {
     echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
            echo "<script type='text/javascript'>alert('You added a product to the cart');</script>";}
          }
    }

    // get all cart data from table
    function getCart(){
        $data = array();
        //select everything from the cart table
        if($stmt = $this -> connection -> prepare("SELECT * FROM cart")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($ProductID,$ProductName, $Description, $Price, $Quantity);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("ProductName" => $ProductName,
                                    "Description" => $Description,
                                   "Price" => $Price,
                                   "Quantity" => $Quantity);
                } // end while
            } //end if num rows > 0
      }
       return $data;
    }


    // display cart information
    function displayCart(){
        $count = 0;
        $data = $this -> getCart();

        if(count($data) > 0){
            $bigString = "<table border='1'>\n
                            <tr><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th></tr>\n";
            foreach($data as $row){
                $bigString .= "<td>{$row['ProductName']}</td><td>{$row['Description']}</td><td>{$row['Price']}</td><td>{$row['Quantity']}</td><tr>\n";

            }
            $bigString .= "</table>\n";
        } else {
            $bigString = "<h2> No products exist </h2>";
        }
        return $bigString;
    }


    // get Price data from cart table
    function getCartTotal(){
        $data = array();
        // query string to get the sum of the Price column of the cart
        if($stmt = $this -> connection -> prepare("SELECT SUM(Price) FROM cart")){
          $stmt -> execute();

          $stmt -> store_result();
          $stmt -> bind_result($Price);

          if ($stmt -> num_rows > 0){
                while($stmt -> fetch()){
                    $data[] = array("Price" => $Price);
                }
            }
      }
       return $data;
    }

    // displays total price which is calculated in getCartTotal
    function displayTotalPrice(){
        $data = $this -> getCartTotal();
        $bigString = "";

        if(count($data) > 0){
            foreach($data as $row){
                $bigString .= "<h2> Price: $"."{$row['Price']} </h2>";

            }
        } else{
           $bigString = "<h2> Price:$";
        }
        return $bigString;

    }

    // make structure for admin form on admin.php
    function adminForm(){
        $count = 0;
        $data = $this -> selectAllItems();

        if(count($data) > 0){
            $bigString = "<table border='1' cellpadding='10'>
                            <tr> <th>ID</th> <th>Name</th> <th>Description</th> <th> Price </th> <th>Quantity</th> <th>Sale Price</th> <th></th> <th></th></tr>";
            foreach($data as $row){
                $bigString .= "<tr>
                                <td>{$row['ProductID']}</td>
                                <td>{$row['ProductName']}</td>
                                <td>{$row['Description']}</td>
                                <td>{$row['Price']}</td>
                                <td>{$row['Quantity']}</td>
                                <td>{$row['SalePrice']}</td>
                                <td><a href='edit.php?ProductID={$row['ProductID']}'>Edit</a></td>
                                <td><a href='delete.php?ProductID={$row['ProductID']}'>Delete</a></td>
                                </tr>";

            }
            $bigString .= "</table>";
            $bigString .= "<p ><a href='newRecord.php'>Add a new record</a></p>";

        } else {
            $bigString = "<h2> No products exist </h2>";
        }
        return $bigString;

    }

}
