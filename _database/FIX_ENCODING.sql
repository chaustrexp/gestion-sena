-- Script para reparar la codificación de caracteres dañados (Doble Codificación UTF-8)
USE dashboard_sena;

-- Reparar tabla programa
UPDATE programa SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);

-- Reparar tabla titulo_programa
UPDATE titulo_programa SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);
UPDATE titulo_programa SET nivel = CONVERT(BINARY(CONVERT(nivel USING latin1)) USING utf8mb4);

-- Reparar tabla centro_formacion
UPDATE centro_formacion SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);
UPDATE centro_formacion SET direccion = CONVERT(BINARY(CONVERT(direccion USING latin1)) USING utf8mb4);

-- Reparar tabla sede
UPDATE sede SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);
UPDATE sede SET direccion = CONVERT(BINARY(CONVERT(direccion USING latin1)) USING utf8mb4);
UPDATE sede SET ciudad = CONVERT(BINARY(CONVERT(ciudad USING latin1)) USING utf8mb4);

-- Reparar tabla instructor
UPDATE instructor SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);

-- Reparar tabla ambiente
UPDATE ambiente SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);
UPDATE ambiente SET tipo = CONVERT(BINARY(CONVERT(tipo USING latin1)) USING utf8mb4);

-- Reparar tabla competencia
UPDATE competencia SET nombre = CONVERT(BINARY(CONVERT(nombre USING latin1)) USING utf8mb4);
UPDATE competencia SET descripcion = CONVERT(BINARY(CONVERT(descripcion USING latin1)) USING utf8mb4);
