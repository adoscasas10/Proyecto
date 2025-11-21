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
    <title>Nuevo Usuario</title>
    <?php include '../Layout/head.php'; ?>
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
                

            <div class="container mt-4">
  <div class="card shadow rounded-4">
    
  <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0">Crear nuevo usuario</h4>
    </div>
    <div class="card-body">
    <form method="post" id="usuario_form">
      <div class="row p-4">

        <!-- Nose utilzara, asta cree el modal en otra pestaña -->
        <input type="hidden" id="usu_id" name="usu_id" value="-1">

        <!-- Nombre -->
        <div class="col-md-6 mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingrese el nombre" maxlength="50">
        </div>

        <!-- Apellido -->
        <div class="col-md-6 mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Ingrese el apellido" maxlength="50">
        </div>

        <!-- Usuario -->
        <div class="col-md-6 mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Nombre de usuario" maxlength="16">
        </div>

        <!-- DNI -->
        <div class="col-md-6 mb-3">
          <label for="dni" class="form-label">DNI</label>
          <div class="input-group">
            <input type="text" name="dni" class="form-control" id="dni" placeholder="Ingrese el DNI" maxlength="8">
            <button type="button" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </div>

        <!-- Correo -->
        <div class="col-md-6 mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" name="correo" class="form-control" id="correo" placeholder="ejemplo@empresa.com" maxlength="75">
        </div>

        <!-- Teléfono -->
        <div class="col-md-6 mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Número de contacto" maxlength="9">
        </div>

        <!-- Área -->
        <div class="col-md-6 mb-3">
          <label for="area" class="form-label">Área</label>
          <select name="area"  class="form-select" id="area_id">
            <!-- <option selected disabled>Seleccione el área</option>
            <option value="soporte">Soporte Técnico</option>
            <option value="desarrollo">Desarrollo</option>
            <option value="admin">Administración</option>
            <option value="ventas">Ventas</option> -->
          </select>
        </div>

        <!-- Rol -->
        <div class="col-md-6 mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select name="rol" id="rol_id" class="form-select">
              <option selected disabled>Seleccione el rol</option>
              <option value="1">Administrador</option>
              <option value="3">Usuario</option>
              <option value="2">Soporte Técnico</option>
          </select>
        </div>

        <!-- Contraseña con botón para mostrar -->
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="********">
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
              <i class="fa-solid fa-eye" id="icono-password"></i>
              
            </button>
          </div>
        </div>
      </div>

      <!-- Botones -->
      <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="reset" id="btnCancelar" class="btn btn-secondary ms-2">Cancelar</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Script para mostrar/ocultar la contraseña -->
<script>
  function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("icono-password");
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
</script>



            </main>

            <!-- Theme Toggler -->
            <?php include '../Layout/theme.php'; ?>
            
            <!-- Footer -->
            <?php include '../Layout/footer.php'; ?>
            
        </div>
    </div>
    
    <?php include '../Layout/script.php'; ?>
    <?php include '../../Components/MainJs/js.php'; ?>

    <script type="text/javascript" src="./mntusuario.js"></script>
    <!-- Iconos -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> -->

</body>

</html>

<?php
    }else{
        header("Location:".Conectar::ruta()."App/view/Login/login.php");
    }
?>
