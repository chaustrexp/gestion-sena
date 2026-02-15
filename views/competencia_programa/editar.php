<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/CompetenciaProgramaModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';
require_once __DIR__ . '/../../model/ProgramaModel.php';

$model = new CompetenciaProgramaModel();
$competenciaModel = new CompetenciaModel();
$programaModel = new ProgramaModel();
$competencias = $competenciaModel->getAll();
$programas = $programaModel->getAll();

$id = $_GET['id'];
$registro = $model->getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->update($id, $_POST);
    header('Location: index.php?msg=actualizado');
    exit;
}

$pageTitle = "Editar Competencia-Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Relación Competencia-Programa</h2>
        <form method="POST">
            <div class="form-group">
                <label>Competencia *</label>
                <select name="competencia_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?php echo $competencia['id']; ?>" <?php echo $registro['competencia_id'] == $competencia['id'] ? 'selected' : ''; ?>>
                            <?php echo $competencia['codigo']; ?> - <?php echo $competencia['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Programa *</label>
                <select name="programa_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id']; ?>" <?php echo $registro['programa_id'] == $programa['id'] ? 'selected' : ''; ?>>
                            <?php echo $programa['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Horas *</label>
                <input type="number" name="horas" class="form-control" value="<?php echo $registro['horas']; ?>" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
