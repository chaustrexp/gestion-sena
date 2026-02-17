# Migración a Nueva Base de Datos ProgSENA

## 📋 Resumen de Cambios

La nueva estructura de base de datos incluye los siguientes cambios principales:

### 1. Nombre de la Base de Datos
- **Anterior:** `dashboard_sena`
- **Nueva:** `ProgSENA`

### 2. Cambios en Nombres de Tablas y Campos

| Tabla Anterior | Tabla Nueva | Cambios Principales |
|----------------|-------------|---------------------|
| `titulo_programa` | `TITULO_PROGRAMA` | Campos con prefijo `titpro_` |
| `programa` | `PROGRAMA` | Campos con prefijo `prog_` |
| `competencia` | `COMPETENCIA` | Campos con prefijo `comp_` |
| `centro_formacion` | `CENTRO_FORMACION` | Campos con prefijo `cent_` |
| `instructor` | `INSTRUCTOR` | Campos con prefijo `inst_`, agregado `inst_password` |
| `coordinacion` | `COORDINACION` | Campos con prefijo `coord_`, agregado `coord_password` |
| `sede` | `SEDE` | Campos con prefijo `sede_` |
| `ambiente` | `AMBIENTE` | Campos con prefijo `amb_`, `amb_id` ahora es VARCHAR(5) |
| `ficha` | `FICHA` | Campos con prefijo `fich_` |
| `asignacion` | `ASIGNACION` | Campos con prefijo `asig_`, `ASIG_ID` AUTO_INCREMENT |
| `competencia_programa` | `COMPETxPROGRAMA` | Tabla de relación |
| `detalle_asignacion` | `DETALLExASIGNACION` | Nueva estructura con `detasig_` |

### 3. Nuevas Tablas
- `INSTRU_COMPETENCIA`: Relaciona instructores con competencias y programas

### 4. Campos Nuevos Importantes
- `inst_password` en INSTRUCTOR (VARCHAR(255))
- `coord_password` en COORDINACION (VARCHAR(255))
- `prog_tipo` en PROGRAMA (VARCHAR(30))
- `comp_horas` en COMPETENCIA (INT)
- `fich_jornada` en FICHA (VARCHAR(20))

## 🚀 Pasos para Migrar

### Paso 1: Backup de la Base de Datos Actual
```sql
-- Exportar la base de datos actual desde phpMyAdmin
-- O usar mysqldump desde la terminal
mysqldump -u root dashboard_sena > backup_dashboard_sena.sql
```

### Paso 2: Crear la Nueva Base de Datos
1. Abrir phpMyAdmin
2. Ir a la pestaña "SQL"
3. Ejecutar el archivo: `_database/nueva_estructura_ProgSENA.sql`

### Paso 3: Verificar la Conexión
1. Abrir en el navegador: `http://localhost/Gestion-sena/dashboard_sena/test_conexion.php`
2. Verificar que la conexión a `ProgSENA` sea exitosa

### Paso 4: Insertar Datos de Prueba (Opcional)
1. Abrir: `http://localhost/Gestion-sena/dashboard_sena/test_insertar_datos.php`
2. Hacer clic en "Insertar Datos de Prueba"

## 📝 Mapeo de Campos

### TITULO_PROGRAMA
```
id → titpro_id
nombre → titpro_nombre
```

### PROGRAMA
```
id → prog_codigo
codigo → prog_codigo
nombre → prog_denominacion
titulo_programa_id → TIT_PROGRAMA_titpro_id
[NUEVO] → prog_tipo
```

### COMPETENCIA
```
id → comp_id
codigo → comp_nombre_corto
nombre → comp_nombre_unidad_competencia
[NUEVO] → comp_horas
```

### CENTRO_FORMACION
```
id → cent_id
nombre → cent_nombre
```

### INSTRUCTOR
```
id → inst_id
nombre → inst_nombres + inst_apellidos (separados)
email → inst_correo
telefono → inst_telefono
centro_formacion_id → CENTRO_FORMACION_cent_id
[NUEVO] → inst_password
```

### COORDINACION
```
id → coord_id
nombre → coord_descripcion
sede_id → CENTRO_FORMACION_cent_id
[NUEVO] → coord_nombre_coordinador
[NUEVO] → coord_correo
[NUEVO] → coord_password
```

### SEDE
```
id → sede_id
nombre → sede_nombre
```

### AMBIENTE
```
id → amb_id (ahora VARCHAR(5))
nombre → amb_nombre
sede_id → SEDE_sede_id
```

### FICHA
```
id → fich_id
numero → fich_id
programa_id → PROGRAMA_prog_id
fecha_inicio → fich_fecha_ini_lectiva
fecha_fin → fich_fecha_fin_lectiva
[NUEVO] → INSTRUCTOR_inst_id_lider
[NUEVO] → fich_jornada
[NUEVO] → COORDINACION_coord_id
```

### ASIGNACION
```
id → ASIG_ID (AUTO_INCREMENT)
ficha_id → FICHA_fich_id
instructor_id → INSTRUCTOR_inst_id
ambiente_id → AMBIENTE_amb_id
competencia_id → COMPETENCIA_comp_id
fecha_inicio → asig_fecha_ini (DATETIME)
fecha_fin → asig_fecha_fin (DATETIME)
```

## ✅ Archivos Actualizados

Los siguientes archivos ya han sido actualizados para trabajar con la nueva estructura:

### Configuración
- ✅ `conexion.php` - Actualizado a `ProgSENA`

### Modelos
- ✅ `model/TituloProgramaModel.php`
- ✅ `model/ProgramaModel.php`
- ✅ `model/CompetenciaModel.php`
- ✅ `model/CentroFormacionModel.php`
- ✅ `model/InstructorModel.php`
- ✅ `model/CoordinacionModel.php`
- ✅ `model/SedeModel.php`
- ✅ `model/AmbienteModel.php`
- ✅ `model/FichaModel.php`
- ✅ `model/AsignacionModel.php`
- ✅ `model/CompetenciaProgramaModel.php`
- ✅ `model/DetalleAsignacionModel.php`

### Vistas
- ⚠️ Las vistas necesitarán actualizarse para usar los nuevos nombres de campos

## 🔧 Tareas Pendientes

1. **Actualizar todas las vistas** para usar los nuevos nombres de campos
2. **Migrar datos existentes** de `dashboard_sena` a `ProgSENA` (si es necesario)
3. **Actualizar formularios** para incluir nuevos campos obligatorios
4. **Implementar sistema de autenticación** usando los campos de password
5. **Crear vistas para nuevas tablas** (INSTRU_COMPETENCIA, DETALLExASIGNACION)

## 📞 Soporte

Si encuentras algún problema durante la migración:
1. Verifica que XAMPP esté corriendo (Apache y MySQL)
2. Revisa los logs de errores de PHP
3. Usa los scripts de diagnóstico en `test_conexion.php` y `test_insertar_datos.php`

## 🎯 Próximos Pasos

1. Ejecutar el script SQL para crear la base de datos
2. Verificar la conexión
3. Actualizar las vistas una por una
4. Probar cada módulo después de actualizar

---

**Fecha de Migración:** 17 de Febrero de 2026  
**Versión:** 2.0  
**Estado:** En Progreso
