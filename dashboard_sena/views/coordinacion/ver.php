<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/CoordinacionModel.php';

$model = new CoordinacionModel();
$id = $_GET['id'];
$registro = $model->getById($id);

$pageTitle = "Ver Coordinación";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="detail-card">
        <h2>Detalle de la Coordinación</h2>
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div><?php echo $registro['id']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Nombre:</div>
            <div><?php echo $registro['nombre']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Centro de Formación:</div>
            <div><?php echo $registro['centro_nombre']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Responsable:</div>
            <div><?php echo $registro['responsable']; ?></div>
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
