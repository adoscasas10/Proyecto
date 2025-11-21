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
    <title>Nuevo Ticket</title>
    <?php include '../Layout/head.php'; ?>
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/lang/summernote-es-ES.min.js"></script>


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
                <div class="container mt-2">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Crear Nuevo Ticket</h5>
                        </div>
                        <div class="card-body">
                            <form action="guardar_ticket.php" method="POST" id="ticket_form" enctype="multipart/form-data">
                                <input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["id_usuario"] ?>">

                                <input type="hidden" id="area_id" name="area_id" value="<?php echo $_SESSION["area"] ?>">

                                <!-- Título -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="tick_titulo" class="form-label">Título del Ticket</label>
                                        <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" required>
                                    </div>
                                </div>

                                <!-- Categoría y Prioridad -->
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-2">
                                        <label for="categoria" class="form-label">Categoría</label>
                                        <select class="form-select" id="id_categoria" name="id_categoria" required>
                                            <option value="">Seleccione una categoría</option>
                                            <option value="1">Software</option>
                                            <option value="2">Hardware</option>
                                            <option value="3">Red</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="tick_prioridad" class="form-label">Prioridad</label>
                                        <select class="form-select" id="tick_prioridad" name="tick_prioridad" required>
                                            <option value="">Seleccione prioridad</option>
                                            <option value=1>Baja</option>
                                            <option value=2>Media</option>
                                            <option value=3>Alta</option>
                                            <option value=4>Crítica</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Archivo -->
                                <div class="mb-3">
                                    <label for="archivo" class="form-label">Adjuntar archivo (opcional)</label>
                                    <input class="form-control" type="file" id="fileElem" name="fileElem" multiple>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <!-- <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea> -->
                                    <div class="card-body">
                                        <p>Ingrese su duda o consulta</p>
                                        <div class="mb-3">
                                            <div class="bg-white p-2 rounded">
                                                <textarea id="tick_descrip" name="tick_descrip" class="form-control summernote"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Registrar Ticket</button>
                                </div>
                            </form>
                        </div>
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
    

    <script src="./js/Nuevoticket.js"></script>
    
    <style>
    .note-editable ul li {
        list-style: disc !important;   /* puntos */
    }

    .note-editable ol li {
        list-style: decimal !important; /* números */
    }
    </style>
    
</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
