-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME,
    pais VARCHAR(100),
    tipo ENUM('admin', 'usuario') DEFAULT 'usuario',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    foto VARCHAR(255) DEFAULT NULL -- Ruta opcional de la foto
);

-- Crear tabla de preferencias de usuario
CREATE TABLE preferencias_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    disponibilidad_horas INT,
    pais_preferencia VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Crear tabla de habilidades
CREATE TABLE habilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

-- Crear tabla de relación usuario-habilidades
CREATE TABLE usuario_habilidades (
    usuario_id INT NOT NULL,
    habilidad_id INT NOT NULL,
    PRIMARY KEY (usuario_id, habilidad_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (habilidad_id) REFERENCES habilidades(id) ON DELETE CASCADE
);

-- Crear tabla de proyectos
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    creador_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'finalizado', 'pendiente') DEFAULT 'activo',
    pais VARCHAR(100),
    horas_dedicacion INT,
    FOREIGN KEY (creador_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Crear tabla de relación proyecto-habilidades
CREATE TABLE proyecto_habilidades (
    proyecto_id INT NOT NULL,
    habilidad_id INT NOT NULL,
    PRIMARY KEY (proyecto_id, habilidad_id),
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (habilidad_id) REFERENCES habilidades(id) ON DELETE CASCADE
);

-- Crear tabla de participantes de proyecto
CREATE TABLE participantes_proyecto (
    proyecto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    rol VARCHAR(100),
    fecha_union DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (proyecto_id, usuario_id),
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Crear tabla de solicitudes de proyecto
CREATE TABLE solicitudes_proyecto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    mensaje TEXT,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Crear tabla de mensajes
CREATE TABLE mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remitente_id INT NOT NULL,
    destinatario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    solicitud_id INT,
    tipo_aviso ENUM('informativo', 'urgente') DEFAULT 'informativo',
    FOREIGN KEY (remitente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (solicitud_id) REFERENCES solicitudes_proyecto(id) ON DELETE CASCADE
);

-- Crear tabla de suscripciones
CREATE TABLE suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('basica', 'premium') DEFAULT 'basica',
    precio DECIMAL(10,2) NOT NULL,
    duracion_meses INT NOT NULL
);

-- Crear tabla de relación usuario-suscripción
CREATE TABLE usuario_suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    suscripcion_id INT NOT NULL,
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_fin DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (suscripcion_id) REFERENCES suscripciones(id) ON DELETE CASCADE
);

-- Crear tabla de cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    duracion_horas INT,
    insignia_otorgada TINYINT(1) DEFAULT 0,
    suscripcion_id INT,
    FOREIGN KEY (suscripcion_id) REFERENCES suscripciones(id) ON DELETE CASCADE
);

-- Crear tabla de relación usuario-cursos
CREATE TABLE usuario_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_finalizacion DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- Crear tabla de mentores
CREATE TABLE mentores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especialidad VARCHAR(255),
    experiencia TEXT,
    calificaciones VARCHAR(255),
    pais VARCHAR(100),
    tipo_servicio ENUM('consultoria', 'formacion') DEFAULT 'consultoria',
    suscripcion_id INT,
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado_aprobacion ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    fecha_aprobacion DATETIME,
    aprobada_por_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (suscripcion_id) REFERENCES suscripciones(id) ON DELETE CASCADE,
    FOREIGN KEY (aprobada_por_id) REFERENCES usuarios(id) ON DELETE SET NULL
);
