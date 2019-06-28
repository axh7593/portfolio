   <!-- included files for header stuff -->
    <?php include('index_header.php'); ?>

    <?php include('carousel.php'); ?>


<!--------------------------CONTENT GOES HERE --------------------------------->
<?php
    // establish a connection to database
    $con = mysqli_connect('localhost','root','root','php_shoeStore');

 $string4 = $db -> getSaleItemsFormatted();
    echo $string4;
$per_page = 5;

$total_pages = "";

  // $result = mysqli_query($con, "SELECT * FROM Project1");
    //$result = $db -> getAllItems();
$result = $db -> selectAllItems();
    $total = count($result);
    //echo $total;

    // How many pages will there be
    $pages = ceil($total / $per_page);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array(
            'default'   => 1,
            'min_range' => 1,),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $per_page;
    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $per_page), $total);
    $data  = $db -> populatePage($per_page, $offset);
        //s$data = $ -> getAllItems();
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
        echo $bigString;



    $prevlink = ($page > 1) ? '<a class ="button" href="?page=1" title="First page">&laquo; First Page</a> <a class ="button" href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo; Previous Page</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';


      $nextlink = ($page < $pages) ? '<a class ="button" href="?page=' . ($page + 1) . '" title="Next page">Next Page &rsaquo;</a> <a class ="button" href="?page=' . $pages . '" title="Last page">Last Page &raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';


    echo '<div id="paging"><p>', $prevlink, ' ', $page, ' of ', $pages, ' pages, ', $start, '-', $end, ' of ', $total_pages, ' items ', $nextlink, ' </p></div>';

    ////////////////////////////paging ///////////////////////////
    if(isset($_GET['page']) && is_numeric($_GET['page'])){
        $show_page = $_GET['page'];

        if($show_page > 0 && $show_page <= $total_pages){
            $start = ($show_page - 1) * $per_page;
            $end = $start + $per_page;
        } else{
            $start = 0;
            $end = $per_page;
        }
    } else{
        $start = 0;
        $end = $per_page;
    }

    for ($i = 1; $i <= $total_pages; $i++)

    {

    echo "<a href='index.php?page=$i'>$i</a> ";

    }

    echo "</p>";


    //on 'submit' button put non sale items selected into cart
    if(isset($_REQUEST['submit'])){
        echo $thing = $_POST['id'];


        $check = $db -> ifExists($thing);


        //var_dump($check);
        if(count($check) > 0){

            $checkedQuan = $check[0]["Quantity"];


            $checkedQuan = $checkedQuan + 1;

            $success = $db -> updateQuantity($thing,$checkedQuan);


            echo "added updated Product";
        } else{
           $string2 = $db -> addToCart();
            echo $string2;
            echo "Added new item to cart";
        }


    }
    // on 'saleSubmit' button put sale items selected into cart
    if(isset($_REQUEST['saleSubmit'])){
         echo $thing = $_POST['id'];


        $check = $db -> ifExists($thing);
        echo "COUNT";

        //var_dump($check);
        if(count($check) > 0){

            $checkedQuan = $check[0]["Quantity"];

            echo "check: $checkedQuan";
            $checkedQuan = $checkedQuan + 1;

            $success = $db -> updateQuantity($thing,$checkedQuan);

            echo "added updated Product";
        } else{
           $string2 = $db -> addToCart();
            echo $string2;
            echo "Added new item to cart";
        }

    }


    echo "<a href='index.php?"
?>
            </div>

        </div>

    </div>


    <!-- jquery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


    <!-- AJAX used to refresh page so Quantity is shown as updated -->
    <script type="text/javascript">
        $(document).ready (function () {
        var updater = setTimeout (function () {
            $('div#main').load ('index.php', 'update=true');
        }, 100);
        });
</script>

</body>

</html>
