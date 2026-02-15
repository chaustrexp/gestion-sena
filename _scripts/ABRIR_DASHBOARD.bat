@echo off
echo ═══════════════════════════════════════════════════════════════════
echo   INICIANDO DASHBOARD SENA
echo ═══════════════════════════════════════════════════════════════════
echo.

echo [1/4] Verificando servicios XAMPP...
echo.

REM Verificar si Apache está corriendo
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ Apache está corriendo
) else (
    echo ✗ Apache NO está corriendo
    echo.
    echo Por favor, inicia Apache desde XAMPP Control Panel
    echo Presiona cualquier tecla para abrir XAMPP Control Panel...
    pause >nul
    start "" "C:\xampp\xampp-control.exe"
    echo.
    echo Después de iniciar Apache, presiona cualquier tecla para continuar...
    pause >nul
)

echo.
echo [2/4] Verificando MySQL...
echo.

REM Verificar si MySQL está corriendo
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL está corriendo
) else (
    echo ✗ MySQL NO está corriendo
    echo Por favor, inicia MySQL desde XAMPP Control Panel
    pause
)

echo.
echo [3/4] Verificando Base de Datos...
echo.
echo Si es la primera vez, ejecuta SETUP_DB.bat antes de continuar.
echo.

echo.
echo [4/4] Abriendo Dashboard en el navegador...
echo.
timeout /t 2 >nul

REM Abrir en el navegador predeterminado
start http://localhost/Gestion-sena/

echo.
echo ═══════════════════════════════════════════════════════════════════
echo   Dashboard abierto en: http://localhost/Gestion-sena/
echo ═══════════════════════════════════════════════════════════════════
echo.
echo Si ves errores de base de datos, cierra esta ventana y ejecuta:
echo SETUP_DB.bat
echo.
echo Presiona cualquier tecla para cerrar...
pause >nul
