<?php
// Proteger página con autenticación
require_once __DIR__ . '/auth/check_auth.php';

require_once __DIR__ . '/model/ProgramaModel.php';
require_once __DIR__ . '/model/FichaModel.php';
require_once __DIR__ . '/model/InstructorModel.php';
require_once __DIR__ . '/model/AmbienteModel.php';
require_once __DIR__ . '/model/AsignacionModel.php';

$programaModel = new ProgramaModel();
$fichaModel = new FichaModel();
$instructorModel = new InstructorModel();
$ambienteModel = new AmbienteModel();
$asignacionModel = new AsignacionModel();

$totalProgramas = $programaModel->count();
$totalFichas = $fichaModel->count();
$totalInstructores = $instructorModel->count();
$totalAmbientes = $ambienteModel->count();
$totalAsignaciones = $asignacionModel->count();
$ultimasAsignaciones = $asignacionModel->getRecent(5);

$pageTitle = "Dashboard Principal";
include __DIR__ . '/views/layout/header.php';
include __DIR__ . '/views/layout/sidebar.php';
?>

<div class="main-content">
    <!-- Título del Dashboard -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">Panel de Control</h1>
        <p class="dashboard-subtitle">Resumen general del sistema de gestión SENA</p>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);">
                <i data-lucide="book-open"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Programas</span>
                <span class="stat-value"><?php echo $totalProgramas; ?></span>
            </div>
            <div class="stat-accent"></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i data-lucide="file-text"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Fichas</span>
                <span class="stat-value"><?php echo $totalFichas; ?></span>
            </div>
            <div class="stat-accent"></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Instructores</span>
                <span class="stat-value"><?php echo $totalInstructores; ?></span>
            </div>
            <div class="stat-accent"></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i data-lucide="home"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Ambientes</span>
                <span class="stat-value"><?php echo $totalAmbientes; ?></span>
            </div>
            <div class="stat-accent"></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                <i data-lucide="calendar"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Total Asignaciones</span>
                <span class="stat-value"><?php echo $totalAsignaciones; ?></span>
            </div>
            <div class="stat-accent"></div>
        </div>
    </div>

    <!-- Tabla de Últimas Asignaciones -->
    <div class="table-section">
        <div class="section-header">
            <div class="section-title">
                <i data-lucide="clock"></i>
                <h2>Últimas Asignaciones</h2>
            </div>
            <a href="/Gestion-sena/views/asignacion/index.php" class="btn-view-all">
                Ver todas
                <i data-lucide="arrow-right"></i>
            </a>
        </div>

        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ficha</th>
                        <th>Instructor</th>
                        <th>Ambiente</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimasAsignaciones)): ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i data-lucide="inbox"></i>
                            <p>No hay asignaciones registradas</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($ultimasAsignaciones as $asignacion): ?>
                        <tr>
                            <td><span class="badge badge-id">#<?php echo $asignacion['id']; ?></span></td>
                            <td><strong><?php echo $asignacion['ficha_numero']; ?></strong></td>
                            <td><?php echo $asignacion['instructor_nombre']; ?></td>
                            <td><?php echo $asignacion['ambiente_nombre']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($asignacion['fecha_inicio'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($asignacion['fecha_fin'])); ?></td>
                            <td>
                                <?php 
                                $hoy = date('Y-m-d');
                                if ($asignacion['fecha_fin'] < $hoy) {
                                    echo '<span class="badge badge-danger">Finalizada</span>';
                                } elseif ($asignacion['fecha_inicio'] > $hoy) {
                                    echo '<span class="badge badge-warning">Pendiente</span>';
                                } else {
                                    echo '<span class="badge badge-success">Activa</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script para Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<?php include __DIR__ . '/views/layout/footer.php'; ?>
