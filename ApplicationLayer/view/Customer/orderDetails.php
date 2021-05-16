<?php
// Author : Ng Wei Sheng
// This page displays the details of a specific order

require_once '../../../BusinessServiceLayer/controller/orderController.php';
require_once '../../../libs/custSession.php';

$orderid = $_GET['orderid'];

$order = new orderController();
$data = $order->viewOrder($orderid);


?>
<html>
    <head>
        <title>Order Details</title>
        <link rel="stylesheet" href="../../../assets/css/main.css">
        <link rel="stylesheet" href="../../../assets/css/navbar.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
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
        <h2>Order #<?= $orderid?></h2>
        <div class="row">
            <?php
                $subtotal = 0;
                $shipping = 0;
                foreach($data as $row){
                    $address = $row['OrderAddress'];
                    $subtotal += ($row['ProductPrice']* $row['quantity']);
                    $shipping += 5;
            ?>
            <div class="col-sm-12">


                <div class="order-wrapper">
                    
                    <!-- ORDER STATUS -->
                    <div class="order-tracker">
                        <div class="complete pending">
                            <div class="circle">
                            </div>
                            <div class="status">Pending</div>
                        </div>
                        <div class="<?php echo $row['DeliveryStatus']!='Pending'?'complete':'';?> processing">
                            <div class="circle">
                            </div>
                            <span class="line"></span>
                            <div class="status">Processing</div>
                        </div>
                        <div class="<?php echo $row['DeliveryStatus']=='Delivering' || $row['DeliveryStatus']=='Delivered' ?'complete':'';?> delivering">
                            <div class="circle">
                            </div>
                            <span class="line"></span>
                            <div class="status">Delivering</div>
                        </div>
                        <div class="<?php echo $row['DeliveryStatus']=='Delivered'?'complete':'';?> delivered">
                            <div class="circle">
                            </div>
                            <span class="line"></span>
                            <div class="status">Delivered</div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <!-- ORDER PRODUCT DETAILS -->
                    <div class="order-product-details">
                        <table class="table">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                            <tr>
                                <td><img src="../../../uploads/<?= $row['ProductImage']?>"></td>
                                <td><?= $row['ProductName']?></td>
                                <td>RM <?= $row['ProductPrice']?></td>
                                <td><?= $row['quantity']?></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>


            <?php
                }
            ?>

            <!-- ORDER SUMMARY -->
            <div class="col-sm-12 order-summary">
                <div class="row justify-content-between">
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-header pb-0">
                                    <p class="card-text text-muted mt-4 space">DELIVERY ADDRESS</p>
                                    <hr class="my-0">
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-auto mt-0">
                                            <p><b><?= $address?></b></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 ">
                                <div class="card-header pb-0">
                                    <p class="card-text text-muted mt-4 space">YOUR ORDER</p>
                                </div>
                                    <div class="row ">
                                        <div class="col">
                                            <div class="row justify-content-between">
                                                <div class="col-4">
                                                    <p class="mb-1"><b>Subtotal</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>RM <?= number_format((float)$subtotal, 2, '.', '')?></b></p>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col">
                                                    <p class="mb-1"><b>Shipping</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>RM <?= number_format((float)$shipping, 2, '.', '')?></b></p>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between">
                                                <div class="col-4">
                                                    <p><b>Total</b></p>
                                                </div>
                                                <div class="flex-sm-col col-auto">
                                                    <p class="mb-1"><b>RM <?= number_format((float)$subtotal+$shipping, 2, '.', '')?></b></p>
                                                </div>
                                            </div>
                                            <hr class="my-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </body>
</html>
