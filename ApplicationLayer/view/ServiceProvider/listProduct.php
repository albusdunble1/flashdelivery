<?php
// Author : Ng Wei Sheng
// This page displays all the products owned by the service provider

require_once '../../../libs/spSession.php';
require_once '../../../BusinessServiceLayer/controller/productController.php';

$product = new productController();

if (isset($_POST['delete'])) {
    $product->deleteProduct();
}

if (isset($_POST['promote'])) {
    $product->promoteProduct();
}



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

$data = $product->viewProductPage($offset, $number_of_records, '');
$total = $product->viewallProduct()->rowCount();

$pages_needed = ceil($total / $number_of_records);


?>
<html>

<head>
    <title><?= $_SESSION['SpName']?> Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../assets/css/main.css">
    <style>
        .promotion-status {
            background: #46d000;
            color: white;
            font-weight: bold;
            border-radius: 20px;
            padding: 0.1rem 0.5rem;
            display: inline-block;
            font-size: 12px;
        }
    </style>
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
    <div class="container">
        <h2><?= $_SESSION['SpName']?> Product List</h2>
        <a class="btn btn-primary" href="addProduct.php">Add Product</a>
        <!-- SERVICE PROVIDER PRODUCT LIST -->
        <div class="row">
            <?php
            foreach ($data as $row) {
                $prodid = $row['ProductID'];
                if ($row['ProductPromotion'] == 1){
                    $status = 'Promoted';
                }else{
                    $status = '';
                }

                echo "
                    <div class='col-sm-3'>
                        <div class='sp product'>
                            <a href='viewProduct.php?prodid=$prodid'>
                                <img class='product-img' src='../../../uploads/".$row['ProductImage'] . "'>
                                <div class='product-bottom'>
                                    <h4>" . $row['ProductName'] . "</h4> ";
                                    
                                    echo $status=='Promoted'?"<span class='promotion-status'>". $status."</span>": "";


                                    echo " <p class='product-price'>RM" . $row['ProductPrice'] . "</p>
                                    <span class='product-status'>" .$row['ProductStatus']."</span>";


            ?>
                <form method="POST" onsubmit="return confirm('Are you sure?');">
                    <a class="btn btn-success" href='editProduct.php?prodid=<?= $prodid ?>'>Edit</a>
                    <input type="hidden" name="prodid" value="<?= $prodid ?>">
                    <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                    <?php echo $status!='Promoted'? "<input class='btn btn-primary' type='submit' name='promote' value='Promote'>":""?>
                </form>


            <?php
                echo "
                                </div>
                            </a>
                        </div>
                    </div>";
            }

            ?>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- page numbers -->
                <?php
                for ($x = 1; $x <= $pages_needed; $x++) {
                    echo "<li class='page-item'><a class='page-link' href='listProduct.php?pageno=" . $x . "'>" . $x . "</a></li>";
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
