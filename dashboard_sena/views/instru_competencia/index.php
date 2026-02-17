<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/InstruCompetenciaModel.php';
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/ProgramaModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';

$model = new InstruCompetenciaModel();
$instructorModel = new InstructorModel();
$programaModel = new ProgramaModel();
$competenciaModel = new CompetenciaModel();

// Manejar creación desde modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_competencia'])) {
    $model->create($_POST);
    header('Location: index.php?msg=creado');
    exit;
}

if (isset($_GET['eliminar'])) {
    $model->delete($_GET['eliminar']);
    header('Location: index.php?msg=eliminado');
    exit;
}

$registros = $model->getAll();
$instructores = $instructorModel->getAll();
$programas = $programaModel->getAll();
$competencias = $competenciaModel->getAll();
$pageTitle = "Competencias de Instructores";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Competencias de Instructores</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las competencias asignadas a cada instructor</p>
        </div>
        <button onclick="abrirModalNuevaCompetencia()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Asignación
        </button>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            if ($_GET['msg'] == 'creado') echo '✓ Competencia asignada exitosamente';
            if ($_GET['msg'] == 'actualizado') echo '✓ Competencia actualizada exitosamente';
            if ($_GET['msg'] == 'eliminado') echo '✓ Competencia eliminada exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Asignaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #8b5cf6;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Vigentes</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;">
                <?php 
                $hoy = date('Y-m-d');
                $vigentes = array_filter($registros, function($r) use ($hoy) {
                    return $r['inscomp_vigencia'] >= $hoy;
                });
                echo count($vigentes);
                ?>
            </div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Vencidas</div>
            <div style="font-size: 32px; font-weight: 700; color: #ef4444;">
                <?php echo count($registros) - count($vigentes); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Competencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Vigencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎯</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay competencias asignadas</p>
                            <a href="crear.php" class="btn btn-primary btn-sm">Crear Primera Asignación</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo $registro['instructor_nombre']; ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo $registro['prog_denominacion']; ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <strong style="color: #8b5cf6;"><?php echo $registro['comp_nombre_corto']; ?></strong>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo date('d/m/Y', strtotime($registro['inscomp_vigencia'])); ?>
                            </td>
                            <td style="padding: 16px;">
                                <?php 
                                $hoy = date('Y-m-d');
                                if ($registro['inscomp_vigencia'] >= $hoy) {
                                    echo '<span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Vigente</span>';
                                } else {
                                    echo '<span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Vencida</span>';
                                }
                                ?>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="ver.php?id=<?php echo $registro['inscomp_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="editar.php?id=<?php echo $registro['inscomp_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['inscomp_id']; ?>, 'competencia de instructor')" class="btn btn-danger btn-sm">Eliminar</button>
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

    // Función para abrir modal de nueva competencia
    function abrirModalNuevaCompetencia() {
        const hoy = new Date().toISOString().split('T')[0];
        const fechaFormateada = new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        const modal = `
            <div id="modalNuevaCompetencia" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='modalNuevaCompetencia') cerrarModalCompetencia()">
                <div style="background: white; border-radius: 12px; max-width: 500px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                    
                    <!-- Header Morado -->
                    <div style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); padding: 24px; color: white;">
                        <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Nueva Competencia de Instructor</h3>
                        <p style="font-size: 14px; margin: 0; opacity: 0.95;">${fechaFormateada}</p>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="" style="padding: 24px;">
                        <input type="hidden" name="crear_competencia" value="1">
                        
                        <!-- Instructor -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Instructor:</label>
                            <select name="INSTRUCTOR_inst_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                                <option value="">Seleccione un instructor</option>
                                <?php foreach ($instructores as $instructor): ?>
                                    <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Programa -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Programa:</label>
                            <select name="COMPETxPROGRAMA_PROGRAMA_prog_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                                <option value="">Seleccione un programa</option>
                                <?php foreach ($programas as $programa): ?>
                                    <option value="<?php echo htmlspecialchars($programa['prog_codigo'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($programa['prog_denominacion'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Competencia -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Competencia:</label>
                            <select name="COMPETxPROGRAMA_COMPETENCIA_comp_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                                <option value="">Seleccione una competencia</option>
                                <?php foreach ($competencias as $competencia): ?>
                                    <option value="<?php echo htmlspecialchars($competencia['comp_id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($competencia['comp_nombre_corto'] ?? ''); ?> - <?php echo htmlspecialchars($competencia['comp_nombre_unidad_competencia'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Vigencia -->
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Fecha de Vigencia:</label>
                            <input type="date" name="inscomp_vigencia" value="${hoy}" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                            <p style="font-size: 11px; color: #6b7280; margin: 6px 0 0; font-style: italic;">Fecha hasta la cual la competencia es válida</p>
                        </div>

                        <!-- Botones -->
                        <div style="display: flex; gap: 12px;">
                            <button type="button" onclick="cerrarModalCompetencia()" style="flex: 1; padding: 14px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                                Cancelar
                            </button>
                            <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(139, 92, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)'">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modal);
    }

    function cerrarModalCompetencia() {
        const modal = document.getElementById('modalNuevaCompetencia');
        if (modal) {
            modal.remove();
        }
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
