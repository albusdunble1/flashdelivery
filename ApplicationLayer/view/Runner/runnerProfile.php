<?php
// Auhor : Firdaus
// Page to display a single runner profile

require_once '../../../libs/runnerProfileSession.php';
require_once '../../../BusinessServiceLayer/controller/runnerProfileController.php';
require_once '../../../BusinessServiceLayer/controller/customerProfileController.php';
require_once '../../../BusinessServiceLayer/controller/productController.php';

$runner = new runnerProfileController();
$product = new productController();
$data = $runner->my();

$RunnerID = $_SESSION['RunnerID'];

error_reporting(0);
// get total count my pending delivery
$counts = $product->countPendingDelivery($RunnerID);
$totals = $counts->fetch();
$values = $totals[0];

// if($values != 0){
// $allAccept = $product->viewAllMyDelivery($RunnerID);
// for($a = 0; $a<$values; $a++){
// $allAccepts = $allAccept->fetch();
// $opID[] = $allAccepts[2];
//   }
// }

// if($opID != ''){
// for($p = 0; $p<count($opID); $p++){
//   $pending = $product->viewMyPendingDelivery($opID,$p);
//   $count = $pending->fetch();
//   if($count[0] != ''){
//   $total[] = $count[0];
//   }
// }
//   $value = count($total);
// } else {
//   $value = $values;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../assets/css/profile.css">
  <link rel="stylesheet" href="../../../assets/css/navbar.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../assets/css/bootstrap.min_united.css">
  <script src="https://kit.fontawesome.com/e40306d6a0.js" crossorigin="anonymous"></script>
  <title>Runner's profile</title>
</head>

      <style>
      .logout {
              background: none;
              padding: 0px;
              border: none;
            }
      </style>

      <body>

          <!-- NAVBAR -->
          <?php
           $fullname = $_SESSION['RunnerName'];
           $shortname = explode(" ", $fullname);
           $name = $shortname[0].' '.$shortname[1];
           ?>
           <nav class="navbar navbar-expand-md navbar-dark bg-info" style="height:50px">
            <div class="collapse navbar-collapse" id="navbarColor01">
              <div class="navbar-nav">
              <?php if ($data["status"] != "APPROVED") : ?>
                <a class="nav-item nav-link" href="runnerProfile.php">HOME</a>
              <?php else : ?>
                <a class="nav-item nav-link" href="deliveryList.php">HOME</a>
                <a class="nav-item nav-link active" href="runnerProfile.php"><?php echo strtoupper($name)."'S ACCOUNT"?><span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="myDeliveryList.php">PENDING DELIVERY<span class="badge badge-danger ml-2"><?= $value ?></span></a>
                <a class="nav-item nav-link" href="myCompleteDelivery.php">COMPLETE DELIVERY</a>
                <!-- <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
              <?php endif; ?>
                
                <form method="post" class="form-inline">
                <button type="submit" id="logout" class="logout" name="logout" style="background:transparent;color:white;border:none;width:0px;outline:none;"
                 onclick="return confirm('Are you sure you want to logout?');">
                <a class="nav-item nav-link" style="margin-right:-50px">LOGOUT</a></button>
                </form>
              </div>
            </div>
          </nav>

          <nav class="navbar navbar-light" style="height:70px;background-color: #f5f5f5">
          <?php if ($data["status"] != "APPROVED") : ?>
            <a href="runnerProfile.php" class="navbar-brand" style="color:black">Home</a>
      <?php else : ?>
        <a href="deliveryList.php" class="navbar-brand" style="color:black">Home</a>
      <?php endif; ?>
            
            <div style="margin-right:630px"><h5>Welcome Flash Runners!</h5></div>
          </nav>


  <div class="container">
    <div id="customer-profile">
      <div id="customer-nav" class="text-center">
        <div class="profile-img border w-100">
        <img class="profile-img-backdrop" src="../../../uploads/<?php echo $data['image'] ?>" alt="" srcset="">
          <img class="profile-img-real" src="../../../uploads/<?php echo $data['image'] ?>" alt="" srcset="" onerror="this.src='../../../uploads/default.png';">
        </div>
        <div class="border w-100">
          <h5 class=" mt-2">Hello, <?php echo $name  ?></h5>
        </div>
        <div class="border w-100 py-2">
          <a class="runner-nav runner-nav-active" href="runnerProfileEdit.php"><i class="fa fa-user" aria-hidden="true"></i>
            My Profile</a>
        </div>
        <?php if ($data["status"] != "REJECTED") : ?>
          <div class="border w-100 py-2">
            <a class="runner-nav" href="runnerProfileEdit.php"> <i class=" fa fa-pencil" aria-hidden="true"></i>
              Edit Profile</a>
          </div>
        <?php endif; ?>

      </div>
      <div id="customer-details" class="mx-4">
        <h4>My Profile</h4>
        <div id="runner-details-info">
          <p>Full name: <strong><?php echo $data["name"] ?></strong></p>
          <p>Email Address: <strong><?php echo $data["email"] ?></strong></p>
          <p>Phone Number: <strong><?php echo $data["phone_number"] ?></strong></p>
          <p>IC Number: <strong><?php echo $data["ic_no"] ?></strong></p>
          <p>Address: <strong><?php echo $data["address"] ?></strong></p>
          <p>Plate Number: <strong><?php echo $data["plate_no"] ?></strong></p>
          <?php if ($data["status"] == "PENDING" || empty($data['status'])) : ?>
            <p>Registration Status: <span class="badge badge-secondary">Pending</span></p>
          <?php elseif ($data["status"] == "REJECTED") : ?>
            <p>Registration Status: <span class="badge badge-danger">Rejected</span></p>
          <?php endif; ?>
          <?php if ($data["status"] == "PENDING" || $data["status"] == "REJECTED" || empty($data['status'])) : ?>
            <?php if (empty($data['status'])) : ?>
              <p>Registration Comment: <strong>Please wait 1-2 days for us to validate your account</strong></p>
            <?php else : ?>
              <p>Registration Comment: <strong><?php echo $data["reg_comment"] ?></strong></p>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($data["status"] == "REJECTED") : ?>
            <div class="row">
              <div class="col">
                <a href="runnerProfileEdit.php" class="btn btn-success btn-block"> Re-Apply
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2020 Flash Delivery</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Privacy</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Support</a></li>
      </ul>
    </footer>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
