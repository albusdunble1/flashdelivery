<?php
require_once '../../../libs/database.php';

class productModel{
    // public variable Wei Sheng
    public $prodid,$prodname,$prodprice,$prodcategory,$proddescription,$prodstatus,$prodimage, $prodsortsales, $prodrating, $prodcomment,$spid, $ReviewDate,

    // public variable ARIF
    $CustID, $OrderDate, $OrderAddress, $DeliveryStatus, $total,
    $OrderID, $ProductID, $OrderProductID, $quantity, $i, $index, $RunnerID,
    $orderproductid, $j, $orderid, $p, $orderproductID;



    // ============ SERVICE PROVIDER FUNCTIONS ============ //


    // insert product details into product table - Wei Sheng
    function addProd(){
        $sql = "insert into product(ProductName, ProductPrice, ProductCategory, ProductDescription, ProductStatus, ProductImage, SpID) values(:prodname, :prodprice, :prodcategory, :proddescription, :prodstatus, :prodimage, :spid)";
        $args = [':prodname'=>$this->prodname, ':prodprice'=>$this->prodprice, ':prodcategory'=>$this->prodcategory, ':proddescription'=>$this->proddescription, ':prodstatus'=>$this->prodstatus, ':prodimage'=>$this->prodimage, ':spid'=>$this->spid];
        $stmt = DB::run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // retrieve all service provider's products fron product table - Wei Sheng
    function viewallProd(){
        $sql = "select * from product where SpID='$this->spid'";
        return DB::run($sql);
    }

    // retrieve a specific number of products from the product table according to the page number - Wei Sheng
    function viewProdPage($offset, $number_of_records){
        $sql =  "select * from product where SpID='$this->spid' limit ". $offset. ", ". $number_of_records;
        return DB::run($sql);
    }

    // retrieve details of a specific product from the product table - Wei Sheng
    function viewProd(){
        $sql = "select * from product where ProductId=:prodid";
        $args = [':prodid'=>$this->prodid];
        return DB::run($sql,$args);
    }

    // update the details of a specific product in the product table - Wei Sheng
    function editProd(){
        $sql = "update product set ProductName=:prodname,ProductPrice=:prodprice,ProductDescription=:proddescription,ProductStatus=:prodstatus,ProductImage=:prodimage where ProductID=:prodid";
        $args = [':prodname'=>$this->prodname, ':prodprice'=>$this->prodprice, ':proddescription'=>$this->proddescription, ':prodstatus'=>$this->prodstatus, ':prodimage'=>$this->prodimage, ':prodid'=>$this->prodid];
        return DB::run($sql,$args);
    }

    // delete a specific product from the product table - Wei Sheng
    function deleteProd(){
        $sql = "delete from product where ProductID=:prodid";
        $args = [':prodid'=>$this->prodid];
        return DB::run($sql,$args);
    }

    // promote a specific product from the product table - Wei Sheng
    function promoteProd(){
        $this->removeExistingPromotion();
        $sql = "update product set ProductPromotion='1' where ProductID=:prodid";
        $args = [':prodid'=>$this->prodid];
        return DB::run($sql,$args);
    }

    function removeExistingPromotion(){
        $sql = "update product set ProductPromotion='0' where ProductPromotion='1' and SpID='$this->spid'";
        
        return DB::run($sql);
    }




    // ============ CUSTOMER FUNCTIONS ============ //

    // retrieve all promoted products
    function viewPromoted(){
        $sql = "select * from product where ProductStatus='Available' and ProductPromotion='1'";

        return DB::run($sql);
    }


    // retrieve all reviews for a specific product
    function viewAllProdReviews(){
        $sql = "select * from reviews as r INNER JOIN customer as c ON r.CustID=c.CustID where r.ProductID='$this->ProductID' ORDER BY ReviewID DESC";

        // "SELECT c.name,, b.date, b.roll FROM a INNER JOIN b ON a.id=b.id;"

        return DB::run($sql);
    }

    // insert product review into reviews table - Wei Sheng
    function addReview(){
        $sql = "insert into reviews(CustID, ProductID, ReviewComment, ReviewRating, ReviewDate) values(:custid, :prodid, :reviewcomment, :reviewrating, :reviewdate)";
        $args = [':custid'=>$this->CustID, ':prodid'=>$this->ProductID, ':reviewcomment'=>$this->prodcomment, ':reviewrating'=>$this->prodrating, ':reviewdate'=>$this->ReviewDate];
        $stmt = DB::run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // check if customer product review already exist in reviews table
    function checkReview(){
        $sql = "select * from reviews where ProductID=:ProductID and CustID=:CustID";
        $args = [':ProductID'=>$this->ProductID, ':CustID'=>$this->CustID];
        $stmt = DB::run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // check if customer product purchase exist in order and order_product table
    function checkPurchase(){
        $sql = "select * from orders as o, order_product as op where op.ProductID='$this->ProductID' and o.CustID='$this->CustID' and o.OrderID=op.OrderID";
        $stmt = DB::run($sql);
        $count = $stmt->rowCount();
        return $count;
    }
    



    // retrieve all products from the product table (used to calculate the number of pages required) - Wei Sheng
    function viewProdList(){
        // if(isset($this->prodcategory)){
        //     $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory'";
        // }else{
        //     $sql = "select * from product where ProductStatus='Available'";
        // }


        if(isset($this->prodcategory) && isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' ORDER BY ProductSales $this->prodsortsales" ;
        }else if(isset($this->prodcategory)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory'";
        }else if(isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' ORDER BY ProductSales $this->prodsortsales";
        }else{
            $sql = "select * from product where ProductStatus='Available'";
        }






        return DB::run($sql);
    }

    // retrieve products that match the searched term from the product table - Wei Sheng
    function viewSearchProdList($term){
        // if(isset($this->prodcategory)){
        //     $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and ProductName like '%$term%' ";
        // }else{
        //     $sql = "select * from product where ProductStatus='Available' and  ProductName like '%$term%'";
        // }


        if(isset($this->prodcategory) && isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and ProductName like '%$term%' ORDER BY ProductSales $this->prodsortsales" ;
        }else if(isset($this->prodcategory)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and  ProductName like '%$term%'";
        }else if(isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' and  ProductName like '%$term%' ORDER BY ProductSales $this->prodsortsales";
        }else{
            $sql = "select * from product where ProductStatus='Available' and  ProductName like '%$term%'";
        }

        


        return DB::run($sql);
    }

    // retrieve a specific number of products from the product table according to the page number - Wei Sheng
    function viewProdListPage($offset, $number_of_records, $term){
        // if(isset($this->prodcategory)){
        //     $sql =  "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and ProductName like '%$term%' limit ". $offset. ", ". $number_of_records;
        // }else{
        //     $sql =  "select * from product where ProductStatus='Available' and  ProductName like '%$term%' limit ". $offset. ", ". $number_of_records;
        // }



        if(isset($this->prodcategory) && isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and ProductName like '%$term%' ORDER BY ProductSales $this->prodsortsales limit ". $offset. ", ". $number_of_records ;
        }else if(isset($this->prodcategory)){
            $sql = "select * from product where ProductStatus='Available' and  ProductCategory='$this->prodcategory' and  ProductName like '%$term%' limit ". $offset. ", ". $number_of_records;
        }else if(isset($this->prodsortsales)){
            $sql = "select * from product where ProductStatus='Available' and  ProductName like '%$term%' ORDER BY ProductSales $this->prodsortsales limit ". $offset. ", ". $number_of_records;
        }else{
            $sql = "select * from product where ProductStatus='Available' and  ProductName like '%$term%' limit ". $offset. ", ". $number_of_records;
        }



        return DB::run($sql);
    }

    // get selected product details to display at productDetails page - ARIF
    function viewProductDetails(){
        $sql = "select * from product where ProductID=:ProductID";
        $args = [':ProductID'=>$this->ProductID];
        return DB::run($sql,$args);
    }


    // add customer order to orders table - ARIF
    function addOrder(){

      $sql = "insert into orders(CustID, OrderDate, OrderAddress, total)
      values(:CustID, :OrderDate, :OrderAddress, :total)";

      $args = [':CustID'=>$this->CustID, ':OrderDate'=>$this->OrderDate, ':OrderAddress'=>$this->OrderAddress, ':total'=>$this->total];

      $stmt = DB::run($sql, $args);
      $count = $stmt->rowCount();
      return $count;
    }

    // retrive last insert id from orders table to be insert in order_product table - ARIF
    function lastInsertId() {
        $sql = "SELECT OrderID FROM orders ORDER BY OrderID DESC LIMIT 1";
        return DB::run($sql);
    }


    // add customer order to order_product table - ARIF
    function addOrderProduct(){

        $DeliveryStatus = 'Pending';

        $index = $this->i;

        $sql = "insert into order_product(OrderID, ProductID, quantity, DeliveryStatus)
        values(:OrderID, :ProductID, :quantity, :DeliveryStatus)";

        $args = [':OrderID'=>$this->OrderID,':ProductID'=>$this->ProductID[$index],':quantity'=>$this->quantity[$index],
        ':DeliveryStatus'=>$DeliveryStatus];

        $stmt = DB::run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }





    // ============ RUNNER FUNCTIONS ============ //

    // get all pending delivery from order_product table - ARIF
    function viewAllDelivery(){
        $sql = "SELECT * FROM order_product WHERE DeliveryStatus = 'Pending'";
        return DB::run($sql);
    }

    // get all product details from product table based on ProductID from order_product table - ARIF
    function viewItemList(){
        $OrderProductID = $this->orderproductid[$this->j];

        $sql = "SELECT * FROM product INNER JOIN order_product ON order_product.ProductID = product.ProductID
        WHERE order_product.OrderProductID = '{$OrderProductID}' ";

        return DB::run($sql);
    }

    // get all orders details from order table based on OrderID from order_product table - ARIF
    function getDeliveryAddress(){
        $OrderID = $this->orderid[$this->j];

        $sql = "SELECT * FROM orders INNER JOIN order_product ON order_product.OrderID = orders.OrderID
        WHERE order_product.OrderID = '{$OrderID}'";

        return DB::run($sql);
    }

    // get all order_product details from order_product table based on OrderID
    // from orders table and OrderProductID from order_product table - ARIF
    function getOrderID(){
        $OrderProductID = $this->orderproductid[$this->j];

        $sql = "SELECT * FROM order_product INNER JOIN orders ON order_product.OrderID = orders.OrderID
        WHERE order_product.OrderProductID = '{$OrderProductID}'";

        return DB::run($sql);
    }

    // count number of rows from runner_order table based on RunnerID - ARIF
    function countPendingDelivery(){

        $sql = "SELECT count(*) FROM runner_order WHERE RunnerID=:RunnerID";
        $args = [':RunnerID'=>$this->RunnerID];
        return DB::run($sql,$args);
    }

    // add orders to runner_order table and update delivery status in runner_order
    // table based on OrderProductID - ARIF
    function acceptDelivery(){

        $DeliveryStatus = 'Processing';

        $sql = "INSERT INTO runner_order(RunnerID, OrderProductID) VALUES (:RunnerID, :OrderProductID);
        UPDATE order_product SET DeliveryStatus=:DeliveryStatus WHERE OrderProductID = 'OrderProductID'";
        $args = [':RunnerID'=>$this->RunnerID, ':OrderProductID'=>$this->OrderProductID, ':DeliveryStatus'=>$DeliveryStatus];

        return DB::run($sql,$args);
    }

    // get all runner_order details based on RunnerID - ARIF
    function viewAllMyDelivery(){

        $sql = "SELECT * FROM runner_order WHERE RunnerID=:RunnerID";
        $args = [':RunnerID'=>$this->RunnerID];
        return DB::run($sql,$args);
    }

    // get all order_product details from order_product based on OrderProductID
    // and Delivery Status not equal to 'Delivered' - ARIF
    function viewMyPendingDelivery(){
        $OrderProductID = $this->orderproductID[$this->p];

        $sql = "SELECT * FROM order_product WHERE OrderProductID = '{$OrderProductID}' AND DeliveryStatus <> 'Delivered'";
        return DB::run($sql);
    }

    // get all order_product details from order_product based on OrderProductID
    // from runner_order table - ARIF
    function viewOrderId() {

      $OrderProductID = $this->orderproductid[$this->j];

      $sql = "SELECT * FROM order_product INNER JOIN runner_order ON runner_order.OrderProductID = order_product.OrderProductID
      WHERE runner_order.OrderProductID = '{$OrderProductID}' AND order_product.OrderProductID = '{$OrderProductID}' ";
      return DB::run($sql);
    }


    // get orders details from orders table based on OrderID from order_product table - ARIF
    function viewMyDeliveryAddress() {

      $OrderID = $this->orderid[$this->j];

      $sql = "SELECT * FROM orders INNER JOIN order_product ON order_product.OrderID = orders.OrderID
      WHERE orders.OrderID = '{$OrderID}'";
      return DB::run($sql);
    }

    // update delivery status to delivering from order_product table based OrderProductID - ARIF
    function pickupDelivery(){

    $sql = "UPDATE order_product SET DeliveryStatus = 'Delivering' WHERE OrderProductID = '{$this->OrderProductID}'";
    $args = [':OrderProductID'=>$this->OrderProductID];

    return DB::run($sql);
    }


    // update delivery status to delivering from order_product table based OrderProductID - ARIF
    function deliveredDelivery(){

    $sql = "UPDATE order_product SET DeliveryStatus = 'Delivered' WHERE OrderProductID = '{$this->OrderProductID}'";
    $args = [':OrderProductID'=>$this->OrderProductID];

    return DB::run($sql);
    }

    // get order_product details from order_product table based on OrderProductID and DeliveryStatus - ARIF
    function viewMyCompleteDelivery(){
        $OrderProductID = $this->orderproductID[$this->p];

        $sql = "SELECT * FROM order_product WHERE OrderProductID = '{$OrderProductID}' AND DeliveryStatus = 'Delivered'";
        return DB::run($sql);
    }



}
?>
