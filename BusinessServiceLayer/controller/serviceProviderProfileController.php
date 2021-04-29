
<?php
// Author : Firdaus
// controller for service provider to edit and display service provider details
require_once '../../../libs/Controller.php';
require_once '../../../BusinessServiceLayer/model/serviceProviderProfileModel.php';
class serviceProviderProfileController extends Controller
{
  // Display Service Provider Profile Details
  public function my()
  {
    $this->userModel = $this->model("serviceProviderProfileModel");
    $serviceProvider = $this->userModel->getUserById($_SESSION['SpID']);
    $data = [
      'name' => $serviceProvider->SpName,
      'sub_name' => substr($serviceProvider->SpName, 0, 8),
      'email' => $serviceProvider->SpEmail,
      'phone_number' => $serviceProvider->SpPhoneNo,
      'password' => $serviceProvider->SpPassword,
      'image' => $serviceProvider->SpImage,
      'reg_no' => $serviceProvider->SpRegID,
      'type' => $serviceProvider->SpType,
      'address' => $serviceProvider->SpAddress,
      'status' => $serviceProvider->SpRegStatus,
      'reg_comment' => $serviceProvider->SpRegComment
    ];

    return $data;
  }
  // Edit Service Provider Profile Details
  public function edit()
  {
    $this->userModel = $this->model("serviceProviderProfileModel");
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
        'address' =>  trim($_POST['address']),
        'reg_no' =>  trim($_POST['reg_no']),
        'type' =>  trim($_POST['type']),
        'status' => $_POST['status'],
        'reg_comment' => $_POST['reg_comment'],
        'name_err' => '',
        'email_err' => '',
        'phone_number_err' => '',
        'password_err' => '',
        'address_err' => '',
        'reg_no_err' => '',
        'type_err' => ''
      ];

      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check email
        if ($this->userModel->findUserByEmail($data['email'])) {
          $serviceProvider = $this->userModel->getUserById($_SESSION['SpID']);
          if ($data['email'] != $serviceProvider->SpEmail) {
            $data['email_err'] = 'Email is already taken';
          }
        }
      }

      // Validate Name
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter name';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // Validate Phone Number 
      if (empty($data['phone_number'])) {
        $data['phone_number_err'] = 'Please enter your phone number';
      }

      // Validate Address
      if (empty($data['address'])) {
        $data['address_err'] = 'Please enter your address';
      }

      // Validate IC Number
      if (empty($data['reg_no'])) {
        $data['reg_no_err'] = 'Please enter your IC number';
      }

      // Validate Plate Number
      if (empty($data['type'])) {
        $data['type_err'] = 'Please enter your phone number';
      }
      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['phone_number_err']) && empty($data['address_err']) && empty($data['reg_no_err']) && empty($data['type_err'])) {
                $_SESSION['SpName'] = $data['name'];
                $_SESSION['SpEmail'] = $data['email'];
                $_SESSION['SpAddress'] = $data['address'];
                $_SESSION['SpPhoneNo'] = $data['phone_number'];
                $_SESSION['SpRegID'] = $data['reg_no'];
                $_SESSION['SpType'] = $data['type'];
                $_SESSION['SpPassword'] = $data['password'];
                $_SESSION['SpImage'] = $data['image'];
                $_SESSION['SpRegStatus'] = $data['status'];
                $_SESSION['SpRegComment'] = $data['reg_comment'];
        // Validated
        // Check the user registration status
        if ($data["status"] == "PENDING" || $data["status"] == "REJECTED") {
          if ($this->userModel->reapplyUserById($_SESSION['SpID'], $data)) {
            header("location:serviceProviderProfile.php");
          } else {
            die('Something went wrong');
          }
        } else {
          if ($this->userModel->editUserById($_SESSION['SpID'], $data)) {
            header("location:serviceProviderProfile.php");
          } else {
            die('Something went wrong');
          }
        }
      } else {
        // Load view with errors
        return $data;
      }
    } else {
      $serviceProvider = $this->userModel->getUserById($_SESSION['SpID']);
      $data = [
        'name' => $serviceProvider->SpName,
        'sub_name' => substr($serviceProvider->SpName, 0, 8),
        'email' => $serviceProvider->SpEmail,
        'phone_number' => $serviceProvider->SpPhoneNo,
        'password' => $serviceProvider->SpPassword,
        'image' => $serviceProvider->SpImage,
        'reg_no' => $serviceProvider->SpRegID,
        'address' => $serviceProvider->SpAddress,
        'type' => $serviceProvider->SpType,
        'status' => $serviceProvider->SpRegStatus,
        'reg_comment' => $serviceProvider->SpRegComment,
        'name_err' => "",
        'email_err' => "",
        'phone_number_err' => "",
        'password_err' => "",
        'address_err' => "",
        'reg_no_err' => "",
        'type_err' => "",

      ];
      return $data;
    }
  }
}
