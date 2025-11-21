<aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">Nexo-IT Negocios</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Menu Principal
                    </li>
                    <li class="sidebar-item">
                        <a href="./../MenuPrincipal/Menu_Principal.php" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Inicio
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="./../Notificaciones/Notificaciones.php" class="sidebar-link">
                            <i class="fa-solid fa-bell"></i>
                             Notificaciones
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-sliders pe-2"></i>
                            Tickets
                        </a>
                        <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="./../Tickets/NuevoTicket.php" class="sidebar-link">Crear Ticket</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Tickets/Tickets.php" class="sidebar-link">Gestión Tickets</a>
                            </li>
                            
                            <li class="sidebar-item">
                                <a href="./../Tickets/MisTickets_Usuario.php" class="sidebar-link">Mis Tickets</a>
                            </li>
                            <!-- <li class="sidebar-item">
                                <a href="./../Tickets/MisTickets_Asignados.php" class="sidebar-link">Mis Tickets Asignados</a>
                            </li> -->
                            <!-- <li class="sidebar-item">
                                <a href="./../Tickets/TicketAsignados.php" class="sidebar-link">Tickets Asignados</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Tickets/TicketSinAsignar.php" class="sidebar-link">Tickets Sin Asignar</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Tickets/TicketsCerrados.php" class="sidebar-link">Tickets Cerrados</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Tickets/TodosTickets.php" class="sidebar-link">Todos los Tickets</a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-regular fa-user pe-2"></i>
                            Perfil
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="./../Perfil/Datos.php" class="sidebar-link">Datos</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Perfil/CambioContraseña.php" class="sidebar-link">Cambiar Contraseña</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        Nivel Administrador
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#multi" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-share-nodes pe-2"></i>
                            Administrador
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-target="#level-usuario"
                                    data-bs-toggle="collapse" aria-expanded="false"><i class="fa-solid fa-users"></i> Usuarios</a>
                                <ul id="level-usuario" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a href="./../Usuarios/ListadoUsuario.php" class="sidebar-link">Listado de Usuarios</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="./../Usuarios/NuevoUsuario.php" class="sidebar-link">Nuevo Usuario</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Areas/ListadoArea.php" class="sidebar-link"><i class="fa-solid fa-layer-group"></i> Áreas</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Categorias/ListadoCategoria.php" class="sidebar-link"><i class="fa-solid fa-list"></i> Categorías</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="./../Reporte/reporte.php" class="sidebar-link"><i class="fa-solid fa-chart-area"></i> Reportes</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>