<?php

require_once "Controlador/template.controller.php";

require_once  'DAO/Solicitudes_DAO.php';
require_once 'Modelo/Solicitudes_Model.php';

require_once "Utils/action.php";
require_once "Utils/General.php";



class SolicitudesController extends Controller
{

    //CONTROLLER ROUTE
    public const ROUTE = "solicitudes";

    //ACTIONS ROUTING
    public const INDEX = "index";
    public const MOSTRAR_SOLICITUD = "solicitud";
    public const CREAR_SOLICITUD = "crear-solicitud";

    public const EDITAR_SOLICITUD = "editar-solicitud";
    public const DELETE_SOLICITUD = "delete-solicitud";
    public const MOSTRAR_SOLICITUDES_TRABAJO = "cargar-solicitudes-trabajo";

    public const MOSTRAR_SOLICITUDES_NOTIFICACIONES = "cargar-solicitudes-notificaciones";

    public $actions;

    public function __construct()
    {
        // parent::__construct($pathName);

        $this->actions = array(
            self::INDEX => new Action("Index", null),
            self::MOSTRAR_SOLICITUD => new Action(null, "mostrarSolicitud"),
            self::CREAR_SOLICITUD => new Action(null, "crearSolicitud"),
            self::EDITAR_SOLICITUD => new Action(null, "editarSolicitud"),
            self::DELETE_SOLICITUD => new Action(null, "deleteSolicitud"),
            self::MOSTRAR_SOLICITUDES_TRABAJO => new Action(null, "cargarSolicitudesTrabajo"),
            self::MOSTRAR_SOLICITUDES_NOTIFICACIONES => new Action(null, "cargarSolicitudesNotificaciones")
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


    public function mostrarSolicitud($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "UsuarioSolicita no def");
            $TrabajoSolicitado = General::getParameterPOST("TrabajoSolicitado", "TrabajoSolicitado no def");
            
            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                $UsuarioSolicita,
                $TrabajoSolicitado,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $listaSolicitudes = Solicitudes_DAO::getSolicitudes("S", $argumentosSolicitud);

            $solicitudExiste = new Solicitudes_Model();
            if (sizeof($listaSolicitudes) == 1){
                $solicitudExiste = $listaSolicitudes[0];
            }
            

            $jsonInfo = json_encode($solicitudExiste);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }

    public function crearSolicitud($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "UsuarioSolicita no def");
            $TrabajoSolicitado = General::getParameterPOST("TrabajoSolicitado", "TrabajoSolicitado no def");
            // $StatusSolicitud = General::getParameterPOST("StatusSolicitud", "StatusSolicitud no def");
            // $FechaCreacionSolicitud = General::getParameterPOST("FechaCreacionSolicitud", "FechaCreacionSolicitud no def");
            // $FechaRespuestaSolicitud = General::getParameterPOST("FechaRespuestaSolicitud", "FechaRespuestaSolicitud no def");
            // $EstadoSolicitud = General::getParameterPOST("EstadoSolicitud", "EstadoSolicitud no def");

            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                $UsuarioSolicita,
                $TrabajoSolicitado,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $rowsAffectted = Solicitudes_DAO::insertUpdateDeleteSolicitudes("I", $argumentosSolicitud);

            if ($rowsAffectted == false) {
                throw new Exception("Error al ingresar Solicitud");
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


    public function editarSolicitud($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "UsuarioSolicita no def");
            $TrabajoSolicitado = General::getParameterPOST("TrabajoSolicitado", "TrabajoSolicitado no def");
            $StatusSolicitud = General::getParameterPOST("StatusSolicitud", "StatusSolicitud no def");
            // $FechaCreacionSolicitud = General::getParameterPOST("FechaCreacionSolicitud", "FechaCreacionSolicitud no def");
            // $FechaRespuestaSolicitud = General::getParameterPOST("FechaRespuestaSolicitud", "FechaRespuestaSolicitud no def");

            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                $UsuarioSolicita,
                $TrabajoSolicitado,
                $StatusSolicitud,
                null,
                null,
                null,
                null,
                null
            );

            $rowsAffectted = Solicitudes_DAO::insertUpdateDeleteSolicitudes("U", $argumentosSolicitud);

            if ($rowsAffectted == false) {
                throw new Exception("Error al editar Solicitud");
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

    public function deleteSolicitud($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "UsuarioSolicita no def");
            $TrabajoSolicitado = General::getParameterPOST("TrabajoSolicitado", "TrabajoSolicitado no def");
            // $StatusSolicitud = General::getParameterPOST("StatusSolicitud", "StatusSolicitud no def");
            // $FechaCreacionSolicitud = General::getParameterPOST("FechaCreacionSolicitud", "FechaCreacionSolicitud no def");
            // $FechaRespuestaSolicitud = General::getParameterPOST("FechaRespuestaSolicitud", "FechaRespuestaSolicitud no def");
            // $EstadoSolicitud = General::getParameterPOST("EstadoSolicitud", "EstadoSolicitud no def");

            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                $UsuarioSolicita,
                $TrabajoSolicitado,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $rowsAffectted = Solicitudes_DAO::insertUpdateDeleteSolicitudes("EliminarSolicitud", $argumentosSolicitud);

            if ($rowsAffectted == false) {
                throw new Exception("Error al eliminar Solicitud");
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

    public function cargarSolicitudesTrabajo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $TrabajoSolicitado = General::getParameterPOST("TrabajoSolicitado", "TrabajoSolicitado no def");
            $StatusSolicitud = General::getParameterPOST("StatusSolicitud", "StatusSolicitud no def");
                        
            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                null,
                $TrabajoSolicitado,
                $StatusSolicitud,
                null,
                null,
                null,
                null,
                null
            );

            $listaSolicitudes = Solicitudes_DAO::getSolicitudes("SolicitudesMiTrabajo", $argumentosSolicitud);

            $jsonInfo = json_encode($listaSolicitudes);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }



    public function cargarSolicitudesNotificaciones($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "UsuarioSolicita no def");

            $argumentosSolicitud = Solicitudes_Model::createSolicitud(
                $UsuarioSolicita,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $listaSolicitudes = Solicitudes_DAO::getSolicitudes("NotificacionesSolicitudes", $argumentosSolicitud);

            $jsonInfo = json_encode($listaSolicitudes);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }
}
