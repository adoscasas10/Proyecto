<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuraciones</title>
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

  <!-- Card Configuraciones generales -->
  <div class="card mb-4">
    <div class="card-header">
      <h4>Configuraciones</h4>
    </div>
    <div class="card-body">
      <!-- Columna izquierda -->
      <div class="mb-4">
        <h5>Colores de prioridad</h5>
        <div class="mb-3 row align-items-center">
          <label for="colorAlta" class="col-sm-4 col-form-label fw-semibold">Prioridad Alta:</label>
          <div class="col-sm-8">
            <input type="color" class="form-control form-control-color" id="colorAlta" value="#dc3545" title="Elige el color para prioridad alta">
          </div>
        </div>
        <div class="mb-3 row align-items-center">
          <label for="colorMedia" class="col-sm-4 col-form-label fw-semibold">Prioridad Media:</label>
          <div class="col-sm-8">
            <input type="color" class="form-control form-control-color" id="colorMedia" value="#ffc107" title="Elige el color para prioridad media">
          </div>
        </div>
        <div class="mb-3 row align-items-center">
          <label for="colorBaja" class="col-sm-4 col-form-label fw-semibold">Prioridad Baja:</label>
          <div class="col-sm-8">
            <input type="color" class="form-control form-control-color" id="colorBaja" value="#198754" title="Elige el color para prioridad baja">
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h5>Idioma</h5>
        <select class="form-select" aria-label="Seleccionar idioma">
          <option selected>Español</option>
          <option value="en">Inglés</option>
        </select>
      </div>

      <!-- <div class="mb-4">
        <h5>Cambio de tema</h5>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tema" id="temaOscuro" value="dark">
          <label class="form-check-label" for="temaOscuro">Tema oscuro</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="tema" id="temaClaro" value="light">
          <label class="form-check-label" for="temaClaro">Tema claro</label>
        </div>
      </div> -->

      <div class="mb-4">
        <h5>Seguridad</h5>
        <a href="./../Perfil/CambioContraseña.php" class="btn btn-primary">Cambiar contraseña</a>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
      </div>
    </div>
  </div>

  <!-- Card Datos Personales -->
  <div class="card">
    <div class="card-header">
      <h4>Datos Personales</h4>
    </div>
    <div class="card-body">
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Nombre:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">Juan</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Apellido:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">Pérez</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Usuario:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">jperez</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Correo:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">juan.perez@email.com</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Teléfono:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">+51 987654321</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Área:</label>
        <div class="col-sm-8">
          <p class="form-control-plaintext">Soporte Técnico</p>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-sm-4 col-form-label fw-semibold">Rol:</label>
        <div class="col-sm-8">
          <span class="badge bg-secondary">Técnico Soporte</span>
        </div>
      </div>

      <div class="mt-3">
        <a href="./../Perfil/Datos.php" class="btn btn-primary w-100">Editar datos</a>
      </div>
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

    <!-- <script>
  document.addEventListener("DOMContentLoaded", function () {
    const radiosTema = document.querySelectorAll('input[name="tema"]');
    const htmlElement = document.documentElement;

    // Verificar si ya hay un tema guardado en localStorage
    const temaGuardado = localStorage.getItem("temaSeleccionado");

    if (temaGuardado) {
      htmlElement.setAttribute("data-bs-theme", temaGuardado);
      document.querySelector(`input[name="tema"][value="${temaGuardado}"]`).checked = true;
    }

    // Evento para cambiar el tema y guardarlo
    radiosTema.forEach(radio => {
      radio.addEventListener("change", function () {
        const nuevoTema = this.value;
        htmlElement.setAttribute("data-bs-theme", nuevoTema);
        localStorage.setItem("temaSeleccionado", nuevoTema);
      });
    });
  });
</script> -->

    
    <?php include '../Layout/script.php'; ?>
    
</body>

</html>
