-- Base de datos para ADA 6: Proyecto Web con CRUD, Base de Datos y Autenticación
CREATE DATABASE IF NOT EXISTS mi_sitio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mi_sitio_db;

-- Tabla de usuarios para autenticación y sesiones
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol VARCHAR(30) DEFAULT 'administrador',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuario administrador por defecto (Usuario: admin | Contraseña: 123456)
INSERT INTO usuarios (nombre_completo, usuario, password_hash, rol)
VALUES (
    'Juan José Canul Piña',
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'administrador'
) ON DUPLICATE KEY UPDATE usuario = usuario;

-- Tabla principal del proyecto (evolución de la tabla contactos con soporte de estado para desactivar/activar)
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(120) NOT NULL,
    telefono VARCHAR(25) DEFAULT '',
    mensaje TEXT NOT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
