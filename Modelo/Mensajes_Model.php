<?php

class Mensajes_Model implements JsonSerializable {
    private $IdMensaje;
    private $UsuarioEnvia;
    private $UsuarioRecibe;
    private $DescripcionMensaje;
    private $FechaCreacionMensaje;
    private $EstadoMensaje;

    private $UsuarioEnviaModel;
    private $UsuarioRecibeModel;

    private $FiltroBandeja;
    public function __construct(){
        $this->UsuarioEnviaModel = new Usuarios_Model();
        $this->UsuarioRecibeModel = new Usuarios_Model();
    }



    public function jsonSerialize() {

        return array(
            'IdMensaje' => $this->IdMensaje,
            'UsuarioEnvia'=>$this->UsuarioEnvia,
            'UsuarioRecibe'=>$this->UsuarioRecibe,
            'DescripcionMensaje'=>$this->DescripcionMensaje,
            'FechaCreacionMensaje'=>$this->getFechaCreacionConFormatoMensaje(),
            'EstadoMensaje'=>$this->EstadoMensaje,
            'UsuarioEnviaModel'=>$this->UsuarioEnviaModel,
            'UsuarioRecibeModel'=>$this->UsuarioRecibeModel,
            'FiltroBandeja'=>$this->FiltroBandeja
       );
    }

    public static function createMensajes($IdMensaje, $UsuarioEnvia, $UsuarioRecibe, $DescripcionMensaje, $FechaCreacionMensaje, $EstadoMensaje,
                                            $UsuarioEnviaModel = null, $UsuarioRecibeModel = null,
                                             $FiltroBandeja=null){
        $instance = new self();
        $instance->setIdMensaje($IdMensaje);
        $instance->setUsuarioEnvia($UsuarioEnvia);
        $instance->setUsuarioRecibe($UsuarioRecibe);
        $instance->setDescripcionMensaje($DescripcionMensaje);
        $instance->setFechaCreacionMensaje($FechaCreacionMensaje);
        $instance->setEstadoMensaje($EstadoMensaje);
        $instance->setUsuarioEnviaModel($UsuarioEnviaModel);
        $instance->setUsuarioRecibeModel($UsuarioRecibeModel);
        $instance->setFiltroBandeja($FiltroBandeja);

        return $instance;
    }

    public function getIdMensaje()
    {
        return $this->IdMensaje;
    }

    public function setIdMensaje($IdMensaje)
    {
        $this->IdMensaje = $IdMensaje;

        return $this;
    }
    public function getUsuarioEnvia()
    {
        return $this->UsuarioEnvia;
    }

    public function setUsuarioEnvia($UsuarioEnvia)
    {
        $this->UsuarioEnvia = $UsuarioEnvia;

        return $this;
    }

    public function getUsuarioRecibe()
    {
        return $this->UsuarioRecibe;
    }

    public function setUsuarioRecibe($UsuarioRecibe)
    {
        $this->UsuarioRecibe = $UsuarioRecibe;

        return $this;
    }

    public function getDescripcionMensaje()
    {
        return $this->DescripcionMensaje;
    }

    public function setDescripcionMensaje($DescripcionMensaje)
    {
        $this->DescripcionMensaje = $DescripcionMensaje;

        return $this;
    }

    public function getFechaCreacionMensaje()
    {
        return $this->FechaCreacionMensaje;
    }

    public function setFechaCreacionMensaje($FechaCreacionMensaje)
    {
        $this->FechaCreacionMensaje = $FechaCreacionMensaje;

        return $this;
    }

    public function getFechaCreacionConFormatoMensaje()
    {
        setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

        $date = $this->FechaCreacionMensaje;

        $date = strtotime($date);


        $myFormatDate = strftime('%e/%b/%Y', $date);
        
        return strtoupper($myFormatDate);
    }

    public function getEstadoMensaje()
    {
        return $this->EstadoMensaje;
    }

    public function setEstadoMensaje($EstadoMensaje)
    {
        $this->EstadoMensaje = $EstadoMensaje;

        return $this;
    }

    // public function getNombreUsuarioEnvia()
    // {
    //     return $this->NombreUsuarioEnvia;
    // }

    // public function setNombreUsuarioEnvia($NombreUsuarioEnvia)
    // {
    //     $this->NombreUsuarioEnvia = $NombreUsuarioEnvia;

    //     return $this;
    // }

    // public function getImagenUsuarioEnvia()
    // {
    //     return $this->ImagenUsuarioEnvia;
    // }

    // public function setImagenUsuarioEnvia($ImagenUsuarioEnvia)
    // {
    //     $this->ImagenUsuarioEnvia = $ImagenUsuarioEnvia;

    //     return $this;
    // }

    // public function getNombreUsuarioRecibe()
    // {
    //     return $this->NombreUsuarioRecibe;
    // }

    // public function setNombreUsuarioRecibe($NombreUsuarioRecibe)
    // {
    //     $this->NombreUsuarioRecibe = $NombreUsuarioRecibe;

    //     return $this;
    // }

    // public function getImagenUsuarioRecibe()
    // {
    //     return $this->ImagenUsuarioRecibe;
    // }

    // public function setImagenUsuarioRecibe($ImagenUsuarioRecibe)
    // {
    //     $this->ImagenUsuarioRecibe = $ImagenUsuarioRecibe;

    //     return $this;
    // }

    public function getUsuarioEnviaModel()
    {
        return $this->UsuarioEnviaModel;
    }

    public function setUsuarioEnviaModel($UsuarioEnviaModel)
    {
        $this->UsuarioEnviaModel = $UsuarioEnviaModel;

        return $this;
    }

    public function getUsuarioRecibeModel()
    {
        return $this->UsuarioRecibeModel;
    }

    public function setUsuarioRecibeModel($UsuarioRecibeModel)
    {
        $this->UsuarioRecibeModel = $UsuarioRecibeModel;

        return $this;
    }

    
    public function getFiltroBandeja()
    {
        return $this->FiltroBandeja;
    }

    public function setFiltroBandeja($FiltroBandeja)
    {
        $this->FiltroBandeja = $FiltroBandeja;

        return $this;
    }

}
