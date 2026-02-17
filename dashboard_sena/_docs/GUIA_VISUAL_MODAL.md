# 🎨 Guía Visual del Modal de Asignaciones

## Vista General del Modal

```
┌─────────────────────────────────────────────────────────────┐
│  📅  Agregar Evento                                      ×  │
│      martes, 17 de febrero de 2026                          │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ▌ Información del Evento                                   │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ CAMPO      │ VALOR          │ ESTADO         │ ✓     │  │
│  ├──────────────────────────────────────────────────────┤  │
│  │ Ficha      │ [Ficha 123 ▼] │ PRESELECCIONADA│  ✓    │  │ ← Verde cuando preseleccionada
│  │ Instructor │ [Seleccionar▼]│ PENDIENTE      │  ⏳   │  │
│  │ Ambiente   │ [Seleccionar▼]│ OPCIONAL       │  -    │  │
│  │ Competencia│ [Seleccionar▼]│ OPCIONAL       │  -    │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                              │
│  Días de la semana                                          │
│  ┌───┐ ┌───┐ ┌───┐ ┌───┐ ┌───┐ ┌───┐                     │
│  │☑Lun│ │☑Mar│ │☑Mié│ │☑Jue│ │☑Vie│ │☐Sáb│                │
│  └───┘ └───┘ └───┘ └───┘ └───┘ └───┘                     │
│   ↑ Preseleccionados (Lun-Vie)                              │
│                                                              │
│  RANGO DE FECHAS          RANGO DE HORAS                    │
│  [2026-02-17] - [...]     [06:00] - [22:00]                │
│                           Horario: 6:00 AM - 10:00 PM       │
│                                                              │
│  [ Cancelar ]  [ Guardar ]                                  │
└─────────────────────────────────────────────────────────────┘
```

## Estados de los Campos

### 1. Ficha PRESELECCIONADA (Verde)
```
┌─────────────────────────────────────────────────────┐
│ Ficha │ [Ficha 123 ▼] │ PRESELECCIONADA │  ✓       │
│       │  (disabled)    │   (verde)       │ (verde)  │
└─────────────────────────────────────────────────────┘
```
- Fondo de fila: `#E8F5E8` (verde claro)
- Select disabled con borde verde
- Badge verde: "PRESELECCIONADA"
- Icono: ✓ verde

### 2. Campo PENDIENTE (Amarillo)
```
┌─────────────────────────────────────────────────────┐
│ Instructor │ [Seleccionar ▼] │ PENDIENTE │  ⏳     │
│            │   (editable)     │ (amarillo)│(amarillo)│
└─────────────────────────────────────────────────────┘
```
- Fondo de fila: `#f9fafb` o `white`
- Select editable normal
- Badge amarillo: "PENDIENTE"
- Icono: ⏳ amarillo

### 3. Campo OPCIONAL (Gris)
```
┌─────────────────────────────────────────────────────┐
│ Ambiente │ [Seleccionar ▼] │ OPCIONAL │  -         │
│          │   (editable)     │  (gris)  │ (gris)     │
└─────────────────────────────────────────────────────┘
```
- Fondo de fila: `#f9fafb` o `white`
- Select editable normal
- Badge gris: "OPCIONAL"
- Icono: - gris

## Días de la Semana

### Día Seleccionado (Verde)
```
┌─────────┐
│ ☑ Lun   │  ← Borde verde, fondo verde claro
└─────────┘
```
- Borde: `#39A900` (verde SENA)
- Fondo: `#E8F5E8` (verde claro)
- Texto: `#39A900` (verde)
- Checkbox marcado

### Día No Seleccionado (Gris)
```
┌─────────┐
│ ☐ Sáb   │  ← Borde gris, fondo blanco
└─────────┘
```
- Borde: `#e5e7eb` (gris)
- Fondo: `white`
- Texto: `#6b7280` (gris)
- Checkbox sin marcar

## Rango de Horas

```
RANGO DE HORAS
┌──────────┐     ┌──────────┐
│  06:00   │  -  │  22:00   │
└──────────┘     └──────────┘
Horario: 6:00 AM - 10:00 PM
         ↑ Texto informativo
```

**Valores por Defecto:**
- Hora inicio: `06:00` (6:00 AM)
- Hora fin: `22:00` (10:00 PM)

**Validación:**
- Mínimo: 6:00 AM
- Máximo: 10:00 PM
- Hora fin debe ser mayor que hora inicio

## Colores del Sistema

### Paleta SENA
```
Verde Principal:    #39A900  ████████
Verde Secundario:   #007832  ████████
Verde Claro:        #E8F5E8  ████████
Verde Muy Claro:    #f0fdf4  ████████
```

### Estados
```
Amarillo (Pendiente):  #D97706  ████████
Amarillo Claro:        #FEF3C7  ████████
Gris (Opcional):       #6B7280  ████████
Gris Claro:            #F3F4F6  ████████
```

## Flujo de Uso

### Caso 1: Modal Normal
```
1. Usuario hace clic en "Nueva Asignación"
2. Modal se abre con todos los campos editables
3. Usuario selecciona ficha manualmente
4. Usuario completa los demás campos
5. Usuario hace clic en "Guardar"
```

### Caso 2: Modal con Ficha Preseleccionada
```
1. Usuario accede con URL: index.php?ficha_id=123
2. Modal se abre con ficha 123 preseleccionada
3. Campo ficha está disabled (no editable)
4. Fila de ficha tiene fondo verde
5. Usuario completa los demás campos
6. Usuario hace clic en "Guardar"
```

## Ejemplo de Código HTML Generado

### Ficha Preseleccionada
```html
<tr style="background: #E8F5E8; border-bottom: 1px solid #e5e7eb;">
    <td>Ficha</td>
    <td>
        <select name="ficha_id" disabled style="border: 2px solid #39A900; background: #f0fdf4;">
            <option value="123" selected>Ficha 123</option>
        </select>
        <input type="hidden" name="ficha_id" value="123">
    </td>
    <td style="text-align: center;">
        <span style="background: #E8F5E8; color: #39A900;">PRESELECCIONADA</span>
    </td>
    <td style="text-align: center;">
        <span style="color: #39A900;">✓</span>
    </td>
</tr>
```

### Campo Normal
```html
<tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
    <td>Instructor</td>
    <td>
        <select name="instructor_id" required>
            <option value="">Seleccionar...</option>
            <option value="1">Juan Pérez</option>
        </select>
    </td>
    <td style="text-align: center;">
        <span style="background: #FEF3C7; color: #D97706;">PENDIENTE</span>
    </td>
    <td style="text-align: center;">
        <span style="color: #D97706;">⏳</span>
    </td>
</tr>
```

## Responsive Design

### Desktop (> 700px)
- Modal: 700px de ancho máximo
- Tabla: 4 columnas completas
- Días: Grid de 6 columnas

### Tablet (400px - 700px)
- Modal: 90% del ancho de pantalla
- Tabla: 4 columnas (puede hacer scroll horizontal)
- Días: Grid de 3 columnas

### Mobile (< 400px)
- Modal: 95% del ancho de pantalla
- Tabla: Scroll horizontal
- Días: Grid de 2 columnas

---

**Última actualización:** Febrero 2026
