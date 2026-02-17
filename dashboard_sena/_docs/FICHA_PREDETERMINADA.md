# 📌 Ficha Predeterminada en Modal de Asignaciones

## ✅ Implementación

La ficha ahora es **OBLIGATORIA** y debe estar **SIEMPRE PREDETERMINADA** antes de abrir el modal.

## 🎯 Flujo de Uso

### 1. Selector de Ficha en el Header

```
┌─────────────────────────────────────────────────────────┐
│  Asignaciones                                            │
│  Gestiona las asignaciones...                            │
│                                                          │
│  [Seleccionar Ficha... ▼]  [ + Nueva Asignación ]      │
└─────────────────────────────────────────────────────────┘
```

**Ubicación**: En el header de la página, junto al botón "Nueva Asignación"

**Componente**:
```html
<select id="fichaSelector">
    <option value="">Seleccionar Ficha...</option>
    <option value="1">Ficha 1</option>
    <option value="2">Ficha 2</option>
    ...
</select>
```

### 2. Validación al Hacer Click

Cuando el usuario hace click en "Nueva Asignación":

```javascript
function abrirModalConFichaSeleccionada() {
    const fichaSelector = document.getElementById('fichaSelector');
    const fichaId = fichaSelector.value;
    
    if (!fichaId) {
        alert('Por favor, seleccione una ficha antes de crear una asignación.');
        fichaSelector.focus();
        return;
    }
    
    abrirModalNuevaAsignacion(fichaId);
}
```

**Comportamiento**:
- ✅ Si hay ficha seleccionada → Abre el modal
- ❌ Si NO hay ficha seleccionada → Muestra alerta y enfoca el selector

### 3. Modal con Ficha Predeterminada

```
┌─────────────────────────────────────────────────────────┐
│  📅  Agregar Evento                                  ×  │
├─────────────────────────────────────────────────────────┤
│  ▌ Información del Evento                               │
│                                                          │
│  ┌────────────────────────────────────────────────────┐ │
│  │ CAMPO      │ VALOR      │ ESTADO    │ VERIFICADO  │ │
│  ├────────────────────────────────────────────────────┤ │
│  │ Ficha      │ Ficha 123  │ ASIGNADA  │  ✓          │ │ ← Verde
│  │ Instructor │ [Select▼]  │ PENDIENTE │  ⏳         │ │
│  │ Ambiente   │ [Select▼]  │ PENDIENTE │  ⏳         │ │
│  │ Competencia│ [Select▼]  │ OPCIONAL  │  -          │ │
│  └────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

**Características de la Fila de Ficha**:
- Fondo verde claro (#E8F5E8)
- Texto "Ficha [ID]" en verde con borde verde
- Badge "ASIGNADA" en verde
- Icono ✓ verde
- NO es editable (solo lectura)
- Se envía como `<input type="hidden">`

## 🔧 Implementación Técnica

### HTML del Selector
```html
<select id="fichaSelector" style="padding: 10px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: white; color: #1f2937; min-width: 200px;">
    <option value="">Seleccionar Ficha...</option>
    <?php foreach ($fichas as $ficha): ?>
        <option value="<?php echo htmlspecialchars($ficha['fich_id'] ?? ''); ?>">
            Ficha <?php echo htmlspecialchars($ficha['fich_id'] ?? ''); ?>
        </option>
    <?php endforeach; ?>
</select>
```

### JavaScript de Validación
```javascript
function abrirModalConFichaSeleccionada() {
    const fichaSelector = document.getElementById('fichaSelector');
    const fichaId = fichaSelector.value;
    
    if (!fichaId) {
        alert('Por favor, seleccione una ficha antes de crear una asignación.');
        fichaSelector.focus();
        return;
    }
    
    abrirModalNuevaAsignacion(fichaId);
}
```

### Función del Modal
```javascript
function abrirModalNuevaAsignacion(fichaIdPreseleccionada = null) {
    const urlParams = new URLSearchParams(window.location.search);
    const fichaId = fichaIdPreseleccionada || urlParams.get('ficha_id') || '';
    
    // Validación obligatoria
    if (!fichaId) {
        alert('Error: Debe seleccionar una ficha antes de crear una asignación.');
        return;
    }
    
    // Continuar con la creación del modal...
}
```

### Hidden Input en el Formulario
```html
<form method="POST" action="">
    <input type="hidden" name="crear_asignacion" value="1">
    <input type="hidden" name="ficha_id" value="${fichaId}">
    <!-- Resto del formulario -->
</form>
```

## 📊 Flujo Completo

```
1. Usuario llega a la página de Asignaciones
   ↓
2. Usuario selecciona una Ficha del selector
   ↓
3. Usuario hace click en "Nueva Asignación"
   ↓
4. JavaScript valida que haya una ficha seleccionada
   ↓
   ├─ SI hay ficha → Abre modal con ficha predeterminada
   │                 (Fila verde, solo lectura)
   │                 ↓
   │                 Usuario completa el formulario
   │                 ↓
   │                 Usuario hace click en "Guardar"
   │                 ↓
   │                 POST con ficha_id incluido
   │
   └─ NO hay ficha → Muestra alerta
                     "Por favor, seleccione una ficha..."
                     ↓
                     Enfoca el selector de ficha
```

## 🎨 Diseño Visual del Selector

```css
/* Selector de Ficha */
#fichaSelector {
    padding: 10px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    color: #1f2937;
    min-width: 200px;
    cursor: pointer;
}

#fichaSelector:focus {
    border-color: #39A900;
    outline: none;
    box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
}
```

## ✨ Ventajas de Este Enfoque

1. **Claridad**: El usuario sabe que debe seleccionar una ficha primero
2. **Validación Temprana**: Se valida antes de abrir el modal
3. **UX Mejorada**: No se abre un modal vacío o con error
4. **Consistencia**: La ficha siempre está predeterminada
5. **Simplicidad**: Un solo paso adicional antes del modal

## 🔄 Alternativas de Acceso

### Opción 1: Selector + Botón (Implementado)
```
[Seleccionar Ficha ▼]  [ + Nueva Asignación ]
```

### Opción 2: Desde URL (También funciona)
```
index.php?ficha_id=123
```
El modal se abre automáticamente con la ficha 123

### Opción 3: Desde JavaScript (También funciona)
```javascript
abrirModalNuevaAsignacion(123);
```

## 📝 Datos Enviados

```php
POST /dashboard_sena/views/asignacion/index.php
{
    "crear_asignacion": "1",
    "ficha_id": "123",           // ← SIEMPRE presente
    "instructor_id": "5",
    "ambiente_id": "A101",
    "competencia_id": "1",
    "dias[]": ["1", "2", "3", "4", "5"],
    "fecha_inicio": "2026-02-03",
    "fecha_fin": "2026-02-03",
    "hora_inicio": "08:00",
    "hora_fin": "17:00"
}
```

## 🚫 Casos de Error

### Error 1: No hay ficha seleccionada
```
Usuario hace click en "Nueva Asignación" sin seleccionar ficha
↓
Alert: "Por favor, seleccione una ficha antes de crear una asignación."
↓
Focus en el selector de ficha
```

### Error 2: Ficha inválida en URL
```
Usuario accede a: index.php?ficha_id=
↓
Alert: "Error: Debe seleccionar una ficha antes de crear una asignación."
↓
Modal no se abre
```

---

**Fecha de Implementación:** Febrero 2026  
**Estado:** ✅ Completado - Ficha siempre predeterminada  
**Versión:** 4.0 (Ficha obligatoria con selector)
