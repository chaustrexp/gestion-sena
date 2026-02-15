-- ============================================
-- SCRIPT DE CONVERSIÓN UTF-8 COMPLETO
-- Dashboard SENA - Gestión de Asignaciones
-- ============================================
-- 
-- INSTRUCCIONES:
-- 1. Abre phpMyAdmin
-- 2. Selecciona la base de datos "dashboard_sena"
-- 3. Ve a la pestaña "SQL"
-- 4. Copia y pega este script completo
-- 5. Click en "Continuar"
--
-- ============================================

-- Paso 1: Convertir la base de datos completa
ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Paso 2: Convertir cada tabla a UTF-8

-- Tabla: usuarios
ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: centro_formacion
ALTER TABLE centro_formacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: sede
ALTER TABLE sede CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: coordinacion
ALTER TABLE coordinacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: ambiente
ALTER TABLE ambiente CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: titulo_programa
ALTER TABLE titulo_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: programa
ALTER TABLE programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: competencia
ALTER TABLE competencia CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: competencia_programa
ALTER TABLE competencia_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: ficha
ALTER TABLE ficha CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: instructor
ALTER TABLE instructor CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: asignacion
ALTER TABLE asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla: detalle_asignacion
ALTER TABLE detalle_asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================
-- VERIFICACIÓN
-- ============================================

-- Ver codificación de todas las tablas
SELECT 
    TABLE_NAME AS 'Tabla',
    TABLE_COLLATION AS 'Collation'
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'dashboard_sena'
ORDER BY TABLE_NAME;

-- Ver codificación de todas las columnas de texto
SELECT 
    TABLE_NAME AS 'Tabla',
    COLUMN_NAME AS 'Columna',
    CHARACTER_SET_NAME AS 'Charset',
    COLLATION_NAME AS 'Collation'
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = 'dashboard_sena'
AND DATA_TYPE IN ('varchar', 'text', 'char', 'mediumtext', 'longtext')
ORDER BY TABLE_NAME, COLUMN_NAME;

-- ============================================
-- RESULTADO ESPERADO
-- ============================================
-- 
-- Todas las tablas deben mostrar:
-- - TABLE_COLLATION: utf8mb4_unicode_ci
-- - CHARACTER_SET_NAME: utf8mb4
-- - COLLATION_NAME: utf8mb4_unicode_ci
--
-- ============================================
