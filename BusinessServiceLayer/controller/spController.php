<?php
require_once '../../../BusinessServiceLayer/model/spModel.php';

class spController {

  // display service provider address from service_provider table at runner delivery list - ARIF
  function getSpAddress($spid,$j) {
    $serviceProvider = new spModel();
    $serviceProvider->spid = $spid;
    $serviceProvider->j = $j;
    return $serviceProvider->getSpAddress();

  }

  //validate the email and password for the service provider to login - ADLI
  function loginSP(){
		$serviceProvider = new spModel();
		$serviceProvider->SpEmail = $_POST['SpEmail'];
    $serviceProvider->SpPassword = $_POST['SpPassword'];
    
    $sp = $serviceProvider->login_SP();
    $value = $sp->fetch();

		if($serviceProvider->login_SP()->rowCount() == 1){
			$message = 'Success Login';
                 
                session_start();
                $_SESSION['SpID'] = $value[0];
                $_SESSION['SpName'] = $value[1];
                $_SESSION['SpEmail'] = $value[2];
                $_SESSION['SpAddress'] = $value[3];
                $_SESSION['SpPhoneNo'] = $value[4];
                $_SESSION['SpRegID'] = $value[5];
                $_SESSION['SpType'] = $value[6];
                $_SESSION['SpPassword'] = $value[7];
                $_SESSION['SpImage'] = $value[8];
                $_SESSION['SpRegStatus'] = $value[9];
                $_SESSION['SpRegComment'] = $value[10];

               
                echo "<script type='text/javascript'>alert('$message');
                window.location = 'serviceProviderProfile.php';
                </script>";
                exit();
		}
		else{
			$message = "Login Failed ! Username or password incorrect";
               
      echo "<script type='text/javascript'>alert('$message');
      window.location = 'loginSP.php';
      </script>";
      exit();
    }
  }

    // Sent data to the database - ADLI
    function regsSp(){
      $serviceProvider = new spModel();
      $serviceProvider->SpName = $_POST['SpName'];
      $serviceProvider->SpEmail = $_POST['SpEmail'];
      $serviceProvider->SpAddress =$_POST['SpAddress'];
      $serviceProvider->SpPhoneNo = $_POST['SpPhoneNo'];
      $serviceProvider->SpRegID =$_POST['SpRegID'];
      $serviceProvider->SpType =$_POST['SpType'];
      $serviceProvider->SpImage = time().$_FILES['photoFile']['name'];
      $serviceProvider->SpPassword = $_POST['SpPassword'];
      $serviceProvider->SpRegStatus = 'PENDING';
    
      //file directory to save image - ADLI
            $serviceProvider->target_dir = "../../../uploads/";
    
            //target file to save in directory - ADLI
            $serviceProvider->target_file = $serviceProvider->target_dir . basename($_FILES["photoFile"]["name"]);
    
            // Select file type - ADLI
            $serviceProvider->imageFileType = strtolower(pathinfo($serviceProvider->target_file,PATHINFO_EXTENSION));
    
            // Valid file extensions - ADLI
            $serviceProvider->extensions_arr = array("jpg","jpeg","png","gif");
    
      // Validate if register succesfull - ADLI      
      if($serviceProvider->registerSP() > 0){
                $message = "Register Succesfull!";
        echo "<script type='text/javascript'>alert('$message');
        window.location = '../../../ApplicationLayer/view/ServiceProvider/loginSP.php';</script>";
            }
            
    }







}



?>
