<?php
require_once '../../../BusinessServiceLayer/controller/customerController.php';
require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../BusinessServiceLayer/controller/spController.php';
require_once '../../../libs/runnerSession.php';


$RunnerID = $_SESSION['RunnerID'];


$product = new productController();
$customer = new customerController();
$serviceProvider = new spController();

error_reporting(0);

// View accepted runner delivery list
$allOrder = $product->viewAllMyDelivery($RunnerID);
foreach ($allOrder as $m => $val) {
    $orderproductID[] = $val['OrderProductID'];
}

for($p = 0; $p < count($orderproductID); $p++) {
      $pendingOrder = $product->viewMyPendingDelivery($orderproductID,$p);
      $pendingOrders = $pendingOrder->fetch();
      if($pendingOrders[0] != ''){
      $orderproductid[] = $pendingOrders[0];
    }
  }


for($j = 0; $j<count($orderproductid);$j++) {
    // $oderproductid[] = $value['OrderProductID'];

    // Get items orderid, quantity and deliverystatus from table order_product
    $OrderID = $product->viewOrderId($orderproductid,$j);
    $id = $OrderID->fetch();
    $orderid[] = $id[1];
    $quantity[] = $id[3];
    $deliverystatus[] = $id[4];

    // Get all items name from table product
    $item = $product->viewItemList($orderproductid,$j);
    $items = $item->fetch();
    $productName[] = $items[1];
    $productimage[] = $items[6];
    $spid[] = $items[7];
    $productid[] = $items[0];

    // Get all delivery address from table orders
    $delivery = $product->viewMyDeliveryAddress($orderid,$j);
    $deliveries = $delivery->fetch();
    $deliveryAddress[] = $deliveries[3];
    $orderDate[] = $deliveries[2];

    // get all customer name from table customer
    $cust = $customer->viewMyDeliveryCustomer($orderid, $j);
    $custs = $cust->fetch();
    $customerName[] = $custs[1];
    $customerPhone[] = $custs[3];

    // get srvice provider address from sp table
    $address = $serviceProvider->getSpAddress($spid,$j);
    $addresses = $address->fetch();
    $pickupAddress[] = $addresses[3];

    $k = $j;

}

if(isset($_POST['delivered'])){
    $product->deliveredDelivery();
} else if(isset($_POST['pickup'])){
    $product->pickupDelivery();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <html lang="en" dir="ltr">
      <head>
         <meta charset="utf-8">
         <link rel="stylesheet" href="../../../assets/css/design.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="../../../assets/css/bootstrap.min_united.css">
         <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>

         <title>My Pending Delivery</title>
      </head>

      <body class="bg-light">

      <!-- NAVBAR -->

      <?php
       $fullname = $_SESSION['RunnerName'];
       $shortname = explode(" ", $fullname);
       $name = $shortname[0].' '.$shortname[1];
       ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-info" style="height:50px">
        <div class="collapse navbar-collapse" id="navbarColor01">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="deliveryList.php">HOME</a>
            <a class="nav-item nav-link" href="runnerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?></a>
            <a class="nav-item nav-link active" href="myDeliveryList.php">PENDING DELIVERY<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="myCompleteDelivery.php">COMPLETE DELIVERY</a>
            <!-- <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            <form method="post" class="form-inline">
            <button type="submit" id="logout" class="logout" name="logout" style="background:transparent;color:white;border:none;width:0px;outline:none;"
             onclick="return confirm('Are you sure you want to logout?');">
            <a class="nav-item nav-link" style="margin-right:-50px">LOGOUT</a></button>
            </form>
          </div>
        </div>
      </nav>

      <nav class="navbar navbar-light" style="height:70px;background-color: #f5f5f5">
        <a href="deliveryList.php" class="navbar-brand" style="color:black">Home</a>
        <div style="margin-right:630px"><h5>Welcome Flash Runners!</h5></div>
      </nav>

        <!-- DELIVERY LIST -->
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                 <h3 align="center">Pending Delivery</h3>
                  <div class="table-responsive">
                   <!-- <table class="table table-borderless table-dark"> -->
                    <div id="container">
                     <!-- <form id="delivery-form" method="post"> -->
                        <table class="table table-striped" id="myDeliveryTable">
                          <thead class="black white-text">
                            <tr>
                            <th width="2%">No</th>
                            <th width="15%">Order Product ID</th>
                            <th width="20%">Customer Name</th>
                            <th width="30%">Pickup Address</th>
                            <th width="30%">Delivery Address</th>
                            <th width="15%">Items(quantity)</th>
                            <th width="30%">Action</th>
                            </tr>
                          </thead>
                          <tbody id="delivery-list">
                            <?php
                                $i = 1;

                                    for($x = 0; $x <= $k;  $x++) {

                                echo  "<tr id='order-list'>"
                                    . "<td>".$i."</td>"

                                           . "<td id='orderproductid".$x."'>" .$orderproductid[$x]."</td>"
                                           . "<td>".$customerName[$x]."</td>"
                                           . "<td>".$pickupAddress[$x]."</td>"
                                           . "<td>".$deliveryAddress[$x]."</td>"
                                           . "<td>".$productName[$x].' ('.$quantity[$x].')'. "</td>";

                                   ?>
                                  <td>
                                    <div id="parent" style="display:flex;">
                                      <div class="" id="button1" style="margin-right:5px">
                                        <?php
                                        if($deliverystatus[$x] == 'Processing'){
                                          $color[$x] = 'red';
                                          ?>

                                          <form id='delivery-form' method='post'>
                                            <input type='hidden' id='OrderProductID[<?=$x?>]' name='OrderProductID' value='<?=$orderproductid[$x]?>'>
                                          <button type='submit' name='pickup' class='btn btn-warning' onclick="return confirm('Are you sure you want to pickup this item?');">PICKUP</button>
                                          </form>
                                        <?php

                                        } else if($deliverystatus[$x] == 'Delivering') {
                                          $color[$x] = 'blue';
                                        ?>

                                          <form id='delivered-form' method='post'>
                                            <input type='hidden' id='OrderProductID[<?=$x?>]' name='OrderProductID' value='<?=$orderproductid[$x]?>'>
                                          <button type='submit' name='delivered' class='btn btn-success' onclick="return confirm('Are you sure delivered this item?');">DELIVERED</button>
                                        </form>
                                        <?php
                                        } else {

                                          }
                                        ?>

                                      </div>
                                        <div class="" id="button2">
                                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#message<?php echo $orderproductid[$x];?>">VIEW</button>
                                            <!-- <a id="buttonView"><button class="btn btn-info">VIEW</button></a> -->
                                        </div>
                                    </div>
                                    </td>

                                    <!-- Modal -->
                                   <div class="modal fade" id="message<?php echo $orderproductid[$x];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                         <div class="modal-header">
                                           <h5 class="modal-title" id="exampleModalLabel">Delivery Details</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                           </button>
                                         </div>
                                         <div class="modal-body">
                                           <img style="margin-left:auto;margin-right:auto;display:block;margin-bottom:20px;width:250px;height:300px;" src='../../../uploads/<?=$productimage[$x]?>' alt="">
                                           <p><span style="font-weight:bold">Product Name: </span><?=$productName[$x]?></p>
                                           <p><span style="font-weight:bold">Quantity: </span><?=$quantity[$x]?></p>
                                           <p><span style="font-weight:bold">Customer Name: </span><?=$customerName[$x]?></p>
                                           <p><span style="font-weight:bold">Customer Phone: </span><?=$customerPhone[$x]?></p>
                                           <p><span style="font-weight:bold">Delivery Address: </span><?=$deliveryAddress[$x]?></p>
                                           <p><span style="font-weight:bold">Order Date: </span><?=$orderDate[$x]?></p>
                                            <p <?php echo "style='color:".$color[$x]."'" ?>><span style="font-weight:bold">Delivery Status: </span><?=strtoupper($deliverystatus[$x])?></p>
                                         </div>
                                         <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                       </div>
                                     </div>
                                   </div>

                                  <?php
                                    $i++;
                                   echo "</tr>";

                                }
                                  ?>
                              </tbody>
                            </table>

                          </div>
                          <div align="right">
                            <button type="button" id="myDelivery" onclick="window.location.href='deliveryList.php'" class="btn btn-dark">View Open Delivery</button>
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
