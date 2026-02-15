<aside class="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <img src="/Gestion-sena/assets/images/sena-logo.png" alt="Logo SENA">
            </div>
            <div class="logo-text">
                <h2>SENA</h2>
                <span>Sistema de Gestión</span>
            </div>
        </div>
    </div>

    <!-- Navegación Principal -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="/Gestion-sena/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="layout-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Sección: Académico -->
            <li class="nav-section">
                <span class="section-title">Académico</span>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/programa/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="book-open"></i>
                    <span class="nav-text">Programas</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/ficha/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="file-text"></i>
                    <span class="nav-text">Fichas</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/competencia/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="target"></i>
                    <span class="nav-text">Competencias</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/competencia_programa/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="link"></i>
                    <span class="nav-text">Competencia-Programa</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/titulo_programa/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="graduation-cap"></i>
                    <span class="nav-text">Título Programa</span>
                </a>
            </li>

            <!-- Sección: Recursos -->
            <li class="nav-section">
                <span class="section-title">Recursos</span>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/instructor/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="user"></i>
                    <span class="nav-text">Instructores</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/ambiente/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="home"></i>
                    <span class="nav-text">Ambientes</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/asignacion/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="calendar"></i>
                    <span class="nav-text">Asignaciones</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/detalle_asignacion/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="clipboard-list"></i>
                    <span class="nav-text">Detalle Asignación</span>
                </a>
            </li>

            <!-- Sección: Infraestructura -->
            <li class="nav-section">
                <span class="section-title">Infraestructura</span>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/centro_formacion/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="building-2"></i>
                    <span class="nav-text">Centro Formación</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/sede/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="map-pin"></i>
                    <span class="nav-text">Sedes</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/Gestion-sena/views/coordinacion/index.php" class="nav-link">
                    <i class="nav-icon" data-lucide="users"></i>
                    <span class="nav-text">Coordinación</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer del Sidebar -->
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                <img src="/Gestion-sena/assets/images/foto-perfil.jpg" alt="Foto de perfil">
            </div>
            <div class="user-info">
                <span class="user-name"><?php echo $_SESSION['usuario_nombre']; ?></span>
                <span class="user-role"><?php echo $_SESSION['usuario_rol']; ?></span>
            </div>
        </div>
    </div>
</aside>

<!-- Script para Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

