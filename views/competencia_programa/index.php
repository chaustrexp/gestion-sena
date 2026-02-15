<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/CompetenciaProgramaModel.php';

$model = new CompetenciaProgramaModel();

if (isset($_GET['eliminar'])) {
    $model->delete($_GET['eliminar']);
    header('Location: index.php?msg=eliminado');
    exit;
}

$registros = $model->getAll();
$pageTitle = "Gestión de Competencia-Programa";
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php 
            if ($_GET['msg'] == 'creado') echo 'Registro creado exitosamente';
            if ($_GET['msg'] == 'actualizado') echo 'Registro actualizado exitosamente';
            if ($_GET['msg'] == 'eliminado') echo 'Registro eliminado exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <div class="table-header">
            <h2>Listado de Competencia-Programa</h2>
            <a href="crear.php" class="btn btn-primary">+ Nueva Relación</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Competencia</th>
                    <th>Programa</th>
                    <th>Horas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['competencia_nombre']; ?></td>
                    <td><?php echo $registro['programa_nombre']; ?></td>
                    <td><?php echo $registro['horas']; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="ver.php?id=<?php echo $registro['id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                            <a href="editar.php?id=<?php echo $registro['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <button onclick="confirmarEliminacion(<?php echo $registro['id']; ?>, 'competencia_programa')" class="btn btn-danger btn-sm">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
