<?php
require_once '../../../libs/database.php';

class adminModel{

    public $AdminEmail,$AdminPassword;

    // get email and password for admin to login - ADLI
    function loginadmin(){
        if(isset($_POST['AdminEmail'])){
            $sql = "select * from admin where AdminEmail=:AdminEmail AND AdminPassword=:AdminPassword limit 1";
            $args = [':AdminEmail'=>$this->AdminEmail, ':AdminPassword'=>$this->AdminPassword];
            // $stmt = DB::run($sql,$args);
            // $count = $stmt->rowCount();
            // return $count;
            return DB::run($sql,$args);
            
            }
    }

}

?>