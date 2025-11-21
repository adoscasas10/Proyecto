<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets Asignados</title>
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
                    <div class="card-body">
                        <header class="mb-4">
                            <h3 class="card-title">Mis Tickets Asignados</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mis Tickets Asignados</li>
                                </ol>
                            </nav>
                        </header>

                        <div class="mb-3 d-flex justify-content-between">
                            <a href="NuevoTicket.php" type="button" id="btnnuevo" class="btn btn-primary">Nuevo Ticket</a>
                            <div class="btn-group">
                                <button id="btnPDF" class="btn btn-danger" title="Exportar PDF"><i class="fa-solid fa-file-pdf"></i></button>
                                <button id="btnExcel" class="btn btn-success" title="Exportar Excel"><i class="fa-solid fa-file-excel"></i></button>
                            </div>
                        </div>


                        <div class="row mb-3 justify-content-between">
                            <!-- Buscador -->
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <label for="buscador" class="form-label">Buscar:</label>
                                <input type="search" id="buscador" class="form-control" placeholder="Buscar...">
                            </div>

                            <!-- Combobox para búsqueda específica -->
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <label for="filtro" class="form-label">Buscar por campo:</label>
                                <select id="filtro" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option value="0">N° Ticket</option>
                                    <option value="2">Categoria</option>
                                    <option value="3">Titulo</option>   
                                </select>
                            </div>

                            <!-- Filtro por Estado del sistema -->
                            <div class="col-12 col-md-3 mb-2">
                                <label for="filtroEstadoSistema" class="form-label">Estado del Sistema:</label>
                                <select id="filtroEstadoSistema" class="form-select">
                                    <option value="">Estado</option>
                                    <option value="Sin Asignar">Sin Asignar</option>
                                    <option value="Asignado">Asignado</option>
                                    <option value="Cerrado">Cerrado</option>
                                </select>
                            </div>

                            <!-- Filtro por Prioridad -->
                            <div class="col-12 col-md-3 mb-2">
                                <label for="filtroPrioridad" class="form-label">Prioridad:</label>
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
                                <table id="ticket_asignado_data" class="table table-bordered table-striped align-middle text-center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>N° Ticket</th>
                                            <th>Prioridad</th>
                                                <th>Categoría</th>
                                                <th>Título</th>
                                                <th>Estado</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Asignación</th>
                                                <th>Soporte</th>
                                                <th>Ver Ticket</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>TK003</td>
                                            <td><span class="badge bg-primary text-dark">Media</span></td>
                                            <td>Hardware</td>
                                            <td>No enciende monitor</td>
                                            <td><span class="badge bg-warning text-dark">Sin Asignar</span></td>
                                            <td>2025-05-10</td>
                                            <td>2025-05-10</td>
                                            <td>José Ruiz</td>
                                            <td>
                                                <div class="btn-group">
                                                <span class="btn-group">
                                                    <a href="DetalleTickets.php" data-id="1" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>                    
                                                </span>
                                                <span class="btn-group">
                                                    <a href="DetalleNotas.php" data-id="1" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>
                                                </span>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TK002</td>
                                            <td> <span class="badge bg-warning text-dark">Alta</span></td>
                                            <td>Software</td>
                                            <td>Error en sistema interno</td>
                                            <td><span class="badge bg-danger text-white">Cerrado</span></td>
                                            <td>2025-05-08</td>
                                            <td>2025-05-09</td>
                                            <td>José Ruiz</td>
                                            <td>
                                            <div class="btn-group">
                                                <span class="btn-group">
                                                    <a href="DetalleTickets.php" data-id="1" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>                    
                                                </span>
                                                <span class="btn-group">
                                                    <a href="DetalleNotas.php" data-id="1" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>
                                                </span>
                                            </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TK004</td>
                                            <td> <span class="badge bg-primary text-dark">Media</span></td>
                                            <td>Hardware</td>
                                            <td>No enciende monitor</td>
                                            <td><span class="badge bg-warning text-dark">Sin Asignar</span></td>
                                            <td>2025-05-10</td>
                                            <td>2025-05-10</td>
                                            <td>José Ruiz</td>
                                            <td>
                                            <div class="btn-group">
                                                <span class="btn-group">
                                                    <a href="DetalleTickets.php" data-id="1" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>                    
                                                </span>
                                                <span class="btn-group">
                                                    <a href="DetalleNotas.php" data-id="1" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>
                                                </span>
                                            </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TK005</td>
                                            <td> <span class="badge bg-warning text-dark">Alta</span></td>
                                            <td>Software</td>
                                            <td>Error en sistema interno</td>
                                            <td><span class="badge bg-danger text-white">Cerrado</span></td>
                                            <td>2025-05-08</td>
                                            <td>2025-05-09</td>
                                            <td>José Ruiz</td>
                                            <td>
                                            <div class="btn-group">
                                                <span class="btn-group">
                                                    <a href="DetalleTickets.php" data-id="1" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>                    
                                                </span>
                                                <span class="btn-group">
                                                    <a href="DetalleNotas.php" data-id="1" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>
                                                </span>
                                            </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TK006</td>
                                            <td> <span class="badge bg-primary text-dark">Media</span></td>
                                            <td>Hardware</td>
                                            <td>Problema con impresora</td>
                                            <td><span class="badge bg-warning text-dark">Sin Asignar</span></td>
                                            <td>2025-05-10</td>
                                            <td>2025-05-10</td>
                                            <td>José Ruiz</td>
                                            <td>
                                            <div class="btn-group">
                                                <span class="btn-group">
                                                    <a href="DetalleTickets.php" data-id="1" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>                    
                                                </span>
                                                <span class="btn-group">
                                                    <a href="DetalleNotas.php" data-id="1" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>
                                                </span>
                                            </div> 
                                            </td>
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

    <script type="text/javascript" src="./js/MisTickets_Asignados.js"></script>

</body>

</html>
