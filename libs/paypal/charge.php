
<?php
// Author : Iman
// payment will be direct to to api

require_once 'configAPI.php';

session_start();

if (!empty($_SESSION['total'])) {

    try {
        $response = $gateway->purchase(array(
            'amount' =>  $_SESSION['total'],
            'currency' => PAYPAL_CURRENCY,
            'returnUrl' => PAYPAL_RETURN_URL,
            'cancelUrl' => PAYPAL_CANCEL_URL,
        ))->send();

        if ($response->isRedirect()) {
            
            $response->redirect(); // this will automatically forward the customer


        } else {
            // not successful
            echo $response->getMessage();

        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
