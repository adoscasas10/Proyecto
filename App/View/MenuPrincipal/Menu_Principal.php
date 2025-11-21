<?php
    require_once("../../../Config/Config.php");
    if(isset($_SESSION["id_usuario"])){
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
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
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Menu Principal</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Bienvenido, <?php echo $_SESSION["nombre"]?> <?php echo $_SESSION["apellido"]?></h4>
                                                <p class="mb-0">A la sección principal, Nexo-IT Negocios. Te esperamos para resolver tus dudas.</p>
                                            </div>
                                        </div>
                                        <!-- align-self-end  -->
                                        <div class="col-6 text-end">
                                            <img src="./../../../Public/Img/banner1.png"
                                                class="img-fluid illustration-img"
                                                style="height: 100%; object-fit: cover;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body py-4">
                                    <div class="row">
                                        <input type="text" hidden id="usu_id" value="<?php echo $_SESSION["id_usuario"]?>">
                                        <!-- Columna izquierda: Datos -->
                                        <div class="col-12 col-lg-6">
                                            <h4 class="mb-2">Datos Necesarios</h4>
                                            <p class="mb-2">Total de Tickets:</p>
                                            <div class="mb-0">
                                                <span class="badge text-success ticketTotales">10</span>
                                                <span class="text-muted">Tickets Totales</span>
                                            </div>
                                            <div class="mb-0">
                                                <span class="badge text-success ticketResueltos">10</span>
                                                <span class="text-muted">Tickets Resueltos</span>
                                            </div>
                                            <p class="mb-2 mt-2">Sesiones:</p>
                                            <div class="mb-0">
                                                <span class="badge text-success ultimaSesion">12-05-2025</span>
                                                <span class="text-muted">Última Sesión</span>
                                            </div>
                                        </div>

                                        <!-- Columna derecha: Acceso Rápido -->
                                        <div class="col-12 col-lg-6 mt-2">
                                            <h4 class="mb-3">Acceso Rápido</h4>
                                            <a href="./../Tickets/NuevoTicket.php" class="btn btn-primary w-100 mb-2">Nuevo Ticket</a>
                                            <a href="./../Tickets/MisTickets_Usuario.php" class="btn btn-secondary w-100">Mis Tickets</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Tickets Registrados
                            </h5>
                            <h6 class="card-subtitle text-muted">
                                Lista de los ultimos 5 tickets registrados en el sistema por el usuario
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table" id="DataTableTickets">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col"># Ticket</th>
                                        <th scope="col">Titulo</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            
            <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
            
        </div>
    </div>
    
    <?php include '../Layout/script.php'; ?>

    
    <!--jquery table-->
    <?php include '../../Components/MainJs/js.php'; ?>

    <script src="./js/MenuPrincipal.js"></script>
</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php?m=2");
    }
?>

