<?php
session_start();

// check is service provider is login - ARIF
if (!isset($_SESSION['SpID'])) {
  echo "<script>
    window.location.href = 'loginSP.php';
    </script>";
}

// check if service provider is logout - ARIF
if (isset($_POST['logout'])) {
  session_destroy();
  $message = 'Success logout';
  echo "<script>
    alert('$message');
    </script>";
  header('Location: loginSP.php');
}
