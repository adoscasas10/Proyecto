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
    <title>Listado de Areas</title>
    <?php include '../Layout/head.php'; ?>
    <link rel="stylesheet" href="../../../Public/css/table.css">
    
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
            
                <div class="card">
                    <div class="card-body">
                        <header class="mb-4">
                            <h3 class="card-title">Listar Áreas</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Listar Areas</li>
                                </ol>
                            </nav>
                        </header>

                        <div class="mb-3 d-flex justify-content-between">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalArea" id="btnnuevo" class="btn btn-primary"> <i class="fa-solid fa-plus"></i> Nueva Area</button>
                            <div>
                                <button id="btnExcel" class="btn btn-success" title="Exportar Excel"><i class="fa-solid fa-file-excel"></i></button>
                                <button id="btnPdf" class="btn btn-danger" title="Exportar PDF"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>


                        <div class="row mb-3 justify-content-between">
                            <!-- Buscador -->
                            <div class="col-12 col-md-6 mb-2 mb-md-0">
                                <input type="search" id="buscador" class="form-control" placeholder="Buscar...">
                            </div>

                            <!-- Combobox -->
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <select id="filtro" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="0">Codigo</option>
                                <option value="1">Area</option>
                                </select>
                            </div>

                            <!-- Filtro por Estado del sistema -->
                            <div class="col-12 col-md-3 mb-2">
                                <select id="filtroEstadoSistema" class="form-select">
                                <option value="">Todos</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
                                </select>
                            </div>
                        
                        </div>




                        <div class="table-responsive">
                            <div class="main-datatable">
                                <table id="area_data" class="table table-bordered table-striped align-middle text-center">
                                    <thead class="table-primary">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Área</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A0001</td>
                                            <td>RRHH</td>
                                            <td><span class="badge bg-success">Habilitado</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-warning btn-sm btn-actualizar"><i class="fa-solid fa-pen-to-square"></i></a>                    
                                                    </span>
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-danger btn-sm btn-deshabilitar"><i class="fa-solid fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>A0002</td>
                                            <td>Logística</td>
                                            <td><span class="badge bg-success">Habilitado</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-warning btn-sm btn-actualizar"><i class="fa-solid fa-pen-to-square"></i></a>                    
                                                    </span>
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-danger btn-sm btn-deshabilitar"><i class="fa-solid fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>A0003</td>
                                            <td>Producción</td>
                                            <td><span class="badge bg-success">Habilitado</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-warning btn-sm btn-actualizar"><i class="fa-solid fa-pen-to-square"></i></a>                    
                                                    </span>
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-danger btn-sm btn-deshabilitar"><i class="fa-solid fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>A0004</td>
                                            <td>Contabilidad</td>
                                            <td><span class="badge bg-success">Habilitado</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-warning btn-sm btn-actualizar"><i class="fa-solid fa-pen-to-square"></i></a>                    
                                                    </span>
                                                    <span class="btn-group">
                                                        <a href="#" data-id="1" class="btn btn-danger btn-sm btn-deshabilitar"><i class="fa-solid fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Puedes duplicar esta fila o cargar datos dinámicamente -->
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
    
    <script type="text/javascript" src="area.js"></script>
    
    <?php include './ModalArea.php'; ?>
</body>

</html>
<?php
} else{
    header("Location: /App/view/Login/login.php");
}
?>
