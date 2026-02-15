<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/DetalleAsignacionModel.php';

$model = new DetalleAsignacionModel();
$id = $_GET['id'];
$registro = $model->getById($id);

$pageTitle = "Ver Detalle Asignación";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="detail-card">
        <h2>Detalle de Asignación</h2>
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div><?php echo $registro['id']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Asignación ID:</div>
            <div><?php echo $registro['asignacion_id']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Ficha:</div>
            <div><?php echo $registro['ficha_numero']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Instructor:</div>
            <div><?php echo $registro['instructor_nombre']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Fecha:</div>
            <div><?php echo $registro['fecha']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Hora Inicio:</div>
            <div><?php echo $registro['hora_inicio']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Hora Fin:</div>
            <div><?php echo $registro['hora_fin']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Observaciones:</div>
            <div><?php echo $registro['observaciones']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Fecha Creación:</div>
            <div><?php echo $registro['created_at']; ?></div>
        </div>
        <div class="btn-group" style="margin-top: 20px;">
            <a href="editar.php?id=<?php echo $registro['id']; ?>" class="btn btn-primary">Editar</a>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
