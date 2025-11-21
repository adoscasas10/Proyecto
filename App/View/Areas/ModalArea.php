<!-- Modal para Área -->
<div class="modal fade" id="modalArea" tabindex="-1" aria-labelledby="modalAreaLabel" style="display: none;" aria-hidden="true" inert="">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalAreaLabel">Registrar/Editar Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="formArea">
        <input type="hidden" id="idArea" name="idArea" value="-1"> 
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigoArea" class="form-label">Código</label>
            <input readonly type="text" maxlength="5" class="form-control" id="codigoArea" name="codigoArea" required>
          </div>

          <div class="mb-3">
            <label for="nombreArea" class="form-label">Nombre del Área</label>
            <input type="text" maxlength="50" class="form-control" id="nombreArea" name="nombreArea" placeholder="" required>
          </div>


          <!-- <div class="mb-3" id="div_estado" hidden>
            <label for="estadoArea" class="form-label">Estado</label>
            <select class="form-select" id="estadoArea" name="estadoArea">
              <option value="Habilitado">Habilitado</option>
              <option value="Deshabilitado">Deshabilitado</option>
            </select>
          </div> -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelar">Cancelar</button>
          <button type="submit" class="botonGuardar btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
