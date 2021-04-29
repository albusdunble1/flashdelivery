<?php
require_once '../../../libs/custSession.php';


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
         <title>Product Cart</title>
      </head>
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
               <a class="nav-item nav-link" href="productList.php">HOME</a>
               <a class="nav-item nav-link" href="customerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?></a>
               <a class="nav-item nav-link" href="orderHistory.php" style="margin-left:-5px">ORDER HISTORY</a>
               <!-- <a class="nav-item nav-link" href="customerProfileEdit.php" style="margin-left:0px;margin-right:-5px">EDIT PROFILE</a> -->
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


        <!-- CART DETAILS -->
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                 <h3>Order Details</h3>
                  <div class="table-responsive">
                   <!-- <table class="table table-bordered"> -->
                    <div id="container">
                     <form id="product-form">
                        <table class="table table-striped" id="cartTable">
                          <thead>
                            <tr>
                            <th width="20%">Item Name</th>
                            <th width="3%">Quantity</th>
                            <th width="7%">Price</th>
                            <th width="7%">Total</th>
                            <th width="7%"></th>
                            </tr>
                          </thead>
                          <tbody id="product-list"></tbody>
                          <tr>
                            <td colspan="4" align="right">Total</td>
                            <td id="totalAll" align="right"></td>
                          </tr>
                        </table>
                        <script src="../../../assets/js/cart.js"></script>
                    </form>

                 </div>
                 <form class="" id="form3" method="post" action="../../../ApplicationLayer/view/Payment/checkout.php" align="right">
                   <button type="submit" name="checkout" class="btn btn-primary">CHECKOUT</button>
                 </form>
                 </div>

                 <div style="padding-top:10px;padding-left:500px">
                   <button class="btn btn-dark" onclick="location.href = 'productList.php'">CONTINUE SHOPPING</button>

                 </div>
            </div>
          </div>
        </div>


        <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', () => {

        const products = Cart.getProducts();

        // let tprice = 0;
        let totalPrice = 0;
        products.forEach((product, index) => {

          totalPrice += parseInt(products[index].quantity) * parseFloat(products[index].ProductPrice).toFixed(2);

        });

        totalPrice = parseFloat(totalPrice).toFixed(2);
        document.getElementById('totalAll').innerText = `RM ${totalPrice}`;

    });
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
