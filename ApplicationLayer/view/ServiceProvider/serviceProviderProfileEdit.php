<?php
// Author : Firdaus
// Page to display a single service provider profile 
require_once '../../../libs/spProfileSession.php';
require_once '../../../BusinessServiceLayer/controller/serviceProviderProfileController.php';
$serviceProvider = new serviceProviderProfileController();
$data = $serviceProvider->edit();
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
  <title>Flash Delivery ! Runner's profile</title>
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
          <a class="sp-nav " href=" serviceProviderProfile.php"><i class="fa fa-user" aria-hidden="true"></i>
            My Profile</a>
        </div>
        <div class="border w-100 py-2">
          <a class="sp-nav sp-nav-active" href="serviceProviderProfileEdit.php"> <i class="fa fa-pencil" aria-hidden="true"></i>
            Edit Profile</a>
        </div>
      </div>
      <div id="customer-details" class="mx-4">
        <h4>My Profile</h4>
        <form action="" method="post">
          <input type="hidden" name="image" value="<?php echo $data["image"] ?>">
          <div id="customer-details-info">
            <div class="form-group ">
              <div class="edit">
                <label for="name">Full Name: </label>
                <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
              </div>
              <span class="invalid">
                <p><?php echo $data['name_err']; ?></p>
              </span>
            </div>
            <div class="form-group">
              <div class="edit">
                <label for="email">Email Address: </label>
                <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
              </div>
              <span class="invalid">
                <p><?php echo $data['email_err']; ?></p>
              </span>
            </div>
            <div class="form-group ">
              <div class="edit">
                <label for="phone_number">Phone Number: </label>
                <input type="text" name="phone_number" class="form-control form-control-lg <?php echo (!empty($data['phone_number_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['phone_number']; ?>">
              </div>
              <span class="invalid">
                <p><?php echo $data['phone_number_err']; ?></p>
              </span>
            </div>
            <div class="form-group">
              <div class="edit">
                <label for="password">Password: </label>
                <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
              </div>
              <span class="invalid">
                <p><?php echo $data['password_err']; ?></p>
              </span>
            </div>
            <div class="form-group">
              <div class="edit">
                <label for="address">Address: </label>
                <input type="text" name="address" class="form-control form-control-lg <?php echo (!empty($data['address_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['address']; ?>">
              </div>
              <span class="invalid">
                <p><?php echo $data['address_err']; ?></p>
              </span>
            </div>


            <?php if ($data["status"] == "PENDING" || $data["status"] == "REJECTED" || empty($data["status"])) : ?>
              <div class="form-group">
                <div class="edit">
                  <label for="reg_no">Registeration Number: </label>
                  <input type="reg_no" name="reg_no" class="form-control form-control-lg <?php echo (!empty($data['reg_no_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['reg_no']; ?>">
                </div>
                <span class="invalid">
                  <p><?php echo $data['reg_no_err']; ?></p>
                </span>
              </div>
              <div class="form-group">
                <div class="edit">
                  <label for="type">Service Type: </label>
                  <input type="type" name="type" class="form-control form-control-lg <?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['type']; ?>">
                </div>
                <span class="invalid">
                  <p><?php echo $data['type_err']; ?></p>
                </span>
              </div>
            <?php else : ?>
              <input type="hidden" name="reg_no" value="<?php echo $data['reg_no']; ?>">
              <input type="hidden" name="type" value="<?php echo $data['type']; ?>">
            <?php endif; ?>
            <input type="hidden" name="status" value="<?php echo $data['status']; ?>">
            <input type="hidden" name="reg_comment" value="<?php echo $data['reg_comment']; ?>">
            <div class="row">
              <div class="col">
                <input type="submit" value="Save" class="btn btn-success btn-block">
              </div>

            </div>
            </input>
        </form>
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