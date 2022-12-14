<?php

require_once "Controlador/template.controller.php";

require_once  'DAO/Mensajes_DAO.php';
require_once 'Modelo/Mensajes_Model.php';

require_once "Utils/action.php";

class MensajesController extends Controller
{

    //CONTROLLER ROUTE
    public const ROUTE = "mensajes";

    //ACTIONS ROUTING
    public const INDEX = "index";
    public const MOSTRAR_CONVERSACIONES = "mis-conversaciones";
    public const MOSTRAR_MENSAJES_CONVERSACION = "mis-mensajes-conversacion";
    public const CREAR_MENSAJE = "crear-mensaje";

    public const EDITAR_MENSAJE = "editar-mensaje";
    public const DELETE_MENSAJE = "delete-mensaje";
    public const FILTRO_MEMSAJES = "filtro-conversaciones";
    public $actions;

    public function __construct()
    {
        // parent::__construct($pathName);

        $this->actions = array(
            self::INDEX => new Action("Index", null),
            self::MOSTRAR_CONVERSACIONES => new Action(null, "mostrarConversaciones"),
            self::MOSTRAR_MENSAJES_CONVERSACION => new Action(null, "mostrarMensajesConversacion"),
            self::FILTRO_MEMSAJES => new Action(null, "filtroConversaciones"),
            self::CREAR_MENSAJE => new Action(null, "crearMensajes"),
            self::EDITAR_MENSAJE => new Action(null, "editarMensajes"),
            self::DELETE_MENSAJE => new Action(null, "deleteMensajes"),
            "ajax" => new Action(null, "Ajax")
        );
    }

    public function ShowContent($paths)
    {
        //Determine wich method call TO A SPECIFIC ACTION SENDED IT IN THE URL
        Action::ValidateActionsPath($paths, $this);
    }

    public function Index($paths)
    {
        include "Vista/Pages/error.php";
    }


    public function mostrarConversaciones($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioEnvia = General::getParameterPOST("UsuarioEnvia", "UsuarioEnvia no def");

            $argumentosBandejaMensajes = new Mensajes_Model();
            $argumentosBandejaMensajes->setUsuarioEnvia($UsuarioEnvia);
            $listaBandejaMensajes = Mensajes_DAO::getMensajes("BandejaMensajes", $argumentosBandejaMensajes);

            $jsonInfo = json_encode($listaBandejaMensajes);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function filtroConversaciones($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioEnvia = General::getParameterPOST("UsuarioEnvia", "UsuarioEnvia no def");
            $FiltroBandeja = General::getParameterPOST("FiltroBandeja", "UsuarioEnvia no def");

            $argumentosBandejaMensajes = new Mensajes_Model();
            $argumentosBandejaMensajes->setUsuarioEnvia($UsuarioEnvia);
            $argumentosBandejaMensajes->setFiltroBandeja($FiltroBandeja);

            $listaBandejaMensajes = Mensajes_DAO::getMensajes("FiltroBandeja", $argumentosBandejaMensajes);

            // $usuarioRemitente = null;
            // $usuarioActivo = UsuariosController::getUsuarioActivo();
            // $json = json_encode(array('bandeja' => $listaBandejaMensajes, "idUsuario" => $IdUsuarioActivo));

            $jsonInfo = json_encode($listaBandejaMensajes);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }

        echo $jsonInfo;

        die();
    }


    public function mostrarMensajesConversacion($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioEnvia = General::getParameterPOST("UsuarioEnvia", "UsuarioEnvia no def");
            $UsuarioRecibe = General::getParameterPOST("UsuarioRecibe", "UsuarioRecibe no def");

            $argumentosMensajesConversacion = new Mensajes_Model();
            $argumentosMensajesConversacion->setUsuarioEnvia($UsuarioEnvia);
            $argumentosMensajesConversacion->setUsuarioRecibe($UsuarioRecibe);
            $listaMensajesConversacion = Mensajes_DAO::getMensajes("MensajesConversacion", $argumentosMensajesConversacion);

            $jsonInfo = json_encode($listaMensajesConversacion);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function crearMensajes($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioEnvia = General::getParameterPOST("UsuarioEnvia", "UsuarioEnvia no def");
            $UsuarioRecibe = General::getParameterPOST("UsuarioRecibe", "UsuarioRecibe no def");
            $DescripcionMensaje = General::getParameterPOST("DescripcionMensaje", "DescripcionMensaje no def");

            $argumentosMensaje = Mensajes_Model::createMensajes(null, $UsuarioEnvia, $UsuarioRecibe, $DescripcionMensaje, null, null);

            $rowsAffectted = Mensajes_DAO::insertUpdateDeleteMensajes("I", $argumentosMensaje);

            if ($rowsAffectted == false) {
                throw new Exception("Error al enviar mensaje");
            }

            $jsonInfo = '{"status": "SUCCESS"}';
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function editarMensajes($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
    }

    public function deleteMensajes($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
    }

    public function Ajax($paths)
    {
        ob_end_clean();


        // $name = $_POST["name"];
        // $age = $_POST["age"];

        $respuesta = array("prueba" => "hola");
        echo json_encode($_POST);
        die();
    }
}
