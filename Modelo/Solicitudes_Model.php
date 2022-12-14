<?php

class Solicitudes_Model implements JsonSerializable
{
    private $UsuarioSolicita;
    private $TrabajoSolicitado;
    private $StatusSolicitud;
    private $FechaCreacionSolicitud;
    private $FechaRespuestaSolicitud;
    private $EstadoSolicitud;
    private $UsuarioSolicitaModel;
    private $UsuarioCreadorModel;


    public function __construct()
    {        
        $this->UsuarioCreadorModel = new Usuarios_Model();
    }

    public static function createSolicitud(
        $UsuarioSolicita,
        $TrabajoSolicitado,
        $StatusSolicitud,
        $FechaCreacionSolicitud,
        $FechaRespuestaSolicitud,
        $EstadoSolicitud,
        $UsuarioSolicitaModel,
        $UsuarioCreadorModel
    ) {
        $instance = new self();
        $instance->setUsuarioSolicita($UsuarioSolicita);
        $instance->setTrabajoSolicitado($TrabajoSolicitado);
        $instance->setStatusSolicitud($StatusSolicitud);
        $instance->setFechaCreacionSolicitud($FechaCreacionSolicitud);
        $instance->setFechaRespuestaSolicitud($FechaRespuestaSolicitud);
        $instance->setEstadoSolicitud($EstadoSolicitud);
        $instance->setUsuarioSolicitaModel($UsuarioSolicitaModel);
        $instance->setUsuarioCreadorModel($UsuarioCreadorModel);
        

        return $instance;
    }

    public function jsonSerialize() {
           
        return array(
            'UsuarioSolicita' => $this->UsuarioSolicita,
            'TrabajoSolicitado' => $this->TrabajoSolicitado,
            'StatusSolicitud' => $this->StatusSolicitud,
            'FechaCreacionSolicitud' => $this->FechaCreacionSolicitud,
            'FechaRespuestaSolicitud' => $this->FechaRespuestaSolicitud,
            'EstadoSolicitud' => $this->EstadoSolicitud,
            'UsuarioSolicitaModel' => $this->UsuarioSolicitaModel,
            'UsuarioCreadorModel' => $this->UsuarioCreadorModel,
            
       );
    }

    public function getUsuarioSolicita()
    {
        return $this->UsuarioSolicita;
    }

    public function setUsuarioSolicita($UsuarioSolicita)
    {
        $this->UsuarioSolicita = $UsuarioSolicita;

        return $this;
    }

    public function getTrabajoSolicitado()
    {
        return $this->TrabajoSolicitado;
    }

    public function setTrabajoSolicitado($TrabajoSolicitado)
    {
        $this->TrabajoSolicitado = $TrabajoSolicitado;

        return $this;
    }

    public function getStatusSolicitud()
    {
        return $this->StatusSolicitud;
    }

    public function setStatusSolicitud($StatusSolicitud)
    {
        $this->StatusSolicitud = $StatusSolicitud;

        return $this;
    }

    public function getFechaCreacionSolicitud()
    {
        return $this->FechaCreacionSolicitud;
    }

    public function setFechaCreacionSolicitud($FechaCreacionSolicitud)
    {
        $this->FechaCreacionSolicitud = $FechaCreacionSolicitud;

        return $this;
    }

    public function getFechaRespuestaSolicitud()
    {
        return $this->FechaRespuestaSolicitud;
    }

    public function setFechaRespuestaSolicitud($FechaRespuestaSolicitud)
    {
        $this->FechaRespuestaSolicitud = $FechaRespuestaSolicitud;

        return $this;
    }

    // public function getFechaCreacionConFormatoSolicitud()
    // {
    //     setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

    //     $date = $this->FechaRespuestaSolicitud;

    //     $date = strtotime($date);


    //     $myFormatDate = strftime('%e/%b/%Y', $date);
        
    //     return strtoupper($myFormatDate);
    // }

    public function getEstadoSolicitud()
    {
        return $this->EstadoSolicitud;
    }

    public function setEstadoSolicitud($EstadoSolicitud)
    {
        $this->EstadoSolicitud = $EstadoSolicitud;

        return $this;
    }


    public function getUsuarioSolicitaModel()
    {
        return $this->UsuarioSolicitaModel;
    }

    public function setUsuarioSolicitaModel($UsuarioSolicitaModel)
    {
        $this->UsuarioSolicitaModel = $UsuarioSolicitaModel;

        return $this;
    }

    public function getUsuarioCreadorModel()
    {
        return $this->UsuarioCreadorModel;
    }

    public function setUsuarioCreadorModel($UsuarioCreadorModel)
    {
        $this->UsuarioCreadorModel = $UsuarioCreadorModel;

        return $this;
    }

}
