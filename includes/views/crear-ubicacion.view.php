</div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main">
	<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>public/css/bootstrap-tagsinput.css">
	<style>
		fieldset {
			border: 1px solid black;
			border-radius: 5px;
			padding: 1.5em;
			border-color: rgba(0,0,0,.25); /*Borde transparente*/
		}
		legend {
			width: 85px;
		}
		.bootstrap-tagsinput {
		  width: 100% !important;
		}
	</style>
	<div class="col-12">
		<form>
			<div class="form-group" id="divEtiqueta">
				<label for="etiqueta">Etiqueta</label>
				<input type="text" placeholder="Etiqueta" maxlength="50" class="form-control" name="etiqueta" id="txtEtiqueta" required>
				<span class="form-text text-muted"><i>&nbsp;Texto de identificación que aparecerá en la URL</i></span><br>
				<span class="form-text text-muted"><i>&nbsp;*Sólo letras, números o guiones medios</i></span><br>
			  <div class="form-control-feedback" id="feedEtiqueta" style="display: none;"></div>
			</div>
			<div class="form-group" id="divTitulo">
				<label for="titulo">T&iacute;tulo</label>
				<input type="text" placeholder="T&iacute;tulo" maxlength="70" class="form-control" name="titulo" id="txtTitulo" required>
				<span class="form-text text-muted"><i>&nbsp;Nombre del espacio</i></span>
			  <div class="form-control-feedback" id="feedTitulo" style="display: none;"></div>
			</div>
			<div class="form-group" id="divCupo">
				<label for="cupo">Cupo</label>
				<input type="number" placeholder="Cupo" min="1" max="3000" class="form-control" name="cupo" id="txtCupo" required>
				<span class="form-text text-muted"><i>&nbsp;Número de personas que pueden utilizar el espacio</i></span>
			  <div class="form-control-feedback" id="feedCupo" style="display: none;"></div>
			</div>
			<div class="form-group">
				<label for="descripcion">Resumen</label>
				<div id="divResumen">
				  <div class="form-control-feedback" id="feedResumen" style="display: none;"></div>
				</div>
				<textarea name="" id="txtResumen"> </textarea>
				<span class="form-text text-muted"><i>&nbsp;Descripción breve del espacio que se oferta</i></span>
			  <div class="form-control-feedback" id="feedResumen" style="display: none;"></div>
			</div>
			<div class="form-group">
				<label for="descripcion">Descripci&oacute;n</label>
				<div id="divDescripcion">
				  <div class="form-control-feedback" id="feedDescripcion" style="display: none;"></div>
				</div>
				<textarea name="" id="txtDescripcion"> </textarea>
				<span class="form-text text-muted"><i>&nbsp;Texto informativo y representativo del lugar</i></span>
			</div>
			<div class="form-group">
				<label for="descripcion">Detalles</label>
				<div id="divDetalles">
				  <div class="form-control-feedback" id="feedDetalles" style="display: none;"></div>
				</div>
				<textarea name="" id="txtDetalles"></textarea>
				<span class="form-text text-muted"><i>&nbsp;Teléfono, horarios de atención, horarios de préstamo y trámites a realizar</i></span>
			</div>
			<div class="form-group">
				<label for="descripcion">Agrupador</label>
				<div id="divAgrupador">
				  <div class="form-control-feedback" id="feedAgrupador" style="display: none;"></div>
				</div>
				<input type="text" class="form-control" placeholder="Agrupador" name="" id="txtAgrupador" maxlength="20">
				<span class="form-text text-muted"><i>&nbsp;Agrupador, aquel que agrupa</i></span>
			</div>
			<div class="form-group" id="divImagen">
				<label for="imagen">Imagen de portada</label>
			  <div class="form-control-feedback" id="feedImagen" style="display: none;"></div>
				<input type="file" class="form-control" name="imagen" id="inputImagen" accept="image/*" required>
				<img src="https://cenedic3.ucol.mx/content/ubicaciones/portadas/default.png" style=" display:block;margin:auto;" class="img-fluid" id="imageUbicacion" alt="Responsive image" style="max-width: 100%; height: auto;">
				<span class="form-text text-muted"><i>&nbsp;Colocar una fotografía representativa del espacio ofertado</i></span><br>				
			</div>
			<div class="form-group" id="divClasificadores">
				<label for="clasificadores">Clasificadores (tags)</label>
				<input type="text" class="form-control" placeholder="Clasificadores" name="clasificadores" id="txtClasificadores" maxlength="500" data-role="tagsinput">
				<span class="form-text text-muted"><i>&nbsp; Palabras clave que identifiquen al lugar</span>
				<span class="form-text text-muted" id="clasificadoresLimit">&nbsp;* Máximo 500 caracteres</span>
			</div>
			<!-- Catálogos section -->
			<div class="form-group" id="formDirigido"><!-- Dirigido -->
				<fieldset id="fieldsetDirigido">
					<legend>Dirigido a:</legend>
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6" id="colDirigido1">  </div>
						<div class="col-12 col-sm-6 col-md-6" id="colDirigido2">  </div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<label for="otroDirigido">Otro:</label>
							<div class="input-group">
					      <input type="text" maxlength="70" class="form-control form-control-danger" name="otroDirigido" id="txtOtroDirig" placeholder="Otro tipo de dirigido">
					      <span class="input-group-btn">
					        <button class="btn btn-success" id="btnOtroDirig" type="button">Agregar</button>
					      </span><br>
					    </div>
					    <div class="form-control-feedback" hidden id="feedbackDirig"></div>
						</div>
			    </div>
				</fieldset>
				<span class="form-text text-muted"><i>&nbsp;Seleccionar el tipo de usuario que puede solicitar el espacio</i></span>
				<div class="form-group" id="divDirigido">
				  <div class="form-control-feedback" id="feedDirigido" style="display: none;"></div>
				</div>
			</div>
			<div class="form-group" id="formEquip"><!-- Equipamiento -->
				<fieldset id="fieldsetEquip">
					<legend>Equipamiento</legend>
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6" id="colEquipamiento1">  </div>
						<div class="col-12 col-sm-6 col-md-6" id="colEquipamiento2">  </div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<label for="otroEquipamiento">Otro:</label>
							<div class="input-group">
					      <input type="text" maxlength="70" class="form-control form-control-danger" name="otroEquipamiento" id="txtOtroEquip" placeholder="Otro tipo de equipamiento">
					      <span class="input-group-btn">
					        <button class="btn btn-success" id="btnOtroEquip" type="button">Agregar</button>
					      </span><br>
					    </div>
					    <div class="form-control-feedback" hidden id="feedbackEquip"></div>
						</div>
			    </div>
				</fieldset>
				<span class="form-text text-muted"><i>&nbsp;Ingresar las herramientas con las que cuenta el espacio</i></span><br>
				<div class="form-group" id="divEquipamiento">
				  <div class="form-control-feedback" id="feedEquipamiento" style="display: none;"></div>
				</div>
			</div>
			<div class="form-group" id="formActi"> <!-- Actividades -->
				<fieldset id="fieldsetAct">
					<legend>Actividades</legend>
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6" id="colActividad1">  </div>
						<div class="col-12 col-sm-6 col-md-6" id="colActividad2">  </div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<label for="otraActividad">Otra:</label>
							<div class="input-group">
					      <input type="text" maxlength="70" class="form-control form-control-danger" name="otraActividad" id="txtOtraActi" placeholder="Otro tipo de actividad">
					      <span class="input-group-btn">
					        <button class="btn btn-success" id="btnOtraActi" type="button">Agregar</button>
					      </span><br>
					    </div>
					    <div class="form-control-feedback" hidden id="feedbackActi"></div>
						</div>
			    </div>
				</fieldset>
				<span class="form-text text-muted"><i>&nbsp;Son las labores que se pueden ejercer dentro del lugar</i></span>
				<div class="form-group" id="divActividades">
				  <div class="form-control-feedback" id="feedActividades" style="display: none;"></div>
				</div>
			</div>
			<div class="form-group" id="formTipo"> <!-- Tipos ubicaciones -->
				<fieldset id="fieldsetTipo">
					<legend>Tipo de lugar</legend>
					<form action="#">
						<div class="row">
							<div class="col-12 col-sm-6 col-md-6" id="colTipo1">  </div>
							<div class="col-12 col-sm-6 col-md-6" id="colTipo2">  </div>
						</div>
					</form>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<label for="otroTipo">Otro:</label>
							<div class="input-group">
					      <input type="text" maxlength="70" class="form-control form-control-danger" name="otroTipo" id="txtOtroTipo" placeholder="Otro tipo de lugar">
					      <span class="input-group-btn">
					        <button class="btn btn-success" id="btnOtroTipo" type="button">Agregar</button>
					      </span><br>
					    </div>
					    <div class="form-control-feedback" hidden id="feedbackTipo"></div>
						</div>
			    </div>
				</fieldset>
				<span class="form-text text-muted"><i>&nbsp;Categoría del espacio ofertado</i></span>
				<div class="form-group" id="divTipo">
				  <div class="form-control-feedback" id="feedTipo" style="display: none;"></div>
				</div>
			</div>
			<div class="form-group" id="formTipo"> <!-- Delegaciones ubicaciones -->
				<fieldset id="fieldsetDelegación">
					<legend>Delegación</legend>
					<form action="#">
						<div class="row">
							<div class="col-12 col-sm-6 col-md-6" id="colDelegacion1">  </div>
							<div class="col-12 col-sm-6 col-md-6" id="colDelegacion2">  </div>
						</div>
					</form>
				</fieldset>
				<span class="form-text text-muted"><i>&nbsp;Delegación a la que pertenece el espacio ofertado</i></span>
			</div>
			<!--Fin Catálogos section -->
			<div class="form-group">
				<br>
				<label for="maps">Ubicaci&oacute;n</label><br>
				<label id="lblDireccion">Avenida Universidad 333, Las Víboras 28040 Colima, Col. Mexico</label>
				<br>			
				<div class="text-center">
					<div ref="map" id="map" style="height: 500px; width: 100% !important; margin: 0; padding: 0;"></div>
				</div>
				<span class="form-text text-muted"><i>&nbsp;Desplácese sobre el mapa y dé clic en la dirección correcta del espacio</i></span>				
			</div>
			<div class="row form-group" hidden>
				<div class="col-sm-12 col-12 col-md-6">
						<label for="latitud">Latitud</label>
						<input type="text" name="latitud" class="form-control" id="txtLatitud" value="19.24896284462921" readonly required>
				</div>
				<div class="col-sm-12 col-12 col-md-6">
					<label for="longitud">Longitud</label>
					<input type="text" name="longitud" class="form-control" id="txtLongitud" value="-103.6988353729248" readonly required>
				</div>
			</div>
	    <div class="form-group" id="divErrors"> <div class="form-control-feedback" hidden id="feedbackErrors"></div> </div>
			<div class="row form-group">
				<button class="form-control btn btn-success" id="btnGuardar">Guardar</button>
			</div>
		</form>
		<div class="modal" tabindex="-1" id="ubicacionGuardada" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Ubicación guardada</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p id="msg">Se ha guardado correctamene la ubicación</p>
					  <div class="form-control-feedback" id="modalErrorMessage"></div>
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnUbicacionAceptar">Aceptar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEpf-OkQrje9YYOYt9PALj33KIAh4DL4w"></script>
	<script src="<?php echo $url; ?>public/js/bootstrap-tagsinput.min.js"></script>
	<script src="<?php echo $url; ?>includes/editor/ckeditor/ckeditor.js"> </script>
	<?php if (!isset($id)): ?>
		<script src="<?php echo $url; ?>public/js/crear-ubicacion.js"></script>
	<?php else: ?>
		<script src="<?php echo $url; ?>public/js/editar-ubicacion.js"></script>
	<?php endif ?>