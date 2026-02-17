# 🧪 Guía de Pruebas - Dashboard SENA

## 📋 Checklist General

### Preparación
- [ ] Base de datos `progsena` creada
- [ ] Tabla ADMINISTRADOR existe
- [ ] Usuario admin creado
- [ ] Apache y MySQL corriendo
- [ ] Navegador actualizado

---

## 🔐 1. Pruebas de Autenticación

### Login
- [ ] Abrir: `http://localhost/Gestion-sena/dashboard_sena/auth/login.php`
- [ ] Verificar diseño responsive
- [ ] Probar login con credenciales correctas
  - Email: `admin@sena.edu.co`
  - Password: `password`
- [ ] Verificar redirección al dashboard
- [ ] Probar login con credenciales incorrectas
- [ ] Verificar mensaje de error
- [ ] Probar con campos vacíos

### Sesión
- [ ] Verificar que el nombre aparece en el sidebar
- [ ] Verificar que el rol aparece (Administrador)
- [ ] Probar logout
- [ ] Verificar redirección al login después de logout
- [ ] Intentar acceder al dashboard sin sesión

---

## 📊 2. Pruebas del Dashboard Principal

### Estadísticas
- [ ] Verificar que muestra total de Programas
- [ ] Verificar que muestra total de Fichas
- [ ] Verificar que muestra total de Instructores
- [ ] Verificar que muestra total de Ambientes
- [ ] Verificar que muestra total de Asignaciones
- [ ] Verificar que muestra total de Competencias Instructor
- [ ] Verificar contador de competencias vigentes

### Tabla de Últimas Asignaciones
- [ ] Verificar que muestra las últimas 5 asignaciones
- [ ] Verificar formato de fechas (dd/mm/yyyy)
- [ ] Verificar estados (Activa, Pendiente, Finalizada)
- [ ] Verificar colores de badges
- [ ] Probar hover en filas
- [ ] Click en "Ver todas"

### Navegación
- [ ] Verificar que todos los enlaces del sidebar funcionan
- [ ] Verificar iconos de Lucide
- [ ] Verificar hover effects en tarjetas

---

## 📚 3. Módulo: Programas

### Index (Listar)
- [ ] Abrir: `views/programa/index.php`
- [ ] Verificar que muestra todos los programas
- [ ] Verificar paginación (si hay muchos registros)
- [ ] Verificar botón "Crear Nuevo"
- [ ] Verificar botones de acciones (Ver, Editar, Eliminar)
- [ ] Probar búsqueda/filtros (si existen)

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Verificar que el formulario se muestra
- [ ] Campos requeridos:
  - [ ] Denominación del programa
  - [ ] Título del programa (select)
  - [ ] Tipo de programa
- [ ] Crear programa de prueba:
  - Denominación: "Análisis y Desarrollo de Software"
  - Tipo: "Tecnólogo"
- [ ] Verificar mensaje de éxito
- [ ] Verificar redirección a index
- [ ] Verificar que el programa aparece en la lista

### Ver
- [ ] Click en botón "Ver" de un programa
- [ ] Verificar que muestra todos los datos
- [ ] Verificar diseño de la vista
- [ ] Verificar botón "Volver"

### Editar
- [ ] Click en botón "Editar"
- [ ] Verificar que el formulario se llena con datos actuales
- [ ] Modificar algún campo
- [ ] Guardar cambios
- [ ] Verificar mensaje de éxito
- [ ] Verificar que los cambios se guardaron

### Eliminar
- [ ] Click en botón "Eliminar"
- [ ] Verificar confirmación (si existe)
- [ ] Confirmar eliminación
- [ ] Verificar mensaje de éxito
- [ ] Verificar que el registro desapareció

---

## 📝 4. Módulo: Fichas

### Index
- [ ] Abrir: `views/ficha/index.php`
- [ ] Verificar listado de fichas
- [ ] Verificar columnas: Número, Programa, Fecha inicio, Fecha fin

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Campos requeridos:
  - [ ] Número de ficha
  - [ ] Programa (select)
  - [ ] Fecha de inicio
  - [ ] Fecha de fin
- [ ] Crear ficha de prueba:
  - Número: "2024001"
  - Programa: Seleccionar uno existente
  - Fecha inicio: Fecha actual
  - Fecha fin: +6 meses
- [ ] Verificar creación exitosa

### CRUD Completo
- [ ] Ver detalles de una ficha
- [ ] Editar ficha
- [ ] Eliminar ficha

---

## 👥 5. Módulo: Instructores

### Index
- [ ] Abrir: `views/instructor/index.php`
- [ ] Verificar listado de instructores
- [ ] Verificar columnas: Nombres, Apellidos, Correo, Teléfono

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Campos requeridos:
  - [ ] Nombres
  - [ ] Apellidos
  - [ ] Correo
  - [ ] Teléfono
  - [ ] Centro de formación (select)
  - [ ] Contraseña
- [ ] Crear instructor de prueba:
  - Nombres: "Juan Carlos"
  - Apellidos: "Pérez García"
  - Correo: "juan.perez@sena.edu.co"
  - Teléfono: "3001234567"
- [ ] Verificar creación exitosa

### CRUD Completo
- [ ] Ver detalles
- [ ] Editar instructor
- [ ] Eliminar instructor

---

## 🏢 6. Módulo: Ambientes

### Index
- [ ] Abrir: `views/ambiente/index.php`
- [ ] Verificar listado de ambientes
- [ ] Verificar columnas: ID, Nombre, Sede

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Campos requeridos:
  - [ ] ID del ambiente (ej: "A101")
  - [ ] Nombre del ambiente
  - [ ] Sede (select)
- [ ] Crear ambiente de prueba:
  - ID: "A101"
  - Nombre: "Laboratorio de Sistemas"
- [ ] Verificar creación exitosa

### CRUD Completo
- [ ] Ver detalles
- [ ] Editar ambiente
- [ ] Eliminar ambiente

---

## 📅 7. Módulo: Asignaciones (Calendario)

### Index (Calendario)
- [ ] Abrir: `views/asignacion/index.php`
- [ ] Verificar que el calendario se muestra
- [ ] Verificar que muestra lunes a sábado (no domingo)
- [ ] Verificar navegación entre meses
- [ ] Verificar botón "Nueva Asignación"

### Crear Asignación
- [ ] Click en "Nueva Asignación"
- [ ] Verificar formulario con:
  - [ ] Ficha (select)
  - [ ] Instructor (select)
  - [ ] Competencia (select)
  - [ ] Ambiente (select)
  - [ ] Días de la semana (checkboxes)
  - [ ] Fecha inicio
  - [ ] Fecha fin
  - [ ] Hora inicio
  - [ ] Hora fin
- [ ] Crear asignación de prueba:
  - Seleccionar ficha existente
  - Seleccionar instructor existente
  - Marcar: Lunes, Miércoles, Viernes
  - Fecha inicio: Hoy
  - Fecha fin: +1 mes
  - Hora inicio: 08:00
  - Hora fin: 12:00
- [ ] Verificar que se crean múltiples eventos (uno por cada día seleccionado)
- [ ] Verificar que aparecen en el calendario

### Validaciones
- [ ] Probar horario fuera de rango (antes de 6:00 AM o después de 10:00 PM)
- [ ] Probar fecha fin antes de fecha inicio
- [ ] Probar sin seleccionar días de la semana

### Ver/Editar/Eliminar
- [ ] Click en un evento del calendario
- [ ] Ver detalles de la asignación
- [ ] Editar asignación
- [ ] Eliminar asignación

---

## 🎯 8. Módulo: Competencias

### Index
- [ ] Abrir: `views/competencia/index.php`
- [ ] Verificar listado de competencias
- [ ] Verificar columnas: Nombre corto, Horas, Unidad de competencia

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Campos requeridos:
  - [ ] Nombre corto
  - [ ] Horas
  - [ ] Nombre de unidad de competencia
- [ ] Crear competencia de prueba:
  - Nombre corto: "PROG-001"
  - Horas: 120
  - Unidad: "Programar aplicaciones web"
- [ ] Verificar creación exitosa

### CRUD Completo
- [ ] Ver detalles
- [ ] Editar competencia
- [ ] Eliminar competencia

---

## 🏆 9. Módulo: Competencias de Instructor

### Index
- [ ] Abrir: `views/instru_competencia/index.php`
- [ ] Verificar listado de competencias de instructores
- [ ] Verificar columnas: Instructor, Competencia, Fecha inicio, Fecha fin, Estado
- [ ] Verificar badges de estado (Vigente/Vencida)

### Crear
- [ ] Click en "Crear Nuevo"
- [ ] Campos requeridos:
  - [ ] Instructor (select)
  - [ ] Competencia (select)
  - [ ] Fecha inicio
  - [ ] Fecha fin
- [ ] Crear competencia de instructor:
  - Seleccionar instructor existente
  - Seleccionar competencia existente
  - Fecha inicio: Hoy
  - Fecha fin: +1 año
- [ ] Verificar creación exitosa
- [ ] Verificar que aparece como "Vigente"

### Ver/Editar/Eliminar
- [ ] Ver detalles
- [ ] Editar competencia
- [ ] Eliminar competencia

---

## 🏛️ 10. Módulo: Centro de Formación

### Index
- [ ] Abrir: `views/centro_formacion/index.php`
- [ ] Verificar listado de centros

### Crear
- [ ] Crear centro de prueba:
  - Nombre: "Centro de Formación Cúcuta"
- [ ] Verificar creación exitosa

### CRUD Completo
- [ ] Ver, editar, eliminar

---

## 🏫 11. Módulo: Sedes

### Index
- [ ] Abrir: `views/sede/index.php`
- [ ] Verificar listado de sedes

### Crear
- [ ] Crear sede de prueba:
  - Nombre: "Sede Principal"
  - Centro de formación: Seleccionar existente
- [ ] Verificar creación exitosa

---

## 👔 12. Módulo: Coordinación

### Index
- [ ] Abrir: `views/coordinacion/index.php`
- [ ] Verificar listado de coordinaciones

### Crear
- [ ] Crear coordinación de prueba:
  - Descripción: "Coordinación Académica"
  - Nombre coordinador: "María López"
  - Correo: "maria.lopez@sena.edu.co"
  - Centro de formación: Seleccionar existente
- [ ] Verificar creación exitosa

---

## 🔗 13. Módulo: Competencia-Programa

### Index
- [ ] Abrir: `views/competencia_programa/index.php`
- [ ] Verificar listado de relaciones

### Crear
- [ ] Crear relación:
  - Programa: Seleccionar existente
  - Competencia: Seleccionar existente
- [ ] Verificar creación exitosa

---

## 📱 14. Pruebas de Responsive

### Desktop (1920px)
- [ ] Verificar diseño en pantalla grande
- [ ] Verificar sidebar completo
- [ ] Verificar tablas sin scroll horizontal

### Laptop (1366px)
- [ ] Verificar diseño en laptop
- [ ] Verificar que todo es legible

### Tablet (768px)
- [ ] Verificar diseño en tablet
- [ ] Verificar que el sidebar se adapta
- [ ] Verificar formularios

### Mobile (375px)
- [ ] Verificar diseño en móvil
- [ ] Verificar navegación
- [ ] Verificar formularios
- [ ] Verificar tablas (scroll horizontal)

---

## 🎨 15. Pruebas de UI/UX

### Colores
- [ ] Verificar colores institucionales SENA
- [ ] Verde principal: #39A900
- [ ] Verde claro sidebar: #e8f5e9
- [ ] Verificar contraste de texto

### Iconos
- [ ] Verificar que todos los iconos Lucide cargan
- [ ] Verificar iconos en sidebar
- [ ] Verificar iconos en botones

### Animaciones
- [ ] Hover en tarjetas del dashboard
- [ ] Hover en filas de tablas
- [ ] Transiciones suaves en botones
- [ ] Efectos en sidebar

### Tipografía
- [ ] Verificar fuente Inter carga correctamente
- [ ] Verificar jerarquía de títulos
- [ ] Verificar legibilidad

---

## ⚡ 16. Pruebas de Rendimiento

### Carga de Páginas
- [ ] Dashboard carga en < 2 segundos
- [ ] Módulos cargan rápidamente
- [ ] Calendario carga sin demora

### Base de Datos
- [ ] Consultas rápidas (< 1 segundo)
- [ ] Sin errores de conexión
- [ ] Transacciones exitosas

---

## 🔒 17. Pruebas de Seguridad

### Sesiones
- [ ] No se puede acceder sin login
- [ ] Sesión expira correctamente
- [ ] Logout limpia la sesión

### SQL Injection
- [ ] Probar caracteres especiales en formularios
- [ ] Verificar que usa PDO prepared statements

### XSS
- [ ] Probar scripts en campos de texto
- [ ] Verificar que se escapan correctamente

---

## 🐛 18. Pruebas de Errores

### Errores Comunes
- [ ] Probar crear registro duplicado
- [ ] Probar eliminar registro con relaciones
- [ ] Probar campos vacíos en formularios
- [ ] Probar formatos incorrectos (email, teléfono)
- [ ] Probar fechas inválidas

### Mensajes de Error
- [ ] Verificar que los errores se muestran claramente
- [ ] Verificar que los mensajes son útiles
- [ ] Verificar que no se muestran errores técnicos al usuario

---

## ✅ 19. Checklist Final

### Funcionalidad
- [ ] Todos los módulos funcionan
- [ ] CRUD completo en cada módulo
- [ ] Calendario funcional
- [ ] Estadísticas correctas

### Diseño
- [ ] Diseño consistente en todas las páginas
- [ ] Colores institucionales
- [ ] Responsive en todos los dispositivos
- [ ] Sin errores visuales

### Seguridad
- [ ] Autenticación funcional
- [ ] Sesiones seguras
- [ ] Contraseñas hasheadas
- [ ] Protección contra ataques

### Rendimiento
- [ ] Carga rápida
- [ ] Sin errores de consola
- [ ] Base de datos optimizada

---

## 📊 Reporte de Pruebas

### Resumen
- **Total de pruebas:** ___
- **Pruebas exitosas:** ___
- **Pruebas fallidas:** ___
- **Errores encontrados:** ___

### Errores Encontrados

| # | Módulo | Descripción | Severidad | Estado |
|---|--------|-------------|-----------|--------|
| 1 |        |             |           |        |
| 2 |        |             |           |        |

### Recomendaciones

1. 
2. 
3. 

---

## 🚀 Datos de Prueba Sugeridos

### Título Programa
- Técnico
- Tecnólogo
- Especialización

### Programas
- Análisis y Desarrollo de Software
- Gestión Administrativa
- Diseño Gráfico

### Fichas
- 2024001, 2024002, 2024003

### Instructores
- Juan Pérez (juan.perez@sena.edu.co)
- María García (maria.garcia@sena.edu.co)
- Carlos López (carlos.lopez@sena.edu.co)

### Ambientes
- A101 - Laboratorio de Sistemas
- A102 - Aula de Clase
- A103 - Taller de Diseño

### Competencias
- PROG-001 - Programar aplicaciones web (120 horas)
- ADMIN-001 - Gestionar procesos administrativos (80 horas)
- DIS-001 - Diseñar piezas gráficas (100 horas)

---

**Fecha de pruebas:** ___________  
**Probado por:** ___________  
**Versión:** 1.0
