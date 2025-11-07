
-- ====================================
-- TABLE: rol
-- ====================================
CREATE TABLE rol (
  id_rol TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre_rol VARCHAR(40),
  descripcion VARCHAR(150),
  PRIMARY KEY (id_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO rol VALUES
(1,'administrador_sistema','gestiona usuarios, configura el sistema y realiza mantenimiento a la base de datos'),
(2,'bibliotecario','registra nuevos libros, gestiona prestamos y devoluciones y atiende a los usuarios'),
(3,'catalogador','se encarga de la entrada detallada de metadatos de nuevos ejemplares'),
(4,'usuario/lector','puede buscar libros, ver su historial de prestamos y reservar ejemplares');

-- ====================================
-- TABLE: usuario
-- ====================================
CREATE TABLE usuario (
  id_usuario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50),
  tipo_usuario VARCHAR(20),
  email VARCHAR(50),
  telefono VARCHAR(20),
  fecha_registro DATE,
  estado VARCHAR(15),
  max_libros TINYINT DEFAULT 3,
  deuda FLOAT DEFAULT 0,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuario VALUES
(101,'ana lopez','estudiante','analopez01@gmail.com','829-525-0944','2025-01-15','activo',3,0),
(102,'juan perez','maestro','perezjuan25@gmail.com','809-710-0045','2025-03-02','activo',3,0),
(103,'maria gomez','estudiante','mariag365@gmail.com','849-263-1035','2025-04-25','inactivo',3,0),
(104,'pedro martinez','estudiante','pedromartinez@gmail.com','849-265-2555','2025-03-10','suspendido',3,0);

-- ====================================
-- TABLE: administrador
-- ====================================
CREATE TABLE administrador (
  id_admin TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario SMALLINT UNSIGNED,
  crear_usuario TINYINT(1) DEFAULT 0,
  cargo VARCHAR(22),
  permisos_especiales VARCHAR(86),
  PRIMARY KEY (id_admin),
  CONSTRAINT fk_admin_usuario FOREIGN KEY (id_usuario)
    REFERENCES usuario(id_usuario) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO administrador VALUES
(1,101,0,'director ejecutivo','acceso a informes financieros'),
(2,102,1,'jefe de adquisiciones','editoriales y gestionar el presupuesto de compra'),
(3,103,1,'tecnico de sistemas','capacidad para reiniciar servidores y realizar copias de seguridad de emergencia'),
(4,104,0,'asistente de prestamos','puede anular multas de usuarios');

-- ====================================
-- TABLE: libro
-- ====================================
CREATE TABLE libro (
  id_libro SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_rol TINYINT UNSIGNED,
  titulo VARCHAR(50),
  autor VARCHAR(40),
  editorial VARCHAR(30),
  anio_publicacion SMALLINT,
  isbn VARCHAR(20),
  categoria VARCHAR(30),
  estado VARCHAR(15),
  PRIMARY KEY (id_libro),
  CONSTRAINT fk_libro_rol FOREIGN KEY (id_rol)
    REFERENCES rol(id_rol) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO libro VALUES
(201,1,'cien años de soledad','gabriel garcia marquez','editorial sur',1967,'978-6071110000','novela','disponible'),
(202,2,'fundamentos de programacion','carlos ruiz','tech press',2018,'978-8426727282','informatica','reservado'),
(203,3,'aventuras en el tiempo','sofia alonzo','joven lector',2022,'978-9588611135','ficcion','perdido'),
(204,4,'el principito','antoine de saint-exupery','salamandra',1943,'978-8478441951','literatura infantil','prestado');

-- ====================================
-- TABLE: inventario
-- ====================================
CREATE TABLE inventario (
  id_inventario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_libro SMALLINT UNSIGNED,
  total_ejemplares TINYINT,
  disponibles TINYINT,
  prestados TINYINT,
  reservados TINYINT,
  fecha_actualizada DATE,
  id_admin TINYINT UNSIGNED,
  PRIMARY KEY (id_inventario),
  CONSTRAINT fk_inventario_libro FOREIGN KEY (id_libro)
    REFERENCES libro(id_libro) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_inventario_admin FOREIGN KEY (id_admin)
    REFERENCES administrador(id_admin) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO inventario VALUES
(301,201,5,4,2,1,'2025-10-03',1),
(302,202,10,9,0,1,'2025-09-25',2),
(303,203,3,3,0,0,'2025-10-15',3),
(304,204,7,0,3,4,'2024-07-18',4);

-- ====================================
-- TABLE: ejemplares
-- ====================================
CREATE TABLE ejemplares (
  id_ejemplar SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_libro SMALLINT UNSIGNED,
  id_inventario SMALLINT UNSIGNED,
  codigo_inventario VARCHAR(9),
  ubicacion VARCHAR(31),
  estado VARCHAR(10),
  PRIMARY KEY (id_ejemplar),
  CONSTRAINT fk_ejemplar_libro FOREIGN KEY (id_libro)
    REFERENCES libro(id_libro) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_ejemplar_inventario FOREIGN KEY (id_inventario)
    REFERENCES inventario(id_inventario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ejemplares VALUES
(401,201,301,'ej-201-01','sala general a-5','prestado'),
(402,202,302,'ej-202-02','seccion tecnologia t-12','disponible'),
(403,203,303,'ej-203-03','sala general a-8','disponible'),
(404,204,304,'ej-204-04','seccion infantil','prestado');

-- ====================================
-- TABLE: control_reservas
-- ====================================
CREATE TABLE control_reservas (
  id_control SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_libro SMALLINT UNSIGNED,
  numero_reservas_activas TINYINT,
  ultima_actualizacion DATETIME,
  PRIMARY KEY (id_control),
  CONSTRAINT fk_control_libro FOREIGN KEY (id_libro)
    REFERENCES libro(id_libro) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO control_reservas VALUES
(903,203,0,'2025-08-10 13:15:48'),
(911,201,1,'2025-09-28 09:45:00'),
(912,202,1,'2025-09-19 11:13:04'),
(914,204,4,'2025-10-21 14:23:00');

-- ====================================
-- TABLE: reservas
-- ====================================
CREATE TABLE reservas (
  id_reserva SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario SMALLINT UNSIGNED,
  id_libro SMALLINT UNSIGNED,
  fecha_reserva DATE,
  fecha_caducidad DATE,
  estado VARCHAR(15),
  PRIMARY KEY (id_reserva),
  CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario)
    REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_reserva_libro FOREIGN KEY (id_libro)
    REFERENCES libro(id_libro) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO reservas VALUES
(801,101,201,'2025-08-25',NULL,'pendiente'),
(802,102,202,'2025-09-15',NULL,'pendiente'),
(803,103,203,'2025-09-25',NULL,'vencida'),
(804,104,204,'2025-10-30',NULL,'en proceso');

-- ====================================
-- TABLE: prestamo
-- ====================================
CREATE TABLE prestamo (
  id_prestamo SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario SMALLINT UNSIGNED,
  id_ejemplar SMALLINT UNSIGNED,
  fecha_prestamo DATE,
  fecha_devolucion_prevista DATE,
  fecha_devolucion_real DATE,
  estado VARCHAR(15),
  PRIMARY KEY (id_prestamo),
  CONSTRAINT fk_prestamo_usuario FOREIGN KEY (id_usuario)
    REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_prestamo_ejemplar FOREIGN KEY (id_ejemplar)
    REFERENCES ejemplares(id_ejemplar) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO prestamo VALUES
(501,101,401,'2025-07-15','2025-07-25','2025-07-27','activo'),
(502,102,402,'2025-06-10','2025-06-25','2025-06-30','devuelto'),
(503,103,403,'2025-08-02','2025-08-10','2025-08-15','perdido'),
(504,104,404,'2025-10-23','2025-11-02','2025-11-05','reservado');

-- ====================================
-- TABLE: renovacion
-- ====================================
CREATE TABLE renovacion (
  id_renovacion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_prestamo SMALLINT UNSIGNED,
  fecha_renovacion DATE,
  fecha_nueva_devolucion DATE,
  PRIMARY KEY (id_renovacion),
  CONSTRAINT fk_renovacion_prestamo FOREIGN KEY (id_prestamo)
    REFERENCES prestamo(id_prestamo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO renovacion VALUES
(601,501,'2025-11-14','2025-11-29'),
(602,502,'2025-11-07','2025-11-22'),
(603,503,'2025-11-17','2025-12-02'),
(604,504,'2025-11-25','2025-12-10');

-- ====================================
-- TABLE: notificacion
-- ====================================
CREATE TABLE notificacion (
  id_notificacion SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario SMALLINT UNSIGNED,
  tipo_notificacion VARCHAR(30),
  fecha_notificacion DATETIME,
  mensaje VARCHAR(255),
  estado VARCHAR(10),
  PRIMARY KEY (id_notificacion),
  CONSTRAINT fk_notificacion_usuario FOREIGN KEY (id_usuario)
    REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO notificacion VALUES
(701,101,'vencimiento de prestamo','2025-03-11 10:00:00','su prestamo del libro vence pronto','no leida'),
(702,102,'devolucion exitosa','2025-03-11 15:30:00','libro devuelto con exito','leida'),
(703,103,'bienvenida','2025-10-25 16:45:00','bienvenido a nuestra biblioteca','no leida'),
(711,101,'vencimiento de prestamo','2025-11-03 10:00:00','su prestamo del libro vence pronto','no leida'),
(712,102,'devolucion exitosa','2025-11-03 15:30:00','libro devuelto con exito','leida'),
(713,103,'bienvenida','2025-10-25 16:45:00','bienvenido a nuestra biblioteca','no leida'),
(714,104,'reserva exitosa','2025-10-29 09:15:25','se ha realizado una reserva','leida');
