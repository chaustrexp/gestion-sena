<?php
require_once __DIR__ . '/../../model/ProgramaModel.php';
require_once __DIR__ . '/../../model/TituloProgramaModel.php';

$model = new ProgramaModel();
$tituloModel = new TituloProgramaModel();
$titulos = $tituloModel->getAll();

$id = $_GET['id'];
$registro = $model->getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->update($id, $_POST);
    header('Location: index.php?msg=actualizado');
    exit;
}

$pageTitle = "Editar Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Programa</h2>
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
                <label>Duración (meses) *</label>
                <input type="number" name="duracion_meses" class="form-control" value="<?php echo $registro['duracion_meses']; ?>" required>
            </div>
            <div class="form-group">
                <label>Título Programa</label>
                <select name="titulo_programa_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($titulos as $titulo): ?>
                        <option value="<?php echo $titulo['id']; ?>" <?php echo $registro['titulo_programa_id'] == $titulo['id'] ? 'selected' : ''; ?>>
                            <?php echo $titulo['nombre']; ?>
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
