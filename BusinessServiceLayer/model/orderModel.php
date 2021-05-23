<?php
require_once '../../../libs/database.php';

class orderModel{
    // public variable Wei Sheng
    public $orderid,$custid,$orderdate,$orderaddress,$deliverystatus,$total; 

    // ============ SERVICE PROVIDER FUNCTIONS ============ //

    // retreive all customers that bought the service provider's products from the database (used to calculate the number of pages required) - Wei Sheng
    function viewBuyList(){
        $sql = "SELECT p.ProductName, o.OrderDate, op.quantity, c.CustName FROM product AS p, order_product AS op, customer AS c, orders as o WHERE op.ProductID = p.ProductID AND op.OrderID = o.OrderID AND o.CustID = c.CustID AND p.SpID = '$this->spid';";
        return DB::run($sql);
    }

    // retrieve specific number of customer that bought the service provider's products from the database based on the page number - Wei Sheng
    function viewBuyListPage($offset, $number_of_records){
        $sql = "SELECT p.ProductName, o.OrderDate, op.quantity, c.CustName, op.DeliveryStatus, op.OrderID FROM product AS p, order_product AS op, customer AS c, orders as o WHERE op.ProductID = p.ProductID AND op.OrderID = o.OrderID AND o.CustID = c.CustID AND p.SpID = '$this->spid'  ORDER BY op.OrderProductID DESC limit ". $offset. ", ". $number_of_records ;
        return DB::run($sql);
    }
    
    // ============ CUSTOMER FUNCTIONS ============ //
    
    // view all orders made by the customer (used to calculate the number of pages required) - Wei Sheng
    function viewOrdList(){
        $sql =  "SELECT * FROM orders WHERE CustID='$this->custid'";
        return DB::run($sql);
    }

    // view a specific number of orders made by the customer based on the page number - Wei Sheng
    function viewOrdListPage($offset, $number_of_records){
        $sql =  "SELECT * FROM orders WHERE CustID='$this->custid' ORDER BY OrderID DESC limit ". $offset. ", ". $number_of_records;
        return DB::run($sql);
    }

    // view details of a specific order made by the customer - Wei Sheng
    function viewOrd(){
        $sql =  "SELECT o.OrderAddress, op.quantity, p.ProductName, p.ProductPrice, o.total, o.OrderAddress, op.DeliveryStatus, p.ProductImage FROM orders AS o, order_product AS op, product AS p 
        WHERE o.orderid = op.orderid AND p.productid = op.productid AND o.orderid = '$this->orderid'";
        return DB::run($sql);
    }

}
?>
