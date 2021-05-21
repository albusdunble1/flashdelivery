
<?php
// Author : Firdaus
// controller for customer to edit and display customer details
require_once '../../../libs/Controller.php';
require_once '../../../BusinessServiceLayer/model/customerProfileModel.php';

class customerProfileController extends Controller
{
  // Display Customer Profile Details
  public function my()
  {
    $this->userModel = $this->model("customerProfileModel");
    $customer = $this->userModel->getUserById($_SESSION['CustID']);
    $data = [
      'name' => $customer->CustName,
      'sub_name' => substr($customer->CustName, 0, 8),
      'email' => $customer->CustEmail,
      'phone_number' => $customer->CustPhoneNo,
      'password' => $customer->CustPassword,
      'image' => $customer->CustImage
    ];
    return $data;
  }

  // Edit Customer Profile Details
  public function edit()
  {
    $this->userModel = $this->model("customerProfileModel");
    $customer = $this->userModel->getUserById($_SESSION['CustID']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'name' => trim($_POST['name']),
        'sub_name' => substr(trim($_POST['name']), 0, 8),
        'email' => trim($_POST['email']),
        'phone_number' => trim($_POST['phone_number']),
        'password' => trim($_POST['password']),
        'image' =>  trim($_POST['image']),
        'name_err' => '',
        'email_err' => '',
        'phone_number_err' => '',
        'password_err' => ''
      ];

      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check email

        if ($this->userModel->findUserByEmail($data['email'])) {
          $customer = $this->userModel->getUserById($_SESSION['CustID']);
          if ($data['email'] != $customer->CustEmail) {
            $data['email_err'] = 'Email is already taken';
          }
        }
      }

      // Validate Name
      if (empty($data['name'])) {

        $data['name_err'] = 'Please enter name';
      }

      // Validate Password using preg_match function -Faiz
      $uppercase = preg_match('@[A-Z]@', $data['password']);
			$lowercase = preg_match('@[a-z]@', $data['password']);
			$number    = preg_match('@[0-9]@', $data['password']);
			$specialChars = preg_match('@[^\w]@', $data['password']);

      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($data['password']) < 8) {

        $data['password_err'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
      }

      // Validate Phone Number Password
      if (empty($data['phone_number'])) {
        $data['phone_number_err'] = 'Please enter your phone number';
      }
      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['phone_number_err'])) {

        // Validated
        if ($this->userModel->editUserById($_SESSION['CustID'], $data)) {
          // set session
          $_SESSION['CustName'] = $data['name'];
          $_SESSION['CustEmail'] = $data['email'];
          $_SESSION['CustPhoneNo'] = $data['phone'];
          $_SESSION['CustImage'] = $data['image'];
          $_SESSION['CustPassword'] = $data['password'];
          header("location:customerProfile.php");
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        return $data;
      }
    } else {
      $data = [
        'name' => $customer->CustName,
        'sub_name' => substr($customer->CustName, 0, 8),
        'email' => $customer->CustEmail,
        'phone_number' => $customer->CustPhoneNo,
        'password' => $customer->CustPassword,
        'image' => $customer->CustImage,
        'name_err' => "",
        'email_err' => "",
        'phone_number_err' => "",
        'password_err' => "",

      ];
      return $data;
    }
  }
}
