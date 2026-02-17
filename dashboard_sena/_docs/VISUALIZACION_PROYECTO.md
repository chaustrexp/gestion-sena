# 📊 Visualización del Proyecto - Sistema de Gestión SENA

## 🎯 Descripción General

Sistema web de gestión académica para el SENA (Servicio Nacional de Aprendizaje) que permite administrar programas de formación, fichas, instructores, ambientes, asignaciones y competencias.

---

## 🏗️ Arquitectura del Sistema

```
┌─────────────────────────────────────────────────────────────┐
│                    SISTEMA DE GESTIÓN SENA                   │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌─────────────┐    ┌──────────────┐    ┌──────────────┐   │
│  │   USUARIO   │───▶│  NAVEGADOR   │───▶│   SERVIDOR   │   │
│  │ Administrador│    │   Web (UI)   │    │  Apache/PHP  │   │
│  └─────────────┘    └──────────────┘    └──────────────┘   │
│                            │                      │          │
│                            ▼                      ▼          │
│                    ┌──────────────┐    ┌──────────────┐    │
│                    │   Frontend   │    │   Backend    │    │
│                    │  HTML/CSS/JS │    │  PHP + PDO   │    │
│                    └──────────────┘    └──────────────┘    │
│                                               │              │
│                                               ▼              │
│                                    ┌──────────────────┐     │
│                                    │  Base de Datos   │     │
│                                    │  MySQL/MariaDB   │     │
│                                    │   (progsena)     │     │
│                                    └──────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Estructura de Directorios

```
dashboard_sena/
│
├── 📂 auth/                          # Sistema de autenticación
│   ├── login.php                     # Página de login
│   ├── logout.php                    # Cerrar sesión
│   ├── check_auth.php                # Verificar autenticación
│   └── README_LOGIN.md               # Documentación de login
│
├── 📂 model/                         # Modelos de datos (MVC)
│   ├── AdministradorModel.php        # ✅ Gestión de administradores
│   ├── ProgramaModel.php             # ✅ Gestión de programas
│   ├── FichaModel.php                # ✅ Gestión de fichas
│   ├── InstructorModel.php           # ✅ Gestión de instructores
│   ├── CompetenciaModel.php          # ✅ Gestión de competencias
│   ├── AmbienteModel.php             # ✅ Gestión de ambientes
│   ├── SedeModel.php                 # ✅ Gestión de sedes
│   ├── AsignacionModel.php           # ✅ Gestión de asignaciones
│   ├── CoordinacionModel.php         # ✅ Gestión de coordinaciones
│   ├── CentroFormacionModel.php      # ✅ Gestión de centros
│   ├── TituloProgramaModel.php       # ✅ Gestión de títulos
│   ├── CompetenciaProgramaModel.php  # ✅ Relación competencia-programa
│   └── InstruCompetenciaModel.php    # ⚠️ Gestión instructor-competencia
│
├── 📂 views/                         # Vistas (MVC)
│   ├── 📂 layout/                    # Plantillas base
│   │   ├── header.php                # Encabezado común
│   │   ├── sidebar.php               # Menú lateral
│   │   └── footer.php                # Pie de página
│   │
│   ├── 📂 programa/                  # ✅ Gestión de Programas
│   │   ├── index.php                 # Listar programas
│   │   ├── crear.php                 # Crear programa
│   │   ├── editar.php                # ⏳ Editar programa
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 ficha/                     # ✅ Gestión de Fichas
│   │   ├── index.php                 # Listar fichas
│   │   ├── crear.php                 # Crear ficha
│   │   ├── editar.php                # ⏳ Editar ficha
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 instructor/                # ✅ Gestión de Instructores
│   │   ├── index.php                 # Listar instructores
│   │   ├── crear.php                 # Crear instructor
│   │   ├── editar.php                # ⏳ Editar instructor
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 competencia/               # ✅ Gestión de Competencias
│   │   ├── index.php                 # Listar competencias
│   │   ├── crear.php                 # Crear competencia
│   │   ├── editar.php                # ⏳ Editar competencia
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 ambiente/                  # ✅ Gestión de Ambientes
│   │   ├── index.php                 # Listar ambientes
│   │   ├── crear.php                 # Crear ambiente
│   │   ├── editar.php                # ⏳ Editar ambiente
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 sede/                      # ✅ Gestión de Sedes
│   │   ├── index.php                 # Listar sedes
│   │   ├── crear.php                 # Crear sede
│   │   ├── editar.php                # ⏳ Editar sede
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 asignacion/                # ✅ Gestión de Asignaciones
│   │   ├── index.php                 # Listar asignaciones
│   │   ├── crear.php                 # Crear asignación
│   │   ├── editar.php                # ⏳ Editar asignación
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 coordinacion/              # ✅ Gestión de Coordinaciones
│   │   ├── index.php                 # Listar coordinaciones
│   │   ├── crear.php                 # Crear coordinación
│   │   ├── editar.php                # ⏳ Editar coordinación
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 centro_formacion/          # ✅ Gestión de Centros
│   │   ├── index.php                 # Listar centros
│   │   ├── crear.php                 # ⏳ Crear centro
│   │   ├── editar.php                # ⏳ Editar centro
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 titulo_programa/           # ✅ Gestión de Títulos
│   │   ├── index.php                 # Listar títulos
│   │   ├── crear.php                 # ⏳ Crear título
│   │   ├── editar.php                # ⏳ Editar título
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   ├── 📂 competencia_programa/      # ✅ Relación Competencia-Programa
│   │   ├── index.php                 # Listar relaciones
│   │   ├── crear.php                 # Crear relación
│   │   └── ver.php                   # ⏳ Ver detalles
│   │
│   └── 📂 instru_competencia/        # ⚠️ Instructor-Competencia
│       ├── index.php                 # ⏳ Listar relaciones
│       ├── crear.php                 # ⏳ Crear relación
│       ├── editar.php                # ⏳ Editar relación
│       └── ver.php                   # ⏳ Ver detalles
│
├── 📂 assets/                        # Recursos estáticos
│   ├── 📂 css/
│   │   ├── styles.css                # Estilos principales
│   │   └── theme-enhanced.css        # Tema SENA
│   └── 📂 images/
│       ├── sena-logo.png             # Logo SENA
│       └── favicon.svg               # Icono del sitio
│
├── 📂 _database/                     # Scripts de base de datos
│   ├── estructura_completa_ProgSENA.sql  # Estructura actual
│   └── nueva_estructura_ProgSENA.sql     # Estructura alternativa
│
├── 📂 _docs/                         # Documentación
│   ├── CAMPOS_BD_REFERENCIA.md       # Referencia de campos
│   ├── CORRECCIONES_CAMPOS_BD.md     # Correcciones realizadas
│   ├── GUIA_PRUEBAS.md               # Guía de testing
│   ├── SISTEMA_ROLES.md              # Sistema de roles
│   └── VISUALIZACION_PROYECTO.md     # Este archivo
│
├── index.php                         # ✅ Dashboard principal
├── conexion.php                      # Conexión a base de datos
├── verificar_y_crear_bd.php          # Verificador de BD
└── insertar_datos_prueba.php         # Datos de prueba

Leyenda:
✅ Funcionando correctamente
⏳ Pendiente de corrección
⚠️ Requiere atención
```

---

## 🗄️ Modelo de Base de Datos

```
┌─────────────────────────────────────────────────────────────────┐
│                    BASE DE DATOS: progsena                       │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────┐         ┌──────────────────┐
│  ADMINISTRADOR   │         │ CENTRO_FORMACION │
├──────────────────┤         ├──────────────────┤
│ admin_id (PK)    │         │ cent_id (PK)     │
│ admin_correo     │         │ cent_nombre      │
│ admin_password   │         └──────────────────┘
└──────────────────┘                  │
                                      │
                    ┌─────────────────┼─────────────────┐
                    │                 │                 │
                    ▼                 ▼                 ▼
         ┌──────────────────┐  ┌──────────┐  ┌──────────────┐
         │   COORDINACION   │  │   SEDE   │  │  INSTRUCTOR  │
         ├──────────────────┤  ├──────────┤  ├──────────────┤
         │ coord_id (PK)    │  │ sede_id  │  │ inst_id (PK) │
         │ coord_descripcion│  │ sede_nom │  │ inst_nombres │
         │ coord_nombre_... │  └──────────┘  │ inst_correo  │
         │ CENTRO_FORM...   │       │        │ CENTRO_FOR...│
         └──────────────────┘       │        └──────────────┘
                  │                 │
                  │                 ▼
                  │         ┌──────────────┐
                  │         │   AMBIENTE   │
                  │         ├──────────────┤
                  │         │ amb_id (PK)  │
                  │         │ amb_nombre   │
                  │         │ SEDE_sede_id │
                  │         └──────────────┘
                  │
                  ▼
         ┌──────────────────┐
         │ TITULO_PROGRAMA  │
         ├──────────────────┤
         │ titpro_id (PK)   │
         │ titpro_nombre    │
         └──────────────────┘
                  │
                  ▼
         ┌──────────────────┐         ┌──────────────────┐
         │    PROGRAMA      │◄────────│   COMPETENCIA    │
         ├──────────────────┤         ├──────────────────┤
         │ prog_codigo (PK) │         │ comp_id (PK)     │
         │ prog_denominacion│         │ comp_nombre_corto│
         │ prog_tipo        │         │ comp_horas       │
         │ TIT_PROGRAMA_... │         └──────────────────┘
         └──────────────────┘                  │
                  │                             │
                  │         ┌───────────────────┘
                  │         │
                  ▼         ▼
         ┌──────────────────────────┐
         │   COMPETxPROGRAMA       │
         ├──────────────────────────┤
         │ PROGRAMA_prog_id (PK,FK) │
         │ COMPETENCIA_comp_id(PK,FK)│
         └──────────────────────────┘
                  │
                  ▼
         ┌──────────────────────────┐
         │  INSTRU_COMPETENCIA     │
         ├──────────────────────────┤
         │ inscomp_id (PK)          │
         │ INSTRUCTOR_inst_id (FK)  │
         │ COMPETxPROGRAMA_... (FK) │
         │ inscomp_vigencia         │
         └──────────────────────────┘

         ┌──────────────────┐
         │      FICHA       │
         ├──────────────────┤
         │ fich_id (PK)     │
         │ PROGRAMA_prog_id │
         │ INSTRUCTOR_...   │
         │ fich_jornada     │
         │ COORDINACION_... │
         │ fich_fecha_ini   │
         │ fich_fecha_fin   │
         └──────────────────┘
                  │
                  ▼
         ┌──────────────────────────┐
         │      ASIGNACION         │
         ├──────────────────────────┤
         │ asig_id (PK)             │
         │ FICHA_fich_id (FK)       │
         │ INSTRUCTOR_inst_id (FK)  │
         │ COMPETENCIA_comp_id (FK) │
         │ AMBIENTE_amb_id (FK)     │
         │ asig_fecha_inicio        │
         │ asig_fecha_fin           │
         │ asig_hora_inicio         │
         │ asig_hora_fin            │
         └──────────────────────────┘
```

---

## 🎨 Interfaz de Usuario

### Paleta de Colores SENA

```
┌─────────────────────────────────────────────────────────┐
│  🟢 Verde Principal:    #39A900  (Botones, acentos)    │
│  🟢 Verde Secundario:   #007832  (Hover, énfasis)      │
│  🟢 Verde Claro:        #E8F5E8  (Fondos, badges)      │
│  ⚪ Blanco:             #FFFFFF  (Fondos principales)   │
│  ⚫ Gris Oscuro:        #1F2937  (Textos principales)   │
│  ⚫ Gris Medio:         #6B7280  (Textos secundarios)   │
│  ⚫ Gris Claro:         #F9FAFB  (Fondos alternos)      │
└─────────────────────────────────────────────────────────┘
```

### Componentes Principales

```
┌─────────────────────────────────────────────────────────┐
│  📱 RESPONSIVE DESIGN                                   │
│  ├─ Desktop: Grid layout, sidebar fijo                  │
│  ├─ Tablet: Grid adaptativo, sidebar colapsable         │
│  └─ Mobile: Stack layout, menú hamburguesa              │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  🎯 COMPONENTES UI                                      │
│  ├─ Tarjetas de estadísticas con iconos                │
│  ├─ Tablas con hover effects                           │
│  ├─ Formularios con validación                         │
│  ├─ Badges de estado (Activo, Pendiente, Finalizado)   │
│  ├─ Botones con iconos (Lucide Icons)                  │
│  └─ Alertas de éxito/error                             │
└─────────────────────────────────────────────────────────┘
```

---

## 🔐 Sistema de Autenticación

```
┌─────────────────────────────────────────────────────────┐
│                    FLUJO DE LOGIN                        │
└─────────────────────────────────────────────────────────┘

    Usuario ingresa credenciales
              │
              ▼
    ┌──────────────────────┐
    │   login.php          │
    │  - Validar formato   │
    │  - Verificar BD      │
    └──────────────────────┘
              │
              ▼
    ┌──────────────────────┐
    │  AdministradorModel  │
    │  - Buscar usuario    │
    │  - Verificar password│
    └──────────────────────┘
              │
              ├─── ✅ Correcto ───▶ Crear sesión ───▶ Dashboard
              │
              └─── ❌ Incorrecto ─▶ Mensaje error ──▶ Login

┌─────────────────────────────────────────────────────────┐
│  CREDENCIALES POR DEFECTO                               │
│  Email:    admin@sena.edu.co                            │
│  Password: password                                     │
└─────────────────────────────────────────────────────────┘
```

---

## 📊 Funcionalidades por Módulo

### ✅ PROGRAMAS
- Listar todos los programas
- Crear nuevo programa
- Ver detalles (⏳ pendiente)
- Editar programa (⏳ pendiente)
- Eliminar programa
- Filtrar por tipo (Técnico, Tecnólogo, etc.)

### ✅ FICHAS
- Listar todas las fichas
- Crear nueva ficha
- Asignar instructor líder
- Definir jornada (Diurna, Nocturna, Mixta)
- Establecer fechas de formación
- Ver detalles (⏳ pendiente)
- Editar ficha (⏳ pendiente)

### ✅ INSTRUCTORES
- Listar todos los instructores
- Crear nuevo instructor
- Gestionar datos de contacto
- Asignar a centro de formación
- Ver detalles (⏳ pendiente)
- Editar instructor (⏳ pendiente)

### ✅ COMPETENCIAS
- Listar todas las competencias
- Crear nueva competencia
- Definir horas de duración
- Ver detalles (⏳ pendiente)
- Editar competencia (⏳ pendiente)

### ✅ AMBIENTES
- Listar todos los ambientes
- Crear nuevo ambiente (código manual)
- Asignar a sede
- Ver detalles (⏳ pendiente)
- Editar ambiente (⏳ pendiente)

### ✅ ASIGNACIONES
- Listar todas las asignaciones
- Crear nueva asignación
- Vista de calendario
- Estados: Activa, Pendiente, Finalizada
- Asignar instructor, ficha, ambiente, competencia
- Definir fechas y horarios
- Ver detalles (⏳ pendiente)
- Editar asignación (⏳ pendiente)

### ✅ COORDINACIONES
- Listar todas las coordinaciones
- Crear nueva coordinación
- Gestionar coordinadores
- Ver detalles (⏳ pendiente)
- Editar coordinación (⏳ pendiente)

---

## 🔄 Flujo de Trabajo Típico

```
1. CONFIGURACIÓN INICIAL
   ├─ Crear Centros de Formación
   ├─ Crear Sedes
   ├─ Crear Ambientes
   └─ Crear Coordinaciones

2. GESTIÓN ACADÉMICA
   ├─ Crear Títulos de Programa
   ├─ Crear Programas
   ├─ Crear Competencias
   └─ Relacionar Competencias con Programas

3. GESTIÓN DE PERSONAL
   ├─ Registrar Instructores
   └─ Asignar Competencias a Instructores

4. GESTIÓN DE FICHAS
   ├─ Crear Fichas
   ├─ Asignar Programa
   ├─ Asignar Instructor Líder
   └─ Definir Jornada y Fechas

5. PROGRAMACIÓN
   ├─ Crear Asignaciones
   ├─ Asignar Instructor
   ├─ Asignar Ambiente
   ├─ Asignar Competencia
   └─ Definir Horarios
```

---

## 📈 Estado Actual del Proyecto

### ✅ Completado (80%)

1. **Sistema de Autenticación**
   - Login funcional
   - Sesiones seguras
   - Protección de rutas

2. **Dashboard Principal**
   - Estadísticas generales
   - Últimas asignaciones
   - Navegación intuitiva

3. **Módulos CRUD (Listar + Crear)**
   - Programas
   - Fichas
   - Instructores
   - Competencias
   - Ambientes
   - Sedes
   - Asignaciones
   - Coordinaciones
   - Centros de Formación
   - Títulos de Programa
   - Competencia-Programa

4. **Base de Datos**
   - Estructura completa
   - Relaciones definidas
   - Charset UTF-8

5. **Diseño UI/UX**
   - Responsive design
   - Colores institucionales SENA
   - Iconografía (Lucide Icons)
   - Efectos hover
   - Badges de estado

### ⏳ Pendiente (20%)

1. **Funcionalidades de Edición**
   - Archivos editar.php de todos los módulos
   - Validación de formularios de edición

2. **Funcionalidades de Visualización**
   - Archivos ver.php de todos los módulos
   - Vistas detalladas con información completa

3. **Módulos Especiales**
   - Instru_Competencia (completo)
   - Detalle_Asignacion (completo)

4. **Mejoras**
   - Búsqueda y filtros avanzados
   - Exportación de datos (PDF, Excel)
   - Reportes estadísticos
   - Validaciones JavaScript

---

## 🚀 Cómo Usar el Sistema

### 1. Acceso Inicial

```
URL: http://localhost/Gestion-sena/dashboard_sena/
```

### 2. Login

```
Email:    admin@sena.edu.co
Password: password
```

### 3. Navegación

```
Dashboard Principal
    │
    ├─ 📚 Gestión Académica
    │   ├─ Programas
    │   ├─ Fichas
    │   ├─ Competencias
    │   ├─ Título de Programa
    │   └─ Competencia-Programa
    │
    ├─ 👥 Gestión de Personal
    │   ├─ Instructores
    │   ├─ Coordinaciones
    │   └─ Instru-Competencia
    │
    ├─ 🏢 Infraestructura
    │   ├─ Centros de Formación
    │   ├─ Sedes
    │   └─ Ambientes
    │
    └─ 📅 Programación
        └─ Asignaciones
```

### 4. Crear Registros

```
1. Seleccionar módulo del menú lateral
2. Clic en botón "Nuevo [Módulo]"
3. Llenar formulario
4. Clic en "Guardar"
5. Verificar mensaje de éxito
```

---

## 🛠️ Tecnologías Utilizadas

```
┌─────────────────────────────────────────────────────────┐
│  BACKEND                                                 │
│  ├─ PHP 7.4+                                            │
│  ├─ PDO (PHP Data Objects)                              │
│  ├─ MySQL/MariaDB                                       │
│  └─ Arquitectura MVC                                    │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  FRONTEND                                                │
│  ├─ HTML5                                               │
│  ├─ CSS3 (Inline + External)                           │
│  ├─ JavaScript (Vanilla)                                │
│  ├─ Lucide Icons                                        │
│  └─ FullCalendar (para asignaciones)                   │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  SEGURIDAD                                               │
│  ├─ password_hash() / password_verify()                 │
│  ├─ htmlspecialchars() (XSS protection)                 │
│  ├─ Prepared Statements (SQL Injection protection)      │
│  └─ Session management                                  │
└─────────────────────────────────────────────────────────┘
```

---

## 📝 Notas Importantes

### Campos Especiales

1. **amb_id (AMBIENTE)**
   - NO es AUTO_INCREMENT
   - Se ingresa manualmente
   - Formato: "A101", "B205", etc.

2. **Contraseñas**
   - Siempre hasheadas con `password_hash()`
   - Verificadas con `password_verify()`

3. **Foreign Keys**
   - Formato: `TABLA_campo_id`
   - Ejemplo: `PROGRAMA_prog_id`, `INSTRUCTOR_inst_id`

### Prefijos de Campos

```
prog_     → Programa
fich_     → Ficha
inst_     → Instructor
comp_     → Competencia
amb_      → Ambiente
sede_     → Sede
cent_     → Centro Formación
coord_    → Coordinación
titpro_   → Título Programa
asig_     → Asignación
inscomp_  → Instructor Competencia
admin_    → Administrador
```

---

## 🎯 Próximos Pasos

1. ✅ Completar archivos editar.php
2. ✅ Completar archivos ver.php
3. ✅ Implementar búsqueda y filtros
4. ✅ Agregar validaciones JavaScript
5. ✅ Implementar exportación de datos
6. ✅ Crear reportes estadísticos
7. ✅ Optimizar rendimiento
8. ✅ Testing completo

---

**Última actualización:** Febrero 17, 2026  
**Versión:** 1.0  
**Estado:** En desarrollo activo
