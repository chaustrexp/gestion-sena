<?php
require_once __DIR__ . '/../../model/InstruCompetenciaModel.php';
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/ProgramaModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';

$model = new InstruCompetenciaModel();
$instructorModel = new InstructorModel();
$programaModel = new ProgramaModel();
$competenciaModel = new CompetenciaModel();

$instructores = $instructorModel->getAll();
$programas = $programaModel->getAll();
$competencias = $competenciaModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->create($_POST);
    header('Location: index.php?msg=creado');
    exit;
}

$pageTitle = "Asignar Competencia a Instructor";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="form-container">
        <h2>Asignar Competencia a Instructor</h2>
        <form method="POST">
            <div class="form-group">
                <label>Instructor *</label>
                <select name="INSTRUCTOR_inst_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($instructores as $instructor): ?>
                        <option value="<?php echo $instructor['inst_id']; ?>">
                            <?php echo $instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Programa *</label>
                <select name="COMPETxPROGRAMA_PROGRAMA_prog_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['prog_codigo']; ?>">
                            <?php echo $programa['prog_denominacion']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Competencia *</label>
                <select name="COMPETxPROGRAMA_COMPETENCIA_comp_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?php echo $competencia['comp_id']; ?>">
                            <?php echo $competencia['comp_nombre_corto'] . ' - ' . $competencia['comp_nombre_unidad_competencia']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha de Vigencia *</label>
                <input type="date" name="inscomp_vigencia" class="form-control" required>
                <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                    Fecha hasta la cual el instructor está certificado para impartir esta competencia
                </small>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
