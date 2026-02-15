<?php
// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /Gestion-sena/auth/login.php');
    exit;
}

// Forzar UTF-8 en la salida
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

// Deshabilitar caché para desarrollo (comentar en producción)
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Versión para forzar recarga de CSS/JS
$version = time(); // Cambia en cada recarga
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard SENA'; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/Gestion-sena/dashboard_sena/assets/images/favicon.svg">
    <link rel="alternate icon" href="/Gestion-sena/dashboard_sena/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/Gestion-sena/dashboard_sena/assets/images/favicon.svg">
    
    <link rel="stylesheet" href="/Gestion-sena/dashboard_sena/assets/css/styles.css?v=<?php echo $version; ?>">
</head>
<body>
    <!-- Navbar Moderno -->
    <nav class="navbar">
        <!-- Título del Dashboard -->
        <div class="navbar-title">
            <h1><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard Principal'; ?></h1>
        </div>
        
        <!-- Perfil de Usuario -->
        <div class="navbar-user">
            <div class="user-profile-header" id="userProfileToggle">
                <div class="user-avatar-header">
                    <img src="/Gestion-sena/assets/images/foto-perfil.jpg" alt="Foto de perfil">
                </div>
                <div class="user-details">
                    <span class="user-name-header"><?php echo $_SESSION['usuario_nombre']; ?></span>
                    <span class="user-role-header"><?php echo $_SESSION['usuario_rol']; ?></span>
                </div>
                <i data-lucide="chevron-down" class="dropdown-icon"></i>
            </div>
            
            <!-- Dropdown Menu -->
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar">
                        <img src="/Gestion-sena/assets/images/foto-perfil.jpg" alt="Foto de perfil">
                    </div>
                    <div class="dropdown-info">
                        <strong><?php echo $_SESSION['usuario_nombre']; ?></strong>
                        <span><?php echo $_SESSION['usuario_email']; ?></span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="/Gestion-sena/views/perfil/index.php" class="dropdown-item">
                    <i data-lucide="user"></i>
                    <span>Mi Perfil</span>
                </a>
                <a href="/Gestion-sena/views/configuracion/index.php" class="dropdown-item">
                    <i data-lucide="settings"></i>
                    <span>Configuración</span>
                </a>
                <a href="/Gestion-sena/views/ayuda/index.php" class="dropdown-item">
                    <i data-lucide="help-circle"></i>
                    <span>Ayuda</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="/Gestion-sena/auth/logout.php" class="dropdown-item logout-item">
                    <i data-lucide="log-out"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </nav>

