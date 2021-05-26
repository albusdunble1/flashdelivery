
<?php
// Author : Firdaus
// controller for runner to edit and display runner details
require_once '../../../libs/Controller.php';
require_once '../../../BusinessServiceLayer/model/runnerProfileModel.php';
class runnerProfileController extends Controller
{
  // Display Runner Profile Details
  public function my()
  {
    $this->userModel = $this->model("runnerProfileModel");
    $runner = $this->userModel->getUserById($_SESSION['RunnerID']);
    $data = [
      'name' => $runner->RunnerName,
      'sub_name' => substr($runner->RunnerName, 0, 8),
      'email' => $runner->RunnerEmail,
      'phone_number' => $runner->RunnerPhoneNo,
      'password' => $runner->RunnerPassword,
      'image' => $runner->RunnerImage,
      'ic_no' => $runner->RunnerICNo,
      'plate_no' => $runner->RunnerPlateNo,
      'address' => $runner->RunnerAddress,
      'status' => $runner->RunnerRegStatus,
      'reg_comment' => $runner->RunnerRegComment
    ];
    return $data;
  }
  // Edit Runner Profile Details
  public function edit()
  {
    $this->userModel = $this->model("runnerProfileModel");
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
        'ic_no' =>  trim($_POST['ic_no']),
        'plate_number' =>  trim($_POST['plate_number']),
        'status' =>  $_POST['status'],
        'reg_comment' =>  $_POST['reg_comment'],
        'name_err' => '',
        'email_err' => '',
        'phone_number_err' => '',
        'password_err' => '',
        'address_err' => '',
        'ic_no_err' => '',
        'plate_number_err' => ''
      ];
      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check email
        if ($this->userModel->findUserByEmail($data['email'])) {
          $runner = $this->userModel->getUserById($_SESSION['RunnerID']);
          if ($data['email'] != $runner->RunnerEmail) {
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

      // Validate Phone Number
      if (empty($data['phone_number'])) {
        $data['phone_number_err'] = 'Please enter your phone number';
      }

      // Validate Address
      if (empty($data['address'])) {
        $data['address_err'] = 'Please enter your address';
      }

      // Validate IC Number
      if (empty($data['ic_no'])) {
        $data['ic_no_err'] = 'Please enter your IC number';
      }

      // Validate Plate Number
      if (empty($data['plate_number'])) {
        $data['plate_number_err'] = 'Please enter your phone number';
      }
      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['phone_number_err']) && empty($data['address_err']) && empty($data['ic_no_err']) && empty($data['plate_number_err'])) {
        $_SESSION['RunnerName'] = $data['name'];
        $_SESSION['RunnerEmail'] = $data['email'];
        $_SESSION['RunnerPassword'] = $data['password'];
        $_SESSION['RunnerPhoneNo'] = $data['phone_number'];
        $_SESSION['RunnerICNo'] = $data['ic_no'];
        $_SESSION['RunnerAddress'] = $data['address'];
        $_SESSION['RunnerImage'] = $data['image'];
        $_SESSION['RunnerPlateNo'] = $data['plate_number'];
        $_SESSION['RunnerRegStatus'] = $data['status'];
        $_SESSION['RunnerRegComment'] = $data['reg_comment'];
        // Validated
        // Check the user registration status
        if ($data["status"] == "PENDING" || $data["status"] == "REJECTED") {
          if ($this->userModel->reapplyUserById($_SESSION['RunnerID'], $data)) {
            header("location:runnerProfile.php");
          } else {
            die('Something went wrong');
          }
        } else {
          if ($this->userModel->editUserById($_SESSION['RunnerID'], $data)) {
            header("location:runnerProfile.php");
          } else {
            die('Something went wrong');
          }
        }
      } else {
        // Load view with errors
        return $data;
      }
    } else {
      $runner = $this->userModel->getUserById($_SESSION['RunnerID']);
      $data = [
        'name' => $runner->RunnerName,
        'sub_name' => substr($runner->RunnerName, 0, 8),
        'email' => $runner->RunnerEmail,
        'phone_number' => $runner->RunnerPhoneNo,
        'password' => $runner->RunnerPassword,
        'image' => $runner->RunnerImage,
        'ic_no' => $runner->RunnerICNo,
        'address' => $runner->RunnerAddress,
        'plate_number' => $runner->RunnerPlateNo,
        'status' => $runner->RunnerRegStatus,
        'reg_comment' => $runner->RunnerRegComment,
        'name_err' => "",
        'email_err' => "",
        'phone_number_err' => "",
        'password_err' => "",
        'address_err' => "",
        'ic_no_err' => "",
        'plate_number_err' => "",

      ];
      return $data;
    }
  }
}
