# 🚀 Guía Rápida - Sistema de Roles

## ¿Qué se implementó?

El sistema ahora tiene **dos roles de usuario**:

1. **👨‍💼 Administrador** - Acceso completo
2. **👥 Coordinador** - Acceso según su coordinación

---

## ⚡ Inicio Rápido (3 pasos)

### 1️⃣ Verificar el Sistema

Abrir en el navegador:
```
http://localhost/Gestion-sena/dashboard_sena/verificar_roles.php
```

Este script verifica:
- ✅ Tabla ADMINISTRADOR existe
- ✅ Tabla COORDINACION existe
- ✅ Archivos del sistema están presentes
- ✅ Usuarios de prueba configurados

### 2️⃣ Crear Usuarios de Prueba (si es necesario)

**Para Administrador:**
```
http://localhost/Gestion-sena/dashboard_sena/agregar_tabla_admin.php
```

**Para Coordinador:**
```
http://localhost/Gestion-sena/dashboard_sena/crear_coordinador_prueba.php
```

### 3️⃣ Probar el Login

Ir a:
```
http://localhost/Gestion-sena/dashboard_sena/auth/login.php
```

**Credenciales de Administrador:**
- Email: `admin@sena.edu.co`
- Password: `password`
- Rol: Seleccionar "Administrador"

**Credenciales de Coordinador:**
- Email: `coordinador@sena.edu.co`
- Password: `password`
- Rol: Seleccionar "Coordinador"

---

## 🎯 Características Principales

### Login Mejorado
- ✨ Diseño vertical moderno
- 🎨 Colores institucionales SENA
- 🔘 Selector visual de roles
- 📱 Responsive (móvil y desktop)
- 🖼️ Fondo institucional

### Seguridad
- 🔒 Contraseñas hasheadas con `password_hash()`
- 🛡️ Verificación de sesión en cada página
- ⏰ Registro de último acceso
- 🚫 Estados de usuario (Activo/Inactivo)

### Sesiones
Cada rol tiene sus propias variables de sesión:
- `usuario_id` - ID del usuario
- `usuario_nombre` - Nombre completo
- `usuario_email` - Correo electrónico
- `usuario_rol` - "Administrador" o "Coordinador"

---

## 📁 Archivos Nuevos

```
dashboard_sena/
├── auth/
│   └── login.php                    ← Login con selector de roles
├── model/
│   └── AdministradorModel.php       ← Modelo CRUD de administradores
├── agregar_tabla_admin.php          ← Crear tabla ADMINISTRADOR
├── crear_coordinador_prueba.php     ← Crear coordinador de prueba
├── verificar_roles.php              ← Verificar configuración
└── _docs/
    ├── SISTEMA_ROLES.md             ← Documentación completa
    └── GUIA_RAPIDA_ROLES.md         ← Esta guía
```

---

## 🔧 Solución Rápida de Problemas

### ❌ "Tabla ADMINISTRADOR no existe"
**Solución:**
```
http://localhost/Gestion-sena/dashboard_sena/agregar_tabla_admin.php
```

### ❌ "Credenciales incorrectas"
**Verificar:**
1. Email correcto (con @sena.edu.co)
2. Password: `password`
3. Rol seleccionado correcto
4. Usuario está Activo

### ❌ "No redirige al dashboard"
**Verificar:**
1. Sesión PHP habilitada
2. Ruta correcta en navegador
3. Base de datos `progsena` existe

### ❌ "Error de conexión"
**Verificar en `conexion.php`:**
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'progsena');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## 📊 Estructura de Base de Datos

### Tabla ADMINISTRADOR (nueva)
```sql
admin_id              INT AUTO_INCREMENT
admin_nombre          VARCHAR(100)
admin_correo          VARCHAR(100) UNIQUE
admin_password        VARCHAR(255)
admin_estado          ENUM('Activo', 'Inactivo')
admin_ultimo_acceso   DATETIME
```

### Tabla COORDINACION (actualizada)
```sql
coord_id                      INT AUTO_INCREMENT
coord_descripcion             VARCHAR(45)
coord_nombre_coordinador      VARCHAR(45)
coord_correo                  VARCHAR(45)
coord_password                VARCHAR(255)  ← Campo agregado
CENTRO_FORMACION_cent_id      INT
```

---

## 🎨 Interfaz

### Página de Login
- Fondo: Imagen institucional SENA
- Layout: Vertical (una columna)
- Selector de roles: Visual con iconos
- Colores: Verde SENA (#39A900)
- Botón: Gradiente verde

### Sidebar
- Perfil de usuario en el footer
- Muestra: Nombre y Rol
- Avatar con inicial del nombre

---

## 🔐 Seguridad Implementada

1. **Contraseñas Hasheadas**
   ```php
   password_hash('password', PASSWORD_DEFAULT)
   password_verify($input, $hash)
   ```

2. **Verificación de Sesión**
   ```php
   require_once 'auth/check_auth.php';
   ```

3. **Estados de Usuario**
   - Solo usuarios "Activo" pueden iniciar sesión

4. **Protección CSRF**
   - Sesiones PHP seguras

---

## 📝 Próximos Pasos Sugeridos

### Funcionalidades Adicionales

1. **Gestión de Administradores**
   - Vista CRUD completa
   - Activar/desactivar usuarios
   - Cambiar contraseñas

2. **Permisos por Rol**
   - Restringir módulos según rol
   - Filtrar datos por centro de formación

3. **Recuperación de Contraseña**
   - Envío de email
   - Token de recuperación

4. **Auditoría**
   - Log de accesos
   - Historial de cambios

---

## 📞 Scripts de Ayuda

| Script | URL | Descripción |
|--------|-----|-------------|
| Verificar Sistema | `/verificar_roles.php` | Diagnóstico completo |
| Crear Admin | `/agregar_tabla_admin.php` | Tabla + usuario admin |
| Crear Coordinador | `/crear_coordinador_prueba.php` | Usuario coordinador |
| Migrar BD | `/migrar_bd.php` | Crear toda la BD |
| Test Conexión | `/test_conexion.php` | Verificar conexión |

---

## ✅ Checklist de Verificación

Antes de usar el sistema, verificar:

- [ ] Base de datos `progsena` existe
- [ ] Tabla `ADMINISTRADOR` creada
- [ ] Tabla `COORDINACION` tiene campo `coord_password`
- [ ] Usuario admin creado (admin@sena.edu.co)
- [ ] Archivo `conexion.php` configurado
- [ ] Login muestra selector de roles
- [ ] Puede iniciar sesión como Administrador
- [ ] Puede iniciar sesión como Coordinador (si creó uno)
- [ ] Dashboard muestra nombre y rol del usuario
- [ ] Logout funciona correctamente

---

## 🎓 Ejemplo de Uso

### Flujo Completo

1. **Usuario abre el login**
   - Ve selector de roles (Administrador / Coordinador)

2. **Selecciona su rol**
   - Click en el rol correspondiente

3. **Ingresa credenciales**
   - Email y contraseña

4. **Sistema valida**
   - Busca en la tabla correspondiente
   - Verifica contraseña hasheada
   - Verifica estado (si es admin)

5. **Crea sesión**
   - Guarda datos del usuario
   - Registra último acceso (si es admin)

6. **Redirige al dashboard**
   - Muestra nombre y rol en sidebar
   - Acceso a módulos según permisos

7. **Usuario trabaja**
   - Todas las páginas verifican sesión
   - Puede cerrar sesión cuando termine

---

## 💡 Tips

- **Desarrollo:** Usar credenciales de prueba
- **Producción:** Cambiar contraseñas por defecto
- **Seguridad:** Usar HTTPS en producción
- **Backup:** Respaldar base de datos regularmente
- **Testing:** Probar ambos roles antes de desplegar

---

**¿Listo para empezar?**

1. Ejecuta `verificar_roles.php`
2. Crea usuarios de prueba si es necesario
3. Inicia sesión en `auth/login.php`
4. ¡Disfruta del sistema! 🎉

---

**Documentación completa:** Ver `SISTEMA_ROLES.md`  
**Última actualización:** Febrero 2026
