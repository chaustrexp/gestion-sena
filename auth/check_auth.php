<?php
// Archivo para proteger páginas - incluir al inicio de cada página protegida
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /Gestion-sena/auth/login.php');
    exit;
}

// Función para verificar rol
function verificarRol($rolesPermitidos) {
    if (!in_array($_SESSION['usuario_rol'], $rolesPermitidos)) {
        header('Location: /Gestion-sena/index.php?error=acceso_denegado');
        exit;
    }
}

// Función para obtener nombre del usuario
function getNombreUsuario() {
    return $_SESSION['usuario_nombre'] ?? 'Usuario';
}

// Función para obtener rol del usuario
function getRolUsuario() {
    return $_SESSION['usuario_rol'] ?? 'Usuario';
}
?>
