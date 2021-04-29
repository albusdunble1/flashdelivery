<?php
require_once '../../../BusinessServiceLayer/model/paymentModel.php';

class paymentController {

  // get last payment id - IMAN
  function lastPaymentId(){
      $payment = new paymentModel();
      return $payment->lastPaymentId();
  }

  // add order id to payment table - IMAN
  function addPaymentOrderID($OrderID,$paymentIDs) {
      echo "PAYMENT CONTROLLER=========";
      

      $payment = new paymentModel();
      echo "PAYMENT CONTROLLER 2ND=========";
      $payment->OrderID = $OrderID;
      $payment->id = $paymentIDs;
      return $payment->addPaymentOrderID();
      echo "PAYMENT CONTROLLER 3RD=========";
      if($payment->addPaymentOrderID() > 0){

      }

    }


}

?>
