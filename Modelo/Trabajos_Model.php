<?php
class Trabajos_Model implements JsonSerializable{
    private $IdTrabajo;
    private $TituloTrabajo;
    private $DescripcionTrabajo;
    private $PagoTrabajo;
    private $StatusTrabajo;
    private $FechaCreacionTrabajo;
    private $EstadoTrabajo;
    private $UsuarioCreador;

    private $ListaArchivosModel;
    private $UsuarioCreadorModel;
    private $SolicitudAplicadaModel;

    private $UsuarioSolicita;
    

    private $NumeroTrabajoPaginacion;
    private $PagoTrabajoDesde;
    private $PagoTrabajoHasta;
    private $FechaDesdeCreacionTrabajo;
    private $FechaHastaCreacionTrabajo;
    private $StatusSolicitud;

    private $FiltroBusqueda;


    public function __construct(){
        $this->ListaArchivosModel = [];
        $this->UsuarioCreadorModel = new Usuarios_Model();
        $this->SolicitudAplicadaModel = new Solicitudes_Model();
    }

    public static function createTrabajo($IdTrabajo, $TituloTrabajo, $DescripcionTrabajo,$PagoTrabajo, $StatusTrabajo, $FechaCreacionTrabajo, $EstadoTrabajo, $UsuarioCreador,
    $ListaArchivosModel = null,
    $UsuarioCreadorModel = null,
    $SolicitudAplicadaModel = null,
    $UsuarioSolicita = null,
    $NumeroTrabajoPaginacion = null,
    $PagoTrabajoDesde = null,
    $PagoTrabajoHasta = null,
    $FechaDesdeCreacionTrabajo = null,
    $FechaHastaCreacionTrabajo = null,
    $StatusSolicitud = null
                                        ){
        $instance = new self();
        $instance->setIdTrabajo($IdTrabajo);
        $instance->setTituloTrabajo($TituloTrabajo);
        $instance->setDescripcionTrabajo($DescripcionTrabajo);
        $instance->setPagoTrabajo($PagoTrabajo);
        $instance->setStatusTrabajo($StatusTrabajo);
        $instance->setFechaCreacionTrabajo($FechaCreacionTrabajo);
        $instance->setEstadoTrabajo($EstadoTrabajo);
        $instance->setUsuarioCreador($UsuarioCreador);
        
        $instance->setListaArchivosModel($ListaArchivosModel);
        $instance->setUsuarioCreadorModel($UsuarioCreadorModel);
        $instance->setSolicitudAplicadaModel($SolicitudAplicadaModel);

        
        $instance->setUsuarioSolicita($UsuarioSolicita);
        $instance->setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion);
        $instance->setPagoTrabajoDesde($PagoTrabajoDesde);
        $instance->setPagoTrabajoHasta($PagoTrabajoHasta);
        $instance->setFechaDesdeCreacionTrabajo($FechaDesdeCreacionTrabajo);
        $instance->setFechaHastaCreacionTrabajo($FechaHastaCreacionTrabajo);
        $instance->setStatusSolicitud($StatusSolicitud);

        return $instance;
    }

    
    public function jsonSerialize() {

        return array(
            'IdTrabajo' => $this->IdTrabajo,
            'TituloTrabajo' => $this->TituloTrabajo,
            'DescripcionTrabajo' => $this->DescripcionTrabajo,
            'PagoTrabajo' => $this->PagoTrabajo,
            'StatusTrabajo' => $this->StatusTrabajo,
            'FechaCreacionTrabajo' => $this->FechaCreacionTrabajo,
            'EstadoTrabajo' => $this->EstadoTrabajo,
            'UsuarioCreador' => $this->UsuarioCreador,
            'ListaArchivosModel' => $this->ListaArchivosModel,
            'UsuarioCreadorModel' => $this->UsuarioCreadorModel,
            'SolicitudAplicadaModel' => $this->SolicitudAplicadaModel,
       );
    }

    
    public function getIdTrabajo()
    {
        return $this->IdTrabajo;
    }

    public function setIdTrabajo($IdTrabajo)
    {
        $this->IdTrabajo = $IdTrabajo;

        return $this;
    }

    public function getTituloTrabajo()
    {
        return $this->TituloTrabajo;
    }

    public function setTituloTrabajo($TituloTrabajo)
    {
        $this->TituloTrabajo = $TituloTrabajo;

        return $this;
    }

    public function getDescripcionTrabajo()
    {
        return $this->DescripcionTrabajo;
    }

    public function setDescripcionTrabajo($DescripcionTrabajo)
    {
        $this->DescripcionTrabajo = $DescripcionTrabajo;

        return $this;
    }


    public function getPagoTrabajo()
    {
        return $this->PagoTrabajo;
    }

    public function getPagoTrabajoConFormato()
    {
        return number_format((float)$this->PagoTrabajo, 2, '.', ',');
    }

    public function setPagoTrabajo($PagoTrabajo)
    {
        $this->PagoTrabajo = $PagoTrabajo;

        return $this;
    }
    


    public function getStatusTrabajo()
    {
        return $this->StatusTrabajo;
    }

    public function setStatusTrabajo($StatusTrabajo)
    {
        $this->StatusTrabajo = $StatusTrabajo;

        return $this;
    }


    public function getFechaCreacionTrabajo()
    {
        return $this->FechaCreacionTrabajo;
    }

    public function setFechaCreacionTrabajo($FechaCreacionTrabajo)
    {
        $this->FechaCreacionTrabajo = $FechaCreacionTrabajo;

        return $this;
    }

    public function getEstadoTrabajo()
    {
        return $this->EstadoTrabajo;
    }

    public function setEstadoTrabajo($EstadoTrabajo)
    {
        $this->EstadoTrabajo = $EstadoTrabajo;

        return $this;
    }

    public function getUsuarioCreador()
    {
        return $this->UsuarioCreador;
    }

    public function setUsuarioCreador($UsuarioCreador)
    {
        $this->UsuarioCreador = $UsuarioCreador;

        return $this;
    }

    
    public function getListaArchivos()
    {
        return $this->listaArchivos;
    }

    public function getListaArchivosModel()
    {
        return $this->ListaArchivosModel;
    }

    public function setListaArchivosModel($ListaArchivosModel)
    {
        $this->ListaArchivosModel = $ListaArchivosModel;
    
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

    
    public function getSolicitudAplicadaModel()
    {
        return $this->SolicitudAplicadaModel;
    }

    public function setSolicitudAplicadaModel($SolicitudAplicadaModel)
    {
        $this->SolicitudAplicadaModel = $SolicitudAplicadaModel;

        return $this;
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

    public function getNumeroTrabajoPaginacion()
    {
        return $this->NumeroTrabajoPaginacion;
    }

    public function setNumeroTrabajoPaginacion($NumeroTrabajoPaginacion)
    {
        $this->NumeroTrabajoPaginacion = $NumeroTrabajoPaginacion;

        return $this;
    }

    public function getPagoTrabajoDesde()
    {
        return $this->PagoTrabajoDesde;
    }

    public function setPagoTrabajoDesde($PagoTrabajoDesde)
    {
        $this->PagoTrabajoDesde = $PagoTrabajoDesde;

        return $this;
    }

    public function getPagoTrabajoHasta()
    {
        return $this->PagoTrabajoHasta;
    }

    public function setPagoTrabajoHasta($PagoTrabajoHasta)
    {
        $this->PagoTrabajoHasta = $PagoTrabajoHasta;

        return $this;
    }

    public function getFechaDesdeCreacionTrabajo()
    {
        return $this->FechaDesdeCreacionTrabajo;
    }

    public function setFechaDesdeCreacionTrabajo($FechaDesdeCreacionTrabajo)
    {
        $this->FechaDesdeCreacionTrabajo = $FechaDesdeCreacionTrabajo;

        return $this;
    }

    public function getFechaHastaCreacionTrabajo()
    {
        return $this->FechaHastaCreacionTrabajo;
    }

    public function setFechaHastaCreacionTrabajo($FechaHastaCreacionTrabajo)
    {
        $this->FechaHastaCreacionTrabajo = $FechaHastaCreacionTrabajo;

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

    public function getFiltroBusqueda()
    {
        return $this->FiltroBusqueda;
    }

    public function setFiltroBusqueda($FiltroBusqueda)
    {
        $this->FiltroBusqueda = $FiltroBusqueda;

        return $this;
    }
}

?>