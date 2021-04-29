<?php
// Author : Ng Wei Sheng
// This page displays a list of order history made by the customer

require_once '../../../BusinessServiceLayer/controller/orderController.php';
require_once '../../../libs/custSession.php';

$order = new orderController();

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

if (isset($_GET['recordnum'])) {
    $number_of_records = $_GET['recordnum'];
} else {
    $number_of_records = 8;
}

$offset = ($pageno - 1) * $number_of_records;

$data = $order->viewOrderListPage($offset, $number_of_records);
$total = $order->viewOrderList()->rowCount();

$pages_needed = ceil($total / $number_of_records);



?>
<html>
<head>
   <title>Order History</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   <link rel="stylesheet" href="../../../assets/css/main.css">
   <link rel="stylesheet" href="../../../assets/css/navbar.css">
   <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
   <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
     $fullname = $_SESSION['CustName'];
     $shortname = explode(" ", $fullname);
     $name = $shortname[0].' '.$shortname[1];
     ?>

     <nav class="navbar navbar-expand-md navbar-dark bg-primary">
       <div class="collapse navbar-collapse" id="navbarColor01">
         <div class="navbar-nav" style="padding-top:17px;">
           <a class="nav-item nav-link" href="productList.php">HOME</a>
           <a class="nav-item nav-link" href="customerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?></a>
           <a class="nav-item nav-link active" href="orderHistory.php" style="margin-left:-5px">ORDER HISTORY<span class="sr-only">(current)</span></a>
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


    <div class="container">
        <h2>Order History</h2>
        <table class="table">
            <thead class="">
                <tr class="bg-primary" style="color:white">
                    <th scope="col">No</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <!-- order list -->
            <tbody>
                <?php
                $i = $offset + 1;
                foreach($data as $row){
                    echo '
                        <tr>
                            <th scope="row">'. $i .'</th>
                            <td> Order #'.$row['OrderID'].'</td>
                            <td>RM'.$row['total'].'</td>
                            <td>'.$row['OrderDate'].'</td>
                            <td><a href="orderDetails.php?orderid='.$row['OrderID'].'">View</a></td>
                        </tr>
                    ';
                    $i++;
                }

                ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- page numbers -->
                <?php
                    for ($x = 1; $x <= $pages_needed; $x++) {
                        echo "<li class='page-item'><a class='page-link' href='orderHistory.php?pageno=".$x."'>". $x ."</a></li>";
                    }
                ?>
            </ul>
        </nav>
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
    <script src="../../../assets/js/main.js"></script>
</body>
</html>
