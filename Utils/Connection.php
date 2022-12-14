<?php

class DBConnection{

    protected $conexion_db;

    public static function getConnection(){
        //PDO version
        try{

            $arrOptions = array(
                PDO::ATTR_EMULATE_PREPARES => FALSE, 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            );

            
            $conexion_db = new PDO('mysql:dbname=hiring_db;host=localhost', 'root', '', $arrOptions);

            $conexion_db->exec("SET CHARACTER SET utf8"); 

                
        }
        catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        }

        return $conexion_db;
    }


    public static function close(){
        //PDO version
        $conexion_db = null;
    }


}

?>