<?php

require_once "Controlador/template.controller.php";

require_once  'DAO/Trabajos_DAO.php';
// require_once  'DAO/Categorias_DAO.php';
require_once  'DAO/Archivos_DAO.php';
// require_once  'DAO/Niveles_DAO.php';

require_once 'Modelo/Trabajos_Model.php';
// require_once 'Modelo/Categorias_Model.php';
require_once 'Modelo/Archivos_Model.php';
// require_once 'Modelo/Niveles_Model.php';

require_once "Utils/action.php";
require_once "Utils/General.php";
require_once "Utils/Validaciones.php";
require_once "Utils/ErrorMessages.php";

class TrabajosController extends Controller
{

    //CONTROLLER ROUTE
    public const ROUTE = "trabajos";

    //ACTIONS ROUTING
    public const INDEX = "index";
    public const MOSTRAR_TRABAJO = "detalles";
    public const MOSTRAR_MIS_TRABAJOS = "mis-trabajos-creados";
    public const MOSTRAR_MIS_SOLICITUDES_TRABAJOS = "mis-solicitudes-trabajos";
    public const MOSTRAR_TRABAJOS_INICIO = "inicio";

    public const CREAR_TRABAJO = "crear-trabajo";

    public const EDITAR_TRABAJO = "editar-trabajo";
    public const BUSQUEDA_AVANZADA_TRABAJOS = "busqueda-avanzada";
    public const DELETE_Trabajo = "delete-trabajo";
    public const CERRAR_Trabajo = "cerrar-trabajo";
    public const VALIDAR_EXTENSION = "validarextension";

    public $actions;

    public function __construct()
    {
        // parent::__construct($pathName);

        $this->actions = array(
            self::INDEX => new Action("Index", null),
            self::MOSTRAR_TRABAJO => new Action("mostrarTrabajo", null),
            self::MOSTRAR_MIS_TRABAJOS => new Action(null, "mostrarMisTrabajos"),
            self::MOSTRAR_MIS_SOLICITUDES_TRABAJOS => new Action(null, "mostrarMisSolicitudesTrabajos"),
            self::MOSTRAR_TRABAJOS_INICIO => new Action("mostrarTrabajosInicio", null),

            self::CREAR_TRABAJO => new Action(null, "crearTrabajo"),
            self::EDITAR_TRABAJO => new Action(null, "editarTrabajo"),
            self::VALIDAR_EXTENSION => new Action(null, "validarExtension"),
            self::BUSQUEDA_AVANZADA_TRABAJOS => new Action(null, "busquedaAvanzada"),
            self::DELETE_Trabajo => new Action(null, "deleteTrabajo"),
            self::CERRAR_Trabajo => new Action(null, "cerrarTrabajo")

        );
    }


    public function validarExtension($paths)
    {

        // ob_end_clean();
        // $extensiones= explode(",",$_POST["extensiones"]);
        // $filename=$_POST["name"];
        // //$type=$_POST["type"];
        // $resultado=General::validarPorExtensiones($extensiones,$filename);
        // //$filename = $_FILES['video_file']['name'];
        // if($resultado){
        //    echo json_encode(true);
        // }else{
        //     echo json_encode(false);
        // }
        // die();
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


    public function mostrarTrabajo($paths)
    {
        ob_end_clean();

        $validacionesGenerales = new Validaciones();
        try {
            #region Validar Paths

            $IdTrabajo = General::getParameterGET($paths, 2, ErrorMessages::IdTrabajoNoDefinido);

            if (General::isInteger($IdTrabajo) == false) {
                throw new Exception(ErrorMessages::IdTrabajoNoEsNumero);
            }
            #endregion

            #region Obtener Trabajo

            $argumentosTrabajos = new Trabajos_Model();
            $argumentosTrabajos->setIdTrabajo($IdTrabajo);

            $listaTrabajo = Trabajos_DAO::getTrabajos("BuscarTrabajo", $argumentosTrabajos);

            if ($listaTrabajo == null) {
                throw new Exception(ErrorMessages::TrabajoNoExisteONoDisponible);
            }

            $TrabajoElegido = $listaTrabajo[0];

            //$TrabajoElegido->getUsuarioCreadorModel()->setImagenPerfilUsuario(null);

            #endregion

            #region Hacer Validaciones
            // $validacionesGenerales = new Validaciones();
            // $validacionesGenerales->validarTrabajoElegido($TrabajoElegido);

            // if ($validacionesGenerales->getUsuarioPuedeVerPaginaTrabajo() == false) {
            //     throw new Exception();
            // }
            #endregion

            #region Obtener archivos del Trabajo
            $argumentosArchivos = new Archivos_Model();
            $argumentosArchivos->setTrabajoAsignado($TrabajoElegido->getIdTrabajo());
            $listaArchivosDelTrabajo = Archivos_DAO::getArchivos("ArchivosDelTrabajo", $argumentosArchivos);

            $TrabajoElegido->setListaArchivosModel($listaArchivosDelTrabajo);
            #endregion

            $jsonInfo = json_encode($TrabajoElegido);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());


            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }

    public function mostrarMisTrabajos($paths)
    {

        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }


        ob_end_clean();

        $validacionesGenerales = new Validaciones();
        try {

            $UsuarioCreador = General::getParameterPOST("UsuarioCreador", "IdUsuario no def");
            $StatusTrabajo = General::getParameterPOSTNulleable("StatusTrabajo", "IdUsuario no def");
            $NumeroTrabajoPaginacion = General::getParameterPOST("NumeroTrabajoPaginacion", "NumeroTrabajoPaginacion no def");

            if (General::isInteger($UsuarioCreador) == false) {
                throw new Exception(ErrorMessages::IdUsuarioNoDefinido);
            }

            $argumentosTrabajos = new Trabajos_Model();
            $argumentosTrabajos->setUsuarioCreador($UsuarioCreador);
            $argumentosTrabajos->setStatusTrabajo($StatusTrabajo);
            $argumentosTrabajos->setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion);       

            $listaMisTrabajosCreados = Trabajos_DAO::getTrabajos("MisTrabajosCreados", $argumentosTrabajos);        

            // foreach ($listaMisTrabajosCreados as $iTrabajo) {
            //     $argumentosArchivos = new Archivos_Model();
            //     $argumentosArchivos->setTrabajoAsignado($iTrabajo->getIdTrabajo());
            //     $listaArchivosDelTrabajo = Archivos_DAO::getArchivos("ArchivosDelTrabajo", $argumentosArchivos);

            //     $iTrabajo->setListaArchivosModel($listaArchivosDelTrabajo);
            // }


            $jsonInfo = json_encode($listaMisTrabajosCreados);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());


            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function mostrarMisSolicitudesTrabajos($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();
        try {

            $UsuarioSolicita = General::getParameterPOST("UsuarioSolicita", "IdUsuario no def");
            $StatusTrabajo = General::getParameterPOST("StatusTrabajo", "IdUsuario no def");
            $NumeroTrabajoPaginacion = General::getParameterPOST("NumeroTrabajoPaginacion", "NumeroTrabajoPaginacion no def");

            if (General::isInteger($UsuarioSolicita) == false) {
                throw new Exception(ErrorMessages::IdUsuarioNoDefinido);
            }

            $argumentosTrabajos = new Trabajos_Model();
            $argumentosTrabajos->setUsuarioSolicita($UsuarioSolicita);
            $argumentosTrabajos->setStatusTrabajo($StatusTrabajo);
            $argumentosTrabajos->setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion);


            $listaMisTrabajosCreados = Trabajos_DAO::getTrabajos("MisSolicitudesTrabajo", $argumentosTrabajos);

            // foreach ($listaMisTrabajosCreados as $iTrabajo) {
            //     $argumentosArchivos = new Archivos_Model();
            //     $argumentosArchivos->setTrabajoAsignado($iTrabajo->getIdTrabajo());
            //     $listaArchivosDelTrabajo = Archivos_DAO::getArchivos("ArchivosDelTrabajo", $argumentosArchivos);

            //     $iTrabajo->setListaArchivosModel($listaArchivosDelTrabajo);
            // }
            
            $jsonInfo = json_encode($listaMisTrabajosCreados);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());


            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }

    public function mostrarTrabajosInicio($paths)
    {
        ob_end_clean();

        $validacionesGenerales = new Validaciones();
        try {

            $NumeroTrabajoPaginacion = General::getParameterGET($paths, 2, "NumeroTrabajoPaginacion no def");


            $argumentosTrabajos = new Trabajos_Model();
            $argumentosTrabajos->setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion);

            $listaMisTrabajosCreados = Trabajos_DAO::getTrabajos("TrabajosInicio", $argumentosTrabajos);


            // foreach ($listaMisTrabajosCreados as $iTrabajo) {
            //     $argumentosArchivos = new Archivos_Model();
            //     $argumentosArchivos->setTrabajoAsignado($iTrabajo->getIdTrabajo());
            //     $listaArchivosDelTrabajo = Archivos_DAO::getArchivos("ArchivosDelTrabajo", $argumentosArchivos);

            //     $iTrabajo->setListaArchivosModel($listaArchivosDelTrabajo);
            // }


            $jsonInfo = json_encode($listaMisTrabajosCreados);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());


            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }



    public function busquedaAvanzada($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $argumentosTrabajos = new Trabajos_Model();

            $UsuarioCreador = null;
            $TituloTrabajo = null;
            $PagoTrabajoDesde = -1;
            $PagoTrabajoHasta = -1;
            $FechaDesdeCreacionTrabajo = null;
            $FechaHastaCreacionTrabajo = null;

            $NumeroTrabajoPaginacion = null;


            // $UsuarioCreador = General::getParameterPOST("UsuarioCreador", "UsuarioCreador no def");
            if (General::existParam("TituloTrabajo")) {
                $TituloTrabajo = htmlspecialchars(addslashes($_POST["TituloTrabajo"]), ENT_QUOTES);
            }

            if (General::existParam("PagoTrabajoDesde")) {
                $PagoTrabajoDesde = htmlspecialchars(addslashes($_POST["PagoTrabajoDesde"]), ENT_QUOTES);
            }

            if (General::existParam("PagoTrabajoHasta")) {
                $PagoTrabajoHasta = htmlspecialchars(addslashes($_POST["PagoTrabajoHasta"]), ENT_QUOTES);
            }

            if (General::existParam("FechaDesdeCreacionTrabajo")) {
                $FechaDesdeCreacionTrabajo = htmlspecialchars(addslashes($_POST["FechaDesdeCreacionTrabajo"]), ENT_QUOTES);
            }

            if (General::existParam("FechaHastaCreacionTrabajo")) {
                $FechaHastaCreacionTrabajo = htmlspecialchars(addslashes($_POST["FechaHastaCreacionTrabajo"]), ENT_QUOTES);
            }


            $NumeroTrabajoPaginacion = General::getParameterPOST("NumeroTrabajoPaginacion", "NumeroTrabajoPaginacion no def");
            $FiltroBusqueda = General::getParameterPOST("FiltroBusqueda", "FiltroBusqueda no def");


            // $argumentosTrabajos->setCategoriaFiltro($IdCategoria);
            $argumentosTrabajos->setUsuarioCreador($UsuarioCreador);
            $argumentosTrabajos->setTituloTrabajo($TituloTrabajo);

            $argumentosTrabajos->setPagoTrabajoDesde(floatval($PagoTrabajoDesde));
            $argumentosTrabajos->setPagoTrabajoHasta(floatval($PagoTrabajoHasta));

            $argumentosTrabajos->setFechaDesdeCreacionTrabajo($FechaDesdeCreacionTrabajo);
            $argumentosTrabajos->setFechaHastaCreacionTrabajo($FechaHastaCreacionTrabajo);

            $argumentosTrabajos->setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion);

            $argumentosTrabajos->setFiltroBusqueda($FiltroBusqueda);
                        

            $listaTrabajosBusquedaAvanzada = Trabajos_DAO::getTrabajos("BusquedaAvanzada", $argumentosTrabajos);

            // foreach ($listaTrabajosBusquedaAvanzada as $iTrabajo) {
            //     $argumentosArchivos = new Archivos_Model();
            //     $argumentosArchivos->setTrabajoAsignado($iTrabajo->getIdTrabajo());
            //     $listaArchivosDelTrabajo = Archivos_DAO::getArchivos("ArchivosDelTrabajo", $argumentosArchivos);

            //     $iTrabajo->setListaArchivosModel($listaArchivosDelTrabajo);
            // }

            $jsonInfo = json_encode($listaTrabajosBusquedaAvanzada);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }



    public function crearTrabajo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            $TituloTrabajo = General::getParameterPOST("TituloTrabajo", "TituloTrabajo no def");
            $DescripcionTrabajo = General::getParameterPOST("DescripcionTrabajo", "DescripcionTrabajo no def");
            $PagoTrabajo = General::getParameterPOST("PagoTrabajo", "IdUsuario no def");
            $StatusTrabajo = General::getParameterPOST("StatusTrabajo", "StatusTrabajo no def");
            $UsuarioCreador = General::getParameterPOST("UsuarioCreador", "UsuarioCreador no def");

            $argumentosTrabajo = Trabajos_Model::createTrabajo(
                null,
                $TituloTrabajo,
                $DescripcionTrabajo,
                $PagoTrabajo,
                $StatusTrabajo,
                null,
                null,
                $UsuarioCreador
            );

            $IdTrabajo = Trabajos_DAO::insertTrabajoGetId("I", $argumentosTrabajo);

            if ($IdTrabajo == null) {
                throw new Exception("Error al ingresar trabajo");
            }

            $archivosTrabajo = $_POST["ListaArchivosModel"];

            foreach ($archivosTrabajo as $iArchivo) {

                $ArchivoData = $iArchivo["ArchivoData"];

                $argumentosArchivo = Archivos_Model::createArchivo(null, $ArchivoData, $IdTrabajo);

                $rowsAffectted = Archivos_DAO::insertUpdateDeleteArchivos("I", $argumentosArchivo);

                if ($rowsAffectted == false) {
                    throw new Exception("Error al ingresar archivo trabajo");
                }
            }

            $jsonInfo = '{"status": "SUCCESS", "IdTrabajo": "' . $IdTrabajo . '"}';
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }



    public function editarTrabajo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $IdTrabajo = General::getParameterPOST("IdTrabajo", "IdTrabajo no def");
            $TituloTrabajo = General::getParameterPOST("TituloTrabajo", "TituloTrabajo no def");
            $DescripcionTrabajo = General::getParameterPOST("DescripcionTrabajo", "DescripcionTrabajo no def");
            $PagoTrabajo = General::getParameterPOST("PagoTrabajo", "IdUsuario no def");
            $StatusTrabajo = General::getParameterPOST("StatusTrabajo", "StatusTrabajo no def");
            $UsuarioCreador = General::getParameterPOST("UsuarioCreador", "UsuarioCreador no def");

            $argumentosTrabajo = Trabajos_Model::createTrabajo(
                $IdTrabajo,
                $TituloTrabajo,
                $DescripcionTrabajo,
                $PagoTrabajo,
                $StatusTrabajo,
                null,
                null,
                $UsuarioCreador
            );


            $rowsAffectted = Trabajos_DAO::insertUpdateDeleteTrabajos("U", $argumentosTrabajo);

            if ($rowsAffectted == false) {
                throw new Exception("Error al actualizar trabajo");
            }


            $archivosTrabajo = $_POST["ListaArchivosModel"];

            foreach ($archivosTrabajo as $iArchivo) {

                $ArchivoData = $iArchivo["ArchivoData"];

                $argumentosArchivo = Archivos_Model::createArchivo(null, $ArchivoData, $IdTrabajo);

                $rowsAffectted = Archivos_DAO::insertUpdateDeleteArchivos("I", $argumentosArchivo);

                if ($rowsAffectted == false) {
                    throw new Exception("Error al editar archivo trabajo");
                }
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



    public function deleteTrabajo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        //TODO: HAY QUE VALIDAR QUE NOSOTROS SOMOS DUEÑOS DEL TRABAJO AQUÍ?
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            ob_end_clean();
            $IdTrabajo = General::getParameterPOST("IdTrabajo", "IdTrabajo no def");
            $argumentosTrabajo = Trabajos_Model::createTrabajo(
                $IdTrabajo,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $rowsAffectted = Trabajos_DAO::insertUpdateDeleteTrabajos("EliminarTrabajo", $argumentosTrabajo);


            if ($rowsAffectted == false) {
                throw new Exception("Error al actualizar trabajo");
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

    public function cerrarTrabajo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            ob_end_clean();
            $IdTrabajo = General::getParameterPOST("IdTrabajo", "IdTrabajo no def");
            $argumentosTrabajo = Trabajos_Model::createTrabajo(
                $IdTrabajo,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            );

            $rowsAffectted = Trabajos_DAO::insertUpdateDeleteTrabajos("CerrarTrabajo", $argumentosTrabajo);


            if ($rowsAffectted == false) {
                throw new Exception("Error al actualizar trabajo");
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
    

    function reArrayFiles(&$file_post)
    {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }


    public function Ajax($paths)
    {
        ob_end_clean();


        die();
    }
}
