<?php
require_once '../../../libs/database.php';

class runnerModel{
    public $RunnerEmail,$RunnerPassword,$RunnerName,$RunnerPhoneNo,$RunnerICNo,
    $RunnerAddress,$RunnerImage,$RunnerPlateNo,$RunnerRegStatus;

    // get email and password for runner to login - ADLI
    function loginRunner(){
        if(isset($_POST['RunnerEmail'])){
        $sql = "select * from runner where RunnerEmail=:RunnerEmail AND RunnerPassword=:RunnerPassword limit 1";
        $args = [':RunnerEmail'=>$this->RunnerEmail, ':RunnerPassword'=>$this->RunnerPassword];
        // $stmt = DB::run($sql,$args);
        // $count = $stmt->rowCount();
        return DB::run($sql,$args);

        }
    }

     // save data to database -ADLI
    function registerRun(){
        if(in_array($this->imageFileType, $this->extensions_arr)){
        $sql = "insert into runner(RunnerName, RunnerEmail,RunnerPhoneNo,RunnerICNo,RunnerAddress,
        RunnerImage,RunnerPlateNo, RunnerPassword, RunnerRegStatus)

        value(:RunnerName, :RunnerEmail, :RunnerPhoneNo,:RunnerICNo, :RunnerAddress, :RunnerImage,
        :RunnerPlateNo, :RunnerPassword, :RunnerRegStatus)";

        $args = [':RunnerName'=>$this->RunnerName, ':RunnerEmail'=>$this->RunnerEmail, ':RunnerPhoneNo'=>$this->RunnerPhoneNo,
        ':RunnerICNo'=>$this->RunnerICNo,':RunnerAddress'=>$this->RunnerAddress, ':RunnerImage'=>$this->RunnerImage,':RunnerPlateNo'=>$this->RunnerPlateNo,
        ':RunnerPassword'=>$this->RunnerPassword, ':RunnerRegStatus'=>$this->RunnerRegStatus];

        //Upload FIle - ADLI
            move_uploaded_file($_FILES['photoFile']['tmp_name'], $this->target_dir.$this->RunnerImage);

            $stmt = DB::run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
    }




}


?>
