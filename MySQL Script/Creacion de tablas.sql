create database hiring_db;
use hiring_db;


CREATE TABLE usuarios (
  IdUsuario 					bigint NOT NULL AUTO_INCREMENT COMMENT 'Identificador del Usuario',
  NombreUsuario 				varchar(30) NOT NULL COMMENT 'Nombre del Usuario' ,
  ApellidoPaternoUsuario 		varchar(30) NOT NULL COMMENT 'Apellido Paterno del Usuario' ,
  ApellidoMaternoUsuario 		varchar(30) NOT NULL COMMENT 'Apellido Materno del Usuario',
  FechaNacimientoUsuario 		date NOT NULL COMMENT 'Fecha en que nació el Usuario' ,
  EscolaridadUsuario			varchar(50) NOT NULL COMMENT 'Escolaridad máxima en la que estudió el Usuario' ,
  ProfesionUsuario 				varchar(100) NOT NULL COMMENT 'Profesion u oficio a lo que se dedica el Usuario' ,
  DescripcionUsuario			varchar(300) NOT NULL COMMENT 'Breve descripción de las aptitudes y habilidades del Usuario en un ambito laboral' ,
  ImagenPerfilUsuario 			mediumblob NOT NULL COMMENT 'Imagen de Perfil del Usuario' ,
  CorreoUsuario 				varchar(60) NOT NULL COMMENT 'Correo del Usuario con el cuál iniciará sesión a la página' ,
  PasswordUsuario 				varchar(30) NOT NULL COMMENT 'Contraseña del Usuario con la cuál iniciará sesión a la página' ,
  FechaCreacionUsuario 			datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en que el Usuario creó su perfil' ,
  EstadoUsuario	 				tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Estado del Usuario (Puede ser 1 si está Activo, 0 si fue dado de baja)' ,
  PRIMARY KEY (IdUsuario),
  UNIQUE KEY idUsuario_UNIQUE (IdUsuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE trabajos (
  IdTrabajo 					bigint NOT NULL AUTO_INCREMENT COMMENT 'Identificador del Trabajo',
  TituloTrabajo 				varchar(100) NOT NULL COMMENT 'Titulo del Trabajo' ,
  DescripcionTrabajo	 		varchar(500) NOT NULL COMMENT 'Descripcion del Trabajo' ,
  PagoTrabajo			 		decimal(19,2) NOT NULL COMMENT 'Pago monetario que se le dara al trabajador contratado',
  StatusTrabajo					varchar(30) NOT NULL COMMENT 'Stuatus actual del Trabajo (Puede ser Borrador, En proceso o Contratado)' ,
  FechaCreacionTrabajo 			datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en que el Trabajo fue creado' ,
  EstadoTrabajo	 				tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Estado del Trabajo (Puede ser 1 si está Activo, 0 si fue dado de baja)' ,
  UsuarioCreador 				bigint NOT NULL COMMENT 'Id del Usuario que creó el Trabajo',
  PRIMARY KEY (IdTrabajo),
  UNIQUE KEY idTrabajo_UNIQUE (IdTrabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE archivos (
  IdArchivo	 					bigint NOT NULL AUTO_INCREMENT COMMENT 'Identificador del Archivo',
  ArchivoData	 				mediumblob NOT NULL COMMENT 'Path del Archivo',
  TrabajoAsignado				bigint NOT NULL COMMENT 'Identificador del Trabajo que tiene los archivos',
  PRIMARY KEY (IdArchivo),
  UNIQUE KEY idArchivo_UNIQUE (IdArchivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE solicitudes (
  UsuarioSolicita 				bigint(20) NOT NULL COMMENT 'Identificador del Usuario que Solicita el Trabajo',
  TrabajoSolicitado 			bigint(20) NOT NULL COMMENT 'Identificador del Trabajo que fue Solicitado por el Usuario',
  StatusSolicitud		 		varchar(30) NOT NULL DEFAULT 'En proceso' COMMENT 'Status de la Solicitud (Puede ser En proceso, Contrado, Rechazado)',
  FechaCreacionSolicitud 		datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en que se realizó la Solicitud',
  FechaRespuestaSolicitud 		datetime DEFAULT NULL COMMENT 'Fecha más reciente en la que el dueño del Trabajo respondió la Solicitud del Trabajo',
  EstadoSolicitud	 			tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Estado del Solicitud (Puede ser 1 si está Activo, 0 si fue dado de baja)',
  PRIMARY KEY (UsuarioSolicita,TrabajoSolicitado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE mensajes (
  IdMensaje 					bigint NOT NULL AUTO_INCREMENT COMMENT 'Identificador del Mensaje',
  UsuarioEnvia 					bigint NOT NULL COMMENT 'Id del Usuario que envió el mensaje',
  UsuarioRecibe 				bigint NOT NULL COMMENT 'Id del Usuario que recibió el mensaje',
  DescripcionMensaje 			varchar(800) NOT NULL COMMENT 'Descripción del Mensaje',
  FechaCreacionMensaje 			datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en que el Usuario creó el Mensaje',
  EstadoMensaje 				tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Estado del Mensaje (Puede ser 1 si está Activo, 0 si fue dado de baja)',
  PRIMARY KEY (IdMensaje),
  UNIQUE KEY IdMensaje_UNIQUE (IdMensaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE trabajos 
ADD INDEX FK_TRAB_USER_idx (UsuarioCreador),
ADD CONSTRAINT FK_TRAB_USER
  FOREIGN KEY (UsuarioCreador)
  REFERENCES usuarios (IdUsuario)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;




ALTER TABLE archivos 
ADD INDEX FK_ARCH_TRAB_idx (TrabajoAsignado),
ADD CONSTRAINT FK_ARCH_TRAB
  FOREIGN KEY (TrabajoAsignado)
  REFERENCES trabajos (IdTrabajo)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;



ALTER TABLE solicitudes 
ADD INDEX FK_SOLI_USER_idx (UsuarioSolicita),
ADD CONSTRAINT FK_SOLI_USER
  FOREIGN KEY (UsuarioSolicita)
  REFERENCES usuarios (IdUsuario)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
  
ALTER TABLE solicitudes 
ADD INDEX FK_SOLI_TRAB_idx (TrabajoSolicitado),
ADD CONSTRAINT FK_SOLI_TRAB
  FOREIGN KEY (TrabajoSolicitado)
  REFERENCES trabajos (IdTrabajo)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;





ALTER TABLE mensajes 
ADD INDEX FK_MSJ_USER_idx (UsuarioEnvia),
ADD CONSTRAINT FK_MSJ_USER_ENV
  FOREIGN KEY (UsuarioEnvia)
  REFERENCES usuarios (IdUsuario)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
  
ALTER TABLE mensajes 
ADD INDEX FK_MSJ_USER_REC_idx (UsuarioRecibe),
ADD CONSTRAINT FK_MSJ_USER_REC
  FOREIGN KEY (UsuarioRecibe)
  REFERENCES usuarios (IdUsuario)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
