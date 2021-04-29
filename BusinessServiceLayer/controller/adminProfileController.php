
<?php
// Author: Firdaus
// controller for admin to display a single runner or service provider details
require_once '../../../libs/Controller.php';
require_once '../../../BusinessServiceLayer/model/runnerProfileModel.php';
require_once '../../../BusinessServiceLayer/model/serviceProviderProfileModel.php';
class adminProfileController extends Controller
{
  // Get Single Runner Profile 
  public function runner()
  {
    $this->userModel = $this->model("runnerProfileModel");
    $runner = $this->userModel->getUserById($_GET['id']);
    $data = [
      'name' => $runner->RunnerName,
      'sub_name' => substr($runner->RunnerName, 0, 8),
      'email' => $runner->RunnerEmail,
      'phone_number' => $runner->RunnerPhoneNo,
      'image' => $runner->RunnerImage,
      'ic_no' => $runner->RunnerICNo,
      'address' => $runner->RunnerAddress,
      'plate_no' => $runner->RunnerPlateNo,
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

  // Get Single Service Provider Profile 
  public function serviceProvider()
  {
    //echo $_GET['id'];
    $this->userModel = $this->model("serviceProviderProfileModel");
    $serviceProvider = $this->userModel->getUserById($_GET['id']);
    $data = [
      'name' => $serviceProvider->SpName,
      'sub_name' => substr($serviceProvider->SpName, 0, 8),
      'email' => $serviceProvider->SpEmail,
      'phone_number' => $serviceProvider->SpPhoneNo,
      'image' => $serviceProvider->SpImage,
      'reg_no' => $serviceProvider->SpRegID,
      'address' => $serviceProvider->SpAddress,
      'type' => $serviceProvider->SpType,
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
