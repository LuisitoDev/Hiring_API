DROP TRIGGER IF EXISTS editar_trabajo

DELIMITER //
CREATE TRIGGER editar_trabajo
AFTER UPDATE
ON trabajos FOR EACH ROW
BEGIN
if(NEW.EstadoTrabajo = 1 AND New.StatusTrabajo != "Cerrado") THEN
DELETE FROM archivos WHERE archivos.TrabajoAsignado=NEW.IdTrabajo;
END IF;
END;//

DROP TRIGGER IF EXISTS baja_fisica_trabajo

DELIMITER //
CREATE TRIGGER baja_fisica_trabajo
BEFORE DELETE
ON trabajos FOR EACH ROW
BEGIN
DELETE FROM archivos WHERE archivos.TrabajoAsignado=OLD.IdTrabajo;
END;//



DROP TRIGGER IF EXISTS baja_logica_trabajo

DELIMITER //
CREATE TRIGGER baja_logica_trabajo
AFTER UPDATE
ON trabajos FOR EACH ROW
BEGIN
if(NEW.EstadoTrabajo = 0) THEN
		UPDATE solicitudes
		SET EstadoSolicitud = 0
		WHERE TrabajoSolicitado = NEW.IdTrabajo;
END IF;
END;//