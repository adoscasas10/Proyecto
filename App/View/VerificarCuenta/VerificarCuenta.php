<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Cuenta</title>
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
                    <h1 class="h4 mb-3 fw-normal">Cuenta Verificada</h1>
                </div>
            </form>
            
                <a href="../Login/login.php" class="btn btn-primary w-100 mb-2">Volver al Login</a>
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

    <script src="VerificarCuenta.js"></script>

</body>


</html>