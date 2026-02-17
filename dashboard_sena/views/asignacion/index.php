<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/AsignacionModel.php';
require_once __DIR__ . '/../../model/FichaModel.php';
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/AmbienteModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';

$model = new AsignacionModel();
$fichaModel = new FichaModel();
$instructorModel = new InstructorModel();
$ambienteModel = new AmbienteModel();
$competenciaModel = new CompetenciaModel();

if (isset($_GET['eliminar'])) {
    $model->delete($_GET['eliminar']);
    header('Location: index.php?msg=eliminado');
    exit;
}

// Manejar creación desde modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_asignacion'])) {
    $model->create($_POST);
    header('Location: index.php?msg=creado');
    exit;
}

$registros = $model->getAll();
$fichas = $fichaModel->getAll();
$instructores = $instructorModel->getAll();
$ambientes = $ambienteModel->getAll();
$competencias = $competenciaModel->getAll();

$pageTitle = "Gestión de Asignaciones";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Asignaciones</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las asignaciones de instructores y ambientes</p>
        </div>
        <button onclick="abrirModalNuevaAsignacion()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Asignación
        </button>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            if ($_GET['msg'] == 'creado') echo '✓ Asignación creada exitosamente';
            if ($_GET['msg'] == 'actualizado') echo '✓ Asignación actualizada exitosamente';
            if ($_GET['msg'] == 'eliminado') echo '✓ Asignación eliminada exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Asignaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #ec4899;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Asignaciones Activas</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;">
                <?php 
                $hoy = date('Y-m-d');
                $activas = array_filter($registros, function($r) use ($hoy) {
                    $inicio = $r['asig_fecha_inicio'] ?? '';
                    $fin = $r['asig_fecha_fin'] ?? '';
                    return $inicio <= $hoy && $fin >= $hoy;
                });
                echo count($activas);
                ?>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="padding: 0 32px 24px;">
        <div style="display: inline-flex; gap: 4px; background: #f3f4f6; padding: 4px; border-radius: 12px;">
            <button onclick="showTab('table')" id="tab-table" style="padding: 10px 24px; border: none; background: white; font-weight: 600; color: #1f2937; border-radius: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i data-lucide="list" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                Lista
            </button>
            <button onclick="showTab('calendar')" id="tab-calendar" style="padding: 10px 24px; border: none; background: transparent; font-weight: 600; color: #6b7280; border-radius: 10px; cursor: pointer; transition: all 0.3s;">
                <i data-lucide="calendar" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                Calendario
            </button>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendar-view" style="display: none; padding: 0 32px 32px;">
        <div style="background: white; border-radius: 16px; border: 1px solid #e5e7eb; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <!-- Calendar Legend -->
            <div style="display: flex; gap: 24px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f3f4f6;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 16px; height: 16px; background: #39A900; border-radius: 4px;"></div>
                    <span style="font-size: 13px; color: #6b7280; font-weight: 500;">Activas</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 16px; height: 16px; background: #D97706; border-radius: 4px;"></div>
                    <span style="font-size: 13px; color: #6b7280; font-weight: 500;">Pendientes</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 16px; height: 16px; background: #DC2626; border-radius: 4px;"></div>
                    <span style="font-size: 13px; color: #6b7280; font-weight: 500;">Finalizadas</span>
                </div>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Table -->
    <div id="table-view" style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ficha</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ambiente</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Competencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Inicio</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📅</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay asignaciones registradas</p>
                            <a href="crear.php" class="btn btn-primary btn-sm">Crear Primera Asignación</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #ec4899; font-size: 14px;"><?php echo htmlspecialchars($registro['ficha_numero'] ?? ''); ?></strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['instructor_nombre'] ?? ''); ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['ambiente_nombre'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['competencia_nombre'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo isset($registro['asig_fecha_inicio']) ? date('d/m/Y', strtotime($registro['asig_fecha_inicio'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px;">
                                <?php 
                                $hoy = date('Y-m-d');
                                $fecha_inicio = $registro['asig_fecha_inicio'] ?? '';
                                $fecha_fin = $registro['asig_fecha_fin'] ?? '';
                                
                                if ($fecha_fin && $fecha_fin < $hoy) {
                                    echo '<span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Finalizada</span>';
                                } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                                    echo '<span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Pendiente</span>';
                                } else {
                                    echo '<span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Activa</span>';
                                }
                                ?>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="ver.php?id=<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="editar.php?id=<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>, 'asignacion')" class="btn btn-danger btn-sm">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    document.querySelectorAll('tbody tr').forEach(row => {
        if (row.cells.length > 1) {
            row.addEventListener('mouseenter', function() {
                this.style.background = '#f9fafb';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        }
    });

    // Tab switching
    function showTab(tab) {
        const tableView = document.getElementById('table-view');
        const calendarView = document.getElementById('calendar-view');
        const tabTable = document.getElementById('tab-table');
        const tabCalendar = document.getElementById('tab-calendar');

        if (tab === 'table') {
            tableView.style.display = 'block';
            calendarView.style.display = 'none';
            tabTable.style.background = 'white';
            tabTable.style.color = '#1f2937';
            tabTable.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            tabCalendar.style.background = 'transparent';
            tabCalendar.style.color = '#6b7280';
            tabCalendar.style.boxShadow = 'none';
        } else {
            tableView.style.display = 'none';
            calendarView.style.display = 'block';
            tabTable.style.background = 'transparent';
            tabTable.style.color = '#6b7280';
            tabTable.style.boxShadow = 'none';
            tabCalendar.style.background = 'white';
            tabCalendar.style.color = '#1f2937';
            tabCalendar.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            
            if (!window.calendarInitialized) {
                initCalendar();
                window.calendarInitialized = true;
            }
        }
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Initialize FullCalendar
    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        const events = [
            <?php foreach ($registros as $registro): ?>
            {
                title: '<?php echo addslashes(($registro['ficha_numero'] ?? '') . " - " . ($registro['instructor_nombre'] ?? '')); ?>',
                start: '<?php echo $registro['asig_fecha_inicio'] ?? $registro['fecha_inicio'] ?? ''; ?>',
                end: '<?php echo isset($registro['asig_fecha_fin']) ? date('Y-m-d', strtotime($registro['asig_fecha_fin'] . ' +1 day')) : (isset($registro['fecha_fin']) ? date('Y-m-d', strtotime($registro['fecha_fin'] . ' +1 day')) : ''); ?>',
                backgroundColor: '<?php 
                    $hoy = date('Y-m-d');
                    $fecha_inicio = $registro['asig_fecha_inicio'] ?? $registro['fecha_inicio'] ?? '';
                    $fecha_fin = $registro['asig_fecha_fin'] ?? $registro['fecha_fin'] ?? '';
                    if ($fecha_fin && $fecha_fin < $hoy) {
                        echo "#DC2626";
                    } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                        echo "#D97706";
                    } else {
                        echo "#39A900";
                    }
                ?>',
                borderColor: '<?php 
                    $hoy = date('Y-m-d');
                    $fecha_inicio = $registro['asig_fecha_inicio'] ?? $registro['fecha_inicio'] ?? '';
                    $fecha_fin = $registro['asig_fecha_fin'] ?? $registro['fecha_fin'] ?? '';
                    if ($fecha_fin && $fecha_fin < $hoy) {
                        echo "#DC2626";
                    } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                        echo "#D97706";
                    } else {
                        echo "#39A900";
                    }
                ?>',
                extendedProps: {
                    ambiente: '<?php echo addslashes($registro['ambiente_nombre'] ?? ''); ?>',
                    competencia: '<?php echo addslashes($registro['competencia_nombre'] ?? ''); ?>',
                    id: <?php echo $registro['asig_id'] ?? $registro['ASIG_ID'] ?? 0; ?>
                }
            },
            <?php endforeach; ?>
        ];

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                list: 'Agenda'
            },
            hiddenDays: [0],
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5, 6],
                startTime: '08:00',
                endTime: '17:00'
            },
            events: events,
            selectable: true,
            selectMirror: true,
            select: function(info) {
                showCreateModal(info.startStr, info.endStr);
                calendar.unselect();
            },
            dateClick: function(info) {
                const dayOfWeek = new Date(info.dateStr).getDay();
                if (dayOfWeek !== 0) {
                    showCreateModal(info.dateStr, info.dateStr);
                }
            },
            eventClick: function(info) {
                const props = info.event.extendedProps;
                const fichaNumero = info.event.title.split(' - ')[0];
                const instructorNombre = info.event.title.split(' - ')[1];
                
                // Determinar estado
                const hoy = new Date();
                const inicio = info.event.start;
                const fin = info.event.end;
                let estado = 'ACTIVO';
                let estadoTexto = 'Activa y Verificada';
                
                if (fin && fin < hoy) {
                    estado = 'FINALIZADA';
                    estadoTexto = 'Finalizada';
                } else if (inicio > hoy) {
                    estado = 'PENDIENTE';
                    estadoTexto = 'Pendiente de Inicio';
                }
                
                const modal = `
                    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="this.remove()">
                        <div style="background: white; border-radius: 12px; max-width: 700px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                            
                            <!-- Header -->
                            <div style="background: white; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: #39A900; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 18px;">📋</span>
                                    </div>
                                    <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Detalles de la Solicitud: ${fichaNumero}</h3>
                                </div>
                                <button onclick="this.closest('div[style*=fixed]').remove()" style="background: transparent; border: none; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 24px; line-height: 1;">×</button>
                            </div>

                            <!-- Contenido -->
                            <div style="padding: 24px;">
                                
                                <!-- Sección: Información de la Ficha -->
                                <div style="margin-bottom: 24px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 8px 12px; background: white; border-left: 4px solid #39A900;">
                                        <span style="font-size: 14px; font-weight: 700; color: #1f2937;">Información de la Ficha</span>
                                    </div>
                                    
                                    <!-- Tabla de información -->
                                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb;">
                                        <thead>
                                            <tr style="background: #39A900;">
                                                <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">CAMPO</th>
                                                <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">VALOR</th>
                                                <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">ESTADO</th>
                                                <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase;">VERIFICADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">ID Ficha</td>
                                                <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">${props.id}</td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">${estado}</span>
                                                </td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="color: #39A900; font-size: 18px;">✓</span>
                                                </td>
                                            </tr>
                                            <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">ID Programa</td>
                                                <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">${props.id}</td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">VÁLIDO</span>
                                                </td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="color: #39A900; font-size: 18px;">✓</span>
                                                </td>
                                            </tr>
                                            <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Jornada</td>
                                                <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">Mañana</td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">VÁLIDO</span>
                                                </td>
                                                <td style="padding: 12px 16px; text-align: center;">
                                                    <span style="color: #39A900; font-size: 18px;">✓</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Información adicional -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                                    <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                        <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">ID INSTRUCTOR-LÍDER</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #1f2937;">${props.id}</div>
                                    </div>
                                    <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                        <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">ESTADO DE LA FICHA</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #1f2937;">${estadoTexto}</div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div style="display: flex; gap: 12px;">
                                    <a href="editar.php?id=${props.id}" style="flex: 1; padding: 12px; background: #3b82f6; color: white; text-align: center; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                        Editar
                                    </a>
                                    <button onclick="if(confirm('¿Está seguro de eliminar esta asignación?')) window.location.href='index.php?eliminar=${props.id}'" style="flex: 1; padding: 12px; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
            },
            height: 'auto',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
            dayMaxEvents: 3,
            eventDisplay: 'block',
            displayEventTime: false
        });

        calendar.render();
    }

    // Show create modal
    function showCreateModal(startDate, endDate) {
        // Cargar datos para los selects
        fetch('get_form_data.php')
            .then(response => response.json())
            .then(data => {
                const modal = `
                    <div id="createModal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='createModal') this.remove()">
                        <div style="background: white; border-radius: 12px; max-width: 700px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                            
                            <!-- Header Verde -->
                            <div style="background: white; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: #39A900; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 18px;">📅</span>
                                    </div>
                                    <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Agregar Evento</h3>
                                </div>
                                <button onclick="document.getElementById('createModal').remove()" style="background: transparent; border: none; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 24px; line-height: 1;">×</button>
                            </div>

                            <!-- Contenido -->
                            <form id="createForm" method="POST" action="crear.php" onsubmit="return validateForm(event)">
                                <div style="padding: 24px;">
                                    
                                    <!-- Sección: Información del Evento -->
                                    <div style="margin-bottom: 24px;">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 8px 12px; background: white; border-left: 4px solid #39A900;">
                                            <span style="font-size: 14px; font-weight: 700; color: #1f2937;">Información del Evento</span>
                                        </div>
                                        
                                        <!-- Tabla de información -->
                                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb;">
                                            <thead>
                                                <tr style="background: #39A900;">
                                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">CAMPO</th>
                                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">VALOR</th>
                                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">ESTADO</th>
                                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase;">VERIFICADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ficha</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="ficha_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.fichas.map(f => `<option value="${f.id}">${f.numero}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Instructor</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="instructor_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.instructores.map(i => `<option value="${i.id}">${i.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ambiente</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="ambiente_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.ambientes.map(a => `<option value="${a.id}">${a.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Competencia</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="competencia_id" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.competencias.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #E5E7EB; color: #6B7280; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">OPCIONAL</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #6B7280; font-size: 18px;">-</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Días de la semana -->
                                    <div style="margin-bottom: 24px;">
                                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px;">Días de la semana</label>
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="1" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Lun</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="2" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Mar</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="3" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Mié</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="4" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Jue</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="5" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Vie</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="6" style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Sáb</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Información adicional -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">RANGO DE FECHAS</div>
                                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                <input type="date" name="fecha_inicio" value="${startDate}" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                                <span style="color: #6b7280; font-weight: 500;">-</span>
                                                <input type="date" name="fecha_fin" value="${endDate}" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                            </div>
                                        </div>
                                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">RANGO DE HORAS</div>
                                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                <input type="time" name="hora_inicio" value="08:00" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                                <span style="color: #6b7280; font-weight: 500;">-</span>
                                                <input type="time" name="hora_fin" value="17:00" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                            </div>
                                            <p style="font-size: 11px; color: #6b7280; margin: 6px 0 0; font-style: italic;">Horario: 6:00 AM - 10:00 PM</p>
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div style="display: flex; gap: 12px;">
                                        <button type="button" onclick="document.getElementById('createModal').remove()" style="flex: 1; padding: 12px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                                            Cancelar
                                        </button>
                                        <button type="submit" style="flex: 1; padding: 12px; background: #39A900; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#2d8700'" onmouseout="this.style.background='#39A900'">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
                
                // Agregar efecto hover a los checkboxes
                document.querySelectorAll('#createModal label:has(input[type="checkbox"])').forEach(label => {
                    const checkbox = label.querySelector('input[type="checkbox"]');
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            label.style.borderColor = '#39A900';
                            label.style.background = '#E8F5E8';
                        } else {
                            label.style.borderColor = '#e5e7eb';
                            label.style.background = 'white';
                        }
                    });
                    // Inicializar estado
                    if (checkbox.checked) {
                        label.style.borderColor = '#39A900';
                        label.style.background = '#E8F5E8';
                    }
                });
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos del formulario');
            });
    }

    // Validar formulario antes de enviar
    function validateForm(event) {
        // Validar que al menos un día esté seleccionado
        const diasCheckboxes = document.querySelectorAll('input[name="dias[]"]:checked');
        if (diasCheckboxes.length === 0) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un día de la semana');
            return false;
        }

        // Validar rango de horas (6:00 AM - 10:00 PM)
        const horaInicio = document.querySelector('input[name="hora_inicio"]').value;
        const horaFin = document.querySelector('input[name="hora_fin"]').value;
        
        const [horaInicioH, horaInicioM] = horaInicio.split(':').map(Number);
        const [horaFinH, horaFinM] = horaFin.split(':').map(Number);
        
        const minutosInicio = horaInicioH * 60 + horaInicioM;
        const minutosFin = horaFinH * 60 + horaFinM;
        const minutosMin = 6 * 60; // 6:00 AM
        const minutosMax = 22 * 60; // 10:00 PM
        
        if (minutosInicio < minutosMin || minutosInicio > minutosMax) {
            event.preventDefault();
            alert('La hora de inicio debe estar entre 6:00 AM y 10:00 PM');
            return false;
        }
        
        if (minutosFin < minutosMin || minutosFin > minutosMax) {
            event.preventDefault();
            alert('La hora de fin debe estar entre 6:00 AM y 10:00 PM');
            return false;
        }
        
        if (minutosFin <= minutosInicio) {
            event.preventDefault();
            alert('La hora de fin debe ser posterior a la hora de inicio');
            return false;
        }
        
        return true;
    }

</script>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />

<style>
/* Estilos personalizados para eventos del calendario */
.fc-event {
    border-radius: 4px !important;
    padding: 2px 6px !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    border: none !important;
    margin-bottom: 1px !important;
    cursor: pointer !important;
}

.fc-event-title {
    font-weight: 600 !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

.fc-daygrid-event {
    padding: 2px 4px !important;
    margin: 1px !important;
}

.fc-event-time {
    display: none !important;
}

/* Mejorar el aspecto general del calendario */
.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e5e7eb !important;
}

.fc-col-header-cell {
    background: #f9fafb !important;
    font-weight: 600 !important;
    color: #6b7280 !important;
    text-transform: uppercase !important;
    font-size: 11px !important;
    padding: 12px 8px !important;
}

.fc-daygrid-day-number {
    color: #1f2937 !important;
    font-weight: 600 !important;
    padding: 8px !important;
    font-size: 14px !important;
}

.fc-day-today {
    background: #f0f9ff !important;
}

.fc-button {
    background: #39A900 !important;
    border-color: #39A900 !important;
    text-transform: capitalize !important;
    font-weight: 600 !important;
    padding: 8px 16px !important;
    border-radius: 8px !important;
}

.fc-button:hover {
    background: #2d8700 !important;
    border-color: #2d8700 !important;
}

.fc-button-active {
    background: #2d8700 !important;
    border-color: #2d8700 !important;
}

.fc-toolbar-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
}

.fc-daygrid-day-events {
    margin-top: 2px !important;
}

.fc-daygrid-event-harness {
    margin-bottom: 1px !important;
}
</style>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>

<script>
// Función para abrir modal de nueva asignación
function abrirModalNuevaAsignacion(fichaIdPreseleccionada = null) {
    const hoy = new Date().toISOString().split('T')[0];
    const fechaFormateada = new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    
    // Obtener la ficha preseleccionada desde la URL si existe
    const urlParams = new URLSearchParams(window.location.search);
    const fichaId = fichaIdPreseleccionada || urlParams.get('ficha_id') || '';
    
    const modal = `
        <div id="modalNuevaAsignacion" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='modalNuevaAsignacion') cerrarModal()">
            <div style="background: white; border-radius: 12px; max-width: 500px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                
                <!-- Header Verde -->
                <div style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); padding: 24px; color: white;">
                    <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Nueva Asignación</h3>
                    <p style="font-size: 14px; margin: 0; opacity: 0.95;">${fechaFormateada}</p>
                </div>

                <!-- Formulario -->
                <form method="POST" action="" style="padding: 24px;">
                    <input type="hidden" name="crear_asignacion" value="1">
                    
                    <!-- ID Asignación (auto) -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">ID Asignación:</label>
                        <input type="text" value="Auto-generado" disabled style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: #f9fafb; color: #6b7280;">
                    </div>

                    <!-- Instructor -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Instructor:</label>
                        <select name="instructor_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione un instructor</option>
                            <?php foreach ($instructores as $instructor): ?>
                                <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fecha Inicio y Fin -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Fecha Inicio:</label>
                            <input type="date" name="fecha_inicio" value="${hoy}" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Fecha Fin:</label>
                            <input type="date" name="fecha_fin" value="${hoy}" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                    </div>

                    <!-- Ficha -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Ficha:</label>
                        <select name="ficha_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione una ficha</option>
                            <?php foreach ($fichas as $ficha): ?>
                                <option value="<?php echo htmlspecialchars($ficha['fich_id'] ?? ''); ?>" ${fichaId == '<?php echo $ficha['fich_id']; ?>' ? 'selected' : ''}>
                                    Ficha <?php echo htmlspecialchars($ficha['fich_id'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Ambiente -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Ambiente:</label>
                        <select name="ambiente_id" style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione un ambiente</option>
                            <?php foreach ($ambientes as $ambiente): ?>
                                <option value="<?php echo htmlspecialchars($ambiente['amb_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($ambiente['amb_nombre'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Competencia -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Competencia:</label>
                        <select name="competencia_id" style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione una competencia</option>
                            <?php foreach ($competencias as $competencia): ?>
                                <option value="<?php echo htmlspecialchars($competencia['comp_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($competencia['comp_nombre_corto'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div style="display: flex; gap: 12px;">
                        <button type="button" onclick="cerrarModal()" style="flex: 1; padding: 14px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            Cancelar
                        </button>
                        <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(57, 169, 0, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.3)'">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
}

function cerrarModal() {
    const modal = document.getElementById('modalNuevaAsignacion');
    if (modal) {
        modal.remove();
    }
}
</script>
                
                <!-- Header Verde -->
                <div style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); padding: 24px; color: white;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 20px;">📅</span>
                        </div>
                        <div>
                            <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Agregar Evento</h3>
                            <p style="font-size: 14px; margin: 0; opacity: 0.95;">${fechaFormateada}</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="" style="padding: 24px;">
                    <input type="hidden" name="crear_asignacion" value="1">
                    <input type="hidden" name="ficha_id" value="${fichaId}">
                    
                    <!-- Sección: Información del Evento -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 3px solid #39A900;">
                            <span style="font-size: 14px; font-weight: 700; color: #1f2937;">Información del Evento</span>
                        </div>
                        
                        <!-- Tabla de información -->
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb;">
                            <thead>
                                <tr style="background: #39A900;">
                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; width: 25%;">CAMPO</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; width: 40%;">VALOR</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; width: 20%;">ESTADO</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; width: 15%;">VERIFICADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ficha (siempre predeterminada) -->
                                <tr style="background: #E8F5E8; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ficha</td>
                                    <td style="padding: 12px 16px;">
                                        <div style="padding: 8px 12px; background: white; border: 2px solid #39A900; border-radius: 6px; font-size: 14px; font-weight: 600; color: #39A900;">
                                            Ficha ${fichaId}
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">ASIGNADA</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #39A900; font-size: 18px;">✓</span>
                                    </td>
                                </tr>
                                
                                <!-- Instructor -->
                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Instructor</td>
                                    <td style="padding: 12px 16px;">
                                        <select name="instructor_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white; color: #1f2937;">
                                            <option value="">Seleccionar...</option>
                                            <?php foreach ($instructores as $instructor): ?>
                                                <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>">
                                                    <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                    </td>
                                </tr>
                                
                                <!-- Ambiente -->
                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ambiente</td>
                                    <td style="padding: 12px 16px;">
                                        <select name="ambiente_id" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white; color: #1f2937;">
                                            <option value="">Seleccionar...</option>
                                            <?php foreach ($ambientes as $ambiente): ?>
                                                <option value="<?php echo htmlspecialchars($ambiente['amb_id'] ?? ''); ?>">
                                                    <?php echo htmlspecialchars($ambiente['amb_nombre'] ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                    </td>
                                </tr>
                                
                                <!-- Competencia -->
                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Competencia</td>
                                    <td style="padding: 12px 16px;">
                                        <select name="competencia_id" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white; color: #1f2937;">
                                            <option value="">Seleccionar...</option>
                                            <?php foreach ($competencias as $competencia): ?>
                                                <option value="<?php echo htmlspecialchars($competencia['comp_id'] ?? ''); ?>">
                                                    <?php echo htmlspecialchars($competencia['comp_nombre_corto'] ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #F3F4F6; color: #6B7280; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">OPCIONAL</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #6B7280; font-size: 18px;">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Días de la semana -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px;">Días de la semana</label>
                        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px;">
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="1" checked style="width: 16px; height: 16px;">
                                Lun
                            </label>
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="2" checked style="width: 16px; height: 16px;">
                                Mar
                            </label>
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="3" checked style="width: 16px; height: 16px;">
                                Mié
                            </label>
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="4" checked style="width: 16px; height: 16px;">
                                Jue
                            </label>
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="5" checked style="width: 16px; height: 16px;">
                                Vie
                            </label>
                            <label style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; background: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #6b7280;">
                                <input type="checkbox" name="dias[]" value="6" style="width: 16px; height: 16px;">
                                Sáb
                            </label>
                        </div>
                    </div>

                    <!-- Rango de fechas y horas -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Rango de Fechas</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="date" name="fecha_inicio" value="${hoy}" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                <span style="color: #6b7280;">-</span>
                                <input type="date" name="fecha_fin" value="${hoy}" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Rango de Horas</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="time" name="hora_inicio" value="08:00" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                <span style="color: #6b7280;">-</span>
                                <input type="time" name="hora_fin" value="17:00" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                            </div>
                            <p style="font-size: 11px; color: #6b7280; margin: 6px 0 0; font-style: italic;">Horario: 6:00 AM - 10:00 PM</p>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div style="display: flex; gap: 12px; padding-top: 8px; border-top: 1px solid #e5e7eb;">
                        <button type="button" onclick="cerrarModal()" style="flex: 1; padding: 14px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            Cancelar
                        </button>
                        <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(57, 169, 0, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.3)'">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Agregar efecto hover a los checkboxes de días
    document.querySelectorAll('#modalNuevaAsignacion label:has(input[type="checkbox"])').forEach(label => {
        const checkbox = label.querySelector('input[type="checkbox"]');
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                label.style.borderColor = '#39A900';
                label.style.background = '#E8F5E8';
                label.style.color = '#39A900';
            } else {
                label.style.borderColor = '#e5e7eb';
                label.style.background = 'white';
                label.style.color = '#6b7280';
            }
        });
    });
}

function cerrarModal() {
    const modal = document.getElementById('modalNuevaAsignacion');
    if (modal) {
        modal.remove();
    }
}
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="4" checked style="width: 16px; height: 16px;">
                                Jue
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #39A900;">
                                <input type="checkbox" name="dias[]" value="5" checked style="width: 16px; height: 16px;">
                                Vie
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px; border: 2px solid #e5e7eb; background: white; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #6b7280;">
                                <input type="checkbox" name="dias[]" value="6" style="width: 16px; height: 16px;">
                                Sáb
                            </label>
                        </div>
                    </div>

                    <!-- Rango de fechas y horas -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Rango de Fechas</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="date" name="fecha_inicio" value="${hoy}" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                <span style="color: #6b7280;">-</span>
                                <input type="date" name="fecha_fin" value="${hoy}" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Rango de Horas</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="time" name="hora_inicio" value="06:00" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                <span style="color: #6b7280;">-</span>
                                <input type="time" name="hora_fin" value="22:00" required style="flex: 1; padding: 10px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                            </div>
                            <p style="font-size: 11px; color: #6b7280; margin: 6px 0 0; font-style: italic;">Horario: 6:00 AM - 10:00 PM</p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div style="display: flex; gap: 12px;">
                        <button type="button" onclick="cerrarModal()" style="flex: 1; padding: 14px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            Cancelar
                        </button>
                        <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(57, 169, 0, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.3)'">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
}

function cerrarModal() {
    const modal = document.getElementById('modalNuevaAsignacion');
    if (modal) {
        modal.remove();
    }
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
