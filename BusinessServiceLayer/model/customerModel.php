<?php
require_once '../../../libs/database.php';

class customerModel {
  public $orderid,$j,$CustEmail, $CustPassword,$CustName,$CustPhoneNo,$CustImage;

  // get the current customer information to display at checkout page - ARIF
  function viewCustomer(){
    $sql = "select * from customer where CustID=:CustID";
    $args = [':CustID'=>$this->CustID];
    return DB::run($sql,$args);
  }

  // get all customer name based on OrderID to display at runner deliveryList page - ARIF
  function viewAllCustomer(){

      $OrderID = $this->orderid[$this->j];

      $sql = "SELECT * FROM customer INNER JOIN orders ON orders.CustID = customer.CustID
      WHERE orders.OrderID = '{$OrderID}'";
      $args = [':OrderID'=>$OrderID];
      return DB::run($sql);
  }

  // get all customer name based on OrderID to display at runner myDeliveryList page - ARIF
  function viewMyDeliveryCustomer() {
    $OrderID = $this->orderid[$this->j];

    $sql = "SELECT * FROM customer INNER JOIN orders ON orders.CustID = customer.CustID
    WHERE orders.OrderID = '{$OrderID}'";

    return DB::run($sql);

  }

  // get email and password for customer to login - ADLI
  function loginCustomer(){
    if(isset($_POST['CustEmail'])){
      $sql = "select * from customer where CustEmail=:CustEmail AND CustPassword=:CustPassword limit 1";
      $args = [':CustEmail'=>$this->CustEmail, ':CustPassword'=>$this->CustPassword];

      // $stmt = DB::run($sql,$args);
      // $count = $stmt->rowCount();
      // return $count;
      return DB::run($sql,$args);
      
      }
    }

    // save data to database -ADLI
    function registerCust(){
      if(in_array($this->imageFileType, $this->extensions_arr)){
      $sql = "insert into customer(CustName, CustEmail,CustPhoneNo,CustImage,CustPassword)
    
      value(:CustName, :CustEmail, :CustPhoneNo, :CustImage, :CustPassword)";
    
      $args = [':CustName'=>$this->CustName, ':CustEmail'=>$this->CustEmail, ':CustPhoneNo'=>$this->CustPhoneNo, ':CustImage'=>$this->CustImage, ':CustPassword'=>$this->CustPassword];
    
      //Upload FIle -ADLI
            move_uploaded_file($_FILES['photoFile']['tmp_name'], $this->target_dir.$this->CustImage);
    
        $stmt = DB::run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
    }

  function paymentSuccess(){
  
    $isPaymentExist = $db->query("SELECT * FROM payments WHERE payment_id = '".$payment_id."'");
    if($isPaymentExist->num_rows == 0) {
    $insert = $db->query("INSERT INTO payments(payment_id, payer_id, payer_email, amount, currency, payment_status) VALUES('". $payment_id ."', '". $payer_id ."', '". $payer_email ."', '". $amount ."', '". $currency ."', '". $payment_status ."')");

    return DB::run($insert);
}


}

}

 ?>
