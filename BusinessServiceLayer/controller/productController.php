<?php
require_once '../../../BusinessServiceLayer/model/productModel.php';

class productController{



    // ============ SERVICE PROVIDER FUNCTIONS ============ //

    // add a new product to the service provider's product list - Wei Sheng
    function addProduct(){
        $product = new productModel();
        $product->prodname = $_POST['prodname'];
        $product->prodprice = $_POST['prodprice'];
        $product->prodcategory = $_SESSION['SpType'];
        $product->proddescription = $_POST['proddescription'];
        $product->prodstatus = $_POST['prodstatus'];
        $product->prodimage = $_POST['prodimage'];
        $product->spid = $_SESSION['SpID'];
        if($product->addProd() > 0){
            $message = "Success Insert!";
		echo "<script type='text/javascript'>alert('$message');
		window.location = 'listProduct.php';</script>";
        }
    }


    // view all products  (used to calculate the number of pages required) - Wei Sheng
    function viewallProduct(){
        $product = new productModel();
        $product->spid = $_SESSION['SpID'];
        return $product->viewallProd();
    }

    // view a specific page of products  - Wei Sheng
    function viewProductPage($offset, $number_of_records){
        $product = new productModel();
        $product->spid = $_SESSION['SpID'];
        return $product -> viewProdPage($offset, $number_of_records);
    }

    // view the details of a specific product - Wei Sheng
    function viewProduct($prodid){
        $product = new productModel();
        $product->prodid = $prodid;
        return $product->viewProd();
    }

    // edit the details of a specific product - Wei Sheng
    function editProduct(){
        $product = new productModel();
        $product->prodid = $_POST['prodid'];
        $product->prodname = $_POST['prodname'];
        $product->prodprice = $_POST['prodprice'];
        $product->proddescription = $_POST['proddescription'];
        $product->prodstatus = $_POST['prodstatus'];
        $product->prodimage = $_POST['prodimage'];
        if($product->editProd()){
            $message = "Success Update!";
		echo "<script type='text/javascript'>alert('$message');
		window.location = 'listProduct.php' </script>";
        }
    }

    // delete a specific product - Wei Sheng
    function deleteProduct(){
        $product = new productModel();
        $product->prodid = $_POST['prodid'];
        if($product->deleteProd()){
            $message = "Success Delete!";
		echo "<script type='text/javascript'>alert('$message');
		window.location = 'listProduct.php';</script>";
        }
    }


    // ============ CUSTOMER FUNCTIONS ============ //

    // view all products (used to calculate the number of pages required) - Wei Sheng
    function viewProductList(){
        $product = new productModel();
        if(isset($_GET['category'])){
            $product->prodcategory = $_GET['category'];
        }
        return $product->viewProdList();
    }

    // view all searched products - Wei Sheng
    function viewSearchProductList($term){
        $product = new productModel();
        if(isset($_GET['category'])){
            $product->prodcategory = $_GET['category'];

        }
        return $product->viewSearchProdList($term);
    }

    // view a specific page of products - Wei Sheng
    function viewProductListPage($offset, $number_of_records, $term){
        $product = new productModel();
        if(isset($_GET['category'])){
            $product->prodcategory = $_GET['category'];
        }
        return $product -> viewProdListPage($offset, $number_of_records, $term);
    }

    // get product details from product table to display at productDetails page - ARIF
    function viewProductDetails($ProductID){
        $product = new productModel();
        $product->ProductID = $ProductID;
        return $product->viewProductDetails();
    }


    // insert order from customer checkout page to orders table - ARIF
    function addOrder($CustID) {
        $product = new productModel();
        $product->CustID= $CustID;
        $product->quantity = $_SESSION['quantity'];
        $product->ProductID = $_SESSION['ProductID'];
        $product->OrderAddress = $_SESSION['OrderAddress'];
        $product->total = $_SESSION['total'];
        $product->OrderDate = date("F j, Y");
        // $product->OrderDate = date("Y-m-d H:i:s");
        if($product->addOrder() > 0){
            $message = "Success Add To Order!";
            echo "<script type='text/javascript'>alert('$message');
            </script>";
        }

      }

    // get last inserted primary key from orders table to be inserted in order_product table - ARIF
    function lastInsertId(){
        $product = new productModel();
        return $product->lastInsertId();
    }


    // insert order from customer checkout page to order_product table - ARIF
    function addOrderProduct($OrderID,$i) {

        $product = new productModel();
        $product->OrderID = $OrderID;
        $product->i = $i;
        $product->ProductID = $_SESSION['ProductID'];
        $product->quantity = $_SESSION['quantity'];

        if($product->addOrderProduct() > 0){
            echo "<script type='text/javascript'>
            window.location = '../../../ApplicationLayer/view/Customer/orderDetails.php?orderid=$OrderID';
            localStorage.clear();
            </script>";
        }
      }



    // ============ RUNNER FUNCTIONS ============ //

    // get all pending delivery from order_product table to display at runner deliveryList page - ARIF
    function viewAllDelivery(){
        $product = new productModel();
        return $product->viewAllDelivery();
    }


    // get all product details based on OrderProductID - ARIF
    function viewItemList($orderproductid,$j){
            $product = new productModel();
            $product->orderproductid = $orderproductid;
            $product->j = $j;
            return $product->viewItemList();
        }

    // get delivery address based on OrderID - ARIF
    function getDeliveryAddress($orderid,$j){
        $product = new productModel();
        $product->orderid = $orderid;
        $product->j = $j;
        return $product->getDeliveryAddress();
    }

    // get all OrderID based on OrderProductID - ARIF
    function getOrderID($orderproductid,$j){           
        $product = new productModel();
        $product->orderproductid = $orderproductid;           
        $product->j = $j;
        return $product->getOrderID();
    }

    // count number of rows based on RunnerID - ARIF
    function countPendingDelivery($RunnerID){
        $product = new productModel();
        $product->RunnerID = $RunnerID;
        return $product->countPendingDelivery();
    }

    // add orders to _order table and update DeliveryStatus - ARIF
    function acceptDelivery($RunnerID){
        $product = new productModel();
        $product->OrderProductID = $_POST['OrderProductID'];
        $product->RunnerID = $RunnerID;
        if($product->acceptDelivery()){
          $message = "Success Accept Delivery!";
            echo "<script type='text/javascript'>
            alert('$message');
            window.location = '../../../ApplicationLayer/view/Runner/deliveryList.php';
            </script>";
        }
    }

    // get all runner delivery based on RunnerID - ARIF
    function viewAllMyDelivery($RunnerID){
        $product = new productModel();
        $product->RunnerID = $RunnerID;
        return $product->viewAllMyDelivery();
    }

    // get all pending delivery based on OrderProductID - ARIF
    function viewMyPendingDelivery($orderproductID,$p){
      $product = new productModel();
      $product->orderproductID = $orderproductID;
      $product->p = $p;
      return $product->viewMyPendingDelivery();
    }

    // get all OrderID based on OrderProductID - ARIF
    function viewOrderId($orderproductid,$j){
        $product = new productModel();
        $product->orderproductid = $orderproductid;
        $product->j = $j;
        return $product->viewOrderId();
    }


    // get all delivery address based on OrderID - ARIF
    function viewMyDeliveryAddress($orderid,$j){
          $product = new productModel();
          $product->orderid = $orderid;
          $product->j = $j;
          return $product->viewMyDeliveryAddress();
      }

    // update delivery status to delivering - ARIF
    function pickupDelivery(){
          $product = new productModel();
          $product->OrderProductID = $_POST['OrderProductID'];
          if($product->pickupDelivery()){
            $message = "Success Pickup Item!";
              echo "<script type='text/javascript'>
              alert('$message');
              window.location = '../../../ApplicationLayer/view/Runner/myDeliveryList.php';
              </script>";
          }
      }

    // update delivery status to delivered - ARIF
    function deliveredDelivery(){
            $product = new productModel();
            $product->OrderProductID = $_POST['OrderProductID'];
            if($product->deliveredDelivery()){
              $message = "Success Delivered Item!";
                echo "<script type='text/javascript'>
                alert('$message');
                window.location = '../../../ApplicationLayer/view/Runner/myDeliveryList.php';
                </script>";
            }
        }

    // get complete delivery details based on OrderProductID - ARIF
    function viewMyCompleteDelivery($orderproductID,$p){
        $product = new productModel();
        $product->orderproductID = $orderproductID;
        $product->p = $p;
        return $product->viewMyCompleteDelivery();
    }


}
?>
