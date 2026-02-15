@echo off
echo Creando directorios para vistas restantes...

mkdir "views\asignacion" 2>nul
mkdir "views\competencia" 2>nul
mkdir "views\competencia_programa" 2>nul
mkdir "views\detalle_asignacion" 2>nul
mkdir "views\sede" 2>nul
mkdir "views\coordinacion" 2>nul
mkdir "views\centro_formacion" 2>nul
mkdir "views\titulo_programa" 2>nul

echo.
echo Directorios creados exitosamente.
echo.
echo NOTA: Las vistas CRUD para estos modulos deben crearse manualmente
echo siguiendo el patron de Programa, Ficha, Instructor y Ambiente.
echo.
echo Estructura de cada modulo:
echo   - index.php  (listado)
echo   - crear.php  (formulario creacion)
echo   - editar.php (formulario edicion)
echo   - ver.php    (vista detalle)
echo.
pause
