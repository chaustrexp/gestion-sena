# 🔧 Correcciones de Campos de Base de Datos

## Resumen de Correcciones Realizadas

Este documento detalla todas las correcciones aplicadas a las vistas y modelos del dashboard para alinear los nombres de campos con la estructura real de la base de datos `progsena`.

---

## ✅ Módulos Corregidos

### 1. PROGRAMAS
**Archivos:** `views/programa/index.php`, `views/programa/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `codigo` | `prog_codigo` | INT (PK) |
| `nombre` | `prog_denominacion` | VARCHAR(100) |
| `duracion_meses` | ❌ Eliminado | - |
| `titulo_programa_id` | `TIT_PROGRAMA_titpro_id` | INT (FK) |
| - | `prog_tipo` | VARCHAR(50) |

---

### 2. FICHAS
**Archivos:** `views/ficha/index.php`, `views/ficha/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `numero` | `fich_id` | INT (PK) |
| `fecha_inicio` | `fich_fecha_ini_lectiva` | DATE |
| `fecha_fin` | `fich_fecha_fin_lectiva` | DATE |
| - | `fich_jornada` | VARCHAR |
| - | `INSTRUCTOR_inst_id_lider` | INT (FK) |
| - | `COORDINACION_coord_id` | INT (FK) |

---

### 3. COMPETENCIAS
**Archivos:** `views/competencia/index.php`, `views/competencia/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `codigo` | `comp_nombre_corto` | VARCHAR(30) |
| `descripcion` | `comp_nombre_unidad_competencia` | VARCHAR(150) |
| - | `comp_horas` | INT |

---

### 4. INSTRUCTORES
**Archivos:** `views/instructor/index.php`, `views/instructor/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `nombre` | `inst_nombres` + `inst_apellidos` | VARCHAR(45) |
| `documento` | ❌ Eliminado | - |
| `email` | `inst_correo` | VARCHAR(45) |
| `telefono` | `inst_telefono` | BIGINT(10) |
| `centro_formacion_id` | `CENTRO_FORMACION_cent_id` | INT (FK) |

---

### 5. TÍTULO DE PROGRAMA
**Archivos:** `views/titulo_programa/index.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `nombre` | `titpro_nombre` | VARCHAR(45) |
| `nivel` | ❌ Eliminado | - |
| `id` | `titpro_id` | INT (PK) |

---

### 6. CENTRO DE FORMACIÓN
**Archivos:** `views/centro_formacion/index.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `codigo` | `cent_id` | INT (PK) |
| `nombre` | `cent_nombre` | VARCHAR(100) |
| `direccion` | ❌ Eliminado | - |
| `telefono` | ❌ Eliminado | - |

---

### 7. COORDINACIÓN
**Archivos:** `views/coordinacion/index.php`, `views/coordinacion/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `nombre` | `coord_descripcion` | VARCHAR(45) |
| `centro_nombre` | `cent_nombre` (JOIN) | VARCHAR(100) |
| `responsable` | `coord_nombre_coordinador` | VARCHAR(45) |
| - | `coord_correo` | VARCHAR(45) |
| - | `coord_password` | VARCHAR(255) |

---

### 8. AMBIENTES
**Archivos:** `views/ambiente/index.php`, `views/ambiente/crear.php`, `model/AmbienteModel.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `codigo` | `amb_id` | VARCHAR(5) (PK) ⚠️ |
| `nombre` | `amb_nombre` | VARCHAR(45) |
| `capacidad` | ❌ Eliminado | - |
| `tipo` | ❌ Eliminado | - |
| `sede_id` | `SEDE_sede_id` | INT (FK) |

⚠️ **IMPORTANTE:** `amb_id` NO es AUTO_INCREMENT, se ingresa manualmente (Ej: "A101", "B205")

---

### 9. SEDES
**Archivos:** `views/sede/index.php`, `views/sede/crear.php`, `model/SedeModel.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `id` | `sede_id` | INT (PK) |
| `nombre` | `sede_nombre` | VARCHAR(45) |
| `direccion` | ❌ Eliminado | - |
| `ciudad` | ❌ Eliminado | - |

⚠️ **NOTA:** La tabla SEDE solo tiene 2 campos: `sede_id` y `sede_nombre`. No tiene relación con CENTRO_FORMACION.

---

### 10. ASIGNACIONES
**Archivos:** `views/asignacion/index.php`, `model/AsignacionModel.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `id` | `asig_id` | INT (PK) |
| `fecha_inicio` | `asig_fecha_inicio` | DATE |
| `fecha_fin` | `asig_fecha_fin` | DATE |
| `asig_fecha_ini` | `asig_fecha_inicio` | DATE |
| - | `asig_hora_inicio` | TIME |
| - | `asig_hora_fin` | TIME |

---

### 11. COMPETENCIA-PROGRAMA
**Archivos:** `views/competencia_programa/index.php`, `views/competencia_programa/crear.php`

| Campo Anterior | Campo Correcto | Tipo |
|----------------|----------------|------|
| `competencia_id` | `COMPETENCIA_comp_id` | INT (PK, FK) |
| `programa_id` | `PROGRAMA_prog_id` | INT (PK, FK) |
| `horas` | ❌ Eliminado | - |
| `competencia_nombre` | `comp_nombre_corto` (JOIN) | VARCHAR(30) |
| `programa_nombre` | `prog_denominacion` (JOIN) | VARCHAR(100) |

⚠️ **IMPORTANTE:** Esta tabla tiene clave primaria compuesta (prog_id + comp_id)

---

## 🔄 Cambios en Modelos

### AmbienteModel.php
- ✅ Campos actualizados: `amb_id`, `amb_nombre`, `SEDE_sede_id`
- ✅ JOIN con SEDE para obtener `sede_nombre`

### SedeModel.php
- ✅ Campos actualizados: `sede_nombre`, `CENTRO_FORMACION_cent_id`
- ✅ JOIN con CENTRO_FORMACION para obtener `cent_nombre`
- ✅ Métodos create() y update() actualizados

### AsignacionModel.php
- ✅ Campos actualizados: `asig_id`, `asig_fecha_inicio`, `asig_fecha_fin`
- ✅ Agregados: `asig_hora_inicio`, `asig_hora_fin`
- ✅ Todos los métodos actualizados (getAll, getById, create, update, delete, getRecent)

### CompetenciaProgramaModel.php
- ✅ Campos actualizados: `PROGRAMA_prog_id`, `COMPETENCIA_comp_id`
- ✅ Método delete() actualizado para manejar clave compuesta

---

## 🛡️ Mejoras de Seguridad

En todas las vistas se aplicaron:

1. **htmlspecialchars()** para prevenir XSS:
```php
<?php echo htmlspecialchars($registro['campo'] ?? ''); ?>
```

2. **Operador null coalescing (??)** para evitar errores:
```php
<?php echo $registro['campo'] ?? 'Valor por defecto'; ?>
```

3. **Validación de datos** en formularios

---

## 📋 Checklist de Verificación

### Módulos Completamente Corregidos ✅
- [x] Programas (index.php + crear.php)
- [x] Fichas (index.php + crear.php)
- [x] Competencias (index.php + crear.php)
- [x] Instructores (index.php + crear.php)
- [x] Título de Programa (index.php)
- [x] Centro de Formación (index.php)
- [x] Coordinación (index.php + crear.php)
- [x] Ambientes (index.php + crear.php)
- [x] Sedes (index.php + crear.php)
- [x] Asignaciones (index.php)
- [x] Competencia-Programa (index.php + crear.php)

### Pendientes ⏳
- [ ] Archivos editar.php de todos los módulos
- [ ] Archivos ver.php de todos los módulos
- [ ] Instru_Competencia (index.php + crear.php + editar.php + ver.php)
- [ ] Detalle_Asignacion (todos los archivos)

---

## 🎯 Próximos Pasos

1. Corregir archivos `editar.php` y `ver.php` de todos los módulos
2. Probar la creación de registros en cada módulo
3. Verificar que los datos se muestren correctamente
4. Probar las relaciones entre tablas (JOINs)
5. Validar que las eliminaciones funcionen correctamente

---

## 📝 Notas Importantes

### Campos con Prefijos
Todos los campos siguen el patrón: `[prefijo]_[nombre]`
- `prog_` - Programa
- `fich_` - Ficha
- `inst_` - Instructor
- `comp_` - Competencia
- `amb_` - Ambiente
- `sede_` - Sede
- `cent_` - Centro Formación
- `coord_` - Coordinación
- `titpro_` - Título Programa
- `asig_` - Asignación

### Foreign Keys
Siempre usan el nombre completo de la tabla en mayúsculas:
- `PROGRAMA_prog_id`
- `INSTRUCTOR_inst_id`
- `COMPETENCIA_comp_id`
- `CENTRO_FORMACION_cent_id`
- etc.

### IDs Especiales
- `amb_id` (AMBIENTE) - VARCHAR(5), NO AUTO_INCREMENT, se ingresa manualmente
- Todos los demás IDs son INT AUTO_INCREMENT

---

**Última actualización:** Febrero 17, 2026
**Estado:** Correcciones principales completadas, pendientes archivos editar.php y ver.php
