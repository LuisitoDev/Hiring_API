<?php

require_once "Controlador/template.controller.php";


require_once  'DAO/Usuarios_DAO.php';

require_once "Modelo/Usuarios_Model.php";

require_once "Utils/action.php";
require_once "Utils/General.php";


class UsuariosController extends Controller
{


    private function conseguirUsuarioPorCorreoPassword($CorreoUsuario, $PasswordUsuario)
    {
        $argumentosUsuario = new Usuarios_Model();
        $argumentosUsuario->setCorreoUsuario($CorreoUsuario);
        $argumentosUsuario->setPasswordUsuario($PasswordUsuario);

        $listaUsuarios = Usuarios_DAO::getUsuarios("UsuarioByCorreoPw", $argumentosUsuario);

        return $listaUsuarios;
    }


    //CONTROLLER ROUTE
    public const ROUTE = "cuenta";

    //ACTIONS ROUTING
    public const MOSTRAR_USUARIO = "perfil";
    public const CREAR_USUARIO = "crear-usuario";
    public const LOGEAR_USUARIO = "login";
    public const BUSCAR_CORREO = "buscar-correo";


    public const EDITAR_USUARIO = "editar-usuario";
    public const ACTUALIZAR_PASSWORD = "actualizar-password";
    public const DELETE_USUARIO = "delete-usuario";
    

    public $actions;

    public function __construct()
    {
        // parent::__construct($pathName);

        $this->actions = array(
            self::CREAR_USUARIO => new Action(null, "crearUsuario"),
            self::LOGEAR_USUARIO => new Action(null, "loginUsuario"),
            self::BUSCAR_CORREO => new Action(null, "buscarCorreo"),
            self::MOSTRAR_USUARIO => new Action("mostrarUsuario", null),
            self::EDITAR_USUARIO => new Action(null, "editarUsuario"),
            self::ACTUALIZAR_PASSWORD => new Action(null, "actualizarPassword"),
            self::DELETE_USUARIO => new Action(null, "deleteUsuario"),
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



    public function crearUsuario($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $NombreUsuario = General::getParameterPOST("NombreUsuario", "NombreUsuario no def");
            $ApellidoPaternoUsuario = General::getParameterPOST("ApellidoPaternoUsuario", "ApellidoPaternoUsuario no def");
            $ApellidoMaternoUsuario = General::getParameterPOST("ApellidoMaternoUsuario", "ApellidoMaternoUsuario no def");
            $FechaNacimientoUsuario = General::getParameterPOST("FechaNacimientoUsuario", "FechaNacimientoUsuario no def");
            $EscolaridadUsuario = General::getParameterPOST("EscolaridadUsuario", "EscolaridadUsuario no def");
            $ProfesionUsuario = General::getParameterPOST("ProfesionUsuario", "ProfesionUsuario no def");
            $DescripcionUsuario = General::getParameterPOST("DescripcionUsuario", "DescripcionUsuario no def");

            $ImagenPerfilUsuario = General::getParameterPOST("ImagenPerfilUsuario", "ImagenPerfilUsuario no def");
            
            $CorreoUsuario = General::getParameterPOST("CorreoUsuario", "CorreoUsuario no def");
            $PasswordUsuario = General::getParameterPOST("PasswordUsuario", "PasswordUsuario no def");
            

            $argumentosUsuario = Usuarios_Model::createUsuario(
                null,
                $NombreUsuario,
                $ApellidoPaternoUsuario,
                $ApellidoMaternoUsuario,
                $FechaNacimientoUsuario,
                $EscolaridadUsuario,
                $ProfesionUsuario,
                $DescripcionUsuario,
                $ImagenPerfilUsuario,
                $CorreoUsuario,
                $PasswordUsuario,
                null,
                null,
                null
            );


            $rowsAffectted = Usuarios_DAO::insertUpdateDeleteUsuarios("I", $argumentosUsuario);

            if ($rowsAffectted == false) {
                throw new Exception("error al crear usuario");
            }

            $listaUsuarios = self::conseguirUsuarioPorCorreoPassword($CorreoUsuario, $PasswordUsuario);

            $usuarioActivo = $listaUsuarios[0];

            $jsonInfo = '{"status": "SUCCESS", "IdUsuario": "' . $usuarioActivo->getIdUsuario() . '"}';

            //$jsonInfo = json_encode($usuarioActivo);

            // $jsonInfo = json_encode($argumentosUsuario);

        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function buscarCorreo($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $CorreoUsuario = General::getParameterPOST("CorreoUsuario", ErrorMessages::CorreoNoDefinido);

            $argumentosUsuario = new Usuarios_Model();
            $argumentosUsuario->setCorreoUsuario($CorreoUsuario);

            $listaUsuarios = Usuarios_DAO::getUsuarios("BuscarCorreo", $argumentosUsuario);

            $usuarioActivo = new Usuarios_Model();
            if (sizeof($listaUsuarios) == 1){
                $usuarioActivo->setIdUsuario($listaUsuarios[0]->getIdUsuario());
            }

            $jsonInfo = json_encode($usuarioActivo);

        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }
        echo $jsonInfo;

        die();
    }

    public function loginUsuario($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $CorreoUsuario = General::getParameterPOST("CorreoUsuario", ErrorMessages::CorreoNoDefinido);
            $PasswordUsuario = General::getParameterPOST("PasswordUsuario", ErrorMessages::PasswordNoDefinido);

            $argumentosUsuario = new Usuarios_Model();
            $argumentosUsuario->setCorreoUsuario($CorreoUsuario);
            $argumentosUsuario->setPasswordUsuario($PasswordUsuario);

            $listaUsuarios = Usuarios_DAO::getUsuarios("Login", $argumentosUsuario);


            if ($listaUsuarios == null) {
                throw new Exception(ErrorMessages::CorreoOPasswordIncorrectos);
            }
            $usuarioActivo = $listaUsuarios[0];

            $jsonInfo = json_encode($usuarioActivo);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }
        echo $jsonInfo;

        die();
    }

    public function mostrarUsuario($paths)
    {
        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {
            #region Validar Paths
            $IdUsuario = General::getParameterGET($paths, 2, ErrorMessages::IdUsuarioNoDefinido);

            if (General::isInteger($IdUsuario) == false) {
                throw new Exception(ErrorMessages::IdUsuarioNoDefinido);
            }

            $argumentosUsuario = new Usuarios_Model();
            $argumentosUsuario->setIdUsuario($IdUsuario);

            $listaUsuarios = Usuarios_DAO::getUsuarios("S", $argumentosUsuario);

            $usuarioActivo = $listaUsuarios[0];

            $jsonInfo = json_encode($usuarioActivo);
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }

        echo $jsonInfo;

        die();
    }

    public function editarUsuario($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $IdUsuario = General::getParameterPOST("IdUsuario", "IdUsuario no def");
            $NombreUsuario = General::getParameterPOST("NombreUsuario", "NombreUsuario no def");
            $ApellidoPaternoUsuario = General::getParameterPOST("ApellidoPaternoUsuario", "ApellidoPaternoUsuario no def");
            $ApellidoMaternoUsuario = General::getParameterPOST("ApellidoMaternoUsuario", "ApellidoMaternoUsuario no def");
            $FechaNacimientoUsuario = General::getParameterPOST("FechaNacimientoUsuario", "FechaNacimientoUsuario no def");
            $EscolaridadUsuario = General::getParameterPOST("EscolaridadUsuario", "EscolaridadUsuario no def");
            $ProfesionUsuario = General::getParameterPOST("ProfesionUsuario", "ProfesionUsuario no def");
            $DescripcionUsuario = General::getParameterPOST("DescripcionUsuario", "DescripcionUsuario no def");
            $ImagenPerfilUsuario = $_POST["ImagenPerfilUsuario"];
            
            // $PasswordUsuario = General::getParameterPOST("IdUsuario","IdUsuario no def");

            $argumentosUsuario = Usuarios_Model::createUsuario(
                $IdUsuario,
                $NombreUsuario,
                $ApellidoPaternoUsuario,
                $ApellidoMaternoUsuario,
                $FechaNacimientoUsuario,
                $EscolaridadUsuario,
                $ProfesionUsuario,
                $DescripcionUsuario,
                $ImagenPerfilUsuario,
                null,
                null,
                null,
                null,
                null
            );



            $rowsAffectted = Usuarios_DAO::insertUpdateDeleteUsuarios("UpdatePerfil", $argumentosUsuario);

            if ($rowsAffectted == false) {
                throw new Exception("error al editar usuario");
            }

            // $listaUsuarios = Usuarios_DAO::getUsuarios("S", $argumentosUsuario);

            // $usuarioActivo = $listaUsuarios[0];


            $jsonInfo = '{"status": "SUCCESS"}';
        } catch (Exception $e) {
            if ($e->getMessage() != "")
                $validacionesGenerales->setMensajeError($e->getMessage());

            $jsonInfo = '{"status": "' . $validacionesGenerales->getMensajeError() . '"}';
        }


        echo $jsonInfo;

        die();
    }


    public function actualizarPassword($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        ob_end_clean();

        $validacionesGenerales = new Validaciones();

        try {

            $IdUsuario = General::getParameterPOST("IdUsuario", "IdUsuario no def");
            $PasswordUsuario = General::getParameterPOST("PasswordUsuario","PasswordUsuario no def");

            $argumentosUsuario = new Usuarios_Model();
            $argumentosUsuario->setIdUsuario($IdUsuario);
            $argumentosUsuario->setPasswordUsuario($PasswordUsuario);

            $rowsAffectted = Usuarios_DAO::insertUpdateDeleteUsuarios("UpdatePassword", $argumentosUsuario);

            if ($rowsAffectted == false) {
                throw new Exception("error al editar usuario");
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

    public function deleteUsuario($paths)
    {
        if (count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
    }
}
