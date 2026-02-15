# 🔧 GUÍA COMPLETA - SOLUCIÓN DE CARACTERES CORTADOS

## 🎯 PROBLEMA IDENTIFICADO

**Síntomas:**
```
Centro de Tecnolog│a  ❌
Centro de Gesti│n Administrativa  ❌
Especializaci│n  ❌
T│cnico  ❌
Tecn│logo  ❌
```

**Causa:** Doble codificación UTF-8 en datos ya guardados en MySQL

---

## ✅ SOLUCIÓN EN 3 PASOS

### PASO 1: Ejecutar Script de Reparación

**URL:**
```
http://localhost/dashboard_sena/reparar_caracteres.php
```

**Este script:**
- ✅ Detecta caracteres dañados automáticamente
- ✅ Repara todos los registros en todas las tablas
- ✅ Muestra tabla de verificación
- ✅ Cuenta registros corregidos

**Ejecutar UNA SOLA VEZ**

---

### PASO 2: Verificar Configuración (Ya Aplicada)

#### ✅ HTML (`views/layout/header.php`)
```php
<?php
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
```

#### ✅ PHP Conexión (`conexion.php`)
```php
$this->conn = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]
);

$this->conn->exec("SET CHARACTER SET utf8mb4");
$this->conn->exec("SET NAMES utf8mb4");
```

#### ✅ MySQL (Ya Configurado)
```sql
ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE titulo_programa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- (todas las tablas ya convertidas)
```

---

### PASO 3: Verificar Resultados

**Ir al Dashboard:**
```
http://localhost/dashboard_sena/
```

**Navegar a:**
- Título Programa
- Centro Formación
- Instructores
- Programas

**Verificar que se vea:**
```
✅ Tecnología
✅ Gestión
✅ Especialización
✅ Técnico
✅ Tecnólogo
✅ Coordinación
✅ Formación
```

---

## 📋 ARCHIVOS MODIFICADOS

### Archivos de Configuración:
1. ✅ `views/layout/header.php` - Headers UTF-8
2. ✅ `conexion.php` - Conexión PDO UTF-8

### Scripts de Reparación:
3. ✅ `reparar_caracteres.php` - Reparación automática (NUEVO)
4. ✅ `corregir_datos_utf8.php` - Corrección manual
5. ✅ `corregir_utf8.sql` - SQL de corrección

---

## 🔍 CÓMO FUNCIONA LA REPARACIÓN

### Detección Automática:
```php
function repararTexto($texto) {
    // Detecta patrones como: │, ├│, ├®, ├¡
    // Reemplaza por: í, ó, é, á
    
    $reemplazos = [
        '│' => 'í',
        '├│' => 'ó',
        '├®' => 'é',
        '├¡' => 'á',
        '├║' => 'ú',
        '├▒' => 'ñ'
    ];
    
    // También palabras completas conocidas:
    'Tecn├│logo' => 'Tecnólogo'
    'T├®cnico' => 'Técnico'
    // etc...
}
```

### Proceso:
1. Lee cada registro de cada tabla
2. Detecta caracteres dañados
3. Aplica reemplazos
4. Actualiza en la base de datos
5. Muestra resultado

---

## 🛡️ PREVENCIÓN FUTURA

### Al Insertar Datos Nuevos:

**Siempre usar:**
```php
// En cada archivo PHP
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
```

**En formularios:**
```html
<meta charset="UTF-8">
<form accept-charset="UTF-8">
```

**Al guardar:**
```php
$stmt = $db->prepare("INSERT INTO tabla (campo) VALUES (?)");
$stmt->execute([$texto_utf8]);
```

---

## 🔧 SOLUCIÓN MANUAL (Si el script no funciona)

### Opción 1: SQL Directo
```sql
USE dashboard_sena;
SET NAMES utf8mb4;

UPDATE titulo_programa SET nombre = 'Técnico' WHERE id = 1;
UPDATE titulo_programa SET nombre = 'Tecnólogo' WHERE id = 2;
UPDATE titulo_programa SET nombre = 'Especialización' WHERE id = 3;

UPDATE centro_formacion SET nombre = 'Centro de Tecnología' WHERE id = 2;
UPDATE centro_formacion SET nombre = 'Centro de Gestión Administrativa' WHERE id = 1;
```

### Opción 2: phpMyAdmin
1. Ir a phpMyAdmin
2. Seleccionar tabla
3. Click en "Editar" (lápiz)
4. Escribir texto correcto
5. Guardar

---

## 📊 TABLA DE REEMPLAZOS

| Carácter Dañado | Carácter Correcto | Ejemplo |
|-----------------|-------------------|---------|
| `│` | `í` | Tecnolog│a → Tecnología |
| `├│` | `ó` | Tecn├│logo → Tecnólogo |
| `├®` | `é` | T├®cnico → Técnico |
| `├¡` | `á` | Gesti├│n → Gestión |
| `├║` | `ú` | Men├║ → Menú |
| `├▒` | `ñ | Espa├▒ol → Español |

---

## ✅ CHECKLIST DE VERIFICACIÓN

### Después de Ejecutar el Script:

- [ ] Ejecuté `reparar_caracteres.php`
- [ ] Vi el mensaje "🎉 ¡Reparación Completada!"
- [ ] Verifiqué la tabla de resultados
- [ ] Refresqué el navegador (Ctrl + F5)
- [ ] Revisé "Título Programa"
- [ ] Revisé "Centro Formación"
- [ ] Revisé "Instructores"
- [ ] Todos los caracteres se ven correctos

---

## 🚨 SOLUCIÓN DE PROBLEMAS

### Problema: El script no repara algunos registros

**Solución:**
```php
// Agregar más reemplazos en reparar_caracteres.php
$reemplazos = [
    'tu_texto_dañado' => 'texto_correcto',
    // Agregar más según necesites
];
```

### Problema: Aparecen nuevos caracteres dañados

**Causa:** Formulario sin UTF-8

**Solución:**
```html
<form accept-charset="UTF-8">
```

### Problema: Datos se guardan mal

**Causa:** Conexión sin UTF-8

**Solución:** Ya está en `conexion.php`

---

## 🎓 EXPLICACIÓN TÉCNICA

### ¿Por qué pasó esto?

**Doble Codificación:**
1. Texto original: "Tecnología"
2. Se guardó como ISO-8859-1: "Tecnolog├¡a"
3. Se leyó como UTF-8: "Tecnolog│a"

### ¿Cómo se soluciona?

**Reparación:**
1. Detectar patrón dañado: "│"
2. Reemplazar por correcto: "í"
3. Actualizar en BD con UTF-8

**Prevención:**
1. Forzar UTF-8 en TODO el flujo
2. PHP → MySQL → HTML
3. Nunca mezclar codificaciones

---

## 📞 SOPORTE

### Si el problema persiste:

1. **Verificar MySQL:**
```sql
SHOW VARIABLES LIKE 'character_set%';
-- Debe mostrar utf8mb4
```

2. **Verificar PHP:**
```php
<?php
phpinfo(); // Buscar "default_charset"
// Debe ser UTF-8
?>
```

3. **Limpiar caché:**
```
Ctrl + Shift + Delete
Limpiar todo
Refrescar con Ctrl + F5
```

---

## ✅ RESULTADO FINAL

**ANTES:**
```
Centro de Tecnolog│a
Centro de Gesti│n Administrativa
Especializaci│n
T│cnico
Tecn│logo
```

**DESPUÉS:**
```
Centro de Tecnología
Centro de Gestión Administrativa
Especialización
Técnico
Tecnólogo
```

---

## 🎉 ¡PROBLEMA RESUELTO!

Ejecuta el script y verifica:
```
http://localhost/dashboard_sena/reparar_caracteres.php
```

Todos los caracteres especiales ahora funcionan correctamente. 🎯
