# 🔧 Solución Rápida UTF-8

## Problema
Los textos se ven con caracteres raros:
- ❌ `Configuración` → Se ve como `Configuración`
- ❌ `Tecnología` → Se ve como `TecnologÃ­a`
- ❌ `Gestión` → Se ve como `GestiÃ³n`

## Solución en 3 Pasos

### 1️⃣ Ejecutar Script de Reparación

Abre tu navegador y ve a:

```
http://localhost/Gestion-sena/dashboard_sena/REPARAR_UTF8_AHORA.php
```

El script hará:
- ✅ Convertir la base de datos a UTF-8
- ✅ Convertir todas las tablas a UTF-8
- ✅ Reparar todos los datos dañados
- ✅ Mostrar un reporte completo

### 2️⃣ Limpiar Caché del Navegador

Después de ejecutar el script, presiona:

```
Ctrl + F5
```

Esto recarga la página sin usar caché.

### 3️⃣ Verificar

Ve al dashboard y verifica que los textos se vean correctamente:
- ✅ Configuración
- ✅ Tecnología
- ✅ Gestión
- ✅ Formación

## ¿Qué hace el script?

1. **Configura la base de datos** en UTF-8 (utf8mb4_unicode_ci)
2. **Convierte todas las tablas** a UTF-8
3. **Repara los datos** usando conversión de codificación
4. **Verifica** que todo esté correcto
5. **Muestra estadísticas** de lo que se reparó

## Tablas que se reparan

- ✅ titulo_programa
- ✅ centro_formacion
- ✅ sede
- ✅ coordinacion
- ✅ instructor
- ✅ programa
- ✅ competencia
- ✅ ambiente
- ✅ ficha
- ✅ usuarios

## Si algo sale mal

Si el script no funciona:

1. Verifica que XAMPP esté corriendo
2. Verifica que la base de datos se llame `dashboard_sena`
3. Verifica que el usuario sea `root` sin contraseña
4. Revisa los mensajes de error en el script

## Alternativa Manual

Si prefieres hacerlo manualmente:

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `dashboard_sena`
3. Ve a la pestaña "SQL"
4. Ejecuta:

```sql
ALTER DATABASE dashboard_sena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Para cada tabla, ejecuta:

```sql
ALTER TABLE nombre_tabla CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Configuración Actual del Proyecto

Tu proyecto YA tiene la configuración correcta:

✅ **conexion.php** - Usa `utf8mb4` en PDO  
✅ **header.php** - Tiene `<meta charset="UTF-8">`  
✅ **header.php** - Usa `header('Content-Type: text/html; charset=UTF-8')`  
✅ **styles.css** - Importa fuente Inter correctamente  

El problema está solo en los **datos de la base de datos**, no en el código.

## Después de la Reparación

Una vez reparado, los datos quedarán permanentemente corregidos. No necesitarás volver a ejecutar el script.

---

**¿Necesitas ayuda?** Revisa los mensajes del script o contacta al administrador del sistema.
