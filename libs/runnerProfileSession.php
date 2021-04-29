<?php
session_start();
// check if runner is login - ARIF
if (!isset($_SESSION['RunnerID'])) {
  echo "<script>
    window.location = 'loginRunner.php';
    </script>";
  exit();
}
// check if runner is logout - ARIF
if (isset($_POST['logout'])) {
  session_destroy();
  $message = 'Success logout';
  echo "<script>
    alert('$message');
    </script>";
  header("Location: loginRunner.php");
  exit();
}