<?php
// Author: Firdaus
require_once '../../../libs/adminSession.php';
require_once '../../../BusinessServiceLayer/controller/adminValidateController.php';
// Page to display all service providers details and for admin to approve/reject the service providers
$serviceProvider = new adminValidateController();
$data = $serviceProvider->serviceProvider();
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
  <title>Flash Delivery ! Admin</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-3">
    <div class="container">
      <a class="navbar-brand" href="adminValidateServiceProvider.php">Flash Delivery | Admin</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="adminValidateRunner.php">Runners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="adminValidateServiceProvider.php">Service Providers</a>
          </li>


        </ul>

        <form method="POST">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <input class="btn shadow-none text-light " type="submit" name="logout" value="Logout">
            </li>
          </ul>
        </form>
      </div>
    </div>
  </nav>
  <div class="container">
    <h2 class="text-center mb-3">Service Providers List</h2>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">No</th>
          <th scope="col">SpID</th>
          <th scope="col">Email</th>
          <th scope="col">Reg No</th>
          <th scope="col">Type</th>
          <th scope="col">Status</th>
          <th scope="col">Comment</th>
          <th scope="col">Validate</th>
          <th scope="col">Info</th>

        </tr>
      </thead>
      <?php $index=1; ?>
      <?php foreach ($data['serviceProviders'] as $serviceProvider) : ?>

        <tbody>
          <form action="" method="post">
            <tr>
            <th scope="row"><?php echo $index ?></th>
              <th scope="row"><?php echo $serviceProvider->SpID ?></th>
              <td><?php echo $serviceProvider->SpEmail ?></td>
              <td><?php echo $serviceProvider->SpRegID ?></td>
              <td><?php echo $serviceProvider->SpType ?></td>
              <td>
                <select class="form-control form-control-sm" name="reg_status">
                  <option selected value="<?php echo $serviceProvider->SpRegStatus; ?>"> <?php echo $serviceProvider->SpRegStatus; ?></option>
                  <option value="REJECTED"> Reject</option>
                  <option value="APPROVED"> Approve</option>
                </select>
              </td>
              <td><input type="text" name="reg_comment" class="form-control form-control-sm " value="<?php echo $serviceProvider->SpRegComment; ?>"></td>
              <input type="hidden" name="id" value="<?php echo $serviceProvider->SpID ?>">
              <td> <input type="submit" value="Save" class="btn btn-success btn-block"></td>
              <td> <a href="adminProfileServiceProvider.php?id=<?php echo $serviceProvider->SpID ?>" class=" btn btn-info btn-block">More</td>
            </tr>
          </form>


          <?php $index++;?> 
        <?php endforeach; ?>
        </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>