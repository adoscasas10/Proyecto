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
    <title>Notificaciones</title>
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
        <h4 class="card-title mb-0">Notificaciones</h4>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">Nuevo mensaje en ticket #123</h6>
                    <small class="text-muted">Hace 10 minutos</small>
                </div>
                <span class="badge bg-primary rounded-pill">Mensaje</span>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">Ticket #456 ha sido resuelto</h6>
                    <small class="text-muted">Hace 2 horas</small>
                </div>
                <span class="badge bg-success rounded-pill">Resuelto</span>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">Nuevo ticket asignado</h6>
                    <small class="text-muted">Hoy, 08:45 AM</small>
                </div>
                <span class="badge bg-warning text-dark rounded-pill">Asignado</span>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">Nuevo ticket asignado</h6>
                    <small class="text-muted">Hoy, 11:05 AM</small>
                </div>
                <span class="badge bg-warning text-dark rounded-pill">Asignado</span>
            </li>

            <!-- <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">Sistema en mantenimiento programado</h6>
                    <small class="text-muted">Ayer</small>
                </div>
                <span class="badge bg-danger rounded-pill">Alerta</span>
            </li> -->
        </ul>
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



    <script src="./../Notificaciones/js/notificaciones.js"></script>

</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
