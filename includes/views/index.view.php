    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>public/css/bootstrap-tagsinput.css">
	<style> 
		.bootstrap-tagsinput {width:? 100% !important; }
		#sidebar {
			display: none
		}
		#tags  {
			margin-bottom: 15px;
		}
		#tags .label {
			outline:none;
		}
		/*#divCards .label {
			font-size: 75%!important;
		}*/
		#divCards {
			display: -webkit-flex;
			display: -moz-flex;
			display: flex;
			-webkit-flex-wrap: row wrap;
			-moz-flex-wrap: row wrap;
			flex-flow: row wrap;
		}
		.card-img-top {
			text-align: center;
		    position: relative;
		    overflow: hidden;
		}
		.card-img-top img {
		    max-width: 100%;
		    max-height: 246px;
		    position: relative;
		    z-index: 1;
		}
		.overlay_fondo_banner {
			position: absolute;
			top: 0;
			height: 100%;
			width: 100%;
			filter: progid: DXImageTransform.Microsoft.Blur(PixelRadius='9');
			background-size: cover;
			background-position: center;
			-webkit-transform: scale(1.1);
			-moz-transform: scale(1.1);
			transform: scale(1.1);
			-webkit-filter: blur(9px);
			-moz-filter: blur(9px);
			filter: blur(9px);
			z-index: 0;
		}
		#divCards .card {
			height: -moz-available;
		    height: -webkit-fill-available;
		    height: fill-available;
		    max-height: 520px;
		    padding-bottom: 61px;
		}
		#divCards .card .btn {
		    bottom: 15px;
		    left: 15px;
		    right: 15px;
		    width: auto;
		}
		#divCards .card .btn,
		#divCards .card .card-tags {
			position: absolute;
		}
		#divCards .card .card-tags {
			bottom: 61px;
		}
		.jumbotron {
		    padding: 1rem 1rem;
		    background-color: #F3F4F5;
		        margin-bottom: 0;
		}
		.label-dark {
		    background-color: #343a40;
		    border-color: #343a40;
		}
		@media(min-width: 992px) {
			.resumen > :first-child {
				max-height: 100px;
				overflow: hidden;
				display: block !important;
			}
		}
		@media(max-width: 991px) {
			.resumen > :first-child {
				max-height: 80px;
				overflow: hidden;
				display: block !important;
			}
		}
		.resumen > p{
			display: none;
		}

	</style>
  </div>
<script>
	var url = 'https://<?php echo $_SERVER['SERVER_NAME']; ?>/ubicaciones/';
</script>
<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
	<div class="jumbotron">En esta secci&oacute;n podr&aacute;s encontrar un cat&aacute;logo de salas audiovisuales, aulas, auditorios, centros de c&oacute;mputo, laboratorios, etc&eacute;tera. Espacios que son ofertados a trav&eacute;s de los planteles y dependencias de la Universidad de Colima.</div>
	<h3 class="titulo-ucol titulo-seccion"><a href="/enterate/">Filtros</a></h3>
	<!-- <div class="row">
	  <div class="col-md-12">
	    <select class="form-control" id="selectDelegaciones" style="margin-bottom:15px">
	      <option value="-1" selected disabled> - Delegaciones - </option>
	      <option value="-2">Todas</option>
	      <?php 
	        foreach ($delegaciones as $delegacion => $value) {
	          echo '<option value="'.$delegacion.'" id="lblDelegacion'.$delegacion.'">'.$value."</option>";
	        } 
	      ?>
	    </select>
	  </div>
	</div> -->
	<div id="tags">
		<?php 
	    foreach ($delegaciones as $delegacion => $value) {
				echo '<button class="label label-default delegacion" value="'.$delegacion.'">'.$value.'</button>&nbsp';
	    }
	  ?>
	</div>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 main">
  <h1 class="text-info" style="display: none;" id="txtSearchResult">No se encontraron coincidencias</h1>
  <div class="row" id="divCards">
    <?php foreach($ubicaciones as $ubicacion): ?>
    <div class="col-xl-3 col-lg-4 col-md-6 col-xs-12 card-ubicacion" id="card-<?php echo $ubicacion->id; ?>">
    		<div class="card">
	    		<div class="card-img-top">
						<img data-holder-rendered="true" src="<?php echo '//'.$_SERVER['SERVER_NAME'].'/content/ubicaciones/portadas/'.$ubicacion->portada; ?>">
						<div class="overlay_fondo_banner" style="background-image: url(<?php echo '//'.$_SERVER['SERVER_NAME'].'/content/ubicaciones/portadas/'.$ubicacion->portada; ?>);"></div>
	    		</div>  
			    <div class="card-block">
			        <h6 class="card-title"><a href="<?php echo $url.'ver-ubicacion/'.$ubicacion->id; ?>"><?php echo $ubicacion->titulo; ?></a></h6>    
			        <em class="card-fecha"><?php echo $ubicacion->nombreSitio. ' - ' .$ubicacion->etiqueta; ?></em>  
			        <div class="resumen"><?php echo $ubicacion->resumen; ?></div>
				        <div class="card-tags">
					        <?php $tags = explode(" ", $ubicacion->clasificadores);
				                foreach ($tags as $tag) {
				                		echo '<span class="label label-dark static-tag">'.$tag.'</span>&nbsp;';
				            		} 
				            ?>
				        </div>
				        <a href="<?php echo $url.'ver-ubicacion/'.$ubicacion->id; ?>" class="btn btn-block btn-success btn-sm">Ver</a>

			    </div>
			</div>
    </div>
    <?php endforeach; ?>
  </div>
  <script src="<?php echo $url.'public/js/index.js'; ?>"></script>
  <script src="<?php echo $url; ?>public/js/bootstrap-tagsinput.min.js"></script>
