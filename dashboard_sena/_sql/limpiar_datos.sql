-- Limpiar y reinsertar datos con UTF-8 correcto
USE dashboard_sena;

-- Configurar sesión UTF-8
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Limpiar y reinsertar titulo_programa
DELETE FROM titulo_programa;
INSERT INTO titulo_programa (id, nombre, nivel) VALUES
(1, 'Técnico', 'Técnico'),
(2, 'Tecnólogo', 'Tecnológico'),
(3, 'Especialización', 'Especialización');

-- Actualizar instructores
UPDATE instructor SET nombre = 'Juan Pérez' WHERE id = 1;
UPDATE instructor SET nombre = 'María García' WHERE id = 2;

-- Actualizar usuarios
UPDATE usuarios SET nombre = 'Administrador SENA' WHERE id = 1;
UPDATE usuarios SET nombre = 'Juan Pérez' WHERE id = 2;
UPDATE usuarios SET nombre = 'María García' WHERE id = 3;

-- Verificar
SELECT 'Datos corregidos' as estado;
SELECT * FROM titulo_programa;
