<?php
require_once '../../../BusinessServiceLayer/model/customerModel.php';

class customerController {

    // display current customer name from customer table on checkout page - ARIF
    function viewCustomer($CustID){
            $customer = new customerModel();
            $customer->CustID = $CustID;
            return $customer->viewCustomer();
        }

    // display all customer name from customer table at runner delivery list - ARIF
    function viewAllCustomer($orderid,$j){
          $customer = new customerModel();
          $customer->orderid = $orderid;
          $customer->j = $j;
          return $customer->viewAllCustomer();
      }

    // display all customer name from customer table for my delivery list - ARIF
    function viewMyDeliveryCustomer($orderid, $j){
        $customer = new customerModel();
        $customer->orderid = $orderid;
        $customer->j = $j;
        return $customer->viewMyDeliveryCustomer();
    }


    //validate the email and password for the customer to login - ADLI
        function loginCust(){
            $customer = new customerModel();
            $customer->CustEmail = $_POST['CustEmail'];
            $customer->CustPassword = $_POST['CustPassword'];

            $cust = $customer->loginCustomer();
            $value = $cust->fetch();
            
            if($customer->loginCustomer()->rowCount() == 1){  
                $message = 'Success Login';
                 
                session_start();
                $_SESSION['CustID'] = $value[0];
                $_SESSION['CustName'] = $value[1];
                $_SESSION['CustEmail'] = $value[2];
                $_SESSION['CustPhoneNo'] = $value[3];
                $_SESSION['CustImage'] = $value[4];
                $_SESSION['CustPassword'] = $value[5];
                
               
                echo "<script type='text/javascript'>alert('$message');
                window.location = 'customerProfile.php';</script>";
                exit();
            }
            else{
                $message = "Login Failed ! Username or password incorrect";
               
                echo "<script type='text/javascript'>alert('$message');
                window.location = 'logincustomer.php';
                </script>";
            }
    
            
    }
    // Sent data to the database - ADLI
    function regsCust(){
        $customer = new customerModel();
        $customer->CustName = $_POST['CustName'];
        $customer->CustEmail = $_POST['CustEmail'];
        $customer->CustPhoneNo = $_POST['CustPhoneNo'];
        $customer->CustImage = time().$_FILES['photoFile']['name'];
        $customer->CustPassword = $_POST['CustPassword'];
    
        //file directory to save image - ADLI
            $customer->target_dir = "../../../uploads/";
    
            //target file to save in directory -ADLI
            $customer->target_file = $customer->target_dir . basename($_FILES["photoFile"]["name"]);
    
            // Select file type - ADLI
            $customer->imageFileType = strtolower(pathinfo($customer->target_file,PATHINFO_EXTENSION));
    
            // Valid file extensions- ADLI
            $customer->extensions_arr = array("jpg","jpeg","png","gif");
    // Validate if register succesfull - ADLI
        if($customer->registerCust() > 0){
                $message = "Register Succesfull!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = 'logincustomer.php';</script>";
            }
    }

    // Sent data to the database once the payment is successful - IMAN
   function paymentSucces(){

       $payment= new customerModel(); 
       $payment-> $payment_id = $arr_body['id'];
       $payment->$payer_id = $arr_body['payer']['payer_info']['payer_id'];
       $payment->$payer_email = $arr_body['payer']['payer_info']['email'];
       $payment->$amount = $arr_body['transactions'][0]['amount']['total'];
       $payment->$currency = PAYPAL_CURRENCY;
       $payment->$payment_status = $arr_body['state'];
        
        if($payment->paymentSuccess() >0 ){
       echo "Payment is successful. Your transaction id is: ". $payment_id; 
        }
    }
        

 
}


 ?>
