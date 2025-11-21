<?php 
    require_once("./../../../Config/Config.php"); 
    if(isset($_SESSION["id_usuario"])){
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio Contraseña</title>
    <?php include '../Layout/head.php'; ?>


    <link rel="stylesheet" href="../../../Public/css/table.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.2/css/responsive.bootstrap5.min.css">


</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include '../Layout/aside.php'; ?>
        <!-- Main -->
        <div class="main">
            <!-- Navbar -->
            <?php include '../Layout/navbar.php'; ?>
            
            <main class="content px-3 py-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">Cambiar Contraseña</h4>
                    </div>
                    <div class="card-body">
                        <form id="formCambiarContraseña">
                            
                        <input type="text" id="usu_id" name="usu_id" value="<?php echo $_SESSION['id_usuario']; ?>" hidden>

                        <!--para que funcione un correo oculto-->
                        <input 
                            type="text" 
                            name="username" 
                            value="usuario@ejemplo.com" 
                            autocomplete="username" 
                            hidden>


                            

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Aviso</label>
                                <div class="form-control text-center" id="aviso">
                                    <label type="text" 
                                    class=""
                                    id="avisoNombre" name="avisoNombre">La contraseña nueva debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial</label>
                                </div>
                            </div>

                            <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña Actual</label>
                            <div class="input-group">
                                <input type="password" class="form-control" 
                                name="currentPassword"
                                id="currentPassword" placeholder="Ingresa tu contraseña actual" autocomplete="current-password">
                                <button class="btn btn-outline-secondary togglePassword" type="button">
                                <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                            </div>
                            </div>

                            <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" 
                                name="newPassword"
                                class="form-control" id="newPassword" placeholder="Nueva contraseña" autocomplete="new-password">
                                <button class="btn btn-outline-secondary togglePassword" type="button">
                                <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                            </div>
                            </div>

                            <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" 
                                name="confirmPassword"
                                id="confirmPassword" placeholder="Repite la nueva contraseña" autocomplete="new-password">
                                <button class="btn btn-outline-secondary togglePassword" type="button">
                                <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                            </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>

                            
                        </form>
                    </div>
                </div>

            </main>

            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
        </div>
    </div>
    
    <?php include '../Layout/script.php'; ?>


    
    
    <?php include '../../Components/MainJs/js.php'; ?>

    
    <!-- 3. Summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>



    <script src="./../Perfil/js/cambio_contraseña.js"></script>
    
</body>

</html>
<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>

