<?php
// Author : Ng Wei Sheng
// This page displays the available products 

require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../libs/custSession.php';


$product = new productController();

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

if (isset($_GET['recordnum'])) {
    $number_of_records = $_GET['recordnum'];
} else {
    $number_of_records = 12;
}

$offset = ($pageno - 1) * $number_of_records;


// search data

if (isset($_GET['term'])) {
    $term = $_GET['term'];
    $data = $product->viewProductListPage($offset, $number_of_records, $term);
    $total = $product->viewSearchProductList($term)->rowCount();
    if ($total == 0){
        $errmsg = 'No results found.';
    }
} else {
    $term = '';
    $data = $product->viewProductListPage($offset, $number_of_records,'');
    $total = $product->viewProductList()->rowCount();
    if ($total == 0){
        $errmsg = 'No results found.';
    }
}

// promoted products data
$data2 = $product->viewPromotedProducts();


$pages_needed = ceil($total / $number_of_records);

?>
<html>
<head>
   <title><?php echo isset($_GET['category'])? $_GET['category']: '';?> Product List</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   <link rel="stylesheet" href="../../../assets/css/main.css">
   <link rel="stylesheet" href="../../../assets/css/navbar.css">
   <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="../../../assets/css/slick.css"/>
   <link rel="stylesheet" type="text/css" href="../../../assets/css/slick-theme.css"/>
   <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
   <style>
    .slick-dots{
        bottom: -40px;
    }

    .slick-initialized .slick-slide {
        margin-left: 1rem;
        margin-right: 1rem;
        margin-top: 10px;
    }

    .slick-dotted.slick-slider {
        margin-bottom: 3rem;
    }

    .slick-prev:before, .slick-next:before{
        color: black;
    }

    .product{
        position: relative;
    }

    .slick-slider .product-bottom h4:before {
        content: '';
        display: block;
        background: url(../../../assets/img/promoted-product.png) no-repeat 0 0;
        background-size: 100%;
        position: absolute;
        width: 36%;
        height: 100%;
        top: -219px;
        left: -1px;
    }

   </style>

</head>
<body>

    <!-- NAVBAR -->

    <?php
     $fullname = $_SESSION['CustName'];
     $shortname = explode(" ", $fullname);
     $name = $shortname[0].' '.$shortname[1];
     ?>

     <nav class="navbar navbar-expand-md navbar-dark bg-primary">
       <div class="collapse navbar-collapse" id="navbarColor01">
         <div class="navbar-nav" style="padding-top:17px;">
           <a class="nav-item nav-link active" href="productList.php">HOME</a>
           <a class="nav-item nav-link" href="customerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?><span class="sr-only">(current)</span></a>
           <a class="nav-item nav-link" href="orderHistory.php" style="margin-left:-5px">ORDER HISTORY</a>
           <form method="post" class="form-inline">
           <button type="submit" id="logout" class="logout" name="logout" style="background:transparent;color:white;border:none;width:0px;outline:none;"
           onclick="return confirm('Are you sure you want to logout?');">
           <a class="nav-item nav-link" style="margin-right:-50px">LOGOUT</a></button>
           </form>
       </div>
     </nav>

     <nav class="navbar navbar-light" style="height:auto;background-color: #f5f5f5">
       <a href="productList.php" class="navbar-brand text-primary h1">Flash</a>
       <h5>Welcome To Flash Delivery</h5>
         <a class="navbar-brand" href="cart.php">
         <i class="fa fa-shopping-cart fa-2x unique-color-dark" aria-hidden="true" style="color:#17141F"></i>
       </a>
     </nav>


    <div class="container" style="margin-top:30px">
        <!-- promoted section -->

        <h2>Promoted Products</h2>
        <div class="row">
            <div class="col-sm-12 promoted-products">
            <?php
                // if (isset($errmsg)){
                //     echo "<h3>$errmsg</h3>";
                // }
                foreach($data2 as $row){
                    $prodid = $row['ProductID'];
                    echo "<div class='cust product'><a href='productDetails.php?prodid=$prodid'><img class='product-img' src='../../../uploads/". $row['ProductImage'] ."'><div class='product-bottom'><h4>".$row['ProductName'] ."</h4><p class='product-price'>RM". $row['ProductPrice'] ."</p><p>" .$row['ProductSales'] . " Sold</p></div></a></div>";
                }

            ?>
            </div>
        </div>


        <!-- all products section -->
        <h2><?php echo isset($_GET['category'])? $_GET['category']: '';?> Product List</h2>
        <div class="row">
            <div class="col-sm-2 sidebar">
                <!-- search -->
                <label for="search">Search: </label>
                <input class="form-control" type="text" value="<?php echo $term?>" name="search" id="term">
                <button class="btn btn-primary" id="search-btn" onclick="search('<?php echo isset($_GET['category'])? $_GET['category']: '';?>')">Search</button>
                <h3>Categories</h3>
                <ul>
                    <li><a href="productList.php">All</a></li>
                    <li><a href="productList.php?category=food">Food</a></li>
                    <li><a href="productList.php?category=goods">Goods</a></li>
                    <li><a href="productList.php?category=pet">Pet</a></li>
                    <li><a href="productList.php?category=medical">Medical</a></li>
                </ul>

                <h3>Sort by</h3>
                <ul>
                    <li><a href="productList.php?sales=desc<?php echo isset($_GET['category'])? '&category='. $_GET['category']: ''?><?php echo isset($_GET['term'])? '&term='. $_GET['term']: ''?>">Product Sales (Descending)</a></li>
                    <li><a href="productList.php?sales=asc<?php echo isset($_GET['category'])? '&category='. $_GET['category']: ''?><?php echo isset($_GET['term'])? '&term='. $_GET['term']: ''?>">Product Sales (Ascending)</a></li>
                </ul>
            </div>
            <div class="col-sm-10 main-content">
                <div class="row">
            <?php
                if (isset($errmsg)){
                    echo "<h3>$errmsg</h3>";
                }
                foreach($data as $row){
                    $prodid = $row['ProductID'];
                    echo "<div class='col-sm-3'><div class='cust product'><a href='productDetails.php?prodid=$prodid'><img class='product-img' src='../../../uploads/". $row['ProductImage'] ."'><div class='product-bottom'><h4>".$row['ProductName'] ."</h4><p class='product-price'>RM". $row['ProductPrice'] ."</p><p>" .$row['ProductSales'] . " Sold</p></div></a></div></div>";
                }

            ?>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- page numbers -->
                <?php
                    for ($x = 1; $x <= $pages_needed; $x++) {
                        if(isset($_GET['category'])){
                            $category = $_GET['category'];
                            echo "<li class='page-item'><a class='page-link' href='productList.php?pageno=$x&category=$category&term=$term'>". $x ."</a></li>";
                        }else{
                            echo "<li class='page-item'><a class='page-link' href='productList.php?pageno=$x&term=$term'>". $x ."</a></li>";
                        }
                    }
                ?>
            </ul>
        </nav>
            </div>
        </div>
    </div>
</div>


<!-- FOOTER -->
<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2020 Flash Delivery</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../../assets/js/slick.min.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script>
        $('.promoted-products').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true
        });
    </script>
</body>
</html>
