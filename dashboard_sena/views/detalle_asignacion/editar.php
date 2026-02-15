<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/DetalleAsignacionModel.php';
require_once __DIR__ . '/../../model/AsignacionModel.php';

$model = new DetalleAsignacionModel();
$asignacionModel = new AsignacionModel();
$asignaciones = $asignacionModel->getAll();

$id = $_GET['id'];
$registro = $model->getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->update($id, $_POST);
    header('Location: index.php?msg=actualizado');
    exit;
}

$pageTitle = "Editar Detalle Asignación";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Detalle de Asignación</h2>
        <form method="POST">
            <div class="form-group">
                <label>Asignación *</label>
                <select name="asignacion_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($asignaciones as $asignacion): ?>
                        <option value="<?php echo $asignacion['id']; ?>" <?php echo $registro['asignacion_id'] == $asignacion['id'] ? 'selected' : ''; ?>>
                            ID: <?php echo $asignacion['id']; ?> - Ficha: <?php echo $asignacion['ficha_numero']; ?> - Instructor: <?php echo $asignacion['instructor_nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Fecha *</label>
                <input type="date" name="fecha" class="form-control" value="<?php echo $registro['fecha']; ?>" required>
            </div>
            <div class="form-group">
                <label>Hora Inicio *</label>
                <input type="time" name="hora_inicio" class="form-control" value="<?php echo $registro['hora_inicio']; ?>" required>
            </div>
            <div class="form-group">
                <label>Hora Fin *</label>
                <input type="time" name="hora_fin" class="form-control" value="<?php echo $registro['hora_fin']; ?>" required>
            </div>
            <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="4"><?php echo $registro['observaciones']; ?></textarea>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
