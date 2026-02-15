-- ============================================
-- CONVERSIÓN COMPLETA A UTF-8
-- Ejecutar en phpMyAdmin o MySQL Workbench
-- ============================================

-- PASO 1: Convertir la base de datos
ALTER DATABASE dashboard_sena 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- PASO 2: Convertir TODAS las tablas a UTF-8
ALTER TABLE ambiente 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE asignacion 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE centro_formacion 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE competencia 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE competencia_programa 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE coordinacion 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE detalle_asignacion 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE ficha 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE instructor 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE programa 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE sede 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE titulo_programa 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

ALTER TABLE usuarios 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- VERIFICACIÓN: Ver el charset de todas las tablas
SELECT 
    TABLE_NAME,
    TABLE_COLLATION
FROM 
    information_schema.TABLES
WHERE 
    TABLE_SCHEMA = 'dashboard_sena';

-- ============================================
-- RESULTADO ESPERADO:
-- Todas las tablas deben mostrar: utf8mb4_unicode_ci
-- ============================================
