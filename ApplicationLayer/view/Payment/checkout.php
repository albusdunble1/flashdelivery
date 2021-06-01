<?php
require_once '../../../BusinessServiceLayer/controller/customerController.php';
require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../BusinessServiceLayer/controller/paymentController.php';
require_once '../../../libs/custSession.php';


$CustID = $_SESSION['CustID'];

$customer = new customerController();
$product = new productController();
$payment = new paymentController();

$data = $customer->viewCustomer($CustID);

//payment method
// echo $_SESSION['status'];


error_reporting(0);
if($_SESSION['status'] == null){
  $_SESSION['status'] = 'empty';
} else {

}

// go to paypal api
if(isset($_POST['add'])){
      $payment = $_POST['paymentMethod'];
      $_SESSION['quantity'] = $_POST['quantity'];
      $_SESSION['ProductID'] = $_POST['ProductID'];
      $_SESSION['OrderAddress'] = $_POST['OrderAddress'];
      $_SESSION['total'] = $_POST['total'];
       if($payment == 'Paypal'){
      header("Location: ../../../libs/paypal/charge.php");
    }//else(payment == 'cash on CashOnDelivery'){
      //header("echo "<script type='text/javascript'>alert('Your payment is successfully!!!'));
    //}

}

//if payment method cash on delivery
if(isset($_POST['add'])){
      $payment = $_POST['paymentMethod'];
      $_SESSION['quantity'] = $_POST['quantity'];
      $_SESSION['ProductID'] = $_POST['ProductID'];
      $_SESSION['OrderAddress'] = $_POST['OrderAddress'];
      $_SESSION['total'] = $_POST['total'];
       if($payment == 'CashOnDelivery'){
      echo 'Your Payment Is Successfully Using Cash On Delivery';
      
 
    }

}

//if payment method online banking
if(isset($_POST['add'])){
      $payment = $_POST['paymentMethod'];
      $_SESSION['quantity'] = $_POST['quantity'];
      $_SESSION['ProductID'] = $_POST['ProductID'];
      $_SESSION['OrderAddress'] = $_POST['OrderAddress'];
      $_SESSION['total'] = $_POST['total'];
       if($payment == 'OnlineBanking'){
      echo 'Your Payment Is Successfully Using Online Banking'; 
    }

}

//if payment method Credit Card
if(isset($_POST['add'])){
      $payment = $_POST['paymentMethod'];
      $_SESSION['quantity'] = $_POST['quantity'];
      $_SESSION['ProductID'] = $_POST['ProductID'];
      $_SESSION['OrderAddress'] = $_POST['OrderAddress'];
      $_SESSION['total'] = $_POST['total'];
       if($payment == 'CreditCard'){
      echo 'Your Payment Is Successfully Using Credit Card'; 
    }

}

//Payment Success
//$customer ->buttonCheckout = $_POST['buttonCheckout']
//if ($customer ->buttonCheckout()) {
  //echo"<script type='text/javascript'>alert('Your Payment Is Successfully!!');
 // window.location = './checkout.php?buttonCheckout'= "$_SESSION['buttonCheckout'],";</script>";
//}





// if paypal payment success
if($_SESSION['status'] == 'success'){
    echo "hello";


    $product->addOrder($CustID);

    // get last insert id
    $result = $product->lastInsertId();
    $id = $result->fetch();
    $OrderID = $id[0];

    echo "hihi";

    // get last payment id
    $payID = $payment->lastPaymentId();
    $paymentID = $payID->fetch();
    $paymentIDs = $paymentID[0];
    
    echo "YOOOOOO";
    echo $OrderID; echo "WOLOLOLO"; echo $paymentIDs;
    echo "YOOOOOO";

    $payment->addPaymentOrderID($OrderID,$paymentIDs);

    echo "HEHEASDASD";

    for($i = 0; $i < count($_SESSION['ProductID']); $i++) {
      $product->addOrderProduct($OrderID,$i);
      echo "ORDER ADDED";

    }
    //else echo"<script type='text/javascript'>alert('Your Payment Is Successfully!!');
    //window.location = './checkout.php?buttonCheckout'= "$_SESSION['buttonCheckout'],";</script>";

    unset($_SESSION['status']);
    unset($_SESSION['quantity']);
    unset($_SESSION['ProductID']);
    unset($_SESSION['OrderAddress']);
    unset($_SESSION['total']);
    // $message = "Success Add To Order!";
    // echo "<script type='text/javascript'>alert('$message');
    //   localStorage.clear();
    //   window.location = '../../../ApplicationLayer/view/Customer/productList.php';
    // </script>";
    exit();

}



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <html lang="en" dir="ltr">
      <head>
         <meta charset="utf-8">
         <link rel="stylesheet" href="../../../assets/css/design.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
         <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
         <script src="../../../assets/js/checkout.js"></script>

         <title>Checkout</title>
      </head>
      <style>
        input[id=paypal]{
          background: url(https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png);
          border: 0;
          display: block;
          height:25px;
          width: 100px;
    }
      </style>
      <body class="bg-light">

  <!-- NAVBAR -->
  <?php
   $fullname = $_SESSION['CustName'];
   $shortname = explode(" ", $fullname);
   $name = $shortname[0].' '.$shortname[1];
   ?>

   <nav class="navbar navbar-expand-md navbar-dark bg-primary">
     <div class="collapse navbar-collapse" id="navbarColor01">
       <div class="navbar-nav" style="padding-top:0px;">
         <a class="nav-item nav-link" href="../Customer/productList.php">HOME</a>
         <a class="nav-item nav-link" href="../Customer/customerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?></a>
         <a class="nav-item nav-link" href="../Customer/orderHistory.php" style="margin-left:-5px">ORDER HISTORY</a>
         <!-- <a class="nav-item nav-link" href="customerProfileEdit.php" style="margin-left:0px;margin-right:-5px">EDIT PROFILE</a> -->
         <form method="post" class="form-inline">
         <button type="submit" id="logout" class="logout" name="logout" style="background:transparent;color:white;border:none;width:0px;outline:none;"
         onclick="return confirm('Are you sure you want to logout?');">
         <a class="nav-item nav-link" style="">LOGOUT</a></button>
         </form>
     </div>
   </nav>

   <nav class="navbar navbar-light" style="height:auto;background-color: #f5f5f5">
     <a href="../Customer/productList.php" class="navbar-brand text-primary h1">Flash</a>
     <h5>Welcome To Flash Delivery</h5>
       <a class="navbar-brand" href="../../../ApplicationLayer/view/Customer/cart.php">
       <i class="fa fa-shopping-cart fa-2x unique-color-dark" aria-hidden="true" style="color:#17141F"></i>
     </a>
   </nav>


      <!-- CHECKOUT -->
        <div class="container">
        <div class="py-3 text-center">
       <h2>CHECKOUT</h2>
     </div>
    <!-- <form class="needs-validation" method="post" novalidate> -->
    <form class="needs-validation" method="post">
     <div class="row">
       <div class="col-md-5 order-md-2 mb-4">
         <h4 class="d-flex justify-content-between align-items-center mb-3">
           <span class="text-muted">Your cart</span>
           <!-- <span class="badge badge-secondary badge-pill">3</span> -->
         </h4>
         <ul class="list-group mb-3" id="list-product">

         <script>
             const products = Cart.getProducts();
             var ul = document.querySelector('#list-product');
             var totalAll = 0;
             let total = 0;
             var totalQuantity = 0;


             products.forEach((product, index) => {
               let total = parseFloat(products[index].ProductPrice) * Number(products[index].quantity);
               total = parseFloat(total).toFixed(2);

               ul.innerHTML += `
               <li class="list-group-item d-flex justify-content-between lh-condensed">
                 <div>
                 <input type="hidden" name="ProductID[]" id="ProductID" value="` + products[index].ProductID + `" readonly>
                 <input type="hidden" name="quantity[]" id="quantity" value="`+ products[index].quantity + `" readonly>
                   <h6 class="my-0" id="product">${products[index].ProductName}</h6>
                   <small class="text-muted">${products[index].ProductName} (RM${products[index].ProductPrice}) x ${products[index].quantity}</small>
                 </div>
                 <span class="text-muted">RM ${total}</span>
               </li>`;

               //shipping = 5 * Number(products.length);
               //if Number(products.length) > 5 {
               //shipping * 0
               //};

               totalQuantity += Number(products[index].quantity);
               totalAll += parseFloat(products[index].ProductPrice) * Number(products[index].quantity);

             });


           </script>
           <li class="list-group-item d-flex justify-content-between">
             <span>Shipping Fee</span>
             <strong id="shippingFee"></strong>
           </li>
           <li class="list-group-item d-flex justify-content-between">
             <span>Number product</span>
             <strong id="numbers"></strong>
           </li>
           <li class="list-group-item d-flex justify-content-between">
             <span>Total (RM)</span>
             <strong id="total"></strong>
           </li>
            <input type="hidden" name="total" id="totalAll" value="" readonly >
         </ul>

        <script>
          if (totalQuantity>5) 
          {
             let shipping = 0;
            document.getElementById('shippingFee').innerHTML = 'FREE SHIPPING';
            document.getElementById('total').innerHTML = 'RM '+parseFloat(totalAll + shipping).toFixed(2)+'';
          document.getElementById('numbers').innerHTML = totalQuantity;
          document.getElementById('totalAll').value = parseFloat(totalAll + shipping).toFixed(2);
          console.log(shipping);
          }
          else
          {
            let shipping = 5;
            document.getElementById('shippingFee').innerHTML = 'RM '+parseFloat(shipping).toFixed(2)+'';
            document.getElementById('total').innerHTML = 'RM '+parseFloat(totalAll + shipping).toFixed(2)+'';
          document.getElementById('numbers').innerHTML = totalQuantity;
          document.getElementById('totalAll').value = parseFloat(totalAll + shipping).toFixed(2);
          console.log(shipping);
          }
          

    //       window.onload = (event) => {
    //     console.log(id);
    // };

        </script>


        <!-- DELIVERY FORM -->
       </div>
       <div class="col-md-7 order-md-1">
         <h4 class="mb-3">Billing address</h4>
         <?php
             foreach($data as $row){
             ?>
           <div class="row">
             <div class="col-md-12 mb-3">
               <label for="firstName">Name</label>
               <input type="text" class="form-control" id="firstName" placeholder="" value="<?=$row['CustName']?>" readonly>
               <div class="invalid-feedback">
                 Valid name is required.
               </div>
             </div>
           </div>

           <div class="mb-3">
             <label for="email">Email <span class="text-muted">(Optional)</span></label>
             <input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?=$row['CustEmail']?>" readonly>
             <div class="invalid-feedback">
               Please enter a valid email address for shipping updates.
             </div>
           </div>



           <div class="mb-3">
             <label for="address">Address</label>
             <input type="text" class="form-control" name="OrderAddress" id="OrderAddress" placeholder="1234 Main St" value="" required>
             <div class="invalid-feedback">
               Please enter your shipping address.
             </div>
           </div>
           

            <div class="mb-3">
               <label for="PhoneNo">Phone</label>
               <input type="text" class="form-control" id="PhoneNo" placeholder="1234" value="<?=$row['CustNo']?>" >
               <div class="invalid-feedback">
                 Valid phone number is required.
               </div>
            </div>
           


           <hr class="mb-4">
           <hr class="mb-4">


           <h4 class="mb-3">Payment</h4>

           <div class="d-block my-3">
             <div class="custom-control custom-radio">
               <input id="cashondelivery" name="paymentMethod" type="radio" value="CashOnDelivery" class="custom-control-input" required>
               <label class="custom-control-label" for="cashondelivery">Cash On Delivery</label>
             </div>
           </div>
           
          <div class="d-block my-3">
             <div class="custom-control custom-radio">
               <input id="onlinebanking" name="paymentMethod" type="radio" value="OnlineBanking" class="custom-control-input" required>
               <label class="custom-control-label" for="onlinebanking">Online Banking</label>
             </div>
           </div>
           
           <div class="d-block my-3">
             <div class="custom-control custom-radio">
               <input id="creditcard" name="paymentMethod" type="radio" value="CreditCard" class="custom-control-input" required>
               <label class="custom-control-label" for="creditcard">Credit Card</label>
             </div>
           </div>
           
           <div class="d-block my-3">
             <div class="custom-control custom-radio">
               <input id="paypal" name="paymentMethod" type="radio" value="Paypal" class="custom-control-input" required>
               <label class="custom-control-label" for="paypal">Paypal</label>
             </div>
           </div>
           <hr class="mb-4">
           
           <div id="buttonCheckout">
               <button name="add" class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </div>




           <?php } ?>
         </form>
       </div>
     </div>
   </div>
        <script>
        if(totalAll != 0){
          document.getElementById('buttonCheckout').innerHTML =
          `<button name="add" class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>`;
        }

        //if ($user ->checkout()) {
          //echo "<script type="text">">
        //}
        </script>

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