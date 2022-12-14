<?php
require_once "Controlador/controller.php";
require_once "Controlador/usuariosController.php";
require_once "Controlador/trabajosController.php";
require_once "Controlador/mensajesController.php";
require_once "Controlador/solicitudesController.php";





class Template {
    private $controllers;
    //It must come from the DB
    public const ROOT_PATH = "/Hiring/";

    public function __construct(){
        $this->InitializeControllers();
    }
    
    public function InitializeControllers(){
        //AQUI IRAN TODOS LOS CONTROLADORES
        $this->controllers = array(
                                    UsuariosController::ROUTE=> new UsuariosController(),
                                    TrabajosController::ROUTE=> new TrabajosController(),
                                    MensajesController::ROUTE=> new MensajesController(),
                                    SolicitudesController::ROUTE=> new SolicitudesController()
                                );

    }

    public function ShowTemplate(){
        include "Vista/main-template.php";
    }

    //Determinar que controlador se va a usar para cada pagina 
    public function DeterminePage(){
        Controller::ValidateControllersPath($this->controllers);
    }

    public function CallScripts(){
        if(function_exists("Scripts")){
            call_user_func("Scripts");
        }
    }
    
   

    public static function Route($controller, $action){
        $route = self::ROOT_PATH;
        if($action != null)
            $route = self::ROOT_PATH.$controller."/".$action;
        else
            $route = self::ROOT_PATH.$controller;
        return $route;
    }

    
   
}


