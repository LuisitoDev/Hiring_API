<?php

abstract class Rol
{
    const Escuela = 1;
    const Estudiante = 2;
}

class General
{

    public function __construct()
    {
    }

    static public function getParameterPOST($name_param, $error_msg, $paramRequired = true)
    {
        if (!isset($_POST[$name_param])) {
            throw new Exception($error_msg);
        }

        if($_POST[$name_param] === "" && $paramRequired == true){
            throw new Exception($error_msg);
        }
        
        $parameter = htmlspecialchars(addslashes($_POST[$name_param]), ENT_QUOTES);
        return $parameter;
    }

    static public function getParameterPOSTNulleable($name_param)
    {        
        $parameter = null;
        if (isset($_POST[$name_param])) {
            $parameter = htmlspecialchars(addslashes($_POST[$name_param]), ENT_QUOTES);
        }
        
        return $parameter;
    }

    static public function existParam($name_param)
    {
        
        if (isset($_POST[$name_param])) {
            return true;
        }
        else{
            return false;
        }
    }

    static public function getParameterGET($params, $index_param, $error_msg)
    {
        if (!isset($params[$index_param])) {
            throw new Exception($error_msg);
        }
        
        $parameter = htmlspecialchars(addslashes($params[$index_param]), ENT_QUOTES);
        return $parameter;
    }

    static public function isExistingRow($row, $rowName)
    {
        $Field = null;
        if (isset($row[$rowName]))
            $Field = $row[$rowName];
        return $Field;
    }


    static public function isInteger($number){
        return !is_int($number) ? (ctype_digit($number)) : true;
    }

    static public function isPositiveNumber($number){
        if (is_numeric($number)){
            if ($number >= 0){
                return true;
            }
        }
        return false;
    }
}
