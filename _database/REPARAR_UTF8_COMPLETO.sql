-- ═══════════════════════════════════════════════════════════════════
-- SOLUCIÓN COMPLETA UTF-8 - REPARAR DOBLE CODIFICACIÓN
-- ═══════════════════════════════════════════════════════════════════

-- PASO 1: Convertir la base de datos a UTF-8
ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- PASO 2: Convertir TODAS las tablas a UTF-8
ALTER TABLE ambiente CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE centro_formacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE competencia CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE competencia_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE coordinacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE detalle_asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE ficha CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE instructor CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE sede CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE titulo_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- PASO 3: Reparar datos con doble codificación
-- TecnologÃ­a → Tecnología
-- GestiÃ³n → Gestión

-- titulo_programa
UPDATE titulo_programa SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';
UPDATE titulo_programa SET nivel = CONVERT(CAST(CONVERT(nivel USING latin1) AS BINARY) USING utf8mb4) WHERE nivel LIKE '%Ã%';

-- centro_formacion
UPDATE centro_formacion SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';
UPDATE centro_formacion SET direccion = CONVERT(CAST(CONVERT(direccion USING latin1) AS BINARY) USING utf8mb4) WHERE direccion LIKE '%Ã%';

-- instructor
UPDATE instructor SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';

-- programa
UPDATE programa SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';

-- usuarios
UPDATE usuarios SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';

-- competencia
UPDATE competencia SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';
UPDATE competencia SET descripcion = CONVERT(CAST(CONVERT(descripcion USING latin1) AS BINARY) USING utf8mb4) WHERE descripcion LIKE '%Ã%';

-- coordinacion
UPDATE coordinacion SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';
UPDATE coordinacion SET responsable = CONVERT(CAST(CONVERT(responsable USING latin1) AS BINARY) USING utf8mb4) WHERE responsable LIKE '%Ã%';

-- ambiente
UPDATE ambiente SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';

-- sede
UPDATE sede SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';
UPDATE sede SET direccion = CONVERT(CAST(CONVERT(direccion USING latin1) AS BINARY) USING utf8mb4) WHERE direccion LIKE '%Ã%';

-- ficha
UPDATE ficha SET nombre = CONVERT(CAST(CONVERT(nombre USING latin1) AS BINARY) USING utf8mb4) WHERE nombre LIKE '%Ã%';

-- VERIFICACIÓN
SELECT 'titulo_programa' as tabla, nombre FROM titulo_programa LIMIT 5;
SELECT 'centro_formacion' as tabla, nombre FROM centro_formacion LIMIT 5;
SELECT 'instructor' as tabla, nombre FROM instructor LIMIT 5;
SELECT 'programa' as tabla, nombre FROM programa LIMIT 5;
