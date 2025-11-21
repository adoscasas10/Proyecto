<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña</title>
    <?php include '../Layout/head.php'; ?>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        

        <!-- Main -->
        <div class="main">
            
            <!-- Navbar -->
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button"></button>
                <div class="navbar-collapse navbar">
                <h3 class="text-center">Nexo IT de Negocios</h3>
                    <ul class="navbar-nav">
                    </ul>
                </div>
            </nav>
            
            <main class="content d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4" style="max-width: 400px; width: 100%;">
        
    
            <form action="" id="form_recuperar" class="form_recuperar" method="post">
                <div class="text-center">
                    <img class="mb-4" src="https://nexo-itnperu.com/wp-content/uploads/2024/07/logo_nexo-removebg-preview.png" alt="" width="200" height="90">
                    <h1 class="h4 mb-3 fw-normal">Nueva Contraseña</h1>
                </div>
                    
                    <input type="text" id="usu_id_recuperar" class="form-control" name="usu_id_recuperar" hidden value="">

                    <div class="input-group mb-3">
                        <input type="password" id="contra" class="form-control" name="contra" placeholder="Contraseña" required>
                        
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#contra">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" id="Confirmar_contra" class="form-control" name="Confirmar_contra" placeholder="Confirmar Contraseña" required>
                        
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#Confirmar_contra">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>

                <button class="btn btn-primary w-100 mb-2" type="submit">Recuperar Contraseña</button>

                
            </form>
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

    
    <script src="../../../Public/js/Cuerpo.js"></script>

    <script src="RecuperarContrasena.js"></script>

</body>


</html>