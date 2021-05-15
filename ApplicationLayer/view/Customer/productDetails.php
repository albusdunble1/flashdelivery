<?php
require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../libs/custSession.php';

$ProductID = $_GET['prodid'];

$product = new productController();
$data = $product->viewProductDetails($ProductID);
$data2 = $product->viewAllReviews($ProductID);

$reviewcount = $data2->rowCount();
if($reviewcount <= 0){
  $errmsg = "No reviews have been made yet.";
}

$data3 = $product->checkReviewHistory($ProductID);
$data4 = $product->checkPurchaseHistory($ProductID);

$data5  = $product->viewAllReviews($ProductID);

$counter = 0;
$total = 0;


foreach($data5 as $row){
  $counter += 1;
  $total += $row['ReviewRating'];
}

if($counter > 0){
  $averagerating = round($total/$counter);
}else{
  $averagerating = 0;
}


if(isset($_POST['submit'])){
  $product->addProductReview($ProductID);
}
// date_default_timezone_set('Asia/Singapore');
// echo date("Y-m-d");

 ?>

<!DOCTYPE html>
   <html lang="en" dir="ltr">
      <head>
         <meta charset="utf-8">
         <link rel="stylesheet" href="../../../assets/css/design.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
         <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
         <title>Product Details</title>

         <style>
            .hide-review{
              display:none;
            }

            .add-review {
                margin: 2rem;
                margin-bottom: 5rem;
            }

            .product-reviews{
              margin: 2rem;
            }

            select#rating {
                width: 10%;
            }

            .card {
                margin-bottom: 1rem;
            }

            .checked {  
            color : #ffbc00;  
            font-size : 20px;  
            }  

            .unchecked {  
                font-size : 20px;  
            }  

            .product-reviews span {
                font-size: 15px;
            }

            h5.card-title {
                font-size: 1.4em;
            }

            .product-reviews p.card-text {
                font-size: 1.2em;
            }

            .card {
                border-radius: 15px;
            }

            form label {
                font-size: 20px!important;
            }
         </style>
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
         <a class="nav-item nav-link" style="">LOGOUT</a></button>
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



        <!-- PRODUCT DETAILS -->
        <?php
            foreach($data as $row){
            ?>
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="<?="../../../uploads/".$row['ProductImage']?>" class="d-block w-100" onerror="this.src='../../../uploads/default.png';">
                        </div>
                        <div class="carousel-item">
                           <img src="<?="../../../uploads/".$row['ProductImage']?>" class="d-block w-100" onerror="this.src='../../../uploads/default.png';">
                        </div>
                        <div class="carousel-item">
                           <img src="<?="../../../uploads/".$row['ProductImage']?>" class="d-block w-100" onerror="this.src='../../../uploads/default.png';">


                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>



          <div class="col-md-1"></div>
               <div class="col-md-5">
                 <form class="" id="product-form">
                      <div class = 'alignline'>
                        <div class="clear-float">
                          <p class = 'newarrival text-center' style="">NEW</p>
                        </div>

                        <div class="clear-float">
                          <input type="hidden" id="ProductID" value="<?=$row['ProductID']?>"
                          readonly >
                        </div>

                        <div class="clear-float">
                          <span id="pName"><?=$row['ProductName']?></span>
                          <input type="hidden" id="ProductName" value="<?=$row['ProductName']?>"
                          readonly="readonly" onfocus="this.blur()">
                        </div>

                        <div class="clear-float">
                          <p class = 'category' >Product Category:</p>
                          <input type="text" id="ProductCategory" value="<?=$row['ProductCategory']?>"
                           readonly="readonly" onfocus="this.blur()" style="padding-top:3px">
                        </div>

                        <div class="clear-float">
                            <!-- To display checked/unchecked star rating icons -->  
                            <span class = "fa fa-star <?php echo $averagerating>0? 'checked': 'unchecked'?>"></span>  
                            <span class = "fa fa-star <?php echo $averagerating>1? 'checked': 'unchecked'?>"></span>  
                            <span class = "fa fa-star <?php echo $averagerating>2? 'checked': 'unchecked'?>"></span>  
                            <span class = "fa fa-star <?php echo $averagerating>3? 'checked': 'unchecked'?>"></span>  
                            <span class = "fa fa-star <?php echo $averagerating>4? 'checked': 'unchecked'?>"></span>  
                        </div>

                        <div class="clear-float">
                          <p  class="price">RM</p>
                          <input type="text" id="ProductPrice" value="<?=$row['ProductPrice']?>"
                          readonly="readonly" onfocus="this.blur()">
                        </div>

                        <div class="clear-float">
                          <p class = 'left'>Availability:</p>
                          <input type="text" id="ProductStatus" value="<?=$row['ProductStatus']?>"
                          readonly="readonly" onfocus="this.blur()" >
                        </div>

                        <!-- <div class="clear-float">
                          <p class = 'left'>Brand:</p>
                          <input type="text" id="ProductBrand" value="Company Name"
                          readonly="readonly" onfocus="this.blur()" >
                        </div> -->

                        <div class="clear-float">
                          <p class = 'left'>Quantity</p>
                        </div>

                        <div class="clear-float">
                          <td><input type="number" id="quantity" value="1" min="1" max="5"></td>
                          <td>
                            <button id="addCart" type="submit" name="add" class="btn btn-primary" data-toggle="modal" data-target="#cartModal">Add to cart</button></td>
                            <!-- <button id="addCart" type="submit" name="add" class="btn btn-primary">Add to cart</button></td> -->
                        </div>

                        <h4>Description</h4>
                        <div class="clear-float">
                              <span id="pDesc"><?=$row['ProductDescription']?></span>
                        </div>
                    </div>
                    </form>
               </div>

            </div>
         </div>
         <?php } ?>




        <!-- PRODUCT REVIEW -->

         <div class="container">
              <div class="row add-review <?php echo $data3>0 || $data4<1? 'hide-review': ''?>">
                <div class="col-12">
                <h2>Add A Review</h2>
                <br>
                <form action="" method="POST">
                  <div class="form-group row">
                    <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                    <div class="col-md-10">
                      <select id="rating" class="form-control" name="rating" required>
                          <option value="1" selected>1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-success" name="submit" value="Submit Review">
                </form>

                </div>
              </div>


              <div class="row product-reviews">
                <div class="col-12">
                  <h2>Product Reviews (<?=$reviewcount?>)</h2>
                  <br>
                  <?php 
                  if (isset($errmsg)){
                    echo "<h4>$errmsg</h4>";
                  }
                ?>
                </div>

                <?php foreach($data2 as $row){ ?>

                <div class="col-12">

                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><?= $row['CustName']?></h5>
                      <p><b><?=date("j F Y", strtotime($row['ReviewDate']))?></b></p>
                      <h6 class="card-subtitle mb-2 text-muted">                            
                        <span class = "fa fa-star <?php echo $row['ReviewRating']>0? 'checked': 'unchecked'?>"></span>  
                        <span class = "fa fa-star <?php echo $row['ReviewRating']>1? 'checked': 'unchecked'?>"></span>  
                        <span class = "fa fa-star <?php echo $row['ReviewRating']>2? 'checked': 'unchecked'?>"></span>  
                        <span class = "fa fa-star <?php echo $row['ReviewRating']>3? 'checked': 'unchecked'?>"></span>  
                        <span class = "fa fa-star <?php echo $row['ReviewRating']>4? 'checked': 'unchecked'?>"></span>  
                      </h6>
                      <p class="card-text"><?= $row['ReviewComment']?></p>
                    </div>
                  </div>
                </div>

                <?php } ?>
              </div>



              </div>
         </div>








               <!-- Modal -->
      <div id="cartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mw-100 w-50" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">1 item have been added to your cart</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <form id="list-form">
                           <table class="table table-striped">
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
                           </table>
                       </form>
                   </form>
                   <script src="../../../assets/js/productDetails.js"></script>
                  </div>
                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'cart.php';">GO TO CART</button>
            <button type="button" class="btn btn-primary" onclick="location.href = '../../../ApplicationLayer/view/Payment/checkout.php';">CHECKOUT</button>
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


         <script type="text/javascript">

           for(var n  = 0; n < 5; n++) {
              document.getElementById('stars').innerHTML += `<i class="fa fa-star" aria-hidden="true"></i>`;
            };
         </script>

         <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

      </body>
   </html>
