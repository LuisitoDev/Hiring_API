USE hiring_db;


DROP procedure IF EXISTS sp_usuarios;
DELIMITER $$
CREATE PROCEDURE sp_usuarios (
	IN p_Opc						varchar(30),
	IN p_IdUsuario 					bigint,
	IN p_NombreUsuario 				varchar(30),
	IN p_ApellidoPaternoUsuario 	varchar(30),
	IN p_ApellidoMaternoUsuario 	varchar(30),
	IN p_FechaNacimientoUsuario 	date,
    IN p_EscolaridadUsuario 		varchar(50),
    IN p_ProfesionUsuario 			varchar(100),
    IN p_DescripcionUsuario 		varchar(300),
	IN p_ImagenPerfilUsuario 		mediumblob,
	IN p_CorreoUsuario 				varchar(60),
	IN p_PasswordUsuario 			varchar(30),
	IN p_FechaCreacionUsuario 		datetime,
	IN p_EstadoUsuario 				tinyint(1)
)
BEGIN
	IF p_Opc = 'I'
	THEN 
		INSERT INTO usuarios(	NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
								EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario)
			VALUES(		p_NombreUsuario, p_ApellidoPaternoUsuario, p_ApellidoMaternoUsuario, p_FechaNacimientoUsuario, 
						p_EscolaridadUsuario, p_ProfesionUsuario, p_DescripcionUsuario, p_ImagenPerfilUsuario, p_CorreoUsuario, p_PasswordUsuario);
	END IF;
	IF p_Opc = 'U'
	THEN
		UPDATE usuarios
			SET NombreUsuario = p_NombreUsuario,
				ApellidoPaternoUsuario = p_ApellidoPaternoUsuario,				
                ApellidoMaternoUsuario = p_ApellidoMaternoUsuario,
				FechaNacimientoUsuario = p_FechaNacimientoUsuario,
				EscolaridadUsuario = p_EscolaridadUsuario,
				ProfesionUsuario = p_ProfesionUsuario,
				DescripcionUsuario = p_DescripcionUsuario,
				ImagenPerfilUsuario= IF(p_ImagenPerfilUsuario IS NULL, ImagenPerfilUsuario, p_ImagenPerfilUsuario), 
                CorreoUsuario = p_CorreoUsuario,
				PasswordUsuario = IF(p_PasswordUsuario IS NULL, PasswordUsuario, p_PasswordUsuario)
			WHERE IdUsuario = p_IdUsuario;
            
	END IF;

	IF p_Opc = 'UpdatePerfil'
	THEN
		UPDATE usuarios
			SET NombreUsuario = p_NombreUsuario,
				ApellidoPaternoUsuario = p_ApellidoPaternoUsuario,				
                ApellidoMaternoUsuario = p_ApellidoMaternoUsuario,
				FechaNacimientoUsuario = p_FechaNacimientoUsuario,
				EscolaridadUsuario = p_EscolaridadUsuario,
				ProfesionUsuario = p_ProfesionUsuario,
				DescripcionUsuario = p_DescripcionUsuario,
				ImagenPerfilUsuario= IF(p_ImagenPerfilUsuario IS NULL, ImagenPerfilUsuario, p_ImagenPerfilUsuario)
			WHERE IdUsuario = p_IdUsuario;
            
	END IF;


	IF p_Opc = 'UpdatePassword'
	THEN
		UPDATE usuarios
			SET PasswordUsuario = p_PasswordUsuario
			WHERE IdUsuario = p_IdUsuario;
            
	END IF;

	IF p_Opc = 'D'
	THEN
		DELETE
			FROM usuarios
		WHERE IdUsuario = p_IdUsuario;	
	END IF;
    
    IF p_Opc = 'SuspenderUsuario'
	THEN
		UPDATE usuarios
			SET 
				EstadoUsuario = 0
			WHERE IdUsuario = p_IdUsuario;
	END IF;

	IF p_Opc = 'S'
	THEN
		SELECT 	IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, 
                ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios
		WHERE IdUsuario = p_IdUsuario;
	END IF;
    
	IF p_Opc = 'BuscarCorreo'
	THEN
		SELECT 	IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, ImagenPerfilUsuario, 
                CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios
		WHERE CorreoUsuario = p_CorreoUsuario;
	END IF;
    
    
	IF p_Opc = 'UsuarioByIdUsuario'
	THEN
     SELECT 	IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, 
                ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios
		WHERE IdUsuario = p_IdUsuario;
	END IF;
    
    
	IF p_Opc = 'UsuarioByCorreoPw'
	THEN
		SELECT IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, 
                ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios
		WHERE BINARY  CorreoUsuario = BINARY p_CorreoUsuario
        AND BINARY PasswordUsuario = BINARY p_PasswordUsuario;
	END IF;
    
	IF p_Opc = 'Login'
	THEN
		SELECT 	IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, 
                ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios
		WHERE BINARY  CorreoUsuario = BINARY p_CorreoUsuario
        AND BINARY PasswordUsuario = BINARY p_PasswordUsuario;
	END IF;
    
	IF p_Opc = 'X'
	THEN
		SELECT 	IdUsuario, NombreUsuario, ApellidoPaternoUsuario, ApellidoMaternoUsuario, FechaNacimientoUsuario, 
				EscolaridadUsuario, ProfesionUsuario, DescripcionUsuario, 
                ImagenPerfilUsuario, CorreoUsuario, PasswordUsuario, FechaCreacionUsuario, EstadoUsuario
			FROM usuarios;
		
	END IF;
    
    IF p_Opc = 'ValidarCorreoRepetido'
    THEN
		SELECT 1 'CorreoUsuarioEncontrado'
        FROM usuarios
        WHERE CorreoUsuario = p_CorreoUsuario;
    END IF;
END$$

DELIMITER ;


DROP procedure IF EXISTS sp_trabajos;
DELIMITER $$
CREATE PROCEDURE sp_trabajos (
	IN p_Opc						varchar(30),
	IN p_IdTrabajo 					bigint,
	IN p_TituloTrabajo 				varchar(100),
	IN p_DescripcionTrabajo	 		varchar(500),
	IN p_PagoTrabajo			 	decimal(19,2),
    IN p_StatusTrabajo				varchar(30),
	IN p_FechaCreacionTrabajo 		datetime,
	IN p_EstadoTrabajo	 			tinyint(1),
	IN p_UsuarioCreador 			bigint,
    IN p_UsuarioSolicita			bigint,
    IN p_NumeroTrabajoPaginacion	int,
	IN p_PagoTrabajoDesde			decimal(19,2),
    IN p_PagoTrabajoHasta			decimal(19,2),
    IN p_FechaDesdeCreacionTrabajo	datetime,
    IN p_FechaHastaCreacionTrabajo 	datetime,
    IN p_StatusSolicitud			varchar(30),
    IN p_FiltroBusqueda				varchar(30)
)
BEGIN
	IF p_Opc = 'I'
	THEN 
		INSERT INTO trabajos(TituloTrabajo, DescripcionTrabajo, PagoTrabajo, StatusTrabajo, UsuarioCreador)
			VALUES(p_TituloTrabajo, p_DescripcionTrabajo, p_PagoTrabajo, p_StatusTrabajo, p_UsuarioCreador);
            
		SELECT IdTrabajo
			FROM trabajos
		WHERE IdTrabajo = last_insert_id();
	END IF;
	IF p_Opc = 'U'
	THEN
		UPDATE trabajos
			SET TituloTrabajo = p_TituloTrabajo,
				DescripcionTrabajo = p_DescripcionTrabajo,	
				PagoTrabajo = p_PagoTrabajo,	
				StatusTrabajo = p_StatusTrabajo
				#,UsuarioCreador = p_UsuarioCreador
			WHERE IdTrabajo = p_IdTrabajo;
            
	END IF;

	IF p_Opc = 'D'
	THEN
		DELETE
			FROM trabajos
		WHERE IdTrabajo = p_IdTrabajo;
	END IF;
    
    IF p_Opc = 'CerrarTrabajo'
	THEN
		UPDATE trabajos
			SET 
				StatusTrabajo = "Cerrado"
			WHERE IdTrabajo = p_IdTrabajo;
            
            
		UPDATE solicitudes
		SET StatusSolicitud = "Rechazada",
			FechaRespuestaSolicitud = CURRENT_TIMESTAMP
		WHERE TrabajoSolicitado = p_IdTrabajo
        AND StatusSolicitud = "En proceso";
            
	END IF;
    
	IF p_Opc = 'EliminarTrabajo'
	THEN
		UPDATE trabajos
			SET EstadoTrabajo = 0 
        WHERE IdTrabajo = p_IdTrabajo;
	END IF;
    

	IF p_Opc = 'S'
	THEN
		SELECT IdTrabajo, TituloTrabajo, DescripcionTrabajo, PagoTrabajo, StatusTrabajo, FechaCreacionTrabajo, EstadoTrabajo, UsuarioCreador
			FROM trabajos
		WHERE IdTrabajo = p_IdTrabajo;
	END IF;


	IF p_Opc = 'X'
	THEN
		SELECT IdTrabajo, TituloTrabajo, DescripcionTrabajo, PagoTrabajo, StatusTrabajo, FechaCreacionTrabajo, EstadoTrabajo, UsuarioCreador
			FROM trabajos;
		
	END IF;
    
    
	IF p_Opc = 'TrabajosInicio'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador

				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado 
				
                ,US.IdUsuario
                ,US.NombreUsuario, US.ApellidoPaternoUsuario, US.ApellidoMaternoUsuario
                ,US.ImagenPerfilUsuario
                ,US.ProfesionUsuario
                 
			FROM trabajos as TRAB
            
			INNER JOIN usuarios AS US
			ON TRAB.UsuarioCreador = US.IdUsuario
        
            INNER JOIN archivos as ARCH
            ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
            
		WHERE TRAB.StatusTrabajo = "En proceso"
        AND TRAB.EstadoTrabajo = 1
		GROUP BY TRAB.IdTrabajo
        ORDER BY TRAB.FechaCreacionTrabajo DESC
		LIMIT p_NumeroTrabajoPaginacion, 5;
    END IF; 
    
    IF p_Opc = 'BuscarTrabajo'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
			            
				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado
                    
				
                ,US.IdUsuario
                ,US.NombreUsuario, US.ApellidoPaternoUsuario, US.ApellidoMaternoUsuario
                ,US.ImagenPerfilUsuario
                ,US.ProfesionUsuario
                
			FROM trabajos as TRAB
		
        INNER JOIN usuarios AS US
        ON TRAB.UsuarioCreador = US.IdUsuario
                
		INNER JOIN archivos as ARCH
		ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
        
		WHERE TRAB.IdTrabajo = p_IdTrabajo
        GROUP BY TRAB.IdTrabajo;

    END IF;
    
	IF p_Opc = 'BusquedaAvanzada'
    THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
			
				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado
                
				
                ,US.IdUsuario
                ,US.NombreUsuario, US.ApellidoPaternoUsuario, US.ApellidoMaternoUsuario
                ,US.ImagenPerfilUsuario
                ,US.ProfesionUsuario
                                
			FROM trabajos as TRAB

        INNER JOIN usuarios AS US
        ON TRAB.UsuarioCreador = US.IdUsuario
				
		INNER JOIN archivos as ARCH
		ON ARCH.TrabajoAsignado = TRAB.IdTrabajo            
                
        WHERE IF(p_TituloTrabajo IS NULL, 1, TRAB.TituloTrabajo LIKE CONCAT('%', p_TituloTrabajo, '%')	)
        AND   IF(p_PagoTrabajoDesde = -1, 1, TRAB.PagoTrabajo >= p_PagoTrabajoDesde) 
        AND   IF(p_PagoTrabajoHasta = -1, 1, TRAB.PagoTrabajo <=  p_PagoTrabajoHasta)
        AND   IF(p_FechaDesdeCreacionTrabajo is null, 1, TRAB.FechaCreacionTrabajo >= p_FechaDesdeCreacionTrabajo) 
        AND   IF(p_FechaHastaCreacionTrabajo is null, 1, TRAB.FechaCreacionTrabajo <=  DATE_ADD(p_FechaHastaCreacionTrabajo,INTERVAL 1 DAY))
        AND   TRAB.EstadoTrabajo = 1
		AND   TRAB.StatusTrabajo = "En proceso"
        
        GROUP BY TRAB.IdTrabajo
        ORDER BY
        Case WHEN p_FiltroBusqueda = 'FechaDescendente' THEN TRAB.FechaCreacionTrabajo END DESC,
		Case WHEN p_FiltroBusqueda = 'FechaAscendente' THEN TRAB.FechaCreacionTrabajo END ASC,
		Case WHEN p_FiltroBusqueda = 'PagoDescendente' THEN TRAB.PagoTrabajo END DESC,
		Case WHEN p_FiltroBusqueda = 'PagoAscendente' THEN TRAB.PagoTrabajo END ASC
		LIMIT p_NumeroTrabajoPaginacion, 5;
	END IF;
    
    IF p_Opc = 'UltimoTrabajoByUsuarioCreador'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
                
			FROM trabajos as TRAB
            
		WHERE TRAB.UsuarioCreador = p_UsuarioCreador
        AND TRAB.EstadoTrabajo = 1
        ORDER BY TRAB.FechaCreacionTrabajo DESC
        LIMIT 1;
	END IF;
    
    
	IF p_Opc = 'MiTrabajoCreado'
	THEN    
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
			
				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado
                
				
                ,US.IdUsuario
                ,US.NombreUsuario, US.ApellidoPaternoUsuario, US.ApellidoMaternoUsuario
                ,US.ImagenPerfilUsuario
                ,US.ProfesionUsuario
                
			FROM trabajos as TRAB
            
        INNER JOIN usuarios AS US
        ON TRAB.UsuarioCreador = US.IdUsuario
                
		INNER JOIN archivos as ARCH
		ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
                    
		WHERE TRAB.IdTrabajo = p_IdTrabajo; 
        #AND TRAB.UsuarioCreador = p_UsuarioCreador;
    END IF;
    
    
	IF p_Opc = 'MisTrabajosCreados'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
                    
				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado
           
			FROM trabajos as TRAB
        
            INNER JOIN archivos as ARCH
            ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
            
        WHERE TRAB.UsuarioCreador = p_UsuarioCreador
        AND  IF(p_StatusTrabajo is null, 1, TRAB.StatusTrabajo = p_StatusTrabajo) 
        AND TRAB.EstadoTrabajo = 1
        GROUP BY TRAB.IdTrabajo
        ORDER BY TRAB.FechaCreacionTrabajo DESC
		LIMIT p_NumeroTrabajoPaginacion, 5;
        
	END IF;   
	
	IF p_Opc = 'TodosMisTrabajosCreados'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
                      
				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado
         
			FROM trabajos as TRAB
        
            INNER JOIN archivos as ARCH
            ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
            
        WHERE TRAB.UsuarioCreador = p_UsuarioCreador
        AND TRAB.EstadoTrabajo = 1
        AND  IF(p_StatusTrabajo is null, 1, TRAB.StatusTrabajo = p_StatusTrabajo) 
        GROUP BY TRAB.IdTrabajo
        ORDER BY TRAB.FechaCreacionTrabajo DESC;
	END IF;  

	IF p_Opc = 'MisSolicitudesTrabajo'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador

				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado

				,SOL.UsuarioSolicita
                ,SOL.TrabajoSolicitado
                ,SOL.StatusSolicitud
				,SOL.FechaCreacionSolicitud
                ,SOL.FechaRespuestaSolicitud
                ,SOL.EstadoSolicitud

			FROM trabajos as TRAB
            
			INNER JOIN solicitudes AS SOL
			ON SOL.TrabajoSolicitado = TRAB.IdTrabajo
                
            INNER JOIN archivos as ARCH
            ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
            
		WHERE SOL.UsuarioSolicita = p_UsuarioSolicita
		AND SOL.StatusSolicitud = "En proceso"
        #AND  IF(p_StatusSolicitud is null, 1, TRAB.StatusTrabajo = p_StatusSolicitud) 
        AND TRAB.EstadoTrabajo = 1
		GROUP BY TRAB.IdTrabajo
        ORDER BY TRAB.IdTrabajo DESC
		LIMIT p_NumeroTrabajoPaginacion, 5;
    END IF;

	IF p_Opc = 'TodasMisSolicitudesTrabajo'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador

				,ARCH.IdArchivo 
                ,ARCH.ArchivoData 
                ,ARCH.TrabajoAsignado

				,SOL.UsuarioSolicita
                ,SOL.TrabajoSolicitado
                ,SOL.StatusSolicitud
				,SOL.FechaCreacionSolicitud
                ,SOL.FechaRespuestaSolicitud
                ,SOL.EstadoSolicitud

			FROM trabajos as TRAB
            
			INNER JOIN solicitudes AS SOL
			ON SOL.TrabajoSolicitado = TRAB.IdTrabajo
                
            INNER JOIN archivos as ARCH
            ON ARCH.TrabajoAsignado = TRAB.IdTrabajo
            
		WHERE SOL.UsuarioSolicita = p_UsuarioSolicita
        AND SOL.StatusSolicitud = "En proceso"
        #AND  IF(p_StatusSolicitud is null, 1, TRAB.StatusTrabajo = p_StatusSolicitud) 
        AND TRAB.EstadoTrabajo = 1
        GROUP BY TRAB.IdTrabajo
		ORDER BY TRAB.IdTrabajo DESC;
    END IF;


	IF p_Opc = 'MisTrabajoBorradores'
	THEN
		SELECT 	TRAB.IdTrabajo, TRAB.TituloTrabajo, TRAB.DescripcionTrabajo, TRAB.PagoTrabajo, TRAB.StatusTrabajo 
				,TRAB.FechaCreacionTrabajo, TRAB.EstadoTrabajo, TRAB.UsuarioCreador
			
			FROM trabajos as TRAB
            
        WHERE TRAB.UsuarioCreador = p_UsuarioCreador
        AND TRAB.StatusTrabajo = "Borrador"
        AND TRAB.EstadoTrabajo = 1; 
    END IF; 

END$$

DELIMITER ;




DROP procedure IF EXISTS sp_archivos;
DELIMITER $$
CREATE PROCEDURE sp_archivos (
	IN p_Opc						varchar(30),
	IN p_IdArchivo					bigint,
	IN p_ArchivoData	 			mediumblob,
    IN p_TrabajoAsignado			bigint
)
BEGIN
	IF p_Opc = 'I'
	THEN 
		INSERT INTO archivos(ArchivoData, TrabajoAsignado)
			VALUES(p_ArchivoData, p_TrabajoAsignado);
	END IF;
	IF p_Opc = 'U'
	THEN
		UPDATE archivos
			SET ArchivoData = p_ArchivoData,
				TrabajoAsignado = p_TrabajoAsignado
			WHERE IdArchivo = p_IdArchivo;
            
	END IF;

	IF p_Opc = 'D'
	THEN
		DELETE
			FROM archivos
		WHERE IdArchivo = p_IdArchivo;
	END IF;
        
	IF p_Opc = 'S'
	THEN
		SELECT IdArchivo, ArchivoData, TrabajoAsignado
			FROM archivos
		WHERE IdArchivo = p_IdArchivo;
	END IF;


	IF p_Opc = 'X'
	THEN
		SELECT IdArchivo, ArchivoData, TrabajoAsignado
			FROM archivos;
		
	END IF;
    
    
    IF p_Opc = 'ArchivosDelTrabajo'
	THEN
		SELECT AR.IdArchivo, AR.ArchivoData, AR.TrabajoAsignado
			FROM archivos AR
		WHERE AR.TrabajoAsignado = p_TrabajoAsignado;
	END IF;
    
END$$

DELIMITER ;



DROP procedure IF EXISTS sp_Solicitudes;
DELIMITER $$
CREATE PROCEDURE sp_Solicitudes (
	IN p_Opc						varchar(30),
	IN p_UsuarioSolicita 			bigint(20),
    IN p_TrabajoSolicitado 			bigint(20),
    IN p_StatusSolicitud		 	varchar(30),
	IN p_FechaCreacionSolicitud 	datetime,
	IN p_FechaRespuestaSolicitud 	datetime,
    IN p_EstadoSolicitud	 		tinyint(1)
)
BEGIN
	IF p_Opc = 'I'
	THEN 
		INSERT INTO solicitudes(UsuarioSolicita, TrabajoSolicitado)
			VALUES(p_UsuarioSolicita, p_TrabajoSolicitado);
	END IF;
	IF p_Opc = 'U'
	THEN
		UPDATE solicitudes
			SET StatusSolicitud = p_StatusSolicitud,
                FechaRespuestaSolicitud = CURRENT_TIMESTAMP
			WHERE UsuarioSolicita = p_UsuarioSolicita
            AND TrabajoSolicitado = p_TrabajoSolicitado;
            
	END IF;

	IF p_Opc = 'D'
	THEN
		DELETE
			FROM solicitudes
		WHERE UsuarioSolicita = p_UsuarioSolicita
		AND TrabajoSolicitado = p_TrabajoSolicitado;
	END IF;
        
	IF p_Opc = 'EliminarSolicitud'
	THEN
		UPDATE solicitudes
			SET EstadoSolicitud = 0 
        WHERE UsuarioSolicita = p_UsuarioSolicita
		AND TrabajoSolicitado = p_TrabajoSolicitado;
	END IF;
    
	IF p_Opc = 'S'
	THEN
		SELECT UsuarioSolicita, TrabajoSolicitado, StatusSolicitud, FechaCreacionSolicitud, FechaRespuestaSolicitud, EstadoSolicitud
			FROM solicitudes
		WHERE UsuarioSolicita = p_UsuarioSolicita
		AND TrabajoSolicitado = p_TrabajoSolicitado;
	END IF;


	IF p_Opc = 'X'
	THEN
		SELECT UsuarioSolicita, TrabajoSolicitado, StatusSolicitud, FechaCreacionSolicitud, FechaRespuestaSolicitud, EstadoSolicitud
			FROM solicitudes;
		
	END IF;
    
	IF p_Opc = 'SolicitudesMiTrabajo'
	THEN
		SELECT 	SOL.UsuarioSolicita, SOL.TrabajoSolicitado, SOL.StatusSolicitud, 
				SOL.FechaCreacionSolicitud, SOL.FechaRespuestaSolicitud, SOL.EstadoSolicitud
			
				
                ,US_SOL.NombreUsuario as NombreUsuarioSolicita
                ,US_SOL.ApellidoPaternoUsuario as ApellidoPaternoUsuarioSolicita
                ,US_SOL.ApellidoMaternoUsuario as ApellidoMaternoUsuarioSolicita
                ,US_SOL.ImagenPerfilUsuario as ImagenPerfilUsuarioSolicita
                ,US_SOL.ProfesionUsuario as ProfesionUsuarioSolicita
						        
			FROM solicitudes as SOL
            
			INNER JOIN usuarios AS US_SOL
			ON US_SOL.IdUsuario = SOL.UsuarioSolicita
        
		WHERE SOL.TrabajoSolicitado = p_TrabajoSolicitado
		AND SOL.StatusSolicitud = p_StatusSolicitud
        AND SOL.EstadoSolicitud = 1
        GROUP BY SOL.UsuarioSolicita;
        
	END IF;
    
    
	IF p_Opc = 'NotificacionesSolicitudes'
	THEN
    Select * FROM (
		SELECT 	SOL.UsuarioSolicita, SOL.TrabajoSolicitado, SOL.StatusSolicitud, 
				SOL.FechaCreacionSolicitud, SOL.FechaRespuestaSolicitud, SOL.EstadoSolicitud
			
				
                ,US_CRE.NombreUsuario as NombreUsuarioCreador
                ,US_CRE.ApellidoPaternoUsuario as ApellidoPaternoUsuarioCreador
                ,US_CRE.ApellidoMaternoUsuario as ApellidoMaternoUsuarioCreador
                ,US_CRE.ImagenPerfilUsuario as ImagenPerfilUsuarioCreador
                ,US_CRE.ProfesionUsuario as ProfesionUsuarioCreador
						        
			FROM solicitudes as SOL
            
            INNER JOIN trabajos AS TRAB
            ON TRAB.IdTrabajo =  SOL.TrabajoSolicitado
        
			INNER JOIN usuarios AS US_CRE
			ON US_CRE.IdUsuario = TRAB.UsuarioCreador
            
		WHERE SOL.UsuarioSolicita = p_UsuarioSolicita
        AND SOL.StatusSolicitud != "En proceso"
        AND SOL.EstadoSolicitud = 1
        
        GROUP BY SOL.UsuarioSolicita, SOL.TrabajoSolicitado
        ORDER BY SOL.FechaCreacionSolicitud desc) as Respondidos
        UNION
        Select * FROM (
		SELECT 	SOL.UsuarioSolicita, SOL.TrabajoSolicitado, SOL.StatusSolicitud, 
				SOL.FechaCreacionSolicitud, SOL.FechaRespuestaSolicitud, SOL.EstadoSolicitud
			
				,US_SOL.NombreUsuario
                ,US_SOL.ApellidoPaternoUsuario
                ,US_SOL.ApellidoMaternoUsuario
                ,US_SOL.ImagenPerfilUsuario
                ,US_SOL.ProfesionUsuario
						        
			FROM solicitudes as SOL
            
			INNER JOIN usuarios AS US_SOL
			ON US_SOL.IdUsuario = SOL.UsuarioSolicita
            
            INNER JOIN trabajos AS TRAB
            ON TRAB.IdTrabajo =  SOL.TrabajoSolicitado
        
		WHERE TRAB.UsuarioCreador = p_UsuarioSolicita
        AND SOL.StatusSolicitud = "En proceso"
        AND SOL.EstadoSolicitud = 1
        
        GROUP BY SOL.UsuarioSolicita, SOL.TrabajoSolicitado
        ORDER BY SOL.FechaCreacionSolicitud desc) as NuevasSolicitudes
        
        ORDER BY FechaCreacionSolicitud desc, FechaRespuestaSolicitud desc;
	END IF;
END$$

DELIMITER ;




DROP procedure IF EXISTS sp_mensajes;
DELIMITER $$
CREATE PROCEDURE sp_mensajes (
	IN p_Opc						varchar(30),
	IN p_IdMensaje					bigint,
	IN p_UsuarioEnvia	 			bigint,
    IN p_UsuarioRecibe				bigint,
    IN p_DescripcionMensaje			varchar(800),
	IN p_FechaCreacionMensaje		datetime,
    IN p_EstadoMensaje 				tinyint(1),
    IN p_FiltroBandeja				varchar(200)
)
BEGIN
	IF p_Opc = 'I'
	THEN 
		INSERT INTO mensajes(UsuarioEnvia, UsuarioRecibe, DescripcionMensaje)
			VALUES(p_UsuarioEnvia, p_UsuarioRecibe, p_DescripcionMensaje);
	END IF;
	IF p_Opc = 'U'
	THEN
		UPDATE mensajes
			SET UsuarioEnvia = p_UsuarioEnvia,
				UsuarioRecibe = p_UsuarioRecibe,
                DescripcionMensaje = p_DescripcionMensaje
			WHERE IdMensaje = p_IdMensaje;
            
	END IF;

	IF p_Opc = 'D'
	THEN
		DELETE
			FROM mensajes
		WHERE IdMensaje = p_IdMensaje;
	END IF;
    
    
	IF p_Opc = 'S'
	THEN
		SELECT IdMensaje, UsuarioEnvia, UsuarioRecibe, DescripcionMensaje, FechaCreacionMensaje, EstadoMensaje
			FROM mensajes
		WHERE IdMensaje = p_IdMensaje;
	END IF;


	IF p_Opc = 'X'
	THEN
		SELECT IdMensaje, UsuarioEnvia, UsuarioRecibe, DescripcionMensaje, FechaCreacionMensaje, EstadoMensaje
			FROM mensajes;
		
	END IF;
    
    
        IF p_Opc = 'BandejaMensajes'
	THEN
    
    SELECT 	MSJ.IdMensaje, MSJ.UsuarioEnvia, MSJ.UsuarioRecibe, MSJ.DescripcionMensaje, MSJ.FechaCreacionMensaje, MSJ.EstadoMensaje
			#,CONCAT(US_ENV.NombreUsuario, ' ', US_ENV.ApellidoPaternoUsuario, ' ', US_ENV.ApellidoMaternoUsuario) AS 'NombreUsuarioEnvia', 
			,US_ENV.NombreUsuario as NombreUsuarioEnvia 
            ,US_ENV.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioEnvia 
            ,US_ENV.ApellidoMaternoUsuario as ApellidoMaternoUsuarioEnvia
            ,US_ENV.ImagenPerfilUsuario AS 'ImagenUsuarioEnvia'
			#,CONCAT(US_REC.NombreUsuario, ' ', US_REC.ApellidoPaternoUsuario, ' ', US_REC.ApellidoMaternoUsuario) AS 'NombreUsuarioRecibe', 
			,US_REC.NombreUsuario as NombreUsuarioRecibe 
            ,US_REC.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioRecibe 
            ,US_REC.ApellidoMaternoUsuario as ApellidoMaternoUsuarioRecibe 
			,US_REC.ImagenPerfilUsuario AS 'ImagenUsuarioRecibe'
		FROM mensajes AS MSJ 

		INNER JOIN usuarios AS US_ENV
		ON US_ENV.IdUsuario = MSJ.UsuarioEnvia
        
        
		INNER JOIN usuarios AS US_REC
		ON US_REC.IdUsuario = MSJ.UsuarioRecibe
      
		INNER JOIN(
			SELECT
				least(UsuarioEnvia, UsuarioRecibe) AS user_1,
				greatest(UsuarioEnvia, UsuarioRecibe) AS user_2,
				max(FechaCreacionMensaje) AS FechaCreacionMensaje
			FROM mensajes
			GROUP BY	least(UsuarioEnvia, UsuarioRecibe),
						greatest(UsuarioEnvia, UsuarioRecibe)
		) AS LAST_MSJ 
		ON least(UsuarioEnvia, UsuarioRecibe)=user_1
		AND greatest(UsuarioEnvia, UsuarioRecibe)=user_2
		AND MSJ.FechaCreacionMensaje = LAST_MSJ.FechaCreacionMensaje
      
		WHERE MSJ.UsuarioEnvia = p_UsuarioEnvia 
		OR MSJ.UsuarioRecibe = p_UsuarioEnvia
        ORDER BY FechaCreacionMensaje DESC;
    
    
	END IF;
    
    
        IF p_Opc = 'MensajesConversacion'
	THEN
		SELECT  IdMensaje, UsuarioEnvia, UsuarioRecibe, DescripcionMensaje, FechaCreacionMensaje, EstadoMensaje
				#,CONCAT(US_ENV.NombreUsuario, ' ', US_ENV.ApellidoPaternoUsuario, ' ', US_ENV.ApellidoMaternoUsuario) AS 'NombreUsuarioEnvia', 
				,US_ENV.NombreUsuario as NombreUsuarioEnvia 
				,US_ENV.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioEnvia 
				,US_ENV.ApellidoMaternoUsuario as ApellidoMaternoUsuarioEnvia
				,US_ENV.ImagenPerfilUsuario AS 'ImagenUsuarioEnvia'
				#,CONCAT(US_REC.NombreUsuario, ' ', US_REC.ApellidoPaternoUsuario, ' ', US_REC.ApellidoMaternoUsuario) AS 'NombreUsuarioRecibe', 
				,US_REC.NombreUsuario as NombreUsuarioRecibe 
				,US_REC.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioRecibe 
				,US_REC.ApellidoMaternoUsuario as ApellidoMaternoUsuarioRecibe 
				,US_REC.ImagenPerfilUsuario AS 'ImagenUsuarioRecibe'
                
			FROM mensajes as MSJ
		
        INNER JOIN usuarios as US_ENV
        ON US_ENV.IdUsuario = MSJ.UsuarioEnvia
        
        INNER JOIN usuarios as US_REC
        ON US_REC.IdUsuario = MSJ.UsuarioRecibe
		
		WHERE (UsuarioEnvia = p_UsuarioEnvia AND UsuarioRecibe = p_UsuarioRecibe) 
        OR (UsuarioEnvia = p_UsuarioRecibe AND UsuarioRecibe = p_UsuarioEnvia)
        ORDER BY FechaCreacionMensaje ASC;
	END IF;
    
    
    
    
    IF p_Opc = 'FiltroBandeja'
    THEN
	
		SELECT 	MSJ.IdMensaje, MSJ.UsuarioEnvia, MSJ.UsuarioRecibe, MSJ.DescripcionMensaje, MSJ.FechaCreacionMensaje, MSJ.EstadoMensaje
				#,CONCAT(US_ENV.NombreUsuario, ' ', US_ENV.ApellidoPaternoUsuario, ' ', US_ENV.ApellidoMaternoUsuario) AS 'NombreUsuarioEnvia', 
				,US_ENV.NombreUsuario as NombreUsuarioEnvia 
				,US_ENV.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioEnvia 
				,US_ENV.ApellidoMaternoUsuario as ApellidoMaternoUsuarioEnvia
				,US_ENV.ImagenPerfilUsuario AS 'ImagenUsuarioEnvia'
				#,CONCAT(US_REC.NombreUsuario, ' ', US_REC.ApellidoPaternoUsuario, ' ', US_REC.ApellidoMaternoUsuario) AS 'NombreUsuarioRecibe', 
				,US_REC.NombreUsuario as NombreUsuarioRecibe 
				,US_REC.ApellidoPaternoUsuario  as ApellidoPaternoUsuarioRecibe 
				,US_REC.ApellidoMaternoUsuario as ApellidoMaternoUsuarioRecibe 
				,US_REC.ImagenPerfilUsuario AS 'ImagenUsuarioRecibe'
		FROM mensajes AS MSJ 
                
		INNER JOIN usuarios AS US_ENV
		ON US_ENV.IdUsuario = MSJ.UsuarioEnvia
        
		INNER JOIN usuarios AS US_REC
		ON US_REC.IdUsuario = MSJ.UsuarioRecibe
        
		INNER JOIN(
			SELECT
				least(UsuarioEnvia, UsuarioRecibe) AS user_1,
				greatest(UsuarioEnvia, UsuarioRecibe) AS user_2,
				max(FechaCreacionMensaje) AS FechaCreacionMensaje
			FROM mensajes
			GROUP BY	least(UsuarioEnvia, UsuarioRecibe),
						greatest(UsuarioEnvia, UsuarioRecibe)
		) AS LAST_MSJ 
		ON least(UsuarioEnvia, UsuarioRecibe)=user_1
		AND greatest(UsuarioEnvia, UsuarioRecibe)=user_2
		AND MSJ.FechaCreacionMensaje = LAST_MSJ.FechaCreacionMensaje
    
        WHERE (MSJ.UsuarioEnvia = p_UsuarioEnvia
        OR MSJ.UsuarioRecibe = p_UsuarioEnvia)
        AND (US_ENV.NombreUsuario LIKE CONCAT(p_FiltroBandeja,"%") OR US_REC.NombreUsuario LIKE CONCAT(p_FiltroBandeja,"%"))
        GROUP BY MSJ.IdMensaje
        ORDER BY MSJ.FechaCreacionMensaje DESC;


    END IF;
    
    
END$$

DELIMITER ;




