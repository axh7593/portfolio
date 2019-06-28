<?php include('cart_header.php'); ?>             
<!-- CONTENT GOES HERE --------------------------------->
        </div>
    <div>
        <?php
        $string = $db -> displayCart();
        echo $string;
        $string3 = $db -> displayTotalPrice();

        $total = 0;
        $allCart = $db -> getCart();
        foreach($allCart as $product){
            $price = $product['Price'];

            $qty = $product['Quantity'];
   
            $total +=$price*$qty;
            
        }
        echo "<h2> Price: $"."$total </h2>";

        //form that empties the cart by pointing to an external script
        echo "<form method='post' action='delete_table.php'>
                <input type='submit' id='delete' name='delete' class='btn' value='Empty the Cart'>
                </form>";

        ?>
    </div>

    </div>
    <!-- /.container -->

    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
