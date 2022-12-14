<?php

require_once "Utils/Validaciones.php";

class Validaciones
{

    private $usuarioPuedeVerPaginaCurso;
    private $usuarioPuedeVerPaginaNivel;
    private $usuarioPuedeVerNiveles;
    private $usuarioPuedeComprarCurso;
    private $usuarioPuedeInteractuarCurso;
    private $usuarioPuedeComentarCurso;

    private $mensajeError;

    public function __construct()
    {
        $this->usuarioPuedeVerPaginaCurso = false;
        $this->usuarioPuedeVerPaginaNivel = false;
        $this->usuarioPuedeVerNiveles = false;
        $this->usuarioPuedeComprarCurso = false;
        $this->usuarioPuedeComentarCurso = false;

        $this->mensajeError = "";
    }

    private function isCursoExiste($cursoElegido)
    {
        $cursoExiste = false;
        if ($cursoElegido != null) {
            if ($cursoElegido->getIdCurso() != null) {
                $cursoExiste = true;
            }
        }

        return $cursoExiste;
    }

    private function isNivelExiste($cursoElegido, $nivelElegido)
    {
        $nivelExiste = false;
        if ($nivelElegido != null) {
            if ($nivelElegido->getIdNivel() != null) {
                if ($cursoElegido->getIdCurso() == $nivelElegido->getCursoImpartido()) {
                    $nivelExiste = true;
                }
            }
        }

        return $nivelExiste;
    }


    private function isCursoActivo($cursoElegido)
    {
        $cursoActivo = false;
        if ($cursoElegido != null) {
            if ($cursoElegido->getEstadoCurso() == 1) {
                $cursoActivo = true;
            }
        }

        return $cursoActivo;
    }

    public function isCursoComprado($cursoElegido)
    {
        $cursoComprado = false;
        if ($cursoElegido != null) {
            if ($cursoElegido->getCompraCurso()->getIdCompra() != null && $cursoElegido->getCompraCurso()->getIdCompra() != 0) {
                $cursoComprado = true;
            }
        }

        return $cursoComprado;
    }

    private function isCursoCompletado($cursoElegido)
    {
        $cursoCompletado = false;
        if ($cursoElegido != null) {
            if ($cursoElegido->getCompraCurso() != null) {
                if ($cursoElegido->getCompraCurso()->getProgresoCursoComprado() == 100) {
                    $cursoCompletado = true;
                }
            }
        }
        return $cursoCompletado;
    }

    public function isCursoComentado($cursoElegido)
    {
        $cursoComentado = false;
        if ($cursoElegido != null) {

            $IdUsuarioActivo = General::getIdUsuarioActivo();
            $IdCurso = $cursoElegido->getIdCurso();

            $argumentoscursoComentado = new Solicitudes_Model();
            $argumentoscursoComentado->setUsuarioComento($IdUsuarioActivo);
            $argumentoscursoComentado->setCursoComentado($IdCurso);

            $listaCursoComentado = Solicitudes_DAO::getSolicitudes("SolicitudReciente", $argumentoscursoComentado);

            if ($listaCursoComentado != null) {
                if ($listaCursoComentado[0]->getIdSolicitud() != null) {
                    $cursoComentado = true;
                }
            }
        }

        return $cursoComentado;
    }

    private function isNivelGratis($nivelElegido)
    {
        $nivelGratis = false;
        if ($nivelElegido != null) {
            if ($nivelElegido->getNivelGratis() == true) {
                $nivelGratis = true;
            }
        }

        return $nivelGratis;
    }

    private function isCursoPropio($cursoElegido)
    {
        $cursoPropio = false;

        if ($cursoElegido != null) {
            $IdCreadorCurso = $cursoElegido->getUsuarioCreador();

            if (General::isUsuarioActivo($IdCreadorCurso) && General::isTipoRol(Rol::Escuela)) {
                $cursoPropio = true;
            }
        }

        return $cursoPropio;
    }

    public function isSetUsuarioActivo()
    {
        $usuarioEsEscuela = false;

        if (General::isSetUsuarioActivo()) {
            $usuarioEsEscuela = true;
        }

        return $usuarioEsEscuela;
    }

    public function isUsuarioEscuela()
    {
        $usuarioEsEscuela = false;

        if (General::isTipoRol(Rol::Escuela)) {
            $usuarioEsEscuela = true;
        }

        return $usuarioEsEscuela;
    }

    public function validarCursoElegido($cursoElegido)
    {
        $cursoExiste = self::isCursoExiste($cursoElegido);
        if ($cursoExiste == true) {

            $cursoActivo = self::isCursoActivo($cursoElegido);
            $cursoPropio = self::isCursoPropio($cursoElegido);
            $cursoComprado = self::isCursoComprado($cursoElegido);
            $cursoCompletado = self::isCursoCompletado($cursoElegido);
            $cursoComentado = self::isCursoComentado($cursoElegido);
            $usuarioRegistrado = self::isSetUsuarioActivo();
            $usuarioEsEscuela = self::isUsuarioEscuela();

            if ($cursoActivo == true || $cursoPropio == true) {
                $this->usuarioPuedeVerPaginaCurso = true;
            }

            if ($this->usuarioPuedeVerPaginaCurso == true) {

                if ($cursoComprado == true || $cursoPropio == true) {
                    $this->usuarioPuedeVerNiveles = true;
                }

                if ($usuarioRegistrado == true && $cursoComprado == false && $cursoPropio == false && $usuarioEsEscuela == false) {
                    $this->usuarioPuedeComprarCurso = true;
                }

                if ($cursoCompletado == true) {
                    $this->usuarioPuedeInteractuarCurso = true;
                }

                if ($cursoComentado == false) {
                    $this->usuarioPuedeComentarCurso = true;
                }
            } else {
                $this->mensajeError = ErrorMessages::CursoDadoDeBaja;
            }
        } else {
            $this->mensajeError = ErrorMessages::CursoNoExisteONoDisponible;
        }
    }


    public function validarNivelCursoElegido($cursoElegido, $nivelElegido)
    {
        $cursoExiste = self::isCursoExiste($cursoElegido);
        $nivelExiste = self::isNivelExiste($cursoElegido, $nivelElegido);

        if ($cursoExiste == true && $nivelExiste == true) {
            $cursoActivo = self::isCursoActivo($cursoElegido);
            $cursoComprado = self::isCursoComprado($cursoElegido);
            $nivelGratis = self::isNivelGratis($nivelElegido);
            $cursoPropio = self::isCursoPropio($cursoElegido);
            $usuarioRegistrado = self::isSetUsuarioActivo();
            $usuarioEsEscuela = self::isUsuarioEscuela();

            if ($cursoActivo == true && ($cursoComprado == true || $nivelGratis == true) || $cursoPropio == true) {
                $this->usuarioPuedeVerPaginaNivel = true;
            }

            if ($this->usuarioPuedeVerPaginaNivel == true) {

                if ($cursoComprado == true || $cursoPropio == true) {
                    $this->usuarioPuedeVerNiveles = true;
                }

                if ($usuarioRegistrado == true && $cursoComprado == false && $cursoPropio == false && $usuarioEsEscuela == false) {
                    $this->usuarioPuedeComprarCurso = true;
                }
            } else {
                if ($cursoActivo == false)
                    $this->mensajeError = ErrorMessages::CursoDadoDeBaja;
                else if ($cursoComprado == false && $nivelGratis == false)
                    $this->mensajeError = ErrorMessages::CursoNoComprado;
            }
        } else {
            $this->mensajeError = ErrorMessages::CursoONivelNoExisten;
        }
    }

    public function getUsuarioPuedeVerPaginaCurso()
    {
        return $this->usuarioPuedeVerPaginaCurso;
    }

    public function setUsuarioPuedeVerPaginaCurso($usuarioPuedeVerPaginaCurso)
    {
        $this->usuarioPuedeVerPaginaCurso = $usuarioPuedeVerPaginaCurso;

        return $this;
    }

    public function getUsuarioPuedeVerPaginaNivel()
    {
        return $this->usuarioPuedeVerPaginaNivel;
    }

    public function setUsuarioPuedeVerPaginaNivel($usuarioPuedeVerPaginaNivel)
    {
        $this->usuarioPuedeVerPaginaNivel = $usuarioPuedeVerPaginaNivel;

        return $this;
    }


    public function getUsuarioPuedeVerNiveles()
    {
        return $this->usuarioPuedeVerNiveles;
    }

    public function setUsuarioPuedeVerNiveles($usuarioPuedeVerNiveles)
    {
        $this->usuarioPuedeVerNiveles = $usuarioPuedeVerNiveles;

        return $this;
    }

    public function getUsuarioPuedeComprarCurso()
    {
        return $this->usuarioPuedeComprarCurso;
    }

    public function setUsuarioPuedeComprarCurso($usuarioPuedeComprarCurso)
    {
        $this->usuarioPuedeComprarCurso = $usuarioPuedeComprarCurso;

        return $this;
    }

    public function getUsuarioPuedeComentarCurso()
    {
        return $this->usuarioPuedeComentarCurso;
    }

    public function setUsuarioPuedeComentarCurso($usuarioPuedeComentarCurso)
    {
        $this->usuarioPuedeComentarCurso = $usuarioPuedeComentarCurso;

        return $this;
    }

    public function getMensajeError()
    {
        return $this->mensajeError;
    }

    public function setMensajeError($mensajeError)
    {
        $this->mensajeError = $mensajeError;

        return $this;
    }

    public function getUsuarioPuedeInteractuarCurso()
    {
        return $this->usuarioPuedeInteractuarCurso;
    }

    public function setUsuarioPuedeInteractuarCurso($usuarioPuedeInteractuarCurso)
    {
        $this->usuarioPuedeInteractuarCurso = $usuarioPuedeInteractuarCurso;

        return $this;
    }
}
