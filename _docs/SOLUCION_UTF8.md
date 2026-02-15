# 🔧 SOLUCIÓN DEFINITIVA UTF-8 - Dashboard SENA

## 📋 DIAGNÓSTICO

Tu problema: **Doble codificación UTF-8**
- Ves: `AnÃ¡lisis`, `TecnologÃ­a`, `GestiÃ³n`
- Deberías ver: `Análisis`, `Tecnología`, `Gestión`

**Causa:** Los datos se guardaron con codificación incorrecta en la base de datos.

---

## ✅ PASO 1: CONFIGURACIÓN PHP (YA ESTÁ CORRECTO)

### 1.1 Conexión PDO a Base de Datos

Tu archivo `conexion.php` ya tiene la configuración correcta:

```php
<?php
$this->conn = new PDO(
    "mysql:host=localhost;dbname=dashboard_sena;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]
);
?>
```

**Si usaras MySQLi (alternativa):**
```php
<?php
$conexion = new mysqli("localhost", "root", "", "dashboard_sena");
$conexion->set_charset("utf8mb4");
?>
```

### 1.2 Meta Tag HTML

Tu `header.php` ya tiene:

```html
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
```

### 1.3 Header PHP

Tu `header.php` ya tiene:

```php
<?php
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
?>
```

---

## 🔴 PASO 2: REPARAR BASE DE DATOS (AQUÍ ESTÁ EL PROBLEMA)

### 2.1 Convertir Estructura de Tablas

Ejecuta este SQL en phpMyAdmin o línea de comandos:

```sql
-- Convertir la base de datos completa
ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Convertir cada tabla (ejecuta para TODAS tus tablas)
ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE centro_formacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE sede CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE coordinacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE ambiente CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE titulo_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE competencia CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE competencia_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE ficha CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE instructor CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE detalle_asignacion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2.2 Reparar Datos Corruptos (Doble Codificación)

Los datos ya están mal guardados. Necesitas repararlos con este script PHP.

---

## 🚀 PASO 3: EJECUTAR SCRIPT DE REPARACIÓN

He creado un script automático que:
1. Detecta columnas de texto en todas las tablas
2. Repara la doble codificación
3. Convierte todo a UTF-8 correcto

**Archivo:** `corregir_datos_utf8.php`

### Cómo usarlo:

1. **Desde el navegador:**
   ```
   http://localhost/Gestion-sena/corregir_datos_utf8.php
   ```

2. **Desde línea de comandos:**
   ```bash
   cd C:\xampp\htdocs\Gestion-sena
   php corregir_datos_utf8.php
   ```

---

## 📝 COMANDOS SQL ÚTILES

### Verificar codificación de tablas:
```sql
SELECT 
    TABLE_NAME,
    TABLE_COLLATION
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'dashboard_sena';
```

### Verificar codificación de columnas:
```sql
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CHARACTER_SET_NAME,
    COLLATION_NAME
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = 'dashboard_sena'
AND DATA_TYPE IN ('varchar', 'text', 'char');
```

---

## ⚠️ IMPORTANTE: BACKUP

**ANTES de ejecutar cualquier script, haz backup:**

```bash
# Desde línea de comandos
cd C:\xampp\mysql\bin
mysqldump -u root dashboard_sena > C:\backup_dashboard_sena.sql
```

**Desde phpMyAdmin:**
1. Selecciona la base de datos `dashboard_sena`
2. Click en "Exportar"
3. Guarda el archivo .sql

---

## 🎯 RESULTADO ESPERADO

Después de ejecutar los pasos:

✅ `Tecnología` (no TecnologÃ­a)
✅ `Gestión` (no GestiÃ³n)
✅ `Análisis` (no AnÃ¡lisis)
✅ `Formación` (no FormaciÃ³n)
✅ `Especialización` (no EspecializaciÃ³n)

---

## 🔍 VERIFICACIÓN FINAL

Después de ejecutar el script, verifica:

1. **En phpMyAdmin:**
   - Abre una tabla
   - Verifica que los datos se vean correctos

2. **En tu aplicación:**
   - Accede a http://localhost/Gestion-sena/
   - Verifica que las tablas muestren texto correcto

3. **Crear nuevo registro:**
   - Crea un registro con tildes
   - Verifica que se guarde y muestre correctamente

---

## 📞 SOPORTE

Si después de ejecutar el script sigues viendo problemas:

1. Verifica que Apache tenga UTF-8 en `httpd.conf`:
   ```
   AddDefaultCharset UTF-8
   ```

2. Verifica `php.ini`:
   ```
   default_charset = "UTF-8"
   ```

3. Reinicia Apache después de cambios en configuración

---

**Fecha:** 13 de febrero de 2026
**Sistema:** Dashboard SENA - Gestión de Asignaciones
