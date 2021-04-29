<?php
// Author : Ng Wei Sheng
// This page displays an add product form for the service provider

require_once '../../../BusinessServiceLayer/controller/productController.php';
require_once '../../../libs/spSession.php';

$product = new productController();

if(isset($_POST['add'])){
    $product->addProduct();
}


if(isset($_POST['upload-photo']) && !isset($_POST['add'])){
    $file = $_FILES['prodphoto'];

    $file_name = $_FILES['prodphoto']['name'];
    $file_tmpname = $_FILES['prodphoto']['tmp_name'];
    $file_destination = '../../../uploads/'. $file_name;

    if (file_exists($file_destination)) {

    }else{
        move_uploaded_file($file_tmpname, $file_destination);
    }
}




?>
<html>
    <head>
        <title>Add Product</title>
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
                            <a class="nav-link active" href="addProduct.php">Add Product</a>
                        </li>
                        <li class="nav-item ">
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
    <div class="container">
        <h2>Add Product</h2>
        <!-- ADD PRODUCT FORM -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="prodphoto">Image</label>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="frame">
                            <img <?php echo isset($file_destination) && !isset($_POST['add'])? 'src="'.$file_destination.'"' : ''; ?> id="prodpreview">
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <label class="file-select btn btn-primary" for="prodphoto">Select File</label>
                        <input type="file" id="prodphoto" class="form-control" name="prodphoto">
                        <input type="hidden" name="prodimage" value='<?php echo isset($file_name) && !isset($_POST['add'])? $file_name : 'default.png'; ?>' >
                        <p id="file-name"><?php echo isset($file_name) && !isset($_POST['add'])? $file_name : 'Photo.png'; ?></p>
                        <input formnovalidate type="submit" name="upload-photo" class="btn btn-primary upload-photo" value="Upload Photo">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="prodname">Name</label>
                <input type="text" class="form-control" id="prodname" name="prodname" required>
            </div>
            <div class="form-group">
                <label for="prodprice">Price</label>
                <input type="text" class="form-control" id="prodprice" name="prodprice" required>
            </div>
            <div class="form-group">
                <label for="proddescription">Description</label>
                <textarea name="proddescription" id="proddescription" cols="30" rows="10" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="prodprice">Status</label><br>
                <input type="radio" name="prodstatus" value="Available" checked>&nbsp;Available&nbsp;
                <input type="radio" name="prodstatus" value="Out of Stock" >&nbsp;Out of Stock
            </div>
            <input type="submit" class="btn btn-success" name="add" value="Add Product">
        </form>
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
