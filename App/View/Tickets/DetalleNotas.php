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
    <title>Detalle Notas</title>

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
                


<div class="container my-4">
  <div class="mb-4">
    <h3 id="lblnomidticket">Detalle Notas - 1</h3>
    <div id="lblestado" class="mt-2"><span class="badge bg-success">Abierto</span></div>
    <span class="badge bg-primary" id="lblnomusuario">Juan Pérez</span>
    <span class="badge bg-secondary" id="lblfechcrea">01/06/2025 10:35 AM</span>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detalle Ticket - Nota</li>
      </ol>
    </nav>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-lg-6">
          <label for="cat_nom" class="form-label">Categoría</label>
          <input type="text" class="form-control" id="cat_nom" name="cat_nom" value="SOFTWARE" readonly>
        </div>
        <div class="col-lg-6">
          <label for="prioridad_nom" class="form-label">Prioridad</label>
          <input type="text" class="form-control" id="prioridad_nom" name="prioridad_nom" value="Alta" readonly>
        </div>

        
      </div>


      <div class="row mb-3">
          <div class="col-lg-12">
            <label for="tick_titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" value="No puedo acceder al sistema" readonly>
          </div>
        </div>


      <div class="mb-4">
        <label class="form-label">Documentos Adicionales</label>
        <div class="table-responsive">
          <table id="documentos_data" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 90%;">Nombre</th>
                <th class="text-center" style="width: 10%;">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>captura_error_login.png</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-info">Ver</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="mb-4">
        <label for="tickd_descripusu" class="form-label">Descripción</label>
        <textarea id="tickd_descripusu" name="tickd_descripusu" class="form-control summernote" rows="5">
          Buenos días, estoy intentando ingresar al sistema pero me aparece un mensaje de error que dice "Usuario o contraseña incorrectos". Ya verifiqué mis datos y sigo sin poder acceder.
        </textarea>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5>Conversación</h5>
      <section class="mb-4" id="lbldetalle">
        
      </section>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <p>Ingrese su duda o consulta</p>
      <div class="mb-3">
        <label for="tickd_descrip" class="form-label">Descripción</label>
        <textarea id="tickd_descrip" name="tickd_descrip" class="form-control summernote" rows="4"></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="button" id="btnenviar" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>

<style>
  :root[data-bs-theme="dark"] .note-editor {
    background-color: #212529 !important;
    color: #f8f9fa !important;
  }

  :root[data-bs-theme="dark"] .note-editor .note-editing-area .note-editable {
    background-color: #212529 !important;
    color: #f8f9fa !important;
  }

  :root[data-bs-theme="dark"] .note-toolbar {
    background-color: #343a40 !important;
    border-color: #495057 !important;
  }

  :root[data-bs-theme="dark"] .note-editor .dropdown-menu {
    background-color: #343a40 !important;
    color: #f8f9fa !important;
  }

  :root[data-bs-theme="dark"] .note-editor .dropdown-item {
    color: #f8f9fa !important;
  }

  :root[data-bs-theme="dark"] .note-editor .dropdown-item:hover {
    background-color: #495057 !important;
  }
</style>     
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


      
<!-- 3. Summernote -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

<script src="./js/DetalleNota.js"></script>
    
</body>

</html>


<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>

