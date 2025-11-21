<nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                

                

                <div class="navbar-collapse navbar">

                <h3>Bienvenido a Nexo-IT: <?php echo $_SESSION['nombre'] ?> <?php echo $_SESSION['apellido'] ?></h3>

                <input type="hidden" id="usuario_idxd" name="usuario_idxd" value="<?php echo $_SESSION["id_usuario"] ?>">

                <input type="hidden" id="rol_idxd" name="rol_idxd" value="<?php echo $_SESSION["rol"] ?>">
                
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="./../../../Public/Img/profile.jpg" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="./../Perfil/Datos.php" class="dropdown-item">Perfil</a>
                                <!-- <a href="./../Configuracion/index.php" class="dropdown-item">Configuración</a> -->
                                <a href="./../Logout/logout.php" class="dropdown-item">Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
            </div>
</nav>