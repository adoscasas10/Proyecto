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
    <title>Reporte Ticket</title>
    <?php include '../Layout/head.php'; ?>
    
    <link rel="stylesheet" href="../../../Public/css/table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.2/css/responsive.bootstrap5.min.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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
                    <h4 class="mb-4">Reportes de Tickets</h4>

                    <!-- Filtros -->
                    <div class="card mb-4">
                        <div class="card-header">Filtros</div>
                        <div class="card-body row g-3">
                            
                            <div class="col-md-3">
                                <label class="form-label">Desde</label>
                                <input type="date" class="form-control" id="filtroDesde">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Hasta</label>
                                <input type="date" class="form-control" id="filtroHasta">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="filtroEstadoSistema">
                                    <option value="">Todos</option>
                                    <option value="Abierto">Abierto</option>
                                    <option value="Cerrado">Cerrado</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Técnico</label>
                                <div class="input-group">
                                    <input hidden type="text" id="atencion_id" name="atencion_id" placeholder="Estara la id">  
                                    <select data-bs-theme="dark" class="form-select" id="aten_garantia" name="aten_garantia" placeholder="Seleccione Atención Garantia" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-3">
                                <button class="btn btn-primary" id="btnFiltrar">Generar Reporte</button>
                            </div>

                        </div>
                    </div>

                    <!-- Resultados -->
                    <div class="card mb-4">
                        <div class="card-header">Resultados</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover" id="tickets_data">
                                <thead>
                                    <tr>
                                        <th># Ticket</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                        <th>Técnico</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>001</td>
                                        <td>Juan</td>
                                        <td>2025-06-06</td>
                                        <td>Abierto</td>
                                        <td>Pedro</td>
                                        <td>Problema con la red</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="text-end">
                                <button class="btn btn-outline-success me-2">Exportar Excel</button>
                                <button class="btn btn-outline-danger">Exportar PDF</button>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Tickets por estado</div>
                                <div class="card-body">
                                    <canvas id="graficoEstado"></canvas>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Tickets por técnico</div>
                                
                                <div class="card-body">

                                    <div class="mb-3"> 
                                        <label for="filtroGraficoTecnico" class="form-label">Filtrar:</label>
                                        <select class="form-select" id="filtroGraficoTecnico" name="filtroGraficoTecnico">

                                        </select>
                                    </div>
                                    <canvas id="graficoTecnico"></canvas>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </main>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
            

        </div>
    </div>
    
    <!-- <?php include '../Layout/script.php'; ?> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="reporte.js"></script>
    
</body>

</html>
<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
