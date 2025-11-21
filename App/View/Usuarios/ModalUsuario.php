
<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="formEditarUsuario">
        <div class="modal-body row g-3">
          <!-- Campo oculto para ID -->
          <input type="hidden" id="idUsuario" name="usu_id">

          <div class="col-md-6">
            <label for="dni" class="form-label">DNI</label>
            <div class="input-group">
              <input type="text" class="form-control" id="dni" name="dni" maxlength="8" required>
              <button type="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
          </div>

          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" required>
          </div>

          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellido" name="apellido" maxlength="50" required>
          </div>

          <div class="col-md-6">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" maxlength="75" required readonly>
          </div>

          <div class="col-md-6">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" maxlength="16" required>
          </div>

          <div class="col-md-6" id="rolContainer">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-select" id="rol" name="rol" required>
              <option value="">Seleccione</option>
              <option value="1">Administrador</option>
              <option value="3">Usuario</option>
              <option value="2">Soporte Técnico</option>
            </select>
          </div>

    

          <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" required>
          </div>
          
          <div class="col-md-6" id="areaContainer">
            <label for="area" class="form-label">Área</label>
            <select class="form-select" id="area" name="area" required>
              <option value="">Seleccione</option>
              <option value="1">TI</option>
              <option value="2">RRHH</option>
              <option value="3">Logística</option>
              <!-- Puedes cargar estos valores dinámicamente con PHP o JS -->
            </select>
          </div>
        </div>

        <div class="modal-footer mt-4">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>

    </div>
  </div>
</div>
