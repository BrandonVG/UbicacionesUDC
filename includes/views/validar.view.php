  </div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main">
  <?php if($isAdmin) { ?>
    <div class="row">
      <div class="col-6">
        <select class="form-control" id="selectDependencias">
          <option value="-1" selected disabled> - Selecciona una dependencia - </option>
          <?php 
            $tituloActual = $_SESSION['url'];
            foreach ($dependencias as $dependencia) {
              echo '<option value="'.$dependencia->id_sitio.'" id="lblDepen'.$dependencia->id_sitio.'">'.$dependencia->titulo."</option>";
              if($dependencia->url == $_SESSION['url'])
                $tituloActual = $dependencia->titulo;
            } 
          ?>
        </select>
      </div>
    </div>
    <br>
    <h1 id="lblDependencia">Dependencia actual: <?php echo $tituloActual; ?></h1>
  <?php } ?>
  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table id='table' class="table table-striped">
          <thead>
            <tr>
              <th>Etiqueta</th>
              <th>T&iacute;tulo</th>
              <th>Tags</th>
              <th>Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal" tabindex="-1" id="modalRechazar" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Modal title</h5>
          <button 
            type="button" 
            class="close" 
            data-dismiss="modal" 
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#">
            <div class="form-group">
               <label for="motivo">Motivo</label>
               <textarea 
                  class="form-control" 
                  type="text" 
                  placeholder="Motivo" 
                  name="motivo" 
                  id="txtMotivo"
                  rows="8" 
                  required
                ></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button 
            type="button" 
            id="btnRechazar" 
            class="btn btn-primary"
          >Rechazar</button>
          <button 
            type="button" 
            class="btn btn-secondary" 
            data-dismiss="modal"
          >Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin modal -->
  <script src="<?php echo $url; ?>public/js/validar.js"></script>
