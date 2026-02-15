-- Tabla de usuarios para el sistema de login
USE dashboard_sena;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador', 'Instructor', 'Coordinador') DEFAULT 'Instructor',
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    ultimo_acceso DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar usuarios de ejemplo
-- Password: admin123 (encriptado con password_hash)
INSERT INTO usuarios (nombre, email, password, rol, estado) VALUES
('Administrador SENA', 'admin@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Administrador', 'Activo'),
('Juan Pérez', 'juan.perez@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Instructor', 'Activo'),
('María García', 'maria.garcia@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Coordinador', 'Activo');

-- Nota: Todos los usuarios tienen la contraseña: admin123
