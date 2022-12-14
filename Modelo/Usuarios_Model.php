<?php
class Usuarios_Model  implements JsonSerializable{
    private $IdUsuario;
    private $NombreUsuario;
    private $ApellidoPaternoUsuario;
    private $ApellidoMaternoUsuario;
    private $FechaNacimientoUsuario;
    private $EscolaridadUsuario;
    private $ProfesionUsuario;
    private $DescripcionUsuario;
    private $ImagenPerfilUsuario;
    private $CorreoUsuario;
    private $PasswordUsuario;
    private $FechaCreacionUsuario;
    private $EstadoUsuario;

    public function __construct(){
        
    }

    public static function createUsuario($IdUsuario, $NombreUsuario, $ApellidoPaternoUsuario, $ApellidoMaternoUsuario, $FechaNacimientoUsuario, 
                                        $EscolaridadUsuario, $ProfesionUsuario, $DescripcionUsuario,
                                        $ImagenPerfilUsuario, $CorreoUsuario, $PasswordUsuario, $FechaCreacionUsuario, $EstadoUsuario){
        $instance = new self();
        $instance->setIdUsuario($IdUsuario);
        $instance->setNombreUsuario($NombreUsuario);
        $instance->setApellidoPaternoUsuario($ApellidoPaternoUsuario);
        $instance->setApellidoMaternoUsuario($ApellidoMaternoUsuario);
        $instance->setFechaNacimientoUsuario($FechaNacimientoUsuario);

        $instance->setEscolaridadUsuario($EscolaridadUsuario);
        $instance->setProfesionUsuario($ProfesionUsuario);
        $instance->setDescripcionUsuario($DescripcionUsuario);


        $instance->setImagenPerfilUsuario($ImagenPerfilUsuario);
        $instance->setCorreoUsuario($CorreoUsuario);
        $instance->setPasswordUsuario($PasswordUsuario);
        $instance->setFechaCreacionUsuario($FechaCreacionUsuario);
        $instance->setEstadoUsuario($EstadoUsuario);

        return $instance;
    }

    
    public function jsonSerialize() {

        return array(
            'IdUsuario' => $this->IdUsuario,
            'NombreUsuario' => $this->NombreUsuario,
            'ApellidoPaternoUsuario' => $this->ApellidoPaternoUsuario,
            'ApellidoMaternoUsuario' => $this->ApellidoMaternoUsuario,
            'FechaNacimientoUsuario' => $this->FechaNacimientoUsuario,
            'EscolaridadUsuario' => $this->EscolaridadUsuario,
            'ProfesionUsuario' => $this->ProfesionUsuario,
            'DescripcionUsuario' => $this->DescripcionUsuario,
            'ImagenPerfilUsuario' => $this->ImagenPerfilUsuario,
            'CorreoUsuario' => $this->CorreoUsuario,
            'PasswordUsuario' => $this->PasswordUsuario,
            'FechaCreacionUsuario' => $this->FechaCreacionUsuario,
            'EstadoUsuario' => $this->EstadoUsuario
       );
    }

    
    public function getIdUsuario()
    {
        return $this->IdUsuario;
    }

    
    public function setIdUsuario($IdUsuario)
    {
        $this->IdUsuario = $IdUsuario;

        return $this;
    }

   
    public function getNombreUsuario()
    {
        return $this->NombreUsuario;
    }

   
    public function setNombreUsuario($NombreUsuario)
    {
        $this->NombreUsuario = $NombreUsuario;

        return $this;
    }

    
    public function getApellidoPaternoUsuario()
    {
        return $this->ApellidoPaternoUsuario;
    }

    public function setApellidoPaternoUsuario($ApellidoPaternoUsuario)
    {
        $this->ApellidoPaternoUsuario = $ApellidoPaternoUsuario;

        return $this;
    }

   
    public function getApellidoMaternoUsuario()
    {
        return $this->ApellidoMaternoUsuario;
    }

   
    public function setApellidoMaternoUsuario($ApellidoMaternoUsuario)
    {
        $this->ApellidoMaternoUsuario = $ApellidoMaternoUsuario;

        return $this;
    }

    public function getFechaNacimientoUsuario()
    {
        return $this->FechaNacimientoUsuario;
    }

   
    public function setFechaNacimientoUsuario($FechaNacimientoUsuario)
    {
        $this->FechaNacimientoUsuario = $FechaNacimientoUsuario;

        return $this;
    }

    
    public function getEscolaridadUsuario()
    {
        return $this->EscolaridadUsuario;
    }

    public function setEscolaridadUsuario($EscolaridadUsuario)
    {
        $this->EscolaridadUsuario = $EscolaridadUsuario;

        return $this;
    }

    public function getProfesionUsuario()
    {
        return $this->ProfesionUsuario;
    }

    public function setProfesionUsuario($ProfesionUsuario)
    {
        $this->ProfesionUsuario = $ProfesionUsuario;

        return $this;
    }

    public function getDescripcionUsuario()
    {
        return $this->DescripcionUsuario;
    }

    public function setDescripcionUsuario($DescripcionUsuario)
    {
        $this->DescripcionUsuario = $DescripcionUsuario;

        return $this;
    }

   
    public function getImagenPerfilUsuario()
    {
        return $this->ImagenPerfilUsuario;
    }


    public function setImagenPerfilUsuario($ImagenPerfilUsuario)
    {
        $this->ImagenPerfilUsuario = $ImagenPerfilUsuario;

        return $this;
    }

    public function getCorreoUsuario()
    {
        return $this->CorreoUsuario;
    }

  
    public function setCorreoUsuario($CorreoUsuario)
    {
        $this->CorreoUsuario = $CorreoUsuario;

        return $this;
    }
    public function getPasswordUsuario()
    {
        return $this->PasswordUsuario;
    }

    public function setPasswordUsuario($PasswordUsuario)
    {
        $this->PasswordUsuario = $PasswordUsuario;

        return $this;
    }

    public function getFechaCreacionUsuario()
    {
        return $this->FechaCreacionUsuario;
    }

    public function setFechaCreacionUsuario($FechaCreacionUsuario)
    {
        $this->FechaCreacionUsuario = $FechaCreacionUsuario;

        return $this;
    }

    public function getEstadoUsuario()
    {
        return $this->EstadoUsuario;
    }

    public function setEstadoUsuario($EstadoUsuario)
    {
        $this->EstadoUsuario = $EstadoUsuario;

        return $this;
    }


    public function concatenarNombreCompletoUsuario(){
        return $this->NombreUsuario . " " . $this->ApellidoPaternoUsuario . " " . $this->ApellidoMaternoUsuario;
    }
    
}

?>