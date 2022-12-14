<?php


require_once 'Utils/Connection.php';

class Usuarios_DAO{

    public function __construct(){

    }
    public static function insertUpdateDeleteUsuarios($p_Opc, $parametrosUsuario) {
    	$con = null;
    	$sentencia = null;

        $rowsAffectted = false;

        try {
            $con = DBConnection::getConnection();
            
            $sql = 'CALL sp_usuarios(   :p_Opc, :p_IdUsuario, :p_NombreUsuario, :p_ApellidoPaternoUsuario, :p_ApellidoMaternoUsuario, 
                                        :p_FechaNacimientoUsuario, :p_EscolaridadUsuario, :p_ProfesionUsuario, :p_DescripcionUsuario, :p_ImagenPerfilUsuario, 
                                        :p_CorreoUsuario, :p_PasswordUsuario, :p_FechaCreacionUsuario, :p_EstadoUsuario);';

            $sentencia = $con->prepare($sql);
    
            $rowsAffectted = $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdUsuario"=>$parametrosUsuario->getIdUsuario(), 
                ":p_NombreUsuario"=>$parametrosUsuario->getNombreUsuario(), 
                ":p_ApellidoPaternoUsuario"=>$parametrosUsuario->getApellidoPaternoUsuario(), 
                ":p_ApellidoMaternoUsuario"=>$parametrosUsuario->getApellidoMaternoUsuario(),
                ":p_FechaNacimientoUsuario"=>$parametrosUsuario->getFechaNacimientoUsuario(), 

                ":p_EscolaridadUsuario"=>$parametrosUsuario->getEscolaridadUsuario(),
                ":p_ProfesionUsuario"=>$parametrosUsuario->getProfesionUsuario(),
                ":p_DescripcionUsuario"=>$parametrosUsuario->getDescripcionUsuario(),

                ":p_ImagenPerfilUsuario"=>$parametrosUsuario->getImagenPerfilUsuario(), 
                ":p_CorreoUsuario"=>$parametrosUsuario->getCorreoUsuario(), 
                ":p_PasswordUsuario"=>$parametrosUsuario->getPasswordUsuario(), 
                ":p_FechaCreacionUsuario"=>$parametrosUsuario->getFechaCreacionUsuario(), 
                ":p_EstadoUsuario"=>$parametrosUsuario->getEstadoUsuario()
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
    
    public static function getUsuarios($p_Opc, $parametrosUsuario)
     {
        $con = null;
    	$sentencia = null;
        
        $listaUsuarios = [];

        try {     
            $con = DBConnection::getConnection();
            

            $sql = 'CALL sp_usuarios(   :p_Opc, :p_IdUsuario, :p_NombreUsuario, :p_ApellidoPaternoUsuario, :p_ApellidoMaternoUsuario, 
                                        :p_FechaNacimientoUsuario, :p_EscolaridadUsuario, :p_ProfesionUsuario, :p_DescripcionUsuario, :p_ImagenPerfilUsuario, 
                                        :p_CorreoUsuario, :p_PasswordUsuario, :p_FechaCreacionUsuario, :p_EstadoUsuario);';

            $sentencia = $con->prepare($sql);
    
            $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdUsuario"=>$parametrosUsuario->getIdUsuario(), 
                ":p_NombreUsuario"=>$parametrosUsuario->getNombreUsuario(), 
                ":p_ApellidoPaternoUsuario"=>$parametrosUsuario->getApellidoPaternoUsuario(), 
                ":p_ApellidoMaternoUsuario"=>$parametrosUsuario->getApellidoMaternoUsuario(),
                ":p_FechaNacimientoUsuario"=>$parametrosUsuario->getFechaNacimientoUsuario(), 

                ":p_EscolaridadUsuario"=>$parametrosUsuario->getEscolaridadUsuario(),
                ":p_ProfesionUsuario"=>$parametrosUsuario->getProfesionUsuario(),
                ":p_DescripcionUsuario"=>$parametrosUsuario->getDescripcionUsuario(),

                ":p_ImagenPerfilUsuario"=>$parametrosUsuario->getImagenPerfilUsuario(), 
                ":p_CorreoUsuario"=>$parametrosUsuario->getCorreoUsuario(), 
                ":p_PasswordUsuario"=>$parametrosUsuario->getPasswordUsuario(), 
                ":p_FechaCreacionUsuario"=>$parametrosUsuario->getFechaCreacionUsuario(), 
                ":p_EstadoUsuario"=>$parametrosUsuario->getEstadoUsuario()
                )
            );


            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                
                $IdUsuario = $filas["IdUsuario"];
                $NombreUsuario = $filas["NombreUsuario"];
                $ApellidoPaternoUsuario = $filas["ApellidoPaternoUsuario"];
                $ApellidoMaternoUsuario = $filas["ApellidoMaternoUsuario"];
                $FechaNacimientoUsuario = $filas["FechaNacimientoUsuario"];

                $EscolaridadUsuario = $filas["EscolaridadUsuario"];
                $ProfesionUsuario = $filas["ProfesionUsuario"];
                $DescripcionUsuario = $filas["DescripcionUsuario"];

                $ImagenPerfilUsuario = $filas["ImagenPerfilUsuario"];
                $CorreoUsuario = $filas["CorreoUsuario"];
                $PasswordUsuario = $filas["PasswordUsuario"];
                $FechaCreacionUsuario = $filas["FechaCreacionUsuario"];
                $EstadoUsuario = $filas["EstadoUsuario"];

                $listaUsuarios[] = Usuarios_Model::createUsuario($IdUsuario, $NombreUsuario, $ApellidoPaternoUsuario, $ApellidoMaternoUsuario, 
                                                                $FechaNacimientoUsuario, $EscolaridadUsuario,$ProfesionUsuario,$DescripcionUsuario,
                                                                $ImagenPerfilUsuario, $CorreoUsuario, $PasswordUsuario, $FechaCreacionUsuario, $EstadoUsuario);
                
            }
        } catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        } 
        finally {
        	$sentencia->closeCursor();
        }


        return $listaUsuarios;
    }
}

?>