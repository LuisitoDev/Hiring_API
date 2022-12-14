<?php

abstract class Controller {
    //protected $pathName;
    protected $template;

    public function __construct(){
        //$this->pathName = strtolower($pathName);
    }

    public function GetPathName(){
        return $this->pathName;
    }

    public static function ValidateControllersPath($controllers){
        $validacionesGenerales = new Validaciones();
        try {
            if(isset($_GET["page"])){
                $arrayPaths = explode("/", strtolower($_GET["page"]));
                foreach ($arrayPaths as $param) {
                    $key_value=explode("--", strtolower($param));
                    if (count($key_value) == 2){
                        // array_push($pila, "manzana", "arándano");
                        $paths[$key_value[0]] = $key_value[1];
                    }
                    else{
                        $paths[] = $param;
                    }
                }
                // $paths = explode("/", strtolower($_GET["page"]));
                if(isset($paths[0])){
                    if(isset($controllers[$paths[0]])){
                        $controllers[$paths[0]]->ShowContent($paths);
                    }
                    else{
                        throw new Exception(ErrorMessages::PaginaNotFound);
                    }
    
                }
            } 
        }
        catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());
    
            include "Vista/Pages/error.php";
        }

       


    }

    abstract public function ShowContent($paths);

    abstract public function Index($paths);
  

}