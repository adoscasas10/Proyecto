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


        <div class="datatable-wrapper">
           
        <input type="text" hidden id="id_usuario" value="<?php echo $_SESSION["id_usuario"]; ?>">
        
        <div class="d-flex justify-content-between gap-2 mb-3">
                <a href="" class="btn btn-primary" id="btnMarcarLeido" title="Nuevo"><i class="bi bi-plus-lg"></i> Marcar como leido</a>
                <div>
                    <button id="btnExcel" class="btn btn-success" title="Exportar Excel"><i class="fa-solid fa-file-excel"></i></button>
                    <button id="btnPdf" class="btn btn-danger" title="Exportar PDF"><i class="fa-solid fa-file-pdf"></i></button>
                </div>
            </div>



            <div class="row mb-3 justify-content-between">
                <!-- Buscador -->
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <input type="search" id="buscador" class="form-control" placeholder="Buscar...">
                </div>

                <!-- Combobox -->
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <input type="date" id="fecha_desde" class="form-control">
                </div>

                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <input type="date" id="fecha_hasta" class="form-control">
                </div>

                <!-- Filtro por Estado del sistema -->
                <div class="col-12 col-md-2 mb-2">
                    <select id="filtroEstadoSistema" class="form-select">
                    <option value="">Estado Notificación</option>
                    <option value="1">Leido</option>
                    <option value="0">No Leido</option>
                    </select>
                </div>
          
            </div>
        
        <div class="main-datatable">


            <table id="notificaciones_data" class="table table-striped table-hover">

                <thead class="table-primary text-center">
                    <tr>
                        <th>Fecha</th>
                        <th># Ticket</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
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
<!--             
            <style>
                .table-responsive {
                    overflow-x: unset !important;
                }
            </style> -->
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
