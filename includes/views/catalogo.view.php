  </div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-12 form-group">
      <button class="btn btn-success pull-right" id='btnAgregar'>Agregar</button>
    </div>
    <div class="col-12">
      <div class="table-responsive">
        <table id='table' class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Estatus</th>
              <th>Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" role="dialog" id="modalEditar">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-12">
              <div class="form-group">
                <label for="newNombre" class="form-control-label">Nombre:</label>
                <div class="form-group" id="formObjeto">
                  <input type="text" class="form-control" id="newNombre" maxlength="70">
                  <div id="errorVacio" class="form-control-feedback" hidden>Debe completar este campo</div>
                  <div id="errorRepetido" class="form-control-feedback" hidden>Ya existe un registro con este nombre</div>
                  <small class="form-text text-muted">Nombre requerido. Hasta 70 caracteres.</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" value="-1" id="btnEnviar">Enviar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="/ubicaciones/public/js/catalogo.js"></script>