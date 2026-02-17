<?php
require_once __DIR__ . '/../../model/TituloProgramaModel.php';

$model = new TituloProgramaModel();

if (isset($_GET['eliminar'])) {
    $model->delete($_GET['eliminar']);
    header('Location: index.php?msg=eliminado');
    exit;
}

$registros = $model->getAll();
$pageTitle = "Gestión de Títulos de Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Títulos de Programa</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona los títulos otorgados por los programas</p>
        </div>
        <a href="crear.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nuevo Título
        </a>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            if ($_GET['msg'] == 'creado') echo '✓ Título creado exitosamente';
            if ($_GET['msg'] == 'actualizado') echo '✓ Título actualizado exitosamente';
            if ($_GET['msg'] == 'eliminado') echo '✓ Título eliminado exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Títulos</div>
            <div style="font-size: 32px; font-weight: 700; color: #f59e0b;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Registrados</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;">
                <?php echo count($registros); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">ID</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nombre del Título</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎓</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay títulos registrados</p>
                            <a href="crear.php" class="btn btn-primary btn-sm">Crear Primer Título</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #f59e0b; font-size: 14px;"><?php echo htmlspecialchars($registro['titpro_id']); ?></strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['titpro_nombre']); ?></div>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="ver.php?id=<?php echo $registro['titpro_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="editar.php?id=<?php echo $registro['titpro_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['titpro_id']; ?>, 'titulo_programa')" class="btn btn-danger btn-sm">Eliminar</button>
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
