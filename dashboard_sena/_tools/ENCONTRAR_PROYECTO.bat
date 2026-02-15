@echo off
chcp 65001 >nul
title Encontrar Ubicación del Proyecto
color 0E

echo.
echo ═══════════════════════════════════════════════════════════════
echo   ENCONTRAR UBICACIÓN DEL PROYECTO
echo ═══════════════════════════════════════════════════════════════
echo.

echo Ubicación actual de este archivo:
echo %~dp0
echo.

echo ═══════════════════════════════════════════════════════════════
echo   INSTRUCCIONES
echo ═══════════════════════════════════════════════════════════════
echo.
echo 1. Copia la ruta mostrada arriba
echo 2. Abre el Explorador de Windows
echo 3. Pega la ruta en la barra de direcciones
echo 4. Copia TODA la carpeta del proyecto
echo 5. Pégala en: C:\xampp\htdocs\Gestion-sena\
echo.
echo ═══════════════════════════════════════════════════════════════
echo.

pause

echo.
echo ¿Quieres abrir la carpeta actual en el Explorador? (S/N)
set /p respuesta=

if /i "%respuesta%"=="S" (
    explorer "%~dp0"
    echo.
    echo ✓ Explorador abierto
) else (
    echo.
    echo Operación cancelada
)

echo.
echo ═══════════════════════════════════════════════════════════════
echo   PRÓXIMOS PASOS
echo ═══════════════════════════════════════════════════════════════
echo.
echo 1. Copia esta carpeta a: C:\xampp\htdocs\Gestion-sena\
echo 2. Ejecuta: ABRIR_DASHBOARD.bat
echo 3. O abre: http://localhost/Gestion-sena/dashboard_sena/test.php
echo.
echo ═══════════════════════════════════════════════════════════════
echo.

pause
