# Dashboard Administrativo SENA

Sistema de gestión académica con arquitectura MVC, diseñado con la paleta institucional SENA.

## Características

- ✅ Arquitectura MVC (Modelo-Vista)
- ✅ CRUD completo para 13 módulos
- ✅ Diseño responsive con paleta SENA (#39A900, #007832)
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Relaciones entre tablas (MySQL)
- ✅ Validaciones y mensajes de éxito/error
- ✅ Confirmación de eliminación con JavaScript

## Módulos Implementados

1. **Programa** - Gestión de programas de formación
2. **Ficha** - Administración de fichas de formación
3. **Instructor** - Registro de instructores
4. **Ambiente** - Control de ambientes de aprendizaje
5. **Asignación** - Asignación de recursos
6. **Competencia** - Gestión de competencias
7. **Competencia_Programa** - Relación N:M entre competencias y programas
8. **Detalle_Asignación** - Detalles de asignaciones
9. **Sede** - Gestión de sedes
10. **Coordinación** - Administración de coordinaciones
11. **Centro_Formación** - Centros de formación
12. **Título_Programa** - Títulos de programas

## Instalación

### Requisitos
- XAMPP (Apache + MySQL + PHP 7.4+)
- Navegador web moderno

### Pasos

1. **Copiar archivos**
   ```
   Copiar la carpeta dashboard_sena a: C:\xampp\htdocs\
   ```

2. **Crear base de datos**
   - Abrir phpMyAdmin: http://localhost/phpmyadmin
   - Importar el archivo: `database.sql`
   - O ejecutar el script SQL completo

3. **Configurar conexión** (opcional)
   - Editar `conexion.php` si usa credenciales diferentes
   - Por defecto: usuario=root, password=vacío

4. **Acceder al sistema**
   ```
   http://localhost/dashboard_sena/
   ```

## Estructura del Proyecto

```
dashboard_sena/
├── index.php                 # Dashboard principal
├── conexion.php             # Conexión PDO a MySQL
├── database.sql             # Script de base de datos
├── README.md                # Este archivo
│
├── model/                   # Modelos (lógica de datos)
│   ├── ProgramaModel.php
│   ├── FichaModel.php
│   ├── InstructorModel.php
│   ├── AmbienteModel.php
│   ├── AsignacionModel.php
│   ├── CompetenciaModel.php
│   ├── CompetenciaProgramaModel.php
│   ├── DetalleAsignacionModel.php
│   ├── SedeModel.php
│   ├── CoordinacionModel.php
│   ├── CentroFormacionModel.php
│   └── TituloProgramaModel.php
│
├── views/                   # Vistas (interfaz)
│   ├── layout/
│   │   ├── header.php      # Encabezado común
│   │   ├── footer.php      # Pie común
│   │   └── sidebar.php     # Menú lateral
│   │
│   ├── programa/           # CRUD Programa
│   │   ├── index.php
│   │   ├── crear.php
│   │   ├── editar.php
│   │   └── ver.php
│   │
│   ├── ambiente/           # CRUD Ambiente
│   │   ├── index.php
│   │   ├── crear.php
│   │   ├── editar.php
│   │   └── ver.php
│   │
│   └── [otros módulos]/    # Estructura similar
│
└── assets/
    └── css/
        └── styles.css      # Estilos con paleta SENA
```

## Paleta de Colores SENA

- **Verde Principal**: #39A900
- **Verde Secundario**: #007832
- **Verde Hover**: #005a25
- **Blanco**: #ffffff
- **Gris Claro**: #f5f5f5

## Funcionalidades por Módulo

Cada módulo incluye:

- **index.php**: Listado con tabla, búsqueda y botones de acción
- **crear.php**: Formulario de creación con validación
- **editar.php**: Formulario de edición precargado
- **ver.php**: Vista detallada de registro

## Base de Datos

### Relaciones Principales

- `programa` → `ficha` (1:N)
- `ficha` → `asignacion` (1:N)
- `instructor` → `asignacion` (1:N)
- `ambiente` → `asignacion` (1:N)
- `competencia` ↔ `programa` (N:M via competencia_programa)
- `asignacion` → `detalle_asignacion` (1:N)

## Uso del Sistema

1. **Dashboard Principal**: Visualiza estadísticas generales
2. **Navegación**: Usa el menú lateral verde para acceder a módulos
3. **Crear Registro**: Click en botón "+ Nuevo [Módulo]"
4. **Editar**: Click en botón "Editar" en la tabla
5. **Ver Detalle**: Click en botón "Ver"
6. **Eliminar**: Click en "Eliminar" (requiere confirmación)

## Tecnologías

- **Backend**: PHP 7.4+ con PDO
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **Arquitectura**: MVC sin frameworks
- **Servidor**: Apache (XAMPP)

## Seguridad

- Consultas preparadas (PDO) para prevenir SQL Injection
- Validación de datos en formularios
- Manejo de errores con try-catch

## Personalización

### Cambiar colores
Editar variables CSS en `assets/css/styles.css`:
```css
:root {
    --verde-principal: #39A900;
    --verde-secundario: #007832;
}
```

### Agregar nuevo módulo
1. Crear modelo en `model/NuevoModuloModel.php`
2. Crear vistas en `views/nuevo_modulo/`
3. Agregar enlace en `views/layout/sidebar.php`

## Soporte

Para problemas comunes:

- **Error de conexión**: Verificar que MySQL esté activo en XAMPP
- **Página en blanco**: Activar display_errors en php.ini
- **Estilos no cargan**: Verificar rutas en header.php

## Créditos

Desarrollado para el SENA - Servicio Nacional de Aprendizaje
Paleta institucional oficial SENA

## Licencia

Uso educativo y administrativo SENA
