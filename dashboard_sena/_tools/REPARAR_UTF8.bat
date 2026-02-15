@echo off
chcp 65001 >nul
title Reparar UTF-8 - Dashboard SENA
color 0A

echo.
echo ═══════════════════════════════════════════════════════════════
echo   REPARACIÓN UTF-8 - DASHBOARD SENA
echo ═══════════════════════════════════════════════════════════════
echo.
echo   Este script abrirá tu navegador para reparar los problemas
echo   de codificación UTF-8 en la base de datos.
echo.
echo   Problema: Configuración → Se ve como "Configuración"
echo   Solución: Reparar datos en la base de datos
echo.
echo ═══════════════════════════════════════════════════════════════
echo.

echo [1/3] Verificando XAMPP...
timeout /t 2 >nul

REM Verificar si Apache está corriendo
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ Apache está corriendo
) else (
    echo ✗ Apache NO está corriendo
    echo.
    echo ⚠️  IMPORTANTE: Debes iniciar XAMPP primero
    echo    1. Abre XAMPP Control Panel
    echo    2. Inicia Apache y MySQL
    echo    3. Vuelve a ejecutar este archivo
    echo.
    pause
    exit
)

REM Verificar si MySQL está corriendo
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL está corriendo
) else (
    echo ✗ MySQL NO está corriendo
    echo.
    echo ⚠️  IMPORTANTE: Debes iniciar MySQL en XAMPP
    echo.
    pause
    exit
)

echo.
echo [2/3] Preparando reparación...
timeout /t 1 >nul

echo.
echo [3/3] Abriendo navegador...
timeout /t 1 >nul

REM Abrir en el navegador predeterminado
start "" "http://localhost/Gestion-sena/dashboard_sena/REPARAR_UTF8_AHORA.php"

echo.
echo ═══════════════════════════════════════════════════════════════
echo   ✓ Navegador abierto
echo ═══════════════════════════════════════════════════════════════
echo.
echo   INSTRUCCIONES:
echo   1. Espera a que el script termine en el navegador
echo   2. Verás un reporte completo con estadísticas
echo   3. Haz clic en "Ir al Dashboard"
echo   4. Presiona Ctrl+F5 para limpiar caché
echo.
echo   Si ves el mensaje "¡Reparación Completada!" todo está OK
echo.
echo ═══════════════════════════════════════════════════════════════
echo.

pause
