</div>
<?php 
	$agenda = EN_PRODUCCION ? 'agenda' : 'agendaea';
?>
<style type="text/css">
    #cont_tags .label {
  		font-size: 75%!important;
  	}
    .map {
			height: 300px; 
  		width: 100% !important; 
  		margin: 0; 
  		padding: 0;
    }
    .label-dark {
      background-color: #343a40;
  		border-color: #343a40;
    }
    fieldset {
      border: 1px solid black;
	    border-radius: 5px;
	    padding: .35em .625em .75em;
	    border-color: rgba(0,0,0,.25);
    }
    legend {
	    width: 100%;
	    text-align: center;
  	}
    .strong {
	    font-weight: bold;
    }
    .row.p-contenido {
	    display: flex;
  		flex-flow: row wrap;
    }
    #colEquipamiento1,
    #colEquipamiento2,
    #colActividad1,
    #colActividad2 {
  		padding-left: 15px;
    }
    @media (max-width: 767px) {
  		.col-xl-3.sidebar {
  			-webkit-order: 2;
  			-moz-order: 2;
  			order: 2;
  		}
  		.col-xl-9.main {
  			-webkit-order: 1;
  			-moz-order: 1;
  			order: 1;
  		}
  	}

		#formDirigido > fieldset > legend {
			width: 80px;
		}
</style>
<script>
  var url = 'https://<?php echo $_SERVER['SERVER_NAME']; ?>/ubicaciones/';
  $('#sidebar').attr('hidden',true);
</script>
<div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 sidebar">
	<img class="img-responsive" src="<?php echo '//'.$_SERVER['SERVER_NAME'].'/content/ubicaciones/portadas/'.$ubicacion->portada; ?>">
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-6">
			<h5 class="strong">Tipo:</h5>
			<p><?php echo $ubicacion->tipo; ?></p>
		</div>
		<div class="col-sm-6">
			<h5 class="strong">Cupo:</h5>
			<p><?php echo $ubicacion->cupo; ?></p>
		</div>
		<div class="col-sm-12">
			<h5 class="strong">Detalles:</h5>
			<p><?php echo $ubicacion->detalles; ?></p>
    </div>
		<div class="col-sm-12">
			<div class="form-group" id="formDirigido"><!-- Equipamiento -->
				<fieldset>
					<legend><h5 class="strong">Dirigido</h5></legend>
					<ul id="colDirigido1" style="margin-bottom:0;"></ul>
					<ul id="colDirigido2"></ul>
				</fieldset>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group" id="formEquip"><!-- Equipamiento -->
						<fieldset>
							<legend><h5 class="strong">Equipamiento</h5></legend>
							<ul id="colEquipamiento1" style="margin-bottom:0;"></ul>
							<ul id="colEquipamiento2"></ul>
						</fieldset>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group" id="formActi"> <!-- Actividades -->
					    <fieldset> 
							<legend><h5 class="strong">Actividades</h5></legend>
							<ul id="colActividad1" style="margin-bottom:0;"></ul>
							<ul id="colActividad2"></ul>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<h5 class="strong">Ubicaci&oacute;n:</h5>
			<p id="lblDireccion"></p>
			<div ref="map" id="map" class="map"></div>
		</div>
		<div class="col-sm-12">
			<br>
			<h5 class="strong">Calendario:</h5>
			<div id="calendario"></div>
		</div>
    <div class="col-sm-12 form-group">
      <br>
      <br>
      <a id="btnSolicitar" class="form-control btn btn-success" href="//<?php echo $_SERVER['SERVER_NAME'] .'/'. $agenda; ?>/solicitar/<?php echo $ubicacion->id; ?>">Solicitar espacio</a>
    </div>
	</div>
</div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main">
	<?php  
    		if($preview)
			echo '<h3 class="titulo-ucol titulo-seccion">'.$preview.'</h3>';
    ?>
	<h3 class="titulo-ucol titulo-seccion"><?php echo $ubicacion->nombreSitio; ?></h3>
	<h4 class="strong"><?php echo $ubicacion->titulo; ?></h4>
	<?php echo $ubicacion->resumen; ?>
	<div id="cont_tags">
	<?php 
        $tags = explode(" ", $ubicacion->clasificadores);
        foreach ($tags as $tag)
        		echo '<span class="label label-dark">'.$tag.'</span>&nbsp';
    ?>
    </div>
    <div class="clearfix">&nbsp;</div>
    <h5 class="strong">Descripción:</h5>
	<?php echo $ubicacion->descripcion; ?>
</div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEpf-OkQrje9YYOYt9PALj33KIAh4DL4w"></script>

	<!-- Calendario -->
  <script src="//www.ucol.mx/cms/beta/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo '/'.$agenda.'/public/css/fullcalendar.css'; ?>">
  <script src="<?php echo '/'.$agenda.'/public/js/moment.min.js'; ?>"></script>
  <script src="<?php echo '/'.$agenda.'/public/js/fullcalendar.js'; ?>"></script>
  <script src="<?php echo '/'.$agenda.'/public/js/fullcalendar/es.js'; ?>"></script>
  <script src="<?php echo '/'.$agenda.'/public/js/calendario.js'; ?>"></script>
  <!-- /Calendario -->
  <script type="text/javascript">
		// mapa
    var idUbicacion = <?php echo $ubicacion->id; ?>;
    var coordenates = {
      lat: <?php echo $ubicacion->latitud ?>, 
      lng: <?php echo $ubicacion->longitud ?>
		};

		function httpRequest(method, url, params, callback) {
			var req = new XMLHttpRequest();
			method = method.toUpperCase();

			req.open(method, url, true);
			req.setRequestHeader("Content-type", "application/json");

			req.onerror = function() {
				callback(true, req.responseText);
			}
			req.onload = function() {
				if(req.readyState == 4 && req.status == 200) 
					callback(false, JSON.parse(req.responseText));
				else
					callback(true, req.responseText);
			}

			req.send(JSON.stringify(params));
		}

    (function() {

      let map = new window.google.maps.Map(document.getElementById('map'), {
        center: coordenates,
        zoom: 14
      })

      marker = new window.google.maps.Marker({
        position: coordenates,
        map: map
      })


      //Get the address
      let geocoder = new google.maps.Geocoder;
      let lblDireccion = document.getElementById('lblDireccion');

      geocoder.geocode({'location': coordenates}, (results, status) => {
        if (status === 'OK') {
          if (results[0])
            lblDireccion.innerHTML = results[0].formatted_address;
          else 
            lblDireccion.innerHTML = 'Hubo un problema al buscar la dirección';
        } 
        else 
          lblDireccion.innerHTML = 'Hubo un problema al buscar la dirección';
			});
			
			var req = new XMLHttpRequest();
			req.open('GET', '/<?php echo $agenda; ?>/calendario.php', true);
			req.onerror = function() {
				console.error(req.responseText);
			}
			req.onload = function() {
				if(req.readyState == 4 && req.status == 200) {
					$('#calendario').html(req.responseText);
					Calendar('/<?php echo $agenda; ?>/api/public/agenda.php?ubicacion=' + idUbicacion + '&diasOcupados=true');
				} else
					console.error(req.responseText);
			}
			req.send();
		})();
  </script>
  <script src="/ubicaciones/public/js/ver-ubicacion.js"></script>