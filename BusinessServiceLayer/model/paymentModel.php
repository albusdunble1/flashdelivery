<?php
require_once '../../../libs/database.php';


class paymentModel {

    public $OrderID, $id;

// retrive last insert id from payments table - IMAN
function lastPaymentId() {
    $sql = "SELECT id FROM payments ORDER BY id DESC LIMIT 1";
    return DB::run($sql);
}

// add order id to payment to payment table based on payment id - IMAN
function addPaymentOrderID(){
    echo "PAYMENT MODE 1ST=========";

    $sql = "UPDATE payments SET OrderID = '{$this->OrderID}' WHERE id = '{$this->id}'";

    echo $sql;

    // $args = [':OrderID'=>$this->OrderID,':id'=>$this->id];
    // echo 'helooooooooooooo model';
    // echo 'ARGGGGGGG'+ $args + 'ARGGGGGG';

    return DB::run($sql);
    }
}

?>
