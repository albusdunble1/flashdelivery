<?php
require_once '../../../BusinessServiceLayer/model/adminModel.php';

class adminController{

//validate the email and password for the customer to login - ADLI
function loginAdmin(){
         $admin = new adminModel();
		$admin->AdminEmail = $_POST['AdminEmail'];
		$admin->AdminPassword = $_POST['AdminPassword'];

        $adm = $admin->loginadmin();
        $value = $adm->fetch();

		if($admin->loginadmin()->rowCount() == 1){
			$message = 'Success Login';
                 
                session_start();
                $_SESSION['AdminID'] = $value[0];
                $_SESSION['AdminEmail'] = $value[1];
                $_SESSION['AdminPassword'] = $value[2];
            
                echo "<script type='text/javascript'>alert('$message');
                window.location = 'adminValidateRunner.php';
                </script>";
                exit();
		}
		else{
			$message = "Login Failed ! Username or password incorrect";
               
            echo "<script type='text/javascript'>alert('$message');
            window.location = 'loginAdmin.php';
            </script>";
            exit();
		}
}





}

?>