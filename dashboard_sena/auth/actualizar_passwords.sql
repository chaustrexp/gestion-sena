USE dashboard_sena;

-- Actualizar contraseñas con el hash correcto
-- Contraseña: admin123
UPDATE usuarios SET password = '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm' WHERE id = 1;
UPDATE usuarios SET password = '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm' WHERE id = 2;
UPDATE usuarios SET password = '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm' WHERE id = 3;

SELECT 'Contraseñas actualizadas correctamente' as mensaje;
