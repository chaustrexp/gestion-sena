<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/CompetenciaProgramaModel.php';

$model = new CompetenciaProgramaModel();

if (isset($_GET['eliminar'])) {
    // Formato: prog_id_comp_id
    $ids = explode('_', $_GET['eliminar']);
    if (count($ids) == 2) {
        $model->delete($ids[0], $ids[1]);
    }
    header('Location: index.php?msg=eliminado');
    exit;
}

$registros = $model->getAll();
$pageTitle = "Gestión de Competencia-Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Competencias por Programa</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona la relación entre competencias y programas</p>
        </div>
        <a href="crear.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Relación
        </a>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            if ($_GET['msg'] == 'creado') echo '✓ Relación creada exitosamente';
            if ($_GET['msg'] == 'actualizado') echo '✓ Relación actualizada exitosamente';
            if ($_GET['msg'] == 'eliminado') echo '✓ Relación eliminada exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Relaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #6366f1;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Programas Vinculados</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;">
                <?php echo count(array_unique(array_column($registros, 'PROGRAMA_prog_id'))); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Competencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 120px;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🔗</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay relaciones registradas</p>
                            <a href="crear.php" class="btn btn-primary btn-sm">Crear Primera Relación</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? ''); ?></div>
                                <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                                    ID: <?php echo htmlspecialchars($registro['COMPETENCIA_comp_id'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['prog_denominacion'] ?? ''); ?></div>
                                <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                                    Código: <?php echo htmlspecialchars($registro['PROGRAMA_prog_id'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: #EFF6FF; color: #3b82f6; padding: 6px 12px; border-radius: 12px; font-size: 14px; font-weight: 700;">
                                    Relación
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="ver.php?prog_id=<?php echo $registro['PROGRAMA_prog_id']; ?>&comp_id=<?php echo $registro['COMPETENCIA_comp_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <button onclick="if(confirm('¿Eliminar esta relación?')) window.location.href='index.php?eliminar=<?php echo $registro['PROGRAMA_prog_id']; ?>_<?php echo $registro['COMPETENCIA_comp_id']; ?>'" class="btn btn-danger btn-sm">Eliminar</button>
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
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
