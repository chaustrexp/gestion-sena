    <script>
        // Confirmación de eliminación
        function confirmarEliminacion(id, modulo) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                window.location.href = '/Gestion-sena/views/' + modulo + '/index.php?eliminar=' + id;
            }
        }

        // User Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userProfileToggle = document.getElementById('userProfileToggle');
            const userDropdown = document.getElementById('userDropdown');
            
            if (userProfileToggle && userDropdown) {
                userProfileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userProfileToggle.classList.toggle('active');
                    userDropdown.classList.toggle('active');
                });
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!userProfileToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                        userProfileToggle.classList.remove('active');
                        userDropdown.classList.remove('active');
                    }
                });
                
                // Reiniciar iconos de Lucide después de toggle
                userProfileToggle.addEventListener('click', function() {
                    setTimeout(function() {
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }, 100);
                });
            }
        });

        // Toggle Sidebar (Menú Hamburguesa) - Optimizado
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const navbar = document.querySelector('.navbar');
            const body = document.body;
            
            // Detectar si es móvil
            const isMobile = () => window.innerWidth <= 768;
            
            // Cargar estado del sidebar desde localStorage (solo desktop)
            if (!isMobile()) {
                const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (sidebarCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                    navbar.classList.add('expanded');
                }
            }
            
            // Toggle sidebar
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                if (isMobile()) {
                    // Modo móvil: toggle overlay
                    sidebar.classList.toggle('active');
                    body.classList.toggle('sidebar-open');
                } else {
                    // Modo desktop: toggle collapse
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    navbar.classList.toggle('expanded');
                    
                    // Guardar estado en localStorage
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                }
                
                // Reiniciar iconos de Lucide después de la transición
                setTimeout(function() {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }, 300);
            });
            
            // Cerrar sidebar en móvil al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (isMobile() && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                        body.classList.remove('sidebar-open');
                    }
                }
            });
            
            // Manejar cambio de tamaño de ventana
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (isMobile()) {
                        // Cambiar a modo móvil
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                        navbar.classList.remove('expanded');
                        body.classList.remove('sidebar-open');
                    } else {
                        // Cambiar a modo desktop
                        sidebar.classList.remove('active');
                        body.classList.remove('sidebar-open');
                        
                        // Restaurar estado guardado
                        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                        if (sidebarCollapsed) {
                            sidebar.classList.add('collapsed');
                            mainContent.classList.add('expanded');
                            navbar.classList.add('expanded');
                        }
                    }
                    
                    // Reiniciar iconos
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }, 250);
            });
        });
    </script>
</body>
</html>
