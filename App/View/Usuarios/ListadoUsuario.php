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
    <title>Listado de Usuarios</title>
    
    <?php 
        // include '../../Components/MainHead/head.php';
        include '../Layout/head.php';
     ?>
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
            
   <!-- archivo: listar_usuarios.html -->
<!-- archivo: listar_usuarios.html -->
<main class="content px-3 py-2">
  <div class="container-fluid">
    
    <div class="card">
      <div class="card-body">
        <header class="mb-4">
          <h3 class="card-title">Listado de Usuarios</h3>



          <input type="text" hidden id="rol_logeado" value="<?php echo $_SESSION['rol']; ?>">
          <input type="text" hidden id="id_usuario_logeado" value="<?php echo $_SESSION['id_usuario']; ?>">
          <input type="text" hidden id="id_area_logeado" value="<?php echo $_SESSION['area']; ?>">


          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Listado de Usuarios</li>
            </ol>
          </nav>
        </header>

        <!-- Botones principales -->
        <div class="d-flex justify-content-between gap-2 mb-3">
          <a href="NuevoUsuario.php" class="btn btn-primary" title="Nuevo"><i class="bi bi-plus-lg"></i> Nuevo Usuario</a>
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
              <option value="0">DNI</option>
              <option value="1">Nombre</option>
              <option value="2">Apellido</option>
              <option value="3">Correo</option>
              <option value="4">Usuario</option>
              <option value="5">Rol</option>
              <option value="6">Área</option>
            </select>
          </div>

           <!-- Filtro por Estado del sistema -->
          <div class="col-12 col-md-3 mb-2">
            <select id="filtroEstadoSistema" class="form-select">
              <option value="">Todos</option>
              <option value="1">Habilitado</option>
              <option value="0">Deshabilitado</option>
              <option value="2">No Verificado</option>
            </select>
          </div>
          
        </div>


        <!-- Tabla para pantallas grandes -->
        <div class="table-responsive datatable-wrapper">
        <div class="main-datatable">
          <table id="usuario_data" class="table table-bordered table-striped align-middle text-center ">
            <thead class="table-primary">
              <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Área</th>
                <th>Estado del sistema</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody id="tablaBody">
              <tr>
                <td>71532009</td>
                <td>Ana</td>
                <td>Gómez</td>
                <td>ana@example.com</td>
                <td>ana.g</td>
                <td>Admin</td>
                <td>Área de TI</td>
                <td> <span class="badge bg-success">Habilitado</span></td>
                <td>
                  <div class="btn-group">
                <span class="btn-group">
                    <a href="#" data-id="1" class="btn btn-warning btn-sm btnEditar"><i class="bi bi-pencil-square"></i></a>                    
                  </span>
                  <span class="btn-group">
                    <a href="#" data-id="1" class="btn btn-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></a>
                  </span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>71532011</td>
                <td>Carlos</td>
                <td>Pérez</td>
                <td>carlosp@example.com</td>
                <td>cperez</td>
                <td>Usuario</td>
                <td>Logística</td>
                <td> <span class="badge bg-danger">Deshabilitado</span></td>
                <td>
                <div class="btn-group">
                <span class="btn-group">
                    <a href="#" class="btn btn-warning btn-sm btnEditar"><i class="bi bi-pencil-square"></i></a>                    
                  </span>
                  <span class="btn-group">
                    <a href="#" class="btn btn-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></a>
                  </span>
                </div>
                </td>
              </tr>
              <tr>
                <td>10363507</td>
                <td>Lucía</td>
                <td>Ramírez</td>
                <td>luciar@example.com</td>
                <td>lramirez</td>
                <td>Supervisor</td>
                <td>RRHH</td>
                <td> <span class="badge bg-success">Habilitado</span></td>
                <td>
                <div class="btn-group">
                 
                  <span class="btn-group">
                    <a href="#" class="btn btn-warning btn-sm btnEditar"><i class="bi bi-pencil-square"></i></a>                    
                  </span>
                  <span class="btn-group">
                    <a href="#" class="btn btn-danger btn-sm btnEliminar"><i class="bi bi-trash"></i></a>
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
  </div>

</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">





            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
            

        </div>
    </div>
    

    <?php include 'ModalUsuario.php'; ?>

    <?php include '../Layout/script.php'; ?>
    <!--jquery table-->
    <?php include '../../Components/MainJs/js.php'; ?>

    <script type="text/javascript" src="../../../Public/js/table.js">





      
    </script>
</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
