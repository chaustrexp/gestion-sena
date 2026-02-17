# 🪟 Guía de Implementación de Modales

## Objetivo
Convertir los formularios de crear en ventanas modales para mejorar la experiencia de usuario.

---

## 📋 Ventajas de los Modales

1. **Mejor UX**: El usuario no pierde el contexto de la página
2. **Más rápido**: No hay recarga de página completa
3. **Moderno**: Interfaz más limpia y profesional
4. **Menos clics**: Crear y ver resultados en la misma vista

---

## 🔧 Implementación

### Paso 1: Modificar el botón "Nuevo"

**Antes:**
```html
<a href="crear.php" class="btn btn-primary">
    Nuevo Programa
</a>
```

**Después:**
```html
<button onclick="abrirModalCrear()" class="btn btn-primary">
    <i data-lucide="plus"></i>
    Nuevo Programa
</button>
```

---

### Paso 2: Agregar el Modal HTML

Agregar antes del cierre de `</div>` del main-content:

```html
<!-- Modal Crear -->
<div id="modalCrear" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 12px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.3);">
        
        <!-- Header del Modal -->
        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Crear Nuevo Programa</h3>
            <button onclick="cerrarModal()" style="background: none; border: none; font-size: 24px; color: #6b7280; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">×</button>
        </div>
        
        <!-- Contenido del Modal -->
        <div style="padding: 24px;">
            <form id="formCrear" method="POST" action="">
                <input type="hidden" name="crear_modal" value="1">
                
                <div class="form-group">
                    <label>Denominación del Programa *</label>
                    <input type="text" name="prog_denominacion" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Tipo de Programa *</label>
                    <select name="prog_tipo" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="Técnico">Técnico</option>
                        <option value="Tecnólogo">Tecnólogo</option>
                        <option value="Especialización">Especialización</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Título del Programa *</label>
                    <select name="TIT_PROGRAMA_titpro_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($titulos as $titulo): ?>
                            <option value="<?php echo $titulo['titpro_id']; ?>">
                                <?php echo htmlspecialchars($titulo['titpro_nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Guardar</button>
                    <button type="button" onclick="cerrarModal()" class="btn btn-secondary" style="flex: 1;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
```

---

### Paso 3: Agregar JavaScript

Agregar antes del cierre de `<?php include footer.php; ?>`:

```html
<script>
function abrirModalCrear() {
    const modal = document.getElementById('modalCrear');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModal() {
    const modal = document.getElementById('modalCrear');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('formCrear').reset();
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalCrear')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});
</script>
```

---

### Paso 4: Modificar el PHP para manejar el modal

Al inicio del archivo index.php, después de los requires:

```php
// Manejar creación desde modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_modal'])) {
    $model->create($_POST);
    header('Location: index.php?msg=creado');
    exit;
}
```

---

## 📝 Módulos a Modificar

### ✅ Prioridad Alta (Más usados)
1. **Programas** - `views/programa/index.php`
2. **Fichas** - `views/ficha/index.php`
3. **Instructores** - `views/instructor/index.php`
4. **Competencias** - `views/competencia/index.php`
5. **Asignaciones** - `views/asignacion/index.php` (ya tiene modal)

### ⚠️ Prioridad Media
6. **Ambientes** - `views/ambiente/index.php`
7. **Coordinaciones** - `views/coordinacion/index.php`
8. **Competencia-Programa** - `views/competencia_programa/index.php`

### ⏳ Prioridad Baja
9. **Sedes** - `views/sede/index.php`
10. **Centros de Formación** - `views/centro_formacion/index.php`
11. **Títulos de Programa** - `views/titulo_programa/index.php`

---

## 🎨 Estilos del Modal

Los estilos inline ya están optimizados para:
- ✅ Responsive (se adapta a móviles)
- ✅ Scroll interno si el contenido es largo
- ✅ Animación suave
- ✅ Fondo oscuro semitransparente
- ✅ Cierre con clic fuera o ESC

---

## 💡 Consejos

1. **Validación**: Agregar validación JavaScript antes de enviar
2. **Loading**: Mostrar spinner mientras se procesa
3. **Errores**: Mostrar errores dentro del modal sin cerrarlo
4. **Success**: Cerrar modal y mostrar mensaje de éxito
5. **Datos relacionados**: Cargar con AJAX si es necesario

---

## 🔄 Flujo Completo

```
Usuario hace clic en "Nuevo" 
    ↓
Se abre el modal
    ↓
Usuario llena el formulario
    ↓
Usuario hace clic en "Guardar"
    ↓
Se envía POST al mismo archivo
    ↓
PHP procesa y guarda en BD
    ↓
Redirección a index.php?msg=creado
    ↓
Se muestra mensaje de éxito
    ↓
La tabla se actualiza con el nuevo registro
```

---

## ⚡ Mejora Futura: AJAX

Para evitar la recarga de página:

```javascript
document.getElementById('formCrear').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('crear_ajax.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            cerrarModal();
            mostrarMensaje('Registro creado exitosamente', 'success');
            recargarTabla(); // Función para recargar solo la tabla
        } else {
            mostrarError(result.message);
        }
    } catch (error) {
        mostrarError('Error al guardar');
    }
});
```

---

**Última actualización:** Febrero 17, 2026  
**Autor:** Sistema de Gestión SENA
