@echo off
chcp 65001 >nul
title Copiar Cambios al Servidor
color 0A

echo.
echo ═══════════════════════════════════════════════════════════════
echo   COPIAR CAMBIOS AL SERVIDOR XAMPP
echo ═══════════════════════════════════════════════════════════════
echo.

echo Copiando archivos actualizados...
echo.

REM Copiar CSS
xcopy /Y /Q "assets\css\styles.css" "C:\xampp\htdocs\Gestion-sena\dashboard_sena\assets\css\"
if %ERRORLEVEL% EQU 0 (
    echo ✓ CSS copiado
) else (
    echo ✗ Error al copiar CSS
)

REM Copiar Header
xcopy /Y /Q "views\layout\header.php" "C:\xampp\htdocs\Gestion-sena\dashboard_sena\views\layout\"
if %ERRORLEVEL% EQU 0 (
    echo ✓ Header copiado
) else (
    echo ✗ Error al copiar Header
)

REM Copiar Sidebar
xcopy /Y /Q "views\layout\sidebar.php" "C:\xampp\htdocs\Gestion-sena\dashboard_sena\views\layout\"
if %ERRORLEVEL% EQU 0 (
    echo ✓ Sidebar copiado
) else (
    echo ✗ Error al copiar Sidebar
)

REM Copiar Index
xcopy /Y /Q "index.php" "C:\xampp\htdocs\Gestion-sena\dashboard_sena\"
if %ERRORLEVEL% EQU 0 (
    echo ✓ Index copiado
) else (
    echo ✗ Error al copiar Index
)

REM Copiar Favicon
xcopy /Y /Q "assets\images\favicon.svg" "C:\xampp\htdocs\Gestion-sena\dashboard_sena\assets\images\"
if %ERRORLEVEL% EQU 0 (
    echo ✓ Favicon copiado
) else (
    echo ✗ Error al copiar Favicon
)

echo.
echo ═══════════════════════════════════════════════════════════════
echo   ✓ Archivos copiados exitosamente
echo ═══════════════════════════════════════════════════════════════
echo.
echo IMPORTANTE: Ahora en tu navegador presiona:
echo   Ctrl + Shift + R  o  Ctrl + F5
echo.
echo Para limpiar la caché y ver los cambios.
echo.
echo ═══════════════════════════════════════════════════════════════
echo.

pause
