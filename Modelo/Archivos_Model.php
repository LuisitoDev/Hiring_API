<?php

class Archivos_Model implements JsonSerializable{
    private $IdArchivo;
    private $ArchivoData;
    private $TrabajoAsignado;

    public function __construct(){
        
    }

    public static function createArchivo($IdArchivo, $ArchivoData, $TrabajoAsignado){
        $instance = new self();
        $instance->setIdArchivo($IdArchivo);
        $instance->setArchivoData($ArchivoData);
        $instance->setTrabajoAsignado($TrabajoAsignado);

        return $instance;
    }

    public function jsonSerialize() {

        return array(
            'IdArchivo' => $this->IdArchivo,
            'ArchivoData' => $this->ArchivoData,
            'TrabajoAsignado' => $this->TrabajoAsignado
       );
    }

    public function getIdArchivo()
    {
        return $this->IdArchivo;
    }

    public function setIdArchivo($IdArchivo)
    {
        $this->IdArchivo = $IdArchivo;

        return $this;
    }

    
    public function getArchivoData()
    {
        return $this->ArchivoData;
    }

    public function setArchivoData($ArchivoData)
    {
        $this->ArchivoData = $ArchivoData;

        return $this;
    }

    public function getTrabajoAsignado()
    {
        return $this->TrabajoAsignado;
    }

    public function setTrabajoAsignado($TrabajoAsignado)
    {
        $this->TrabajoAsignado = $TrabajoAsignado;

        return $this;
    }

}

?>