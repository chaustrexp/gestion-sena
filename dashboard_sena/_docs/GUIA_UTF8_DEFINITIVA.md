# 🔧 GUÍA DEFINITIVA UTF-8 - SISTEMA SENA

## ✅ PROBLEMA RESUELTO

Si ves caracteres como:
- `AnÃ¡lisis` en lugar de `Análisis`
- `TecnologÃ­a` en lugar de `Tecnología`
- `GestiÃ³n` en lugar de `Gestión`

Sigue estos pasos **EN ORDEN**:

---

## 📋 PASO 1: CONVERTIR BASE DE DATOS

### Opción A: Usando phpMyAdmin

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `dashboard_sena`
3. Ve a la pestaña **SQL**
4. Copia y pega el contenido del archivo: `CONVERTIR_UTF8_COMPLETO.sql`
5. Haz clic en **Continuar**

### Opción B: Usando MySQL Command Line

```bash
mysql -u root -p dashboard_sena < CONVERTIR_UTF8_COMPLETO.sql
```

### ✅ Verificación

Ejecuta esta consulta en phpMyAdmin:

```sql
SELECT TABLE_NAME, TABLE_COLLATION
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'dashboard_sena';
```

**Resultado esperado:** Todas las tablas deben mostrar `utf8mb4_unicode_ci`

---

## 📋 PASO 2: ACTUALIZAR ARCHIVOS PHP

### ✅ Ya están actualizados:

1. **conexion.php** ✓
   - PDO con charset=utf8mb4
   - SET NAMES utf8mb4
   - SET CHARACTER SET utf8mb4

2. **views/layout/header.php** ✓
   - header('Content-Type: text/html; charset=UTF-8')
   - mb_internal_encoding('UTF-8')
   - <meta charset="UTF-8">

---

## 📋 PASO 3: REPARAR DATOS YA DAÑADOS

Si los datos YA están mal guardados en la base de datos, ejecuta:

```
http://localhost/Gestion-sena/SOLUCION_FINAL_UTF8.php
```

Este script:
- Detecta caracteres con doble codificación
- Repara automáticamente todos los registros
- Muestra estadísticas de reparación

**EJECUTAR UNA SOLA VEZ**

---

## 📋 PASO 4: COPIAR ARCHIVOS AL SERVIDOR

```bash
# Windows (CMD)
copy dashboard_sena\conexion.php C:\xampp\htdocs\Gestion-sena\conexion.php
copy dashboard_sena\views\layout\header.php C:\xampp\htdocs\Gestion-sena\views\layout\header.php
copy dashboard_sena\CONVERTIR_UTF8_COMPLETO.sql C:\xampp\htdocs\Gestion-sena\CONVERTIR_UTF8_COMPLETO.sql
```

---

## 📋 PASO 5: VERIFICAR FUNCIONAMIENTO

1. **Limpia caché del navegador:**
   - Presiona `Ctrl + Shift + Delete`
   - Selecciona "Caché" y "Cookies"
   - Haz clic en "Borrar datos"

2. **Refresca la página:**
   - Presiona `Ctrl + F5` (recarga forzada)

3. **Verifica los datos:**
   - Ve a: `http://localhost/Gestion-sena/`
   - Navega a "Título Programa" o "Centro Formación"
   - Los textos deben verse correctamente:
     - ✅ Tecnología
     - ✅ Gestión
     - ✅ Formación
     - ✅ Análisis

---

## 🔍 SOLUCIÓN DE PROBLEMAS

### Problema: Los caracteres siguen mal

**Solución:**
1. Ejecuta el script de reparación:
   ```
   http://localhost/Gestion-sena/SOLUCION_FINAL_UTF8.php
   ```

2. Verifica que el SQL se ejecutó correctamente:
   ```sql
   SHOW TABLE STATUS FROM dashboard_sena;
   ```
   Todas las tablas deben mostrar `Collation: utf8mb4_unicode_ci`

### Problema: Error de conexión

**Solución:**
1. Verifica que MySQL esté corriendo en XAMPP
2. Verifica las credenciales en `conexion.php`
3. Verifica que la base de datos `dashboard_sena` exista

### Problema: Página en blanco

**Solución:**
1. Activa errores en PHP:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

2. Revisa los logs de Apache:
   ```
   C:\xampp\apache\logs\error.log
   ```

---

## 📝 RESUMEN DE ARCHIVOS MODIFICADOS

### Archivos PHP actualizados:
- ✅ `conexion.php` - Conexión PDO con UTF-8
- ✅ `views/layout/header.php` - Headers UTF-8 y meta tags

### Archivos SQL creados:
- ✅ `CONVERTIR_UTF8_COMPLETO.sql` - Conversión de tablas

### Scripts de reparación:
- ✅ `SOLUCION_FINAL_UTF8.php` - Reparar datos dañados

---

## 🎯 CHECKLIST FINAL

Marca cada paso completado:

- [ ] Ejecuté `CONVERTIR_UTF8_COMPLETO.sql` en phpMyAdmin
- [ ] Verifiqué que todas las tablas están en utf8mb4_unicode_ci
- [ ] Copié `conexion.php` al servidor
- [ ] Copié `views/layout/header.php` al servidor
- [ ] Ejecuté `SOLUCION_FINAL_UTF8.php` (si los datos estaban dañados)
- [ ] Limpié caché del navegador
- [ ] Refresqué con Ctrl + F5
- [ ] Verifiqué que los textos se ven correctamente

---

## ✅ RESULTADO FINAL

Después de seguir todos los pasos:

**ANTES:**
- ❌ TecnologÃ­a
- ❌ GestiÃ³n
- ❌ FormaciÃ³n
- ❌ AnÃ¡lisis

**DESPUÉS:**
- ✅ Tecnología
- ✅ Gestión
- ✅ Formación
- ✅ Análisis

---

## 📞 SOPORTE

Si después de seguir todos los pasos el problema persiste:

1. Verifica que Apache y MySQL estén corriendo
2. Revisa los logs de error
3. Asegúrate de haber ejecutado TODOS los pasos en orden
4. Limpia completamente el caché del navegador

---

**¡Problema resuelto! 🎉**
