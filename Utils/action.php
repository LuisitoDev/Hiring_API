<?php


class Action
{


    private $getCallback;
    private $postCallback;

    public function __construct($getCallback, $postCallback)
    {
        $this->getCallback = $getCallback;
        $this->postCallback = $postCallback;
    }

    public function Invoke($controller, $paths)
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            call_user_func(array($controller, $this->getCallback), $paths);
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
            call_user_func(array($controller, $this->postCallback), $paths);
        }
    }

    public static function ValidateActionsPath($paths, $controller)
    {
        //It's always expecting for a index method to be call in the default scenario when nothing is sent to the controller
        
        $validacionesGenerales = new Validaciones();
        try {
            if (!isset($paths[1])){
                throw new Exception(ErrorMessages::PaginaNotFound);
            }

            if (!isset($controller->actions[$paths[1]])){
                throw new Exception(ErrorMessages::PaginaNotFound);
            }

            $controller->actions[$paths[1]]->Invoke($controller, $paths);

        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            include "Vista/Pages/error.php";
        }
    }
}
