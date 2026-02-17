# 📋 Referencia de Campos de Base de Datos

## Guía rápida de nombres de campos para cada tabla

---

## 📚 PROGRAMA
**Tabla:** `PROGRAMA`
**ID:** `prog_codigo` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `prog_codigo` | INT | ID del programa (PK) |
| `prog_denominacion` | VARCHAR(100) | Nombre del programa |
| `TIT_PROGRAMA_titpro_id` | INT | ID del título (FK) |
| `prog_tipo` | VARCHAR(50) | Tipo (Técnico, Tecnólogo, etc.) |

**JOIN:** `TITULO_PROGRAMA` → `titpro_nombre`

---

## 📝 FICHA
**Tabla:** `FICHA`
**ID:** `fich_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `fich_id` | INT | ID de la ficha (PK) |
| `PROGRAMA_prog_id` | INT | ID del programa (FK) |
| `INSTRUCTOR_inst_id_lider` | INT | ID del instructor líder (FK) |
| `fich_jornada` | VARCHAR | Jornada (Diurna, Nocturna, etc.) |
| `COORDINACION_coord_id` | INT | ID de coordinación (FK) |
| `fich_fecha_ini_lectiva` | DATE | Fecha inicio |
| `fich_fecha_fin_lectiva` | DATE | Fecha fin |

**JOIN:** `PROGRAMA` → `prog_denominacion`

---

## 👥 INSTRUCTOR
**Tabla:** `INSTRUCTOR`
**ID:** `inst_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `inst_id` | INT | ID del instructor (PK) |
| `inst_nombres` | VARCHAR(45) | Nombres |
| `inst_apellidos` | VARCHAR(45) | Apellidos |
| `inst_correo` | VARCHAR(45) | Correo electrónico |
| `inst_telefono` | BIGINT(10) | Teléfono |
| `CENTRO_FORMACION_cent_id` | INT | ID del centro (FK) |
| `inst_password` | VARCHAR(255) | Contraseña hasheada |

**JOIN:** `CENTRO_FORMACION` → `cent_nombre`

---

## 🎯 COMPETENCIA
**Tabla:** `COMPETENCIA`
**ID:** `comp_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `comp_id` | INT | ID de la competencia (PK) |
| `comp_nombre_corto` | VARCHAR(30) | Código/nombre corto |
| `comp_horas` | INT | Horas de duración |
| `comp_nombre_unidad_competencia` | VARCHAR(150) | Descripción completa |

---

## 🏢 AMBIENTE
**Tabla:** `AMBIENTE`
**ID:** `amb_id` (VARCHAR - NO AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `amb_id` | VARCHAR(5) | ID del ambiente (PK) - Ej: "A101" |
| `amb_nombre` | VARCHAR(45) | Nombre del ambiente |
| `SEDE_sede_id` | INT | ID de la sede (FK) |

**JOIN:** `SEDE` → `sede_nombre`

---

## 🏫 SEDE
**Tabla:** `SEDE`
**ID:** `sede_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `sede_id` | INT | ID de la sede (PK) |
| `sede_nombre` | VARCHAR(45) | Nombre de la sede |

⚠️ **NOTA:** Esta tabla NO tiene relación con CENTRO_FORMACION en la estructura actual.

---

## 🏛️ CENTRO_FORMACION
**Tabla:** `CENTRO_FORMACION`
**ID:** `cent_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `cent_id` | INT | ID del centro (PK) |
| `cent_nombre` | VARCHAR(100) | Nombre del centro |

---

## 👔 COORDINACION
**Tabla:** `COORDINACION`
**ID:** `coord_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `coord_id` | INT | ID de la coordinación (PK) |
| `coord_descripcion` | VARCHAR(45) | Descripción |
| `CENTRO_FORMACION_cent_id` | INT | ID del centro (FK) |
| `coord_nombre_coordinador` | VARCHAR(45) | Nombre del coordinador |
| `coord_correo` | VARCHAR(45) | Correo electrónico |
| `coord_password` | VARCHAR(255) | Contraseña hasheada |

**JOIN:** `CENTRO_FORMACION` → `cent_nombre`

---

## 📜 TITULO_PROGRAMA
**Tabla:** `TITULO_PROGRAMA`
**ID:** `titpro_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `titpro_id` | INT | ID del título (PK) |
| `titpro_nombre` | VARCHAR(45) | Nombre del título |

---

## 🏆 INSTRU_COMPETENCIA
**Tabla:** `INSTRU_COMPETENCIA`
**ID:** `instcomp_id` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `instcomp_id` | INT | ID (PK) |
| `INSTRUCTOR_inst_id` | INT | ID del instructor (FK) |
| `COMPETENCIA_comp_id` | INT | ID de la competencia (FK) |
| `instcomp_fecha_inicio` | DATE | Fecha inicio |
| `instcomp_fecha_fin` | DATE | Fecha fin |

**JOIN:** 
- `INSTRUCTOR` → `inst_nombres`, `inst_apellidos`
- `COMPETENCIA` → `comp_nombre_corto`

---

## 📅 ASIGNACION
**Tabla:** `ASIGNACION`
**ID:** `ASIG_ID` (AUTO_INCREMENT)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `ASIG_ID` | INT | ID de la asignación (PK) |
| `FICHA_fich_id` | INT | ID de la ficha (FK) |
| `INSTRUCTOR_inst_id` | INT | ID del instructor (FK) |
| `COMPETENCIA_comp_id` | INT | ID de la competencia (FK) |
| `AMBIENTE_amb_id` | VARCHAR(5) | ID del ambiente (FK) |
| `asig_fecha_ini` | DATETIME | Fecha y hora de inicio |
| `asig_fecha_fin` | DATETIME | Fecha y hora de fin |

⚠️ **NOTA IMPORTANTE:** Los campos son DATETIME (incluyen fecha y hora juntos). NO hay campos separados de hora.

**JOIN:**
- `FICHA` → `fich_id`
- `INSTRUCTOR` → `inst_nombres`, `inst_apellidos`
- `COMPETENCIA` → `comp_nombre_corto`
- `AMBIENTE` → `amb_nombre`

---

## 🔗 COMPETxPROGRAMA
**Tabla:** `COMPETxPROGRAMA`
**ID Compuesto:** `PROGRAMA_prog_id` + `COMPETENCIA_comp_id`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `PROGRAMA_prog_id` | INT | ID del programa (PK, FK) |
| `COMPETENCIA_comp_id` | INT | ID de la competencia (PK, FK) |

**JOIN:**
- `PROGRAMA` → `prog_denominacion`
- `COMPETENCIA` → `comp_nombre_corto`

---

## ⚠️ Notas Importantes

### IDs que NO son AUTO_INCREMENT:
- `amb_id` (AMBIENTE) - Se ingresa manualmente (Ej: "A101", "B205")

### Campos de Contraseña:
Siempre usar `password_hash()` y `password_verify()`:
```php
// Al crear/actualizar
$hash = password_hash($password, PASSWORD_DEFAULT);

// Al verificar
if (password_verify($input, $hash)) {
    // Login exitoso
}
```

### Prefijos de Campos:
- `prog_` - Programa
- `fich_` - Ficha
- `inst_` - Instructor
- `comp_` - Competencia
- `amb_` - Ambiente
- `sede_` - Sede
- `cent_` - Centro Formación
- `coord_` - Coordinación
- `titpro_` - Título Programa
- `instcomp_` - Instructor Competencia
- `asig_` - Asignación

### Foreign Keys:
Siempre usar el nombre completo de la tabla en mayúsculas:
- `PROGRAMA_prog_id`
- `INSTRUCTOR_inst_id`
- `COMPETENCIA_comp_id`
- `CENTRO_FORMACION_cent_id`
- etc.

---

**Última actualización:** Febrero 2026
