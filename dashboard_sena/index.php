<?php
// Proteger página con autenticación
require_once __DIR__ . '/auth/check_auth.php';

require_once __DIR__ . '/model/ProgramaModel.php';
require_once __DIR__ . '/model/FichaModel.php';
require_once __DIR__ . '/model/InstructorModel.php';
require_once __DIR__ . '/model/AmbienteModel.php';
require_once __DIR__ . '/model/AsignacionModel.php';
require_once __DIR__ . '/model/InstruCompetenciaModel.php';

// Verificar si la base de datos existe
try {
    $programaModel = new ProgramaModel();
    $fichaModel = new FichaModel();
    $instructorModel = new InstructorModel();
    $ambienteModel = new AmbienteModel();
    $asignacionModel = new AsignacionModel();
    $instruCompetenciaModel = new InstruCompetenciaModel();

    $totalProgramas = $programaModel->count();
    $totalFichas = $fichaModel->count();
    $totalInstructores = $instructorModel->count();
    $totalAmbientes = $ambienteModel->count();
    $totalAsignaciones = $asignacionModel->count();
    $totalCompetenciasInstructor = $instruCompetenciaModel->count();
    $competenciasVigentes = $instruCompetenciaModel->countVigentes();
    $ultimasAsignaciones = $asignacionModel->getRecent(5);
} catch (Exception $e) {
    // Si hay error, simplemente mostrar arrays vacíos
    $totalProgramas = 0;
    $totalFichas = 0;
    $totalInstructores = 0;
    $totalAmbientes = 0;
    $totalAsignaciones = 0;
    $totalCompetenciasInstructor = 0;
    $competenciasVigentes = 0;
    $ultimasAsignaciones = [];
}

$pageTitle = "Dashboard Principal";
include __DIR__ . '/views/layout/header.php';
include __DIR__ . '/views/layout/sidebar.php';
?>

<div class="main-content">
    <!-- Header del Dashboard -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <h1 style="font-size: 32px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Bienvenido al Sistema SENA</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">Resumen general de la gestión académica</p>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 24px 32px;">
        
        <!-- Programas -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #E8F5E8; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="book-open" style="width: 24px; height: 24px; color: #39A900;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Programas</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalProgramas; ?></div>
        </div>

        <!-- Fichas -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #EFF6FF; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="file-text" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Fichas</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalFichas; ?></div>
        </div>

        <!-- Instructores -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #F5F3FF; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="users" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Instructores</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalInstructores; ?></div>
        </div>

        <!-- Ambientes -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="home" style="width: 24px; height: 24px; color: #f59e0b;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Ambientes</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalAmbientes; ?></div>
        </div>

        <!-- Asignaciones -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #FCE7F3; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="calendar" style="width: 24px; height: 24px; color: #ec4899;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Asignaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalAsignaciones; ?></div>
        </div>

        <!-- Competencias de Instructores -->
        <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; transition: all 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #F5F3FF; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="award" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
                </div>
            </div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Competencias Instructor</div>
            <div style="font-size: 32px; font-weight: 700; color: #1f2937;"><?php echo $totalCompetenciasInstructor; ?></div>
            <div style="font-size: 12px; color: #10b981; margin-top: 8px;">
                <i data-lucide="check-circle" style="width: 14px; height: 14px; vertical-align: middle;"></i>
                <?php echo $competenciasVigentes; ?> vigentes
            </div>
        </div>
    </div>

    <!-- Tabla de Últimas Asignaciones -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            
            <!-- Header de la tabla -->
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Últimas Asignaciones</h2>
                    <p style="font-size: 13px; color: #6b7280; margin: 0;">Asignaciones recientes del sistema</p>
                </div>
                <a href="/Gestion-sena/dashboard_sena/views/asignacion/index.php" class="btn btn-secondary btn-sm">
                    Ver todas
                </a>
            </div>

            <!-- Tabla -->
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ficha</th>
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ambiente</th>
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Inicio</th>
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Fin</th>
                            <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ultimasAsignaciones)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                                <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
                                <p style="margin: 0; font-size: 16px;">No hay asignaciones registradas</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($ultimasAsignaciones as $asignacion): ?>
                            <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;">
                                <td style="padding: 16px 24px;">
                                    <strong style="color: #1f2937;"><?php echo htmlspecialchars($asignacion['ficha_numero'] ?? ''); ?></strong>
                                </td>
                                <td style="padding: 16px 24px; color: #6b7280;">
                                    <?php echo htmlspecialchars($asignacion['instructor_nombre'] ?? ''); ?>
                                </td>
                                <td style="padding: 16px 24px; color: #6b7280;">
                                    <?php echo htmlspecialchars($asignacion['ambiente_nombre'] ?? ''); ?>
                                </td>
                                <td style="padding: 16px 24px; color: #6b7280;">
                                    <?php echo isset($asignacion['fecha_inicio']) ? date('d/m/Y', strtotime($asignacion['fecha_inicio'])) : 'N/A'; ?>
                                </td>
                                <td style="padding: 16px 24px; color: #6b7280;">
                                    <?php echo isset($asignacion['fecha_fin']) ? date('d/m/Y', strtotime($asignacion['fecha_fin'])) : 'N/A'; ?>
                                </td>
                                <td style="padding: 16px 24px;">
                                    <?php 
                                    $hoy = date('Y-m-d');
                                    $fecha_inicio = $asignacion['fecha_inicio'] ?? '';
                                    $fecha_fin = $asignacion['fecha_fin'] ?? '';
                                    
                                    if ($fecha_fin && $fecha_fin < $hoy) {
                                        echo '<span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Finalizada</span>';
                                    } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                                        echo '<span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Pendiente</span>';
                                    } else {
                                        echo '<span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Activa</span>';
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
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
    
    // Hover effect en cards
    document.querySelectorAll('[style*="background: white"]').forEach(card => {
        if (card.querySelector('[data-lucide]')) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        }
    });
    
    // Hover effect en filas de tabla
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
</script>

<?php include __DIR__ . '/views/layout/footer.php'; ?>
