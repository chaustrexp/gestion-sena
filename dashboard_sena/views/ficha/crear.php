<?php
require_once __DIR__ . '/../../model/FichaModel.php';
require_once __DIR__ . '/../../model/ProgramaModel.php';

$model = new FichaModel();
$programaModel = new ProgramaModel();
$programas = $programaModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->create($_POST);
    header('Location: index.php?msg=creado');
    exit;
}

$pageTitle = "Crear Ficha";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Crear Nueva Ficha</h2>
        <form method="POST">
            <div class="form-group">
                <label>Número *</label>
                <input type="text" name="numero" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Programa *</label>
                <select name="programa_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id']; ?>"><?php echo $programa['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Fecha Inicio *</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Fecha Fin *</label>
                <input type="date" name="fecha_fin" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Estado *</label>
                <select name="estado" class="form-control" required>
                    <option value="Activa">Activa</option>
                    <option value="Inactiva">Inactiva</option>
                    <option value="Finalizada">Finalizada</option>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
