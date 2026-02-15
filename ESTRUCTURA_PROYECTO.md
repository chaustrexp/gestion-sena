# Estructura del Proyecto - Dashboard SENA

## 📁 Organización de Carpetas

### `/dashboard_sena/` - Aplicación Principal
Contiene toda la aplicación web del dashboard SENA con su estructura MVC completa.

### `/_scripts/` - Scripts de Ejecución
- `ABRIR_DASHBOARD.bat` - Inicia el dashboard en el navegador
- `SETUP_DB.bat` - Configura la base de datos inicial
- `crear_vistas_restantes.bat` - Crea vistas adicionales en la BD

### `/_database/` - Archivos SQL
- `database.sql` - Estructura principal de la base de datos
- `CONVERTIR_UTF8_COMPLETO.sql` - Conversión completa a UTF-8
- `corregir_utf8.sql` - Correcciones de codificación
- `FIX_ENCODING.sql` - Reparación de encoding
- `limpiar_datos.sql` - Limpieza de datos
- `REPARAR_UTF8_COMPLETO.sql` - Reparación completa UTF-8

### `/_docs/` - Documentación
- Guías de uso y configuración
- Instrucciones de instalación
- Documentación del proyecto

### `/_setup/` - Configuración Inicial
- `conexion.php` - Configuración de conexión a BD
- `generar_vistas.php` - Generador de vistas
- `index.php` - Archivo de redirección
- `index_redirect.php` - Redirección alternativa

### `/_utils/` - Utilidades
- Scripts PHP para reparación de caracteres UTF-8
- Herramientas de mantenimiento

### `/auth/` - Sistema de Autenticación
Sistema de login y autenticación de usuarios.

### `/assets/` - Recursos Estáticos
- `/css/` - Hojas de estilo
- `/images/` - Imágenes del proyecto
- `/img/` - Imágenes adicionales

## 🚀 Inicio Rápido

1. Ejecuta `_scripts/SETUP_DB.bat` (primera vez)
2. Ejecuta `_scripts/ABRIR_DASHBOARD.bat` para abrir el dashboard

## 📝 Notas
- Requiere XAMPP con Apache y MySQL
- La aplicación principal está en `/dashboard_sena/`
