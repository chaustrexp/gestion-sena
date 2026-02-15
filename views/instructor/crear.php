<?php
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/CentroFormacionModel.php';
$model = new InstructorModel();
$centroModel = new CentroFormacionModel();
$centros = $centroModel->getAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { $model->create($_POST); header('Location: index.php?msg=creado'); exit; }
$pageTitle = "Crear Instructor";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>
<div class="main-content">
    <div class="form-container">
        <h2>Crear Nuevo Instructor</h2>
        <form method="POST">
            <div class="form-group"><label>Nombre *</label><input type="text" name="nombre" class="form-control" required></div>
            <div class="form-group"><label>Documento *</label><input type="text" name="documento" class="form-control" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
            <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
            <div class="form-group"><label>Centro Formación</label><select name="centro_formacion_id" class="form-control"><option value="">Seleccione...</option><?php foreach ($centros as $centro): ?><option value="<?php echo $centro['id']; ?>"><?php echo $centro['nombre']; ?></option><?php endforeach; ?></select></div>
            <div class="btn-group"><button type="submit" class="btn btn-primary">Guardar</button><a href="index.php" class="btn btn-secondary">Cancelar</a></div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
