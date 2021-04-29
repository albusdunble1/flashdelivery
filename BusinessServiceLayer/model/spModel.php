<?php
require_once '../../../libs/database.php';

class spModel {
  public $spid,$j,$SpEmail,$SpPassword,$SpName,$SpAddress,$SpPhoneNo,$SpRegID,$SpType, $SpImage, $SpRegStatus;

  // get all service provider details from service_provider table based SpID from product table - ARIF 
  function getSpAddress() {
    $SpID = $this->spid[$this->j];

    $sql = "SELECT * FROM service_provider INNER JOIN product ON product.SpID = service_provider.SpID
    WHERE service_provider.SpID = '{$SpID}'";

    return DB::run($sql);

  }

  // get email and password for service provider to login - ADLI
  function login_SP(){
    if(isset($_POST['SpEmail'])){
    $sql = "select * from service_provider where SpEmail=:SpEmail AND SpPassword=:SpPassword limit 1";
    $args = [':SpEmail'=>$this->SpEmail, ':SpPassword'=>$this->SpPassword];
    // $stmt = DB::run($sql,$args);
    // $count = $stmt->rowCount();
    // return $count;
    return DB::run($sql,$args);
    }
  }

   // save data to database -ADLI
  function registerSP(){
    if(in_array($this->imageFileType, $this->extensions_arr)){
    $sql = "insert into service_provider(SpName, SpEmail,SpAddress, SpPhoneNo,SpRegID,SpType, SpImage,SpPassword, SpRegStatus)
  
    value(:SpName, :SpEmail,:SpAddress, :SpPhoneNo,:SpRegID,:SpType, :SpImage, :SpPassword, :SpRegStatus)";
  
    $args = [':SpName'=>$this->SpName, ':SpEmail'=>$this->SpEmail,':SpAddress'=>$this->SpAddress, ':SpPhoneNo'=>$this->SpPhoneNo, ':SpRegID'=>$this->SpRegID,
    ':SpType'=>$this->SpType,':SpImage'=>$this->SpImage, ':SpPassword'=>$this->SpPassword, ':SpRegStatus'=>$this->SpRegStatus];
  
    //Upload FIle - ADLI
          move_uploaded_file($_FILES['photoFile']['tmp_name'], $this->target_dir.$this->SpImage);
  
      $stmt = DB::run($sql, $args);
          $count = $stmt->rowCount();
          return $count;
      }
  }

}



?>
