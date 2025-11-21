<?php
    require_once("./../../../Config/Config.php");
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
        require_once("./../../Model/Usuario.php");
        $usuario = new Usuario();
        $usuario->login();
    }
    if(isset($_SESSION["id_usuario"])){
        header("Location:".Conectar::ruta()."/App/View/MenuPrincipal/Menu_Principal.php");
    }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logins</title>
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
                    <form action="" method="post">
                        <div class="text-center">
                            <img class="mb-4" src="https://nexo-itnperu.com/wp-content/uploads/2024/07/logo_nexo-removebg-preview.png" alt="" width="200" height="90">
                            <h1 class="h4 mb-3 fw-normal">Iniciar Sesión</h1>
                        </div>

                        <?php 
                        if(isset($_GET["m"])){
                            $m = $_GET["m"];
                            if($m==1){
                                echo '<div class="alert alert-danger">Error al iniciar sesión</div>';
                            } else if($m==2){
                                echo '<div class="alert alert-danger">Falta verificar su correo electrónica</div>';
                            }
                        }
                        ?>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="usu_correo" id="floatingInput" placeholder="name@example.com" required>
                            <label for="floatingInput">Correo Electrónico</label>
                        </div>

                        <div class="mb-3 position-relative">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="usu_pass" id="floatingPassword" placeholder="Contraseña" 
                                autocomplete="current-password"
                                required>
                                <label for="floatingPassword">Contraseña</label>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                    onclick="togglePassword()" tabindex="-1">
                                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    


                    
                        <input type="hidden" name="enviar" class="form-control" value="si">
                        <button class="btn btn-primary w-100 mb-2" type="submit" >Iniciar Sesión</button>
                        <div class="text-center">
                            <a href="./forgotPassword.php" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                </div>
            </main>


            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
            
        </div>
    </div>
    
    <script src="../../../Public/js/Cuerpo.js"></script>
    <script>
    function togglePassword() {
        const input = document.getElementById("floatingPassword");
        const icon = document.getElementById("toggleIcon");
        if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-solid");
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-regular");
        icon.classList.add("fa-eye-slash");
        } else {
        input.type = "password";
        icon.classList.add("fa-solid");
        icon.classList.add("fa-eye");
        icon.classList.remove("fa-regular");
        icon.classList.remove("fa-eye-slash");
        }
    }
    //Quietro que el error desaparezca
    setTimeout(() => {
        document.querySelector(".alert").remove();
    }, 3000);
    </script>

</body>

</html>



