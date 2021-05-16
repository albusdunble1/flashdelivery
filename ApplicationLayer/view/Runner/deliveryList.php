<?php
require_once '../../../libs/runnerSession.php';
require_once '../../../BusinessServiceLayer/controller/customerController.php';
require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../BusinessServiceLayer/controller/spController.php';



$RunnerID = $_SESSION['RunnerID'];

$product = new productController();
$customer = new customerController();
$serviceProvider = new spController();

// error_reporting(0);


// Get all delivery from runner_order table
$data = $product->viewAllDelivery();
foreach($data as $j => $value) {
  // get orderproductid from table order_product
  $orderproductid[] = $value['OrderProductID'];

  // get orderid, item quantity from order_product table
  $result = $product->getOrderID($orderproductid,$j);     
  $id = $result->fetch();
  $orderid[] = $id[1];
  $quantity[] = $id[3];
  $deliveryStatus[] = $id[4];

  // Get all items name from product table
  $item = $product->viewItemList($orderproductid,$j);
  $items = $item->fetch();
  $productName[] = $items[1];
  $productimage[] = $items[6];
  $spid[] = $items[7];

  // Get all delivery address from orders table
  $delivery = $product->getDeliveryAddress($orderid,$j);
  $deliveries = $delivery->fetch();
  $deliveryAddress[] = $deliveries[3];
  $orderDate[] = $deliveries[2];

  // get all customer name from customer table
  $cust = $customer->viewAllCustomer($orderid,$j);
  $custs = $cust->fetch();
  $customerName[] = $custs[1];
  $customerPhone[] = $custs[3];

  // get srvice provider address from sp table
  $address = $serviceProvider->getSpAddress($spid,$j);
  $addresses = $address->fetch();
  $pickupAddress[] = $addresses[3];

  $k = $j;
}

// error_reporting(0);

// get total count my pending delivery
$counts = $product->countPendingDelivery($RunnerID);
$totals = $counts->fetch();
$values = $totals[0];

if($value != 0){
$allAccept = $product->viewAllMyDelivery($RunnerID);
for($a = 0; $a<$values; $a++){
$allAccepts = $allAccept->fetch();
$opID[] = $allAccepts[2];
  }
}

if($opID != ''){
for($p = 0; $p<count($opID); $p++){
  $pending = $product->viewMyPendingDelivery($opID,$p);
  $count = $pending->fetch();
  if($count[0] != ''){
  $totals[] = $count[0];
  }
}
  $value = count($totals);
} else {
  $value = $values;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product->acceptDelivery($RunnerID);

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
      <head>
         <meta charset="utf-8">
         <link rel="stylesheet" href="../../../assets/css/design.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="../../../assets/css/bootstrap.min_united.css">
         <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
         <title>Delivery List</title>
      </head>

      <style media="screen">
        .my-custom-scrollbar {
        position: relative;
        height: 530px;
        overflow: auto;
        }
        .table-wrapper-scroll-y {
        display: block;
        }

        th {
        background-color: #593196;
        color: white;
        }

      </style>

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
              <a class="nav-item nav-link active" href="deliveryList.php">HOME<span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="runnerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?></a>
              <a class="nav-item nav-link" href="myDeliveryList.php">PENDING DELIVERY<span class="badge badge-danger ml-2"><?= $value ?></span></a>
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


         <div class="container" style="margin-bottom:100px">
            <div class="row">
               <div class="col-md-12">

                 <div style="text-align:center;">
                   <h3 align="center">Open Delivery</h3>
                    <i class="fa fa-truck fa-3x" aria-hidden="true"></i>
                 </div>
                 <input type="text" class="form-control mt-3" id="filterInput" placeholder="Search location...">

                 <br>
                  <div class="table-responsive pt-10">
                   <!-- <table class="table table-borderless table-dark"> -->
                    <div id="container">
                      <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table" id="deliveryTable">
                          <thead class="black white-text thead-info">
                            <tr class="header">
                            <th width="2%">No</th>
                            <th width="15%">Order Product ID</th>
                            <th width="15%">Order ID</th>
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
                                   echo "<tr id='order-list'>"
                                    . "<td>".$i."</td>"
                                           . "<td>" .$orderproductid[$x]."</td>"
                                           . "<td>" .$orderid[$x]."</td>"
                                           . "<td>". $customerName[$x]. "</td>"
                                           . "<td>". $pickupAddress[$x]. "</td>"
                                           . "<td>". $deliveryAddress[$x]. "</td>"
                                           . "<td>". $productName[$x].' ('.$quantity[$x].')'."</td>";
                                   ?>
                                  <td>
                                     <form id="delivery-form" method="post">
                                    <div id="parent" style="display:flex;">
                                      <div class="" id="button1" style="margin-right:5px">
                                          <input type="hidden" name="OrderProductID" value="<?=$orderproductid[$x]?>">
                                          <button type="submit" class="btn btn-primary accept" onclick="return confirm('Are you sure you want to accept this delivery?');">ACCEPT</button>
                                      </div>
                                        <div class="" id="button2">
                                        <!-- <a id="buttonView"><button class="btn btn-info">VIEW</button></a> -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#message<?php echo $orderproductid[$x];?>">VIEW</button>
                                        </div>
                                    </div>
                                    </form>
                                  </td>

                                  <!-- <div id="message<?php echo $orderproductid[$x];?>" class="modal fade" role="dialog"> -->
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
                                            <p style="color:red"><span style="font-weight:bold">Delivery Status: </span><?=strtoupper($deliveryStatus[$x])?></p>
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

                          </div>
                          <?php
                          if($value != 0){
                           ?>
                            <div align="right" style="margin-top:30px">
                              <button type="button" id="myDelivery" class="btn btn-dark" onclick="window.location.href='myDeliveryList.php'">MY PENDING DELIVERY<span class="badge badge-danger ml-2"><?= $value ?></span></button>
                            </div>
                            <?php
                                }
                             ?>
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


                <script type="text/javascript">
                  // Get input element
                  let filterInput = document.getElementById('filterInput');
                  // Add event listener
                  filterInput.addEventListener('keyup', filter);

                  function filter(){
                    // Get value of input
                    let filterValue = document.getElementById('filterInput').value.toUpperCase();

                    let trs = document.querySelectorAll('#deliveryTable tr:not(.header)');

                    trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filterValue)) ? '' : 'none');

                  }
              </script>

     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
