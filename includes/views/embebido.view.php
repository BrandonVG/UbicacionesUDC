<script type="text/javascript" src="/cms/js/carruselV3.2.js" ></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEpf-OkQrje9YYOYt9PALj33KIAh4DL4w"></script>
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
  .slider, .slider[class*='span'] {
    margin: 0 !important;
  }
</style>
<div class="col-xl-3 col-lg-4 col-md-4 col-xs-12 sidebar">
  <img class="img-responsive" src="<?php echo '//portal.ucol.mx/content/ubicaciones/portadas/'.$ubicacion->portada; ?>">
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
  </div>
</div>
<div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 main">
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
<script>
  var idUbicacion = <?php echo $ubicacion->id; ?>;
  var coordenates = {
    lat: <?php echo $ubicacion->latitud ?>, 
    lng: <?php echo $ubicacion->longitud ?>
  };
  window.addEventListener('load', function () {
      var divMap = document.getElementById('map');
        var map = new window.google.maps.Map(divMap, {
          center: coordenates,
          zoom: 14
        })

        marker = new window.google.maps.Marker({
          position: coordenates,
          map: map
        })

        //Get the address
        var geocoder = new google.maps.Geocoder;
        var lblDireccion = document.getElementById('lblDireccion');
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
  });

  (function() {
    function httpRequest(method, url, params, callback) {
      var req = new XMLHttpRequest();
      if(params) {
        url += '?';
        var props = Object.keys(params);
        props.forEach(function(prop) {
          url += prop + '=' + params[prop] + '&';
        });
        console.log('URL: ' + url);
      }

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
      req.send();
    }
    
    httpRequest(
      'GET', 
      '/ubicaciones/api/catalogos', 
      {table: 'dirigidoUbicacion', idUbicacion: idUbicacion}, 
      function(err, res) {
        if(err) {
          console.error(res);
          $('#colEquipamiento1').text('Hubo un problema al cargar el equipamiento');
        }
        else {
          for (var i = 0; i < res.length; i++) {
            var divTemp = $('<li></li>').append(`${res[i].nombre}`);
            i % 2 == 0 ? $('#colDirigido1').append(divTemp) : $('#colDirigido2').append(divTemp);
          }
        }
      }
    );

    httpRequest(
      'GET', 
      '/ubicaciones/api/catalogos', 
      {table: 'equipamientoUbicacion', idUbicacion: idUbicacion}, 
      function(err, res) {
        if(err) {
          console.error(res);
          $('#colEquipamiento1').text('Hubo un problema al cargar el equipamiento');
        }
        else {
          for (var i = 0; i < res.length; i++) {
            var divTemp = $('<li></li>').append(`${res[i].nombre}`);
            i % 2 == 0 ? $('#colEquipamiento1').append(divTemp) : $('#colEquipamiento2').append(divTemp);
          }
        }
      }
    );

    httpRequest(
      'GET', 
      '/ubicaciones/api/catalogos', 
      {table: 'actividadesUbicacion', idUbicacion: idUbicacion}, 
      function(err, res) {
        if(err) {
          console.error(res);
          $('#colActividad1').text('Hubo un problema al cargar el equipamiento');
        }
        else {
          for (var i = 0; i < res.length; i++) {
            var divTemp = $('<li></li>').append(`${res[i].nombre}`);
            i % 2 == 0 ? $('#colActividad1').append(divTemp) : $('#colActividad2').append(divTemp);
          }
        }
      }
    );
  })();
</script>