<!-- Modal para Categoría -->
<!-- <div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true"> -->
<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" style="display: none;" aria-hidden="true" inert="">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modalCategoriaLabel">Registrar/Editar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="formCategoria">

        <input type="hidden" id="idCategoria" name="idCategoria" value="-1">

        <div class="modal-body">
          
          <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input readonly type="text" class="form-control" id="codigo" name="codigo" placeholder="" readonly required maxlength="7">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de Categoría</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Red" required maxlength="50">
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ej. Problemas con la red interna" maxlength="255"></textarea>
          </div>


          <!-- <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select class="form-select" id="prioridad" name="prioridad" required>
              <option value="">Seleccione</option>
              <option value="1">Baja</option>
              <option value="2">Media</option>
              <option value="3">Alta</option>
              <option value="4">Critica</option>
            </select>
          </div> -->

          
          
        </div>

        

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelar">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
