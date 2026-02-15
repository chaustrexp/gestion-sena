<?php
require_once __DIR__ . '/../../model/AmbienteModel.php';
require_once __DIR__ . '/../../model/SedeModel.php';

$model = new AmbienteModel();
$sedeModel = new SedeModel();
$sedes = $sedeModel->getAll();

$id = $_GET['id'];
$registro = $model->getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->update($id, $_POST);
    header('Location: index.php?msg=actualizado');
    exit;
}

$pageTitle = "Editar Ambiente";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Ambiente</h2>
        <form method="POST">
            <div class="form-group">
                <label>Código *</label>
                <input type="text" name="codigo" class="form-control" value="<?php echo $registro['codigo']; ?>" required>
            </div>
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $registro['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label>Capacidad *</label>
                <input type="number" name="capacidad" class="form-control" value="<?php echo $registro['capacidad']; ?>" required>
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <input type="text" name="tipo" class="form-control" value="<?php echo $registro['tipo']; ?>" required>
            </div>
            <div class="form-group">
                <label>Sede</label>
                <select name="sede_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($sedes as $sede): ?>
                        <option value="<?php echo $sede['id']; ?>" <?php echo $registro['sede_id'] == $sede['id'] ? 'selected' : ''; ?>>
                            <?php echo $sede['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
