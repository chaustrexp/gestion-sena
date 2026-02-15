<?php
require_once __DIR__ . '/../../model/InstructorModel.php';
$model = new InstructorModel();
$id = $_GET['id'];
$registro = $model->getById($id);
$pageTitle = "Ver Instructor";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>
<div class="main-content">
    <div class="detail-card">
        <h2>Detalle del Instructor</h2>
        <div class="detail-row"><div class="detail-label">ID:</div><div><?php echo $registro['id']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Nombre:</div><div><?php echo $registro['nombre']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Documento:</div><div><?php echo $registro['documento']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Email:</div><div><?php echo $registro['email']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Teléfono:</div><div><?php echo $registro['telefono']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Centro:</div><div><?php echo $registro['centro_nombre']; ?></div></div>
        <div class="detail-row"><div class="detail-label">Fecha Creación:</div><div><?php echo $registro['created_at']; ?></div></div>
        <div class="btn-group" style="margin-top: 20px;">
            <a href="editar.php?id=<?php echo $registro['id']; ?>" class="btn btn-primary">Editar</a>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
