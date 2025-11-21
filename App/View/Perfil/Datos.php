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
    <title>Datos Usuarios</title>
    <?php include '../Layout/head.php'; ?>

    <link rel="stylesheet" href="../../../Public/css/table.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.2/css/responsive.bootstrap5.min.css">

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

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
        <h4 class="card-title mb-0">Mis Datos</h4>
    </div>
    <div class="card-body">
        <!-- Datos personales -->
        <h5 class="mb-3">Datos Personales</h5>
        <form id="formEditarUsuario">



            <input type="hidden" id="idUsuario" name="usu_id">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"  maxlength="50" placeholder="Juan" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" maxlength="50" class="form-control" name="apellido" id="apellido" maxlength="50" placeholder="Pérez"required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" maxlength="16" class="form-control" name="usuario" id="usuario" placeholder="juanperez123" required>
                </div>
            </div>

            <hr>

            <!-- Información de contacto -->
            <h5 class="mb-3">Información de Contacto</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="correo@ejemplo.com" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" name="telefono" id="telefono" maxlength="9" placeholder="987654321" required>
                </div>
            </div>

            <hr>

            <!-- Área y Rol -->
            
            <h5 class="mb-3">Área y Rol</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="area" class="form-label">Área</label>
                    <div class="form-control">
                        <label type="text" id="areaNombre"></label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol</label>
                    <div class="form-control" id="rol">
                        <label type="text" id="rolNombre" name="rolNombre"></label>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success" id="btnGuardarCambios">Guardar cambios</button>
            </div>


        
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



    <script src="./../Perfil/js/datos.js"></script>

</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>

