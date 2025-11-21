<?php 
    require_once("./../../../Config/Config.php"); 
    if(isset($_SESSION["id_usuario"]) && $_SESSION["rol"] != 3 && $_SESSION["estado"] != 2){
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets</title>
    <?php include '../Layout/head.php'; ?>
    <link rel="stylesheet" href="../../../Public/css/table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.2/css/responsive.bootstrap5.min.css">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <div class="card-body">
                            <header class="mb-4">
                                <h3 class="card-title">Gestión de Tickets</h3>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                                    </ol>
                                </nav>
                            </header>


                            <div class="mb-3 d-flex justify-content-between">
                                <a href="NuevoTicket.php" type="button" id="btnnuevo" class="btn btn-primary">Nuevo Ticket</a>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button id="btnExcel" class="btn btn-success" title="Exportar Excel"><i class="fa-solid fa-file-excel"></i></button>
                                    <button id="btnPDF" class="btn btn-danger" title="Exportar PDF"><i class="fa-solid fa-file-pdf"></i></button>
                                </div>
                            </div>


                            <div class="row mb-3 justify-content-between">

                                <!-- Buscador -->
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <label for="filtro_estado" class="form-label">Buscar:</label>
                                    <input type="search" id="buscador" class="form-control" placeholder="Buscar...">
                                </div>

                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <label for="filtro_estado" class="form-label">Buscar por:</label>
                                    <select id="filtro" class="form-select">
                                        <option value="">Seleccione</option>
                                        <option value="0">N° Ticket</option>
                                        <option value="2">Categoria</option>
                                        <option value="3">Titulo</option>   
                                        <option value="7">Soporte Asignado</option>
                                        <option value="8">Creador del Ticket</option>
                                    </select>
                                </div>

                            </div>



                            <div class="row mb-3 justify-content-between">
                                
                                <!-- Combobox -->
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="filtro_estado" class="form-label">Filtrar por tipo:</label>
                                    <select class="form-select" id="filtro_estado">
                                        <option value="">📋 Todos los Tickets</option>
                                        <option value="<?php echo $_SESSION['id_usuario']; ?>">✅ Mis Tickets Asignados</option>
                                        <option value="Sin Asignar">🕓 Tickets Sin Asignar</option>
                                        
                                    </select>
                                </div>

                                <!-- Filtro por Estado del sistema -->
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="filtro_estado" class="form-label">Filtrar por estado:</label>
                                    <select id="filtroEstadoSistema" class="form-select">
                                    <option value="">Estado</option>
                                    <option value="Abierto">Abierto</option>
                                    <option value="Cerrado">Cerrado</option>
                                    </select>
                                </div>
                            
                                <!-- Filtro por Prioridad -->
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="filtro_prioridad" class="form-label">Filtrar por prioridad:</label>
                                    <select id="filtroPrioridad" class="form-select">
                                    <option value="">Prioridad</option>
                                    <option value="Critica">Critica</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                    </select>
                                </div>
                            </div>

                            

                            <div class="table-responsive">
                                <div class="main-datatable">
                                    <table id="tabla_tickets_data" class="table table-bordered table-striped align-middle text-center">
                                        <thead class="table-primary">
                                        <tr>
                                            <th>N° Ticket</th>
                                            <th>Prioridad</th>
                                            <th>Categoría</th>
                                            <th>Título</th>
                                            <th>Estado</th>
                                            <th>Fecha Creación</th>
                                            <th>Fecha Asignación</th>
                                            <th>Soporte Asignado</th>
                                            <th class="center">Creador del Ticket</th>
                                            <th>Ver</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                        <!-- Cards para pantallas pequeñas -->
                        <div class="datatable-cards" style="display: none;" id="cardContainer">
                        <!-- Cards generados dinámicamente -->
                        </div>

                        <div id="paginadorExtra" class="paginador-movil"></div>

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

    <!--jquery table-->
    <?php include '../../Components/MainJs/js.php'; ?>

    <script type="text/javascript" src="./js/Tickets.js"></script>

    <?php include './modalasignar.php'; ?>
    
</body>

</html>
<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
