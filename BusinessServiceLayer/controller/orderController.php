<?php
require_once '../../../BusinessServiceLayer/model/orderModel.php';

class orderController{

    // ============ SERVICE PROVIDER FUNCTIONS ============ //

    // view all the customers that bought their products (used to calculate the number of pages required)  - Wei Sheng
    function viewBuyersList(){
        $order = new orderModel();
        $order->spid = $_SESSION['SpID'];
        return $order->viewBuyList();
    }

    // view a specific page of buyers list - Wei Sheng
    function viewBuyersListPage($offset, $number_of_records){
        $order = new orderModel();
        $order->spid = $_SESSION['SpID'];
        return $order->viewBuyListPage($offset, $number_of_records);
    }

    // ============ CUSTOMER FUNCTIONS ============ //


    // view all orders made by the customer (used to calculate the number of pages required) - Wei Sheng
    function viewOrderList(){
        $order = new orderModel();
        $order->custid = $_SESSION['CustID'];
        return $order->viewOrdList();
    }

    // view a specific page of orders made by the customer - Wei Sheng
    function viewOrderListPage($offset, $number_of_records){
        $order = new orderModel();
        $order->custid = $_SESSION['CustID'];
        return $order -> viewOrdListPage($offset, $number_of_records);
    }

    // view the details of a specific order made by the customer - Wei Sheng
    function viewOrder($orderid){
        $order = new orderModel();
        $order->orderid = $orderid;
        return $order->viewOrd();
    }


}
?>
