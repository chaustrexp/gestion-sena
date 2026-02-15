<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/DetalleAsignacionModel.php';

$model = new DetalleAsignacionModel();

if (isset($_GET['eliminar'])) {
    $model->delete($_GET['eliminar']);
    header('Location: index.php?msg=eliminado');
    exit;
}

$registros = $model->getAll();
$pageTitle = "Gestión de Detalle Asignación";
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
            <h2>Listado de Detalle Asignación</h2>
            <a href="crear.php" class="btn btn-primary">+ Nuevo Detalle</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Asignación</th>
                    <th>Ficha</th>
                    <th>Instructor</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['asignacion_id']; ?></td>
                    <td><?php echo $registro['ficha_numero']; ?></td>
                    <td><?php echo $registro['instructor_nombre']; ?></td>
                    <td><?php echo $registro['fecha']; ?></td>
                    <td><?php echo $registro['hora_inicio']; ?></td>
                    <td><?php echo $registro['hora_fin']; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="ver.php?id=<?php echo $registro['id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                            <a href="editar.php?id=<?php echo $registro['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <button onclick="confirmarEliminacion(<?php echo $registro['id']; ?>, 'detalle_asignacion')" class="btn btn-danger btn-sm">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
