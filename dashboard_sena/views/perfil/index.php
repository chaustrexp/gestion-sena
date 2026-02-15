<?php
$pageTitle = "Mi Perfil";
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../conexion.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';
    
    try {
        // Actualizar nombre y email
        if (!empty($nombre) && !empty($email)) {
            $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $_SESSION['usuario_id']]);
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email'] = $email;
            $mensaje = 'Perfil actualizado correctamente';
        }
        
        // Cambiar contraseña si se proporcionó
        if (!empty($password_actual) && !empty($password_nueva)) {
            if ($password_nueva !== $password_confirmar) {
                $error = 'Las contraseñas nuevas no coinciden';
            } elseif (!password_verify($password_actual, $usuario['password'])) {
                $error = 'La contraseña actual es incorrecta';
            } else {
                $hash = password_hash($password_nueva, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $stmt->execute([$hash, $_SESSION['usuario_id']]);
                $mensaje = 'Contraseña actualizada correctamente';
            }
        }
        
        // Recargar datos del usuario
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $usuario = $stmt->fetch();
        
    } catch (PDOException $e) {
        $error = 'Error al actualizar el perfil';
    }
}

include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-content">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Mi Perfil</h1>
        <p class="dashboard-subtitle">Administra tu información personal y contraseña</p>
    </div>

    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i data-lucide="user-circle"></i>
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($usuario['rol']); ?></p>
                    <span class="profile-badge <?php echo $usuario['estado'] === 'Activo' ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $usuario['estado']; ?>
                    </span>
                </div>
            </div>

            <form method="POST" class="profile-form">
                <h3>Información Personal</h3>
                
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Rol</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['rol']); ?>" disabled>
                </div>

                <div class="form-divider"></div>

                <h3>Cambiar Contraseña</h3>
                <p class="form-hint">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                <div class="form-group">
                    <label for="password_actual">Contraseña Actual</label>
                    <input type="password" id="password_actual" name="password_actual" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_nueva">Nueva Contraseña</label>
                    <input type="password" id="password_nueva" name="password_nueva" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmar">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmar" name="password_confirmar" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i>
                        Guardar Cambios
                    </button>
                    <a href="/Gestion-sena/index.php" class="btn btn-secondary">
                        <i data-lucide="x"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <div class="profile-stats">
            <h3>Información de la Cuenta</h3>
            <div class="stat-item">
                <i data-lucide="calendar"></i>
                <div>
                    <span>Fecha de Registro</span>
                    <strong><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></strong>
                </div>
            </div>
            <div class="stat-item">
                <i data-lucide="clock"></i>
                <div>
                    <span>Último Acceso</span>
                    <strong><?php echo $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca'; ?></strong>
                </div>
            </div>
            <div class="stat-item">
                <i data-lucide="shield"></i>
                <div>
                    <span>Estado</span>
                    <strong><?php echo $usuario['estado']; ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
