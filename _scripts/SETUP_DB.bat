@echo off
echo ═══════════════════════════════════════════════════════════════════
echo   CONFIGURACION DE BASE DE DATOS - GESTION SENA
echo ═══════════════════════════════════════════════════════════════════
echo.

set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe
set DB_NAME=dashboard_sena
set DB_FILE=database.sql

if not exist "%MYSQL_PATH%" (
    echo [ERROR] No se encontro mysql.exe en: %MYSQL_PATH%
    echo Por favor verifica tu instalacion de XAMPP.
    pause
    exit /b
)

echo [1/3] Creando base de datos '%DB_NAME%' si no existe...
"%MYSQL_PATH%" -u root -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Fallo al crear la base de datos.
    echo Asegurate de que MySQL (XAMPP) este corriendo.
    pause
    exit /b
)

echo [2/3] Importando estructura desde '%DB_FILE%'...
"%MYSQL_PATH%" -u root --default-character-set=utf8mb4 %DB_NAME% < "%DB_FILE%"

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Fallo al importar la base de datos.
    pause
    exit /b
)

echo [3/3] Verificando tablas...
"%MYSQL_PATH%" -u root %DB_NAME% -e "SHOW TABLES;"

echo.
echo ═══════════════════════════════════════════════════════════════════
echo   BASE DE DATOS CONFIGURADA CORRECTAMENTE
echo ═══════════════════════════════════════════════════════════════════
echo.
echo Ya puedes ejecutar ABRIR_DASHBOARD.bat
echo.
pause
