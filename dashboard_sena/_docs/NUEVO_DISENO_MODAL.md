# 📋 Nuevo Diseño del Modal de Asignaciones

## ✅ Diseño Implementado Según Imagen

El modal ahora sigue el orden y estructura mostrados en la imagen proporcionada:

```
┌─────────────────────────────────────────────────────────────┐
│  📅  Agregar Evento                                      ×  │
│      martes, 17 de febrero de 2026                          │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  AMBIENTE                                                    │
│  [Seleccionar ambiente... ▼]                                │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ COMPETENCIA                                            │ │
│  │ [Seleccionar competencia... ▼]                         │ │
│  │                                                         │ │
│  │ ┌────────────────────────────────────────────────────┐ │ │
│  │ │ Denominación: [___________________________]        │ │ │
│  │ │ Habilidades:  [___________________________]        │ │ │
│  │ │ Criterios:    [___________________________]        │ │ │
│  │ │ TLC:          [___________________________]        │ │ │
│  │ └────────────────────────────────────────────────────┘ │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ INSTRUCTOR                                             │ │
│  │ [Seleccionar instructor... ▼]                          │ │
│  │                                                         │ │
│  │ ┌──────────┬──────────┬──────────┐                    │ │
│  │ │N. Horas  │N. Semanas│A. Criterio│                   │ │
│  │ │[____]    │[____]    │[____]    │                    │ │
│  │ └──────────┴──────────┴──────────┘                    │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  FICHA (oculto si viene preseleccionada)                    │
│  [Seleccionar ficha... ▼]                                   │
│                                                              │
│  FECHA                                                       │
│  Fecha Inicio: [2026-02-17]  Fecha Fin: [2026-02-17]       │
│                                                              │
│  HORAS                                                       │
│  h. ini: [06:00]  h. fin: [17:00]                          │
│  Horario: 6:00 AM - 10:00 PM                                │
│                                                              │
│  ─────────────────────────────────────────────────────────  │
│  [ ✖ Cancelar ]  [ ✓ Guardar ]                             │
└─────────────────────────────────────────────────────────────┘
```

## 📝 Orden de los Campos

### 1. AMBIENTE (arriba)
- Select simple
- Sin subcampos
- Campo opcional

### 2. COMPETENCIA (con subcampos)
- Select principal de competencia
- Subcampos en caja con fondo blanco:
  - **Denominación**: Texto libre
  - **Habilidades**: Texto libre
  - **Criterios**: Texto libre
  - **TLC**: Texto libre
- Fondo gris claro (#f9fafb) para la sección completa

### 3. INSTRUCTOR (con subcampos)
- Select principal de instructor (REQUERIDO)
- Subcampos en grid de 3 columnas:
  - **N. Horas**: Campo numérico
  - **N. Semanas**: Campo numérico
  - **A. Criterio**: Texto libre
- Fondo gris claro (#f9fafb) para la sección completa

### 4. FICHA
- Select de ficha
- Se oculta automáticamente si viene preseleccionada por URL
- Cuando está preseleccionada, se envía como campo hidden

### 5. FECHA
- Grid de 2 columnas
- **Fecha Inicio**: Campo date
- **Fecha Fin**: Campo date
- Valores por defecto: fecha actual

### 6. HORAS
- Grid de 2 columnas
- **h. ini**: Campo time (valor por defecto: 06:00)
- **h. fin**: Campo time (valor por defecto: 17:00)
- Texto informativo: "Horario: 6:00 AM - 10:00 PM"

### 7. BOTONES
- Separador visual (línea gris)
- **Cancelar** (gris): Cierra el modal
- **Guardar** (verde SENA): Envía el formulario

## 🎨 Estilos Visuales

### Secciones con Subcampos
```css
/* Competencia e Instructor */
border: 2px solid #e5e7eb
border-radius: 8px
padding: 16px
background: #f9fafb

/* Subcampos internos */
background: white
border: 1px solid #e5e7eb
border-radius: 6px
padding: 12px
```

### Campos Simples
```css
/* Ambiente, Ficha, Fecha, Horas */
padding: 10px 12px
border: 2px solid #e5e7eb
border-radius: 6px
background: white
```

### Botones
```css
/* Cancelar */
background: #6b7280
hover: #4b5563

/* Guardar */
background: linear-gradient(135deg, #39A900 0%, #007832 100%)
box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3)
hover: translateY(-2px) + shadow más grande
```

## 🔧 Funcionalidad

### Ficha Preseleccionada
Cuando se accede con `?ficha_id=123`:
1. El campo Ficha se oculta visualmente (`display: none`)
2. Se crea un `<input type="hidden">` con el valor
3. El formulario envía el valor correctamente

### Validación
- **Instructor**: Campo requerido
- **Fecha Inicio**: Campo requerido
- **Fecha Fin**: Campo requerido
- **Hora Inicio**: Campo requerido (06:00 por defecto)
- **Hora Fin**: Campo requerido (17:00 por defecto)

### Campos Opcionales
- Ambiente
- Competencia (y todos sus subcampos)
- Todos los subcampos de Instructor
- Todos los subcampos de Competencia

## 📊 Estructura de Datos Enviados

```php
POST /dashboard_sena/views/asignacion/index.php
{
    "crear_asignacion": "1",
    "ambiente_id": "A101",
    "competencia_id": "1",
    "comp_denominacion": "Desarrollo de Software",
    "comp_habilidades": "Programación, Análisis",
    "comp_criterios": "Criterio 1, Criterio 2",
    "comp_tlc": "TLC Info",
    "instructor_id": "5",
    "inst_num_horas": "40",
    "inst_num_semanas": "4",
    "inst_criterio": "Criterio A",
    "ficha_id": "123",
    "fecha_inicio": "2026-02-17",
    "fecha_fin": "2026-02-28",
    "hora_inicio": "06:00",
    "hora_fin": "17:00"
}
```

## 🚀 Ventajas del Nuevo Diseño

1. **Más Limpio**: Sin tabla compleja, diseño más simple
2. **Mejor Organización**: Campos agrupados lógicamente
3. **Subcampos Visibles**: Los subcampos están claramente dentro de su sección padre
4. **Responsive**: Se adapta mejor a diferentes tamaños de pantalla
5. **Menos Ruido Visual**: Sin columnas de "ESTADO" y "VERIFICADO"
6. **Más Intuitivo**: El flujo de llenado es más natural

## 📱 Responsive

### Desktop (> 700px)
- Modal: 700px de ancho
- Subcampos de Instructor: 3 columnas
- Fecha y Horas: 2 columnas cada uno

### Tablet (400px - 700px)
- Modal: 90% del ancho
- Subcampos de Instructor: 3 columnas (puede ajustarse)
- Fecha y Horas: 2 columnas

### Mobile (< 400px)
- Modal: 95% del ancho
- Subcampos de Instructor: 1 columna
- Fecha y Horas: 1 columna

## 🔄 Diferencias con el Diseño Anterior

| Aspecto | Diseño Anterior | Diseño Nuevo |
|---------|----------------|--------------|
| Estructura | Tabla con 4 columnas | Formulario vertical |
| Estados | Badges de PENDIENTE/OPCIONAL | Sin badges |
| Verificación | Iconos ✓/⏳/- | Sin iconos |
| Subcampos | No existían | Agrupados visualmente |
| Orden | Ficha primero | Ambiente primero |
| Días semana | Checkboxes visibles | Comentados (opcional) |

---

**Fecha de Implementación:** Febrero 2026  
**Estado:** ✅ Completado según imagen proporcionada
