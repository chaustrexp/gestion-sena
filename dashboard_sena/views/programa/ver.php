<?php
require_once __DIR__ . '/../../model/ProgramaModel.php';

$model = new ProgramaModel();
$id = $_GET['id'];
$registro = $model->getById($id);

$pageTitle = "Ver Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="detail-card">
        <h2>Detalle del Programa</h2>
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div><?php echo $registro['id']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Código:</div>
            <div><?php echo $registro['codigo']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Nombre:</div>
            <div><?php echo $registro['nombre']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Duración (meses):</div>
            <div><?php echo $registro['duracion_meses']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Título Programa:</div>
            <div><?php echo $registro['titulo_nombre']; ?></div>
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
