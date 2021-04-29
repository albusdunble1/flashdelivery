<?php
// Author : Ng Wei Sheng
// This page displays the details of a product by the service provider

require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../libs/spSession.php';
if (!isset($_SESSION["SpID"])) {
    $_SESSION["SpID"] = "1";
    $_SESSION["SpEmail"] = "test@gmail.com";
}
$prodid = $_GET['prodid'];

$product = new productController();
$data = $product->viewProduct($prodid);
?>
<html>
    <head>
        <title>Pet Product Details</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="../../../assets/css/main.css">
    </head>
    <body>


    <nav class="navbar navbar-expand-lg navbar-light bg-warning mb-3">
        <div class="container">
            <a class="navbar-brand" href="listProduct.php">Flash Delivery | SP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="addProduct.php">Add Product</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="listProduct.php">Product List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="buyersList.php">Buyers List</a>
                        </li>
                    </ul>
                </ul>
                <form method="POST">
                    <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="serviceProviderProfile.php">Welcome <?php echo $_SESSION["SpEmail"]  ?></a>
                            </li>
                            <li class="nav-item">
                                <input class="btn bg-warning shadow-none" type="submit" name="logout" value="Logout" style="color:black" onclick="return confirm('Are you sure you want to logout?');">
                            </li>

                    </ul>
                </form>
            </div>
        </div>
    </nav>
        <!-- SERVICE PROVIDER PRODUCT DETAILS -->
        <?php
            foreach($data as $row){
        ?>
        <div class="container">
            <h2>Pet Product Details</h2>
            <div class="row">
                <div class="col-sm-3">
                    <div class="frame-2"><img src="../../../uploads/<?=$row['ProductImage']?>"></div>
                </div>
                <div class="col-sm-9">
                    <div class="table-wrapper">
                        <table>
                            <tr>
                                <td>Name: </td>
                                <td><?= $row['ProductName']?></td>
                            </tr>
                            <tr>
                                <td>Price: </td>
                                <td>RM<?= $row['ProductPrice']?></td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td><?= $row['ProductDescription']?></td>
                            </tr>
                            <tr>
                                <td>Status: </td>
                                <td><?= $row['ProductStatus']?></td>
                            </tr>
                        </table>
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
      
        <?php
            }
        ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>
