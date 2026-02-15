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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard SENA'; ?></title>
    <link rel="stylesheet" href="/Gestion-sena/assets/css/styles.css">
</head>
<body>
    <!-- Navbar Moderno -->
    <nav class="navbar">
        <!-- Botón Hamburguesa -->
        <button class="hamburger-btn" id="toggleSidebar" aria-label="Toggle Sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
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

