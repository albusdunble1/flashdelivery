<?php
// Author : Firdaus
// Page to display a single service provider profile 

require_once '../../../libs/spProfileSession.php';
require_once '../../../BusinessServiceLayer/controller/serviceProviderProfileController.php';

$serviceProvider = new serviceProviderProfileController();
$data = $serviceProvider->my();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/f252491b10.js" crossorigin="anonymous"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../assets/css/profile.css">
  <title>Flash Delivery ! Service Provider's profile</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-warning mb-3">
    <div class="container">
      <?php if ($data["status"] != "APPROVED") : ?>
        <a class="navbar-brand" href="serviceProviderProfile.php">Flash Delivery | SP</a>
      <?php else : ?>
        <a class="navbar-brand" href="listProduct.php">Flash Delivery | SP</a>
      <?php endif; ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <?php if ($data["status"] != "APPROVED") : ?>
            <a class="nav-item nav-link" href="serviceProviderProfile.php">Home <span class="sr-only">(current)</span></a>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="addProduct.php">Add Product</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="listProduct.php">Product List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="buyersList.php">Buyers List</a>
            </li>
          <?php endif; ?>

        </ul>
        <form method="POST">
          <ul class="navbar-nav ml-auto">

            <li class="nav-item">
              <a class="nav-link" href="serviceProviderProfile.php">Welcome <?php echo $_SESSION["SpEmail"]  ?></a>
            </li>
            <li class="nav-item">
              <input class="btn bg-warning shadow-none" type="submit" name="logout" value="Logout" style="color:black"
              onclick="return confirm('Are you sure you want to logout?');">
            </li>

          </ul>
        </form>
      </div>
    </div>
  </nav>
  <div class="container">
    <div id="customer-profile">
      <div id="customer-nav" class="text-center">
        <div class="profile-img border w-100">
          <img class="profile-img-backdrop" src="../../../uploads/<?php echo $data['image'] ?>" alt="" srcset="">
          <img class="profile-img-real" src="../../../uploads/<?php echo $data['image'] ?>" alt="" srcset="" onerror="this.src='../../../uploads/default.png';">
        </div>
        <div class="border w-100">
          <h5 class=" mt-2">Hello, <?php echo $data["sub_name"]  ?></h5>
        </div>

        <div class="border w-100 py-2">
          <a class="sp-nav sp-nav-active" href=" serviceProviderProfile.php"><i class="fa fa-user" aria-hidden="true"></i>
            My Profile</a>
        </div>
        <?php if ($data["status"] != "REJECTED") : ?>
          <div class="border w-100 py-2">
            <a class="sp-nav" href="serviceProviderProfileEdit.php"> <i class="fa fa-pencil" aria-hidden="true"></i>
              Edit Profile</a>
          </div>
        <?php endif; ?>
      </div>
      <div id="customer-details" class="mx-4">
        <h4>My Profile</h4>
        <div id="customer-details-info">
          <p>Full name: <strong><?php echo $data["name"] ?></strong></p>
          <p>Email Address: <strong><?php echo $data["email"] ?></strong></p>
          <p>Phone Number: <strong><?php echo $data["phone_number"] ?></strong></p>
          <p>Registeration Number: <strong><?php echo $data["reg_no"] ?></strong></p>
          <p>Address: <strong><?php echo $data["address"] ?></strong></p>
          <p>Service Type: <strong><?php echo $data["type"] ?></strong></p>
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
                <a href="serviceProviderProfileEdit.php" class="btn btn-success btn-block"> Re-Apply
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