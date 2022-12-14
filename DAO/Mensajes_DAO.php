<?php


require_once 'Utils/Connection.php';

class Mensajes_DAO{

    public function __construct(){

    }
    public static function insertUpdateDeleteMensajes($p_Opc, $parametrosMensajes) {
    	$con = null;
    	$sentencia = null;

        $rowsAffectted = 0;

        try {
            $con = DBConnection::getConnection();

            $sql = 'CALL sp_mensajes(:p_Opc, :p_IdMensaje, :p_UsuarioEnvia, :p_UsuarioRecibe, :p_DescripcionMensaje, 
            :p_FechaCreacionMensaje, :p_EstadoMensaje,:p_FiltroBandeja);';

            $sentencia = $con->prepare($sql);
    
            $rowsAffectted = $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdMensaje"=>$parametrosMensajes->getIdMensaje(), 
                ":p_UsuarioEnvia"=>$parametrosMensajes->getUsuarioEnvia(), 
                ":p_UsuarioRecibe"=>$parametrosMensajes->getUsuarioRecibe(),
                ":p_DescripcionMensaje"=>$parametrosMensajes->getDescripcionMensaje(),
                ":p_FechaCreacionMensaje"=>$parametrosMensajes->getFechaCreacionMensaje(),
                ":p_EstadoMensaje"=>$parametrosMensajes->getEstadoMensaje(),
                ":p_FiltroBandeja"=>$parametrosMensajes->getFiltroBandeja()
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

    public static function getMensajes($p_Opc, $parametrosMensajes)
    {
        $con = null;
    	$sentencia = null;
        
        $listaMensajes = [];

        try {     
            $con = DBConnection::getConnection();

            $sql = 'CALL sp_mensajes(:p_Opc, :p_IdMensaje, :p_UsuarioEnvia, :p_UsuarioRecibe, :p_DescripcionMensaje, 
                                    :p_FechaCreacionMensaje, :p_EstadoMensaje,:p_FiltroBandeja);';

            $sentencia = $con->prepare($sql);
    
            $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdMensaje"=>$parametrosMensajes->getIdMensaje(), 
                ":p_UsuarioEnvia"=>$parametrosMensajes->getUsuarioEnvia(), 
                ":p_UsuarioRecibe"=>$parametrosMensajes->getUsuarioRecibe(),
                ":p_DescripcionMensaje"=>$parametrosMensajes->getDescripcionMensaje(),
                ":p_FechaCreacionMensaje"=>$parametrosMensajes->getFechaCreacionMensaje(),
                ":p_EstadoMensaje"=>$parametrosMensajes->getEstadoMensaje(),
                ":p_FiltroBandeja"=>$parametrosMensajes->getFiltroBandeja()
                )
            );


            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                
                $IdUsuario = $filas["IdMensaje"];
                $UsuarioEnvia = $filas["UsuarioEnvia"];
                $UsuarioRecibe = $filas["UsuarioRecibe"];
                $DescripcionMensaje = $filas["DescripcionMensaje"];
                $FechaCreacionMensaje = $filas["FechaCreacionMensaje"];
                $EstadoMensaje = $filas["EstadoMensaje"];

                $NombreUsuarioEnvia = null;
                $ApellidoPaternoUsuarioEnvia = null;
                $ApellidoMaternoUsuarioEnvia = null;
                $ImagenUsuarioEnvia = null;

                $NombreUsuarioEnvia = General::isExistingRow($filas, "NombreUsuarioEnvia");
                $ApellidoPaternoUsuarioEnvia = General::isExistingRow($filas, "ApellidoPaternoUsuarioEnvia");
                $ApellidoMaternoUsuarioEnvia = General::isExistingRow($filas, "ApellidoMaternoUsuarioEnvia");
                $ImagenUsuarioEnvia = General::isExistingRow($filas, "ImagenUsuarioEnvia");
                
                $UsuarioEnviaModel = new Usuarios_Model();
                $UsuarioEnviaModel->setNombreUsuario($NombreUsuarioEnvia);
                $UsuarioEnviaModel->setApellidoPaternoUsuario($ApellidoPaternoUsuarioEnvia);
                $UsuarioEnviaModel->setApellidoMaternoUsuario($ApellidoMaternoUsuarioEnvia);
                $UsuarioEnviaModel->setImagenPerfilUsuario($ImagenUsuarioEnvia);

                $NombreUsuarioRecibe = null;
                $ApellidoPaternoUsuarioRecibe = null;
                $ApellidoMaternoUsuarioRecibe = null;
                $ImagenUsuarioRecibe = null;

                $NombreUsuarioRecibe = General::isExistingRow($filas, "NombreUsuarioRecibe");
                $ApellidoPaternoUsuarioRecibe = General::isExistingRow($filas, "ApellidoPaternoUsuarioRecibe");
                $ApellidoMaternoUsuarioRecibe = General::isExistingRow($filas, "ApellidoMaternoUsuarioRecibe");
                $ImagenUsuarioRecibe = General::isExistingRow($filas, "ImagenUsuarioRecibe");
                
                $UsuarioRecibeModel = new Usuarios_Model();
                $UsuarioRecibeModel->setNombreUsuario($NombreUsuarioRecibe);
                $UsuarioRecibeModel->setApellidoPaternoUsuario($ApellidoPaternoUsuarioRecibe);
                $UsuarioRecibeModel->setApellidoMaternoUsuario($ApellidoMaternoUsuarioRecibe);
                $UsuarioRecibeModel->setImagenPerfilUsuario($ImagenUsuarioRecibe);


                $listaMensajes[] = Mensajes_Model::createMensajes($IdUsuario, $UsuarioEnvia, $UsuarioRecibe, $DescripcionMensaje, $FechaCreacionMensaje, $EstadoMensaje,
                                                                $UsuarioEnviaModel,$UsuarioRecibeModel, null);
                
            }
        } catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        } 
        finally {
        	$sentencia->closeCursor();
        }


        return $listaMensajes;
    }
}

?>