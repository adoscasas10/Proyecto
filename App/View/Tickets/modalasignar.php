<div id="modalasignar" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mdltitulo">Asignar Soporte</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="post" id="ticket_form">
                <div class="modal-body">
                    <input type="hidden" id="id_rol" name="id_rol" value="<?php echo $_SESSION['rol']; ?>">
                    <input type="hidden" id="usu_Actual" name="usu_Actual" value="<?php echo $_SESSION['id_usuario']; ?>">
                    
                    <input type="hidden" id="usu_id" name="usu_id" value="0">

                    <input type="hidden" id="tick_id" name="tick_id">

                    <div class="form-group">
                        <label class="form-label" for="usu_asig">Soporte</label>
                        <!-- <select class="select2" id="usu_asig" name="usu_asig" data-placeholder="Seleccionar" required>

                        </select> -->
                        <div class="position-relative">
                            <input type="text" class="form-control" id="usu_asig" name="usu_asig" placeholder="Escriba el nombre o dni" maxlength="120" required>
                            <div id="resultados" class="list-group position-absolute w-100"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal" id="btnCerrar">Cerrar</button>
                    <button type="button" class="btn btn-rounded btn-warning" data-dismiss="modal" id="btnAutoasignar" >Autoasignarse</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Asignar</button>
                </div>

                <style>
                   #resultados {
    z-index: 1050;   /* más alto que otros elementos */
    max-height: 200px;
    overflow-y: auto;
    display: none;
}

                </style>
            </form>
        </div>
    </div>
</div>