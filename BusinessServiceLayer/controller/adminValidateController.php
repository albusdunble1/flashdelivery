
<?php
// Author : Firdaus
// controller for admin to display all runners or service providers details and to validate each one
require_once '../../../libs/Controller.php';
require_once '../../../BusinessServiceLayer/model/runnerProfileModel.php';
require_once '../../../BusinessServiceLayer/model/serviceProviderProfileModel.php';
class adminValidateController extends Controller
{
  // Display and edit runner details
  public function runner()
  {
    $this->userModel = $this->model("runnerProfileModel");
    $runner = $this->userModel->getAllRunners();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'runners' => $runner,
        'status' => trim($_POST['reg_status']),
        'comment' => trim($_POST['reg_comment']),
        'id' => $_POST['id'],
      ];

      if ($this->userModel->validateRunnerByID($data['id'], $data)) {
        header("location:adminValidateRunner.php");
      }
    } else {
      $data = [
        'runners' => $runner
      ];

      return $data;
    }
  }
  // Display and edit service provider details
  public function serviceProvider()
  {

    $this->userModel = $this->model("serviceProviderProfileModel");
    $serviceProvider = $this->userModel->getAllServiceProviders();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'serviceProviders' => $serviceProvider,
        'status' => trim($_POST['reg_status']),
        'comment' => trim($_POST['reg_comment']),
        'id' => $_POST['id'],
      ];

      if ($this->userModel->validateServiceProviderByID($data['id'], $data)) {
        header("location:adminValidateServiceProvider.php");
      }
    } else {
      $data = [
        'serviceProviders' => $serviceProvider
      ];

      return $data;
    }
  }
}
