<?php
// author : Iman
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

//Direct customer to registered business paypal account client ID . All payment will be direct to FLASH SYSTEM
define('CLIENT_ID', 'AfPPPXL8lqxBrUyzESxrz0154jM9amtZGBXkLaM05A8QU2J6ym4zKLw6yjHSi4uV-DesNRZT-9e3DbQh'); 
define('CLIENT_SECRET', 'EO--znozOIPU_1aXMqY7EyATJo8I6scVFxkqfktt1me_3M6hN_pH5o010eDGYP37NTXKWzmA63xjUUhl');
// Success payment
define('PAYPAL_RETURN_URL', 'http://localhost/group5flash/libs/paypal/success.php');
//Cancel payment
define('PAYPAL_CANCEL_URL', 'http://localhost/group5flash/libs/paypal/cancel.php');
//Set currency
define('PAYPAL_CURRENCY', 'MYR'); // set your currency here

// Connect with the database
$db = new mysqli('localhost', 'root', '', 'flash');

if ($db->connect_errno) {
    die("Connect failed: ". $db->connect_error);
}

$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //set it to 'false' when go live
