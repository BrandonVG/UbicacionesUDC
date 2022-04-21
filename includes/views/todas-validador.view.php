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
              <th>Aceptada</th>
              <th>Visible</th>
              <th>Opciones</th><!-- Ver/preveer borrar -->
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" id="modalBorrar" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body container">
          <h5 id="modalTitle">¿Estás seguro que quieres eliminar?</h5>
          <button
            type="button" 
            class="btn btn-secondary pull-right" 
            data-dismiss="modal"
          >No</button>
          <button 
            type="button"
            id="btnBorrar" 
            class="btn btn-danger pull-right"
          >Sí</button>
        </div>
    </div>
  </div>
  <script src="<?php echo $url; ?>public/js/todas-validador.js"></script>