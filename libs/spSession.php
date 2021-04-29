<?php
session_start();


if (!isset($_SESSION['SpID'])) {
    echo "<script>
    window.location.href = 'loginSP.php';
    </script>";
} 
// check sp registration status and redirect to sp profile if the status is not approved
else if (isset($_SESSION['SpID'])) {
    require_once '../../../BusinessServiceLayer/controller/serviceProviderProfileController.php';
    $spController = new serviceProviderProfileController();
    $spController->userModel = $spController->model("serviceProviderProfileModel");
    $serviceProvider = $spController->userModel->getUserById($_SESSION['SpID']);
    $dataServiceProvider = [
        'status' => $serviceProvider->SpRegStatus,
    ];
    if ($dataServiceProvider['status'] != "APPROVED") {
        echo "<script>
    window.location = 'serviceProviderProfile.php';
    </script>";
        exit();
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    $message = 'Success logout';
    echo "<script>
    alert('$message');
    </script>";
    header('Location: loginSP.php');
}
