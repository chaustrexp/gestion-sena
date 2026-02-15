<?php
require_once __DIR__ . '/../../model/FichaModel.php';

$model = new FichaModel();
$id = $_GET['id'];
$registro = $model->getById($id);

$pageTitle = "Ver Ficha";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="detail-card">
        <h2>Detalle de la Ficha</h2>
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div><?php echo $registro['id']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Número:</div>
            <div><?php echo $registro['numero']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Programa:</div>
            <div><?php echo $registro['programa_nombre']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Fecha Inicio:</div>
            <div><?php echo $registro['fecha_inicio']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Fecha Fin:</div>
            <div><?php echo $registro['fecha_fin']; ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Estado:</div>
            <div><?php echo $registro['estado']; ?></div>
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
