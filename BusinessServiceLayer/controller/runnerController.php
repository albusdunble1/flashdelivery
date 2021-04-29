<?php
require_once '../../../BusinessServiceLayer/model/runnerModel.php';
class runnerController {

 //validate the email and password for the runner to login - ADLI
function loginRun(){
    $runner = new runnerModel ();
    $runner->RunnerEmail = $_POST['RunnerEmail'];
    $runner->RunnerPassword = $_POST['RunnerPassword'];

    $run = $runner->loginRunner();
    $value = $run->fetch();

    if($runner->loginRunner()->rowCount() == 1){
        $message = 'Success Login';

                session_start();
                $_SESSION['RunnerID'] = $value[0];
                $_SESSION['RunnerName'] = $value[1];
                $_SESSION['RunnerEmail'] = $value[2];
                $_SESSION['RunnerPassword'] = $value[3];
                $_SESSION['RunnerPhoneNo'] = $value[4];
                $_SESSION['RunnerICNo'] = $value[5];
                $_SESSION['RunnerAddress'] = $value[6];
                $_SESSION['RunnerImage'] = $value[7];
                $_SESSION['RunnerPlateNo'] = $value[8];
                $_SESSION['RunnerRegStatus'] = $value[9];
                $_SESSION['RunnerRegComment'] = $value[10];
                
                echo "<script type='text/javascript'>alert('$message');
                window.location = 'runnerProfile.php';
                </script>";
                exit();
    }else{
        $message = "Login Failed ! Username or password incorrect";

        echo "<script type='text/javascript'>
        alert('$message');
        window.location = 'loginRunner.php';
        </script>";
        exit();
    }

    }

    //function to sent data to database -ADLI
    function regsRun(){
        $runner = new runnerModel();
        $runner->RunnerName = $_POST['RunnerName'];
        $runner->RunnerEmail = $_POST['RunnerEmail'];
        $runner->RunnerPhoneNo = $_POST['RunnerPhoneNo'];
        $runner->RunnerICNo = $_POST['RunnerICNo'];
        $runner->RunnerAddress = $_POST['RunnerAddress'];
        $runner->RunnerImage = time().$_FILES['photoFile']['name'];
        $runner->RunnerPlateNo = $_POST['RunnerPlateNo'];
        $runner->RunnerPassword = $_POST['RunnerPassword'];
        $runner->RunnerRegStatus = 'PENDING';

        //file directory to save image - ADLI
            $runner->target_dir = "../../../uploads/";

            //target file to save in directory - ADLI
            $runner->target_file = $runner->target_dir . basename($_FILES["photoFile"]["name"]);

            // Select file type - ADLI
            $runner->imageFileType = strtolower(pathinfo($runner->target_file,PATHINFO_EXTENSION));

            // Valid file extensions -ADLI
            $runner->extensions_arr = array("jpg","jpeg","png","gif");

        // validate if register succesfull - ADLI
        if($runner->registerRun() > 0){
                 $message = "Register Succesfull!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = 'loginRunner.php';</script>";
            }
    }
}
?>
