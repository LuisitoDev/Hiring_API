<?php 

abstract class ErrorMessages
{
    const PaginaNotFound = "La pagina ingresada no existe o no se encuentra disponible";

    const IdUsuarioNoDefinido = "El Id del Usuario no está definido";
    const IdUsuarioNoEsNumero = "El Id del Usuario no es un numero entero";
    const UsuarioNoRegistrado = "No hay ningun usuario registrado";

    const CorreoOPasswordIncorrectos = "El correo o el password están incorrectos";

    const IdTrabajoNoDefinido = "El Id del Trabajo no está definido";
    const IdTrabajoNoEsNumero = "El Id del Trabajo no es un numero entero";
    const TrabajoNoExisteONoDisponible = "El Trabajo ingresado no existe o no se encuentra disponible";
    const TrabajoDadoDeBaja = "El Trabajo ingresado fue dado de baja";
    const TrabajoNoComprado = "No puedes acceder a los niveles del Trabajo porque no lo has comprado";

    const CostoTrabajoNoDefinido = "El costo del Trabajo no está definido";
    const CostoTrabajoNoEsNumeroPositivo = "El costo del Trabajo no es un numero positivo";

    const IdNivelNoDefinido = "El Id del nivel no está definido";
    const IdNivelNoEsNumero = "El Id del nivel no es un numero entero";
    const NivelNoExisteONoDisponible = "El nivel ingresado no existe o no se encuentra disponible";
    
    const TrabajoONivelNoExisten = "El Trabajo o el nivel ingresado no existen o no se encuentran disponibles";


    const CorreoNoDefinido = "El correo no está definido";
    const PasswordNoDefinido = "El password no está definido";


    const SoloUsuariosEscuelaPueden = "Solo los usuarios con rol \"Escuela\" pueden: ";
    const SoloUsuariosEstudiantePueden = "Solo los usuarios con rol \"Estudiante\" pueden: ";
    const SoloUsuariosRegistradosPueden = "Solo los usuarios registrados pueden: ";

}
