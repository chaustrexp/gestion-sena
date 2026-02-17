# 🔐 Sistema de Roles - Dashboard SENA

## Descripción General

El sistema ahora soporta dos roles de usuario con diferentes niveles de acceso:

1. **👨‍💼 Administrador** - Acceso completo al sistema
2. **👥 Coordinador** - Acceso limitado según su coordinación

---

## 📋 Estructura de Tablas

### Tabla ADMINISTRADOR

```sql
CREATE TABLE `ADMINISTRADOR` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `admin_nombre` VARCHAR(100) NOT NULL,
  `admin_correo` VARCHAR(100) NOT NULL UNIQUE,
  `admin_password` VARCHAR(255) NOT NULL,
  `admin_estado` ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
  `admin_ultimo_acceso` DATETIME NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Tabla COORDINACION (existente)

La tabla COORDINACION ya existe en la base de datos con los siguientes campos relevantes:
- `coord_id` - ID del coordinador
- `coord_nombre_coordinador` - Nombre completo
- `coord_correo` - Correo electrónico
- `coord_password` - Contraseña hasheada
- `CENTRO_FORMACION_cent_id` - Centro de formación asignado

---

## 🔑 Credenciales por Defecto

### Administrador
- **Email:** `admin@sena.edu.co`
- **Password:** `password`
- **Estado:** Activo

### Coordinadores
Los coordinadores deben ser creados desde el módulo de Coordinación con sus respectivas contraseñas.

---

## 🚀 Flujo de Autenticación

### 1. Página de Login (`auth/login.php`)

El usuario selecciona su rol antes de iniciar sesión:

```php
// Selector de roles
<div class="role-selector">
    <input type="radio" name="rol" value="administrador" checked>
    <input type="radio" name="rol" value="coordinador">
</div>
```

### 2. Validación de Credenciales

El sistema valida según el rol seleccionado:

**Para Administrador:**
```php
$stmt = $db->prepare("SELECT * FROM ADMINISTRADOR WHERE admin_correo = ? AND admin_estado = 'Activo'");
```

**Para Coordinador:**
```php
$stmt = $db->prepare("SELECT * FROM COORDINACION WHERE coord_correo = ?");
```

### 3. Creación de Sesión

Las variables de sesión creadas son:

**Administrador:**
- `$_SESSION['usuario_id']` - admin_id
- `$_SESSION['usuario_nombre']` - admin_nombre
- `$_SESSION['usuario_email']` - admin_correo
- `$_SESSION['usuario_rol']` - "Administrador"

**Coordinador:**
- `$_SESSION['usuario_id']` - coord_id
- `$_SESSION['usuario_nombre']` - coord_nombre_coordinador
- `$_SESSION['usuario_email']` - coord_correo
- `$_SESSION['usuario_rol']` - "Coordinador"
- `$_SESSION['coordinacion_id']` - coord_id
- `$_SESSION['centro_formacion_id']` - CENTRO_FORMACION_cent_id

---

## 🛡️ Protección de Páginas

### Archivo: `auth/check_auth.php`

Todas las páginas del dashboard incluyen este archivo para verificar autenticación:

```php
<?php
require_once __DIR__ . '/auth/check_auth.php';
?>
```

### Funciones Disponibles

```php
// Verificar si el usuario tiene uno de los roles permitidos
verificarRol(['Administrador', 'Coordinador']);

// Obtener nombre del usuario actual
$nombre = getNombreUsuario();

// Obtener rol del usuario actual
$rol = getRolUsuario();
```

---

## 📁 Archivos del Sistema

### Autenticación
- `auth/login.php` - Página de inicio de sesión con selector de roles
- `auth/check_auth.php` - Verificación de sesión activa
- `auth/logout.php` - Cerrar sesión

### Modelos
- `model/AdministradorModel.php` - CRUD de administradores

### Scripts de Configuración
- `agregar_tabla_admin.php` - Crear tabla ADMINISTRADOR e insertar admin por defecto
- `verificar_roles.php` - Verificar configuración del sistema de roles

### Base de Datos
- `_database/estructura_completa_ProgSENA.sql` - Incluye tabla ADMINISTRADOR

---

## 🎨 Interfaz de Usuario

### Diseño del Login

- **Layout vertical** con fondo institucional SENA
- **Selector visual de roles** con iconos
- **Colores institucionales:** Verde SENA (#39A900)
- **Responsive** para móviles y tablets

### Sidebar

El perfil del usuario se muestra en el footer del sidebar:
- Nombre del usuario
- Rol (Administrador o Coordinador)
- Avatar con inicial

---

## ⚙️ Instalación y Configuración

### Paso 1: Verificar Base de Datos

Ejecutar el script de verificación:
```
http://localhost/Gestion-sena/dashboard_sena/verificar_roles.php
```

### Paso 2: Crear Tabla ADMINISTRADOR (si no existe)

Ejecutar el script:
```
http://localhost/Gestion-sena/dashboard_sena/agregar_tabla_admin.php
```

O ejecutar el SQL completo:
```
http://localhost/Gestion-sena/dashboard_sena/migrar_bd.php
```

### Paso 3: Probar Login

1. Ir a: `http://localhost/Gestion-sena/dashboard_sena/auth/login.php`
2. Seleccionar rol "Administrador"
3. Ingresar credenciales:
   - Email: `admin@sena.edu.co`
   - Password: `password`
4. Click en "Iniciar Sesión"

---

## 🔒 Seguridad

### Contraseñas

Todas las contraseñas se almacenan hasheadas usando `password_hash()`:

```php
// Al crear usuario
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Al verificar
if (password_verify($password, $usuario['admin_password'])) {
    // Login exitoso
}
```

### Protección de Sesiones

- Verificación en cada página protegida
- Redirección automática si no está autenticado
- Cierre de sesión seguro

### Estados de Usuario

Los administradores tienen un campo `admin_estado`:
- **Activo:** Puede iniciar sesión
- **Inactivo:** No puede iniciar sesión

---

## 📊 Permisos por Rol

### Administrador
- ✅ Acceso completo a todos los módulos
- ✅ Gestión de programas, fichas, instructores
- ✅ Gestión de ambientes y asignaciones
- ✅ Gestión de competencias
- ✅ Gestión de coordinaciones
- ✅ Gestión de centros de formación

### Coordinador
- ✅ Acceso al dashboard
- ✅ Ver información de su centro de formación
- ⚠️ Permisos limitados (a implementar según necesidades)

> **Nota:** Los permisos específicos del coordinador pueden ser configurados agregando validaciones en cada vista usando `verificarRol()`.

---

## 🔧 Mantenimiento

### Crear Nuevo Administrador

```php
require_once 'model/AdministradorModel.php';

$adminModel = new AdministradorModel();
$adminModel->create([
    'admin_nombre' => 'Nombre Completo',
    'admin_correo' => 'email@sena.edu.co',
    'admin_password' => 'contraseña_segura',
    'admin_estado' => 'Activo'
]);
```

### Actualizar Contraseña

```php
$adminModel->update($admin_id, [
    'admin_nombre' => 'Nombre',
    'admin_correo' => 'email@sena.edu.co',
    'admin_password' => 'nueva_contraseña', // Opcional
    'admin_estado' => 'Activo'
]);
```

### Desactivar Administrador

```php
$adminModel->update($admin_id, [
    'admin_nombre' => 'Nombre',
    'admin_correo' => 'email@sena.edu.co',
    'admin_estado' => 'Inactivo'
]);
```

---

## 🐛 Solución de Problemas

### Error: "Tabla ADMINISTRADOR no existe"

**Solución:** Ejecutar `agregar_tabla_admin.php` o `migrar_bd.php`

### Error: "Credenciales incorrectas"

**Verificar:**
1. Email correcto: `admin@sena.edu.co`
2. Password correcto: `password`
3. Estado del usuario: debe ser "Activo"
4. Rol seleccionado: debe coincidir con el tipo de usuario

### Error: "Campo coord_password no existe"

**Solución:** Agregar el campo a la tabla COORDINACION:
```sql
ALTER TABLE COORDINACION ADD coord_password VARCHAR(255) NOT NULL;
```

### No redirige al dashboard después del login

**Verificar:**
1. Ruta correcta en `header('Location: ...')`
2. Sesión iniciada correctamente
3. Variables de sesión creadas

---

## 📝 Próximos Pasos

### Funcionalidades Sugeridas

1. **Recuperación de contraseña**
   - Envío de email con token
   - Formulario de reset

2. **Gestión de administradores**
   - Vista CRUD completa
   - Activar/desactivar usuarios

3. **Permisos granulares para coordinadores**
   - Definir qué módulos puede ver cada rol
   - Filtrar datos por centro de formación

4. **Auditoría**
   - Registro de accesos
   - Historial de cambios

5. **Autenticación de dos factores (2FA)**
   - Mayor seguridad para administradores

---

## 📞 Soporte

Para problemas o dudas sobre el sistema de roles:

1. Ejecutar `verificar_roles.php` para diagnóstico
2. Revisar logs de errores de PHP
3. Verificar configuración de base de datos en `conexion.php`

---

**Última actualización:** Febrero 2026  
**Versión:** 1.0  
**Estado:** ✅ Implementado y funcional
