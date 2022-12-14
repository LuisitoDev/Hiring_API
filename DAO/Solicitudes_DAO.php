<?php


require_once 'Utils/Connection.php';

class Solicitudes_DAO {

    public function __construct(){

    }
    public static function insertUpdateDeleteSolicitudes($p_Opc, $parametrosSolicitudes) {
        $con = null;
        $sentencia = null;

        $rowsAffectted = 0;

        try {
            $con = DBConnection::getConnection();
            
            $sql = 'CALL sp_Solicitudes(:p_Opc, :p_UsuarioSolicita, :p_TrabajoSolicitado,:p_StatusSolicitud, 
                                    :p_FechaCreacionSolicitud, :p_FechaRespuestaSolicitud, :p_EstadoSolicitud);';

            $sentencia = $con->prepare($sql);
           
            $rowsAffectted = $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_UsuarioSolicita"=>$parametrosSolicitudes->getUsuarioSolicita(), 
                ":p_TrabajoSolicitado"=>$parametrosSolicitudes->getTrabajoSolicitado(), 
                ":p_StatusSolicitud"=>$parametrosSolicitudes->getStatusSolicitud(),
                ":p_FechaCreacionSolicitud"=>$parametrosSolicitudes->getFechaCreacionSolicitud(),
                ":p_FechaRespuestaSolicitud"=>$parametrosSolicitudes->getFechaRespuestaSolicitud(),
                ":p_EstadoSolicitud"=>$parametrosSolicitudes->getEstadoSolicitud()
                )
            );
        }   
        catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        } 
        finally {
        	//$statement->close();
            //$con->close();
        }

        return $rowsAffectted;
    }

    public static function getSolicitudes($p_Opc, $parametrosSolicitudes)
    {
        $con = null;
        $sentencia = null;
        
        $listaSolicitudes = [];

        try {     
            $con = DBConnection::getConnection();

            $sql = 'CALL sp_Solicitudes(:p_Opc, :p_UsuarioSolicita, :p_TrabajoSolicitado,:p_StatusSolicitud, 
                                    :p_FechaCreacionSolicitud, :p_FechaRespuestaSolicitud, :p_EstadoSolicitud);';

            $sentencia = $con->prepare($sql);
    
            $rowsAffectted = $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_UsuarioSolicita"=>$parametrosSolicitudes->getUsuarioSolicita(), 
                ":p_TrabajoSolicitado"=>$parametrosSolicitudes->getTrabajoSolicitado(), 
                ":p_StatusSolicitud"=>$parametrosSolicitudes->getStatusSolicitud(),
                ":p_FechaCreacionSolicitud"=>$parametrosSolicitudes->getFechaCreacionSolicitud(),
                ":p_FechaRespuestaSolicitud"=>$parametrosSolicitudes->getFechaRespuestaSolicitud(),
                ":p_EstadoSolicitud"=>$parametrosSolicitudes->getEstadoSolicitud()
                )
            );


            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                
                $UsuarioSolicita = $filas["UsuarioSolicita"];
                $TrabajoSolicitado = $filas["TrabajoSolicitado"];
                $StatusSolicitud = $filas["StatusSolicitud"];
                $FechaCreacionSolicitud = $filas["FechaCreacionSolicitud"];
                $FechaRespuestaSolicitud = $filas["FechaRespuestaSolicitud"];
                $EstadoSolicitud = $filas["EstadoSolicitud"];

                $NombreUsuario = null;
                $ApellidoPaternoUsuario = null;
                $ApellidoMaternoUsuario = null;
                $ProfesionUsuario = null;
                $ImagenPerfilUsuario = null;

                $NombreUsuario = General::isExistingRow($filas, "NombreUsuarioSolicita");
                $ApellidoPaternoUsuario = General::isExistingRow($filas, "ApellidoPaternoUsuarioSolicita");
                $ApellidoMaternoUsuario = General::isExistingRow($filas, "ApellidoMaternoUsuarioSolicita");
                $ImagenPerfilUsuario = General::isExistingRow($filas, "ImagenPerfilUsuarioSolicita");;
                $ProfesionUsuario = General::isExistingRow($filas, "ProfesionUsuarioSolicita");;

                $UsuarioSolicitaModel = new Usuarios_Model();
                $UsuarioSolicitaModel->setNombreUsuario($NombreUsuario);
                $UsuarioSolicitaModel->setApellidoPaternoUsuario($ApellidoPaternoUsuario);
                $UsuarioSolicitaModel->setApellidoMaternoUsuario($ApellidoMaternoUsuario);
                $UsuarioSolicitaModel->setImagenPerfilUsuario($ImagenPerfilUsuario);
                $UsuarioSolicitaModel->setProfesionUsuario($ProfesionUsuario);

                $NombreUsuario = null;
                $ApellidoPaternoUsuario = null;
                $ApellidoMaternoUsuario = null;
                $ProfesionUsuario = null;
                $ImagenPerfilUsuario = null;

                $NombreUsuario = General::isExistingRow($filas, "NombreUsuarioCreador");
                $ApellidoPaternoUsuario = General::isExistingRow($filas, "ApellidoPaternoUsuarioCreador");
                $ApellidoMaternoUsuario = General::isExistingRow($filas, "ApellidoMaternoUsuarioCreador");
                $ImagenPerfilUsuario = General::isExistingRow($filas, "ImagenPerfilUsuarioCreador");;
                $ProfesionUsuario = General::isExistingRow($filas, "ProfesionUsuarioCreador");;



                $UsuarioCreadorModel = new Usuarios_Model();
                $UsuarioCreadorModel->setNombreUsuario($NombreUsuario);
                $UsuarioCreadorModel->setApellidoPaternoUsuario($ApellidoPaternoUsuario);
                $UsuarioCreadorModel->setApellidoMaternoUsuario($ApellidoMaternoUsuario);
                $UsuarioCreadorModel->setImagenPerfilUsuario($ImagenPerfilUsuario);
                $UsuarioCreadorModel->setProfesionUsuario($ProfesionUsuario);

                $listaSolicitudes[] = Solicitudes_Model::createSolicitud($UsuarioSolicita, $TrabajoSolicitado, $StatusSolicitud, $FechaCreacionSolicitud, 
                                                                $FechaRespuestaSolicitud, $EstadoSolicitud, $UsuarioSolicitaModel, $UsuarioCreadorModel);
                
            }
        } catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        } 
        finally {
            $sentencia->closeCursor();
        }


        return $listaSolicitudes;
    }
}
