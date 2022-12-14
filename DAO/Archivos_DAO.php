<?php


require_once 'Utils/Connection.php';

class Archivos_DAO{

    public function __construct(){

    }
    public static function insertUpdateDeleteArchivos($p_Opc, $parametrosArchivo) {
        $con = null;
        $sentencia = null;

        $rowsAffectted = 0;

        try {
            $con = DBConnection::getConnection();
            
            $sql = 'CALL sp_archivos(:p_Opc, :p_IdArchivo, :p_ArchivoData, :p_TrabajoAsignado);';

            $sentencia = $con->prepare($sql);
    
            $rowsAffectted = $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdArchivo"=>$parametrosArchivo->getIdArchivo(), 
                ":p_ArchivoData"=>$parametrosArchivo->getArchivoData(), 
                ":p_TrabajoAsignado"=>$parametrosArchivo->getTrabajoAsignado()
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

    public static function getArchivos($p_Opc, $parametrosArchivo)
    {
        $con = null;
        $sentencia = null;
        
        $listaArchivo = [];

        try {     
            $con = DBConnection::getConnection();

            $sql = 'CALL sp_archivos(:p_Opc, :p_IdArchivo, :p_ArchivoData, :p_TrabajoAsignado);';
            
            $sentencia = $con->prepare($sql);
    
            $sentencia->execute(
                array(
                ":p_Opc"=>$p_Opc, 
                ":p_IdArchivo"=>$parametrosArchivo->getIdArchivo(), 
                ":p_ArchivoData"=>$parametrosArchivo->getArchivoData(), 
                ":p_TrabajoAsignado"=>$parametrosArchivo->getTrabajoAsignado()
                )
            );


            while ($filas = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                
                $IdArchivo = $filas["IdArchivo"];
                $ArchivoData = $filas["ArchivoData"];
                $TrabajoAsignado = $filas["TrabajoAsignado"];

                $listaArchivo[] = Archivos_Model::createArchivo($IdArchivo, $ArchivoData, $TrabajoAsignado);
                
            }
        } catch(Exception $e){
            die('Error: ' . $e->GetMessage());
        } 
        finally {
            $sentencia->closeCursor();
        }


        return $listaArchivo;
    }
}

?>