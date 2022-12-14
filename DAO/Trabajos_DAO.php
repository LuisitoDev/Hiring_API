<?php


require_once 'Utils/Connection.php';
require_once 'Utils/General.php';

class Trabajos_DAO
{

    public function __construct()
    {
    }
    public static function insertUpdateDeleteTrabajos($p_Opc, $parametrosTrabajo)
    {
        $con = null;
        $sentencia = null;

        $rowsAffectted = 0;

        try {
            $con = DBConnection::getConnection();

             $sql = 'CALL sp_trabajos(
                :p_Opc, :p_IdTrabajo, :p_TituloTrabajo, :p_DescripcionTrabajo, :p_PagoTrabajo, 
                :p_StatusTrabajo, :p_FechaCreacionTrabajo, :p_EstadoTrabajo, :p_UsuarioCreador, 
                :p_UsuarioSolicita, :p_NumeroTrabajoPaginacion, :p_PagoTrabajoDesde, :p_PagoTrabajoHasta,
                :p_FechaDesdeCreacionTrabajo, :p_FechaHastaCreacionTrabajo, :p_StatusSolicitud, :p_FiltroBusqueda);';


            $sentencia = $con->prepare($sql);

            $rowsAffectted = $sentencia->execute(
                array(
                    ":p_Opc" => $p_Opc,
                    ":p_IdTrabajo" => $parametrosTrabajo->getIdTrabajo(),
                    ":p_TituloTrabajo" => $parametrosTrabajo->getTituloTrabajo(),
                    ":p_DescripcionTrabajo" => $parametrosTrabajo->getDescripcionTrabajo(),
                    ":p_PagoTrabajo" => $parametrosTrabajo->getPagoTrabajo(),
                    ":p_StatusTrabajo" => $parametrosTrabajo->getStatusTrabajo(),
                    ":p_FechaCreacionTrabajo" => $parametrosTrabajo->getFechaCreacionTrabajo(),
                    ":p_EstadoTrabajo" => $parametrosTrabajo->getEstadoTrabajo(),
                    ":p_UsuarioCreador" => $parametrosTrabajo->getUsuarioCreador(),
                    ":p_UsuarioSolicita" => $parametrosTrabajo->getUsuarioSolicita(),
                    ":p_NumeroTrabajoPaginacion" => $parametrosTrabajo->getNumeroTrabajoPaginacion(),
                    ":p_PagoTrabajoDesde" => $parametrosTrabajo->getPagoTrabajoDesde(),
                    ":p_PagoTrabajoHasta" => $parametrosTrabajo->getPagoTrabajoHasta(),
                    ":p_FechaDesdeCreacionTrabajo" => $parametrosTrabajo->getFechaDesdeCreacionTrabajo(),
                    ":p_FechaHastaCreacionTrabajo" => $parametrosTrabajo->getFechaHastaCreacionTrabajo(),
                    ":p_StatusSolicitud" => $parametrosTrabajo->getStatusSolicitud(),
                    ":p_FiltroBusqueda" => $parametrosTrabajo->getFiltroBusqueda()
                )
            );


        } catch (Exception $e) {
            die('Error: ' . $e->GetMessage());
        } finally {
            //$statement->close();
            //$con->close();
        }

        return $rowsAffectted;
    }


    public static function insertTrabajoGetId($p_Opc, $parametrosTrabajo)
    {
        $con = null;
        $sentencia = null;

        $IdTrabajo = null;

        try {
            $con = DBConnection::getConnection();

             $sql = 'CALL sp_trabajos(
                :p_Opc, :p_IdTrabajo, :p_TituloTrabajo, :p_DescripcionTrabajo, :p_PagoTrabajo, 
                :p_StatusTrabajo, :p_FechaCreacionTrabajo, :p_EstadoTrabajo, :p_UsuarioCreador, 
                :p_UsuarioSolicita, :p_NumeroTrabajoPaginacion, :p_PagoTrabajoDesde, :p_PagoTrabajoHasta,
                :p_FechaDesdeCreacionTrabajo, :p_FechaHastaCreacionTrabajo, :p_StatusSolicitud, :p_FiltroBusqueda);';


            $sentencia = $con->prepare($sql);

            $rowsAffectted = $sentencia->execute(
                array(
                    ":p_Opc" => $p_Opc,
                    ":p_IdTrabajo" => $parametrosTrabajo->getIdTrabajo(),
                    ":p_TituloTrabajo" => $parametrosTrabajo->getTituloTrabajo(),
                    ":p_DescripcionTrabajo" => $parametrosTrabajo->getDescripcionTrabajo(),
                    ":p_PagoTrabajo" => $parametrosTrabajo->getPagoTrabajo(),
                    ":p_StatusTrabajo" => $parametrosTrabajo->getStatusTrabajo(),
                    ":p_FechaCreacionTrabajo" => $parametrosTrabajo->getFechaCreacionTrabajo(),
                    ":p_EstadoTrabajo" => $parametrosTrabajo->getEstadoTrabajo(),
                    ":p_UsuarioCreador" => $parametrosTrabajo->getUsuarioCreador(),
                    ":p_UsuarioSolicita" => $parametrosTrabajo->getUsuarioSolicita(),
                    ":p_NumeroTrabajoPaginacion" => $parametrosTrabajo->getNumeroTrabajoPaginacion(),
                    ":p_PagoTrabajoDesde" => $parametrosTrabajo->getPagoTrabajoDesde(),
                    ":p_PagoTrabajoHasta" => $parametrosTrabajo->getPagoTrabajoHasta(),
                    ":p_FechaDesdeCreacionTrabajo" => $parametrosTrabajo->getFechaDesdeCreacionTrabajo(),
                    ":p_FechaHastaCreacionTrabajo" => $parametrosTrabajo->getFechaHastaCreacionTrabajo(),
                    ":p_StatusSolicitud" => $parametrosTrabajo->getStatusSolicitud(),
                    ":p_FiltroBusqueda" => $parametrosTrabajo->getFiltroBusqueda()
                )
            );

            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {

                $IdTrabajo =  General::isExistingRow($filas, "IdTrabajo");
                
            }

        } catch (Exception $e) {
            die('Error: ' . $e->GetMessage());
        } finally {
            //$statement->close();
            //$con->close();
        }

        return $IdTrabajo;
    }



    public static function getTrabajos($p_Opc, $parametrosTrabajo)
    {
        $con = null;
        $sentencia = null;

        $listaTrabajos = [];

        try {
            $con = DBConnection::getConnection();


            $sql = 'CALL sp_trabajos(
                :p_Opc, :p_IdTrabajo, :p_TituloTrabajo, :p_DescripcionTrabajo, :p_PagoTrabajo, 
                :p_StatusTrabajo, :p_FechaCreacionTrabajo, :p_EstadoTrabajo, :p_UsuarioCreador, 
                :p_UsuarioSolicita, :p_NumeroTrabajoPaginacion, :p_PagoTrabajoDesde, :p_PagoTrabajoHasta,
                :p_FechaDesdeCreacionTrabajo, :p_FechaHastaCreacionTrabajo, :p_StatusSolicitud, :p_FiltroBusqueda);';


            $sentencia = $con->prepare($sql);

            $rowsAffectted = $sentencia->execute(
                array(
                    ":p_Opc" => $p_Opc,
                    ":p_IdTrabajo" => $parametrosTrabajo->getIdTrabajo(),
                    ":p_TituloTrabajo" => $parametrosTrabajo->getTituloTrabajo(),
                    ":p_DescripcionTrabajo" => $parametrosTrabajo->getDescripcionTrabajo(),
                    ":p_PagoTrabajo" => $parametrosTrabajo->getPagoTrabajo(),
                    ":p_StatusTrabajo" => $parametrosTrabajo->getStatusTrabajo(),
                    ":p_FechaCreacionTrabajo" => $parametrosTrabajo->getFechaCreacionTrabajo(),
                    ":p_EstadoTrabajo" => $parametrosTrabajo->getEstadoTrabajo(),
                    ":p_UsuarioCreador" => $parametrosTrabajo->getUsuarioCreador(),
                    ":p_UsuarioSolicita" => $parametrosTrabajo->getUsuarioSolicita(),
                    ":p_NumeroTrabajoPaginacion" => $parametrosTrabajo->getNumeroTrabajoPaginacion(),
                    ":p_PagoTrabajoDesde" => $parametrosTrabajo->getPagoTrabajoDesde(),
                    ":p_PagoTrabajoHasta" => $parametrosTrabajo->getPagoTrabajoHasta(),
                    ":p_FechaDesdeCreacionTrabajo" => $parametrosTrabajo->getFechaDesdeCreacionTrabajo(),
                    ":p_FechaHastaCreacionTrabajo" => $parametrosTrabajo->getFechaHastaCreacionTrabajo(),
                    ":p_StatusSolicitud" => $parametrosTrabajo->getStatusSolicitud(),
                    ":p_FiltroBusqueda" => $parametrosTrabajo->getFiltroBusqueda()
                )
            );


            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {

                $IdTrabajo =  General::isExistingRow($filas, "IdTrabajo");
                $TituloTrabajo =  General::isExistingRow($filas, "TituloTrabajo");
                $DescripcionTrabajo =  General::isExistingRow($filas, "DescripcionTrabajo");
                $PagoTrabajo =  General::isExistingRow($filas, "PagoTrabajo");
                $StatusTrabajo =  General::isExistingRow($filas, "StatusTrabajo");
                $FechaCreacionTrabajo = General::isExistingRow($filas, "FechaCreacionTrabajo");
                $EstadoTrabajo = General::isExistingRow($filas, "EstadoTrabajo");

                $UsuarioCreador = General::isExistingRow($filas, "UsuarioCreador");

                #region otras columnas
                $IdArchivo = null;
                $ArchivoData = null;
                $TrabajoAsignado = null;

                $IdArchivo = General::isExistingRow($filas, "IdArchivo");
                $ArchivoData = General::isExistingRow($filas, "ArchivoData");
                $TrabajoAsignado =  General::isExistingRow($filas, "TrabajoAsignado");

                $archivoTrabajoModel = null;
                $archivoTrabajoModel[] = Archivos_Model::createArchivo(
                    $IdArchivo,
                    $ArchivoData,
                    $TrabajoAsignado
                );

                $IdUsuario = null;                
                $NombreUsuario = null;
                $ApellidoPaternoUsuario = null;
                $ApellidoMaternoUsuario = null;
                $ProfesionUsuario = null;
                $ImagenPerfilUsuario = null;

                $IdUsuario = General::isExistingRow($filas, "IdUsuario");
                $NombreUsuario = General::isExistingRow($filas, "NombreUsuario");
                $ApellidoPaternoUsuario = General::isExistingRow($filas, "ApellidoPaternoUsuario");
                $ApellidoMaternoUsuario = General::isExistingRow($filas, "ApellidoMaternoUsuario");
                $ImagenPerfilUsuario = General::isExistingRow($filas, "ImagenPerfilUsuario");;
                $ProfesionUsuario = General::isExistingRow($filas, "ProfesionUsuario");;

                $UsuarioCreadorModel = new Usuarios_Model();
                $UsuarioCreadorModel->setIdUsuario($IdUsuario);
                $UsuarioCreadorModel->setNombreUsuario($NombreUsuario);
                $UsuarioCreadorModel->setApellidoPaternoUsuario($ApellidoPaternoUsuario);
                $UsuarioCreadorModel->setApellidoMaternoUsuario($ApellidoMaternoUsuario);
                $UsuarioCreadorModel->setImagenPerfilUsuario($ImagenPerfilUsuario);
                $UsuarioCreadorModel->setProfesionUsuario($ProfesionUsuario);

                $UsuarioSolicita = null;      
                $TrabajoSolicitado = null;
                $StatusSolicitud = null;
                $FechaCreacionSolicitud = null;
                $FechaRespuestaSolicitud = null;
                $EstadoSolicitud = null;

                $UsuarioSolicita = General::isExistingRow($filas, "UsuarioSolicita");
                $TrabajoSolicitado = General::isExistingRow($filas, "TrabajoSolicitado");
                $StatusSolicitud = General::isExistingRow($filas, "StatusSolicitud");
                $FechaCreacionSolicitud = General::isExistingRow($filas, "FechaCreacionSolicitud");
                $FechaRespuestaSolicitud = General::isExistingRow($filas, "FechaRespuestaSolicitud");
                $EstadoSolicitud = General::isExistingRow($filas, "EstadoSolicitud");
                
                $SolicitudAplicadaModel = new Solicitudes_Model();
                $SolicitudAplicadaModel->setUsuarioSolicita($UsuarioSolicita);
                $SolicitudAplicadaModel->setTrabajoSolicitado($TrabajoSolicitado);
                $SolicitudAplicadaModel->setStatusSolicitud($StatusSolicitud);
                $SolicitudAplicadaModel->setFechaCreacionSolicitud($FechaCreacionSolicitud);
                $SolicitudAplicadaModel->setFechaRespuestaSolicitud($FechaRespuestaSolicitud);
                $SolicitudAplicadaModel->setEstadoSolicitud($EstadoSolicitud);
                #endregion

               

                $listaTrabajos[] = Trabajos_Model::createTrabajo(
                    $IdTrabajo,
                    $TituloTrabajo,
                    $DescripcionTrabajo,
                    $PagoTrabajo,
                    $StatusTrabajo,
                    $FechaCreacionTrabajo,
                    $EstadoTrabajo,
                    $UsuarioCreador,
                    $archivoTrabajoModel,
                    $UsuarioCreadorModel,
                    $SolicitudAplicadaModel,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                );
            }
        } catch (Exception $e) {
            die('Error: ' . $e->GetMessage());
        } finally {
            $sentencia->closeCursor();
        }


        return $listaTrabajos;
    }
}
